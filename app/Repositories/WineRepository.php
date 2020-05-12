<?php


namespace App\Repositories;


use App\Core\App;
use App\Core\Pgsql;
use App\Models\Wine;

/**
 * Class WineRepository
 * @package App\Repositories
 */
class WineRepository
{
    /** @var Pgsql|null */
    private $dbAdapter;

    /**
     * WineRepository constructor.
     */
    public function __construct()
    {
        $this->dbAdapter = App::resolve(Pgsql::class);
    }

    public function saveWine(Wine $wine){
        if($this->dbAdapter->update('wines', $wine->toDbRow(), 'WHERE wid = ?', [$wine->getId()])){
            return $wine->getId();
        }
        return null;
    }

    public function delete($wid){
        return $this->dbAdapter->query('DELETE FROM wines WHERE wid = ?', [$wid]);
    }

    /**
     * Insert un vin dans la bdd
     *
     * @param Wine $wine
     * @return array|int|string|null
     */
    public function addWine(Wine $wine){
        return $this->dbAdapter->insert('wines', [
            'name' => $wine->getName(),
            'description' => $wine->getDescription(),
            'tags' => $wine->getTags(false),
            'tid' => $wine->getTypeId(),
            'did' => $wine->getDomainId(),
            'yid' => $wine->getYearId(),
            'proposed_by' => $wine->getProposedBy(),
        ], true, "RETURNING wid");
    }

    /**
     * Récupère un vin par son id
     *
     * @param $wid
     * @return Wine|null
     */
    public function get($wid){
        $res = $this->dbAdapter->query("SELECT * FROM wines WHERE wid = ?", [$wid]);
        return $res !== null && count($res) > 0 ? Wine::fromDbRow($res[0]) : null;
    }

    public function getLast($limit = 8){
        $res = [];
        $query = $this->dbAdapter->query("SELECT * FROM wines ORDER BY wid DESC LIMIT ?", [$limit]);
        foreach ($query as $row){
            $res[] = Wine::fromDbRow($row);
        }
        return $res;
    }

    /**
     * Récupère les vins favoris les plus aimés si $uid = null, sinon les vins favoris du user
     *
     * @param null $uid
     * @param null $num
     * @param null $offset
     * @return Wine[]
     */
    public function getAllFavorites($uid = null, $num = null, $offset = null){
        $query = $this->dbAdapter->iterator('SELECT w.*' . (!is_null($uid) ? '' : ',count(f.wid)') . ' AS count FROM wines AS w FULL JOIN favorites_wines AS f ON w.wid = f.wid ' . (!is_null($uid) ? 'WHERE uid = ?' : 'GROUP BY w.wid ORDER BY count(w.wid) DESC') . (!is_null($num) ? " LIMIT $num" . (!is_null($offset) ? " OFFSET $offset" : '') : ''), !is_null($uid) ? [$uid] : []);
        $res = [];
        foreach($query as $row){
            $wine = Wine::fromDbRow($row);
            $wine->{'likes'} = $row['count'];
            $res[] = $wine;
        }
        return $res;
    }

    /**
     * Recherche un vin dans la bdd avec le string donné
     * Cherche dans les domaines, années, types et nom des vins
     *
     * @param $search
     * @param int $num
     * @param int $offset
     * @return Wine[]
     */
    public function search($search, $num = null, $offset = null){
        $query = $this->dbAdapter->iterator('
            SELECT w.*,count(f.wid) AS count 
            FROM wines AS w 
            FULL JOIN favorites_wines AS f ON w.wid = f.wid
            WHERE LOWER(w.name) LIKE LOWER(?)
            OR LOWER(w.description) LIKE LOWER(?)
            GROUP BY w.wid 
            ORDER BY count(f.wid) DESC' . (!is_null($num) ? " LIMIT $num" . (!is_null($offset) ? " OFFSET $offset" : '') : ''), [
            '%' . $search . '%',
            '%' . $search . '%'
        ]);
        $res = [];
        foreach($query as $row){
            $wine = Wine::fromDbRow($row);
            $wine->{'likes'} = $row['count'];
            $res[] = $wine;
        }
        return $res;
    }

    /**
     * Récupère le nombre de vins proposés par un user
     *
     * @param $uid
     * @return int|mixed
     */
    public function getProposedCountByUser($uid){
        $res = $this->dbAdapter->query('SELECT COUNT(*) AS count FROM wines WHERE proposed_by = ?', [$uid]);
        return $res !== null ? $res[0]['count'] : -1;
    }

    /**
     * Récupère le nombre de vin favoris pour un user
     *
     * @param $uid
     * @return int|mixed
     */
    public function getFavoriteCountByUser($uid){
        $res = $this->dbAdapter->query('SELECT COUNT(*) AS count FROM favorites_wines WHERE uid = ?', [$uid]);
        return $res !== null ? $res[0]['count'] : -1;
    }

    /**
     * Récupère le nombre de vin favoris pour un user
     *
     * @param $uid
     * @return int|mixed
     */
    public function getFavoriteWinesByUser($uid){
        $query = $this->dbAdapter->iterator('
            SELECT w.*,count(f.wid) AS count 
            FROM wines AS w 
            FULL JOIN favorites_wines AS f ON w.wid = f.wid
            WHERE f.uid = ?
            GROUP BY w.wid 
            ORDER BY count(f.wid) DESC', [$uid]);
        $res = [];
        $yRepo = new YearRepository();
        foreach($query as $row){
            $wine = Wine::fromDbRow($row);
            $wine->{'likes'} = $row['count'];
            $wine->setYearId($yRepo->get($wine->getYearId()));
            $res[] = $wine;
        }
        return $res;
    }

    /**
     * Récupère le nombre de favoris pour le vin donné
     *
     * @param $wid
     * @return int|mixed
     */
    public function getFavoriteCountByWine($wid){
        $res = $this->dbAdapter->query('SELECT COUNT(*) AS count FROM favorites_wines WHERE wid = ?', [$wid]);
        return $res !== null ? $res[0]['count'] : -1;
    }

    /**
     * Vérifie si un user a le vin en favoris
     *
     * @param $uid
     * @param $wid
     * @return bool|null
     */
    public function isFavorite($uid, $wid){
        $res = $this->dbAdapter->query('SELECT * FROM favorites_wines WHERE uid = ? AND wid = ?', [$uid, $wid]);
        return $res !== null ? count($res) == 1 : null;
    }

    /**
     * Définit le favoris pour un vin par un user
     *
     * @param $uid
     * @param $wid
     * @param $isLiked
     * @return bool
     */
    public function setFavorite($uid, $wid, $isLiked){
        if($isLiked){
            return $this->dbAdapter->insert('favorites_wines', [
                    'wid' => $wid,
                    'uid' => $uid
                ], true) > 0;
        }else{
            return $this->dbAdapter->query('DELETE FROM favorites_wines WHERE uid = ? AND wid = ?', [
                    $uid,
                    $wid
                ]) > 0;
        }
    }
}