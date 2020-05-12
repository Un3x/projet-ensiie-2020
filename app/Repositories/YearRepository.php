<?php


namespace App\Repositories;


use App\Core\App;
use App\Core\Pgsql;
use App\Models\Year;

/**
 * Class YearRepository
 * @package App\Repositories
 */
class YearRepository
{
    /** @var Pgsql|null */
    private $dbAdapter;

    /**
     * YearRepository constructor.
     */
    public function __construct()
    {
        $this->dbAdapter = App::resolve(Pgsql::class);
    }

    /**
     * Insert un Year dans la bdd
     *
     * @param Year $year
     * @return array|int|string|null
     */
    public function addYear(Year $year){
        return $this->dbAdapter->insert('years', [
            'year' => $year->getYear(),
            'tags' => $year->getTags(false),
        ], true, "RETURNING yid");
    }

    /**
     * Récupère une année dans la bdd à partir de son id
     *
     * @param $yid
     * @return Year|null
     */
    public function get($yid){
        $res = $this->dbAdapter->query("SELECT * FROM years WHERE yid = ?", [$yid]);
        return $res !== null ? Year::fromDbRow($res[0]) : null;
    }

    /**
     * Recherche et renvoie l'id si un résultat existe, sinon insert
     * le type et renvoie l'id attribué
     *
     * @param $name
     * @return int
     */
    public function getIdOrInsert($year){
        $res = $this->search($year, true);
        if(!$res){
            $res = $this->dbAdapter->insert('years', [
                'year' => $year,
                'tags' => ''
            ], false, "RETURNING yid");
        }
        return $res;
    }

    /**
     * Récupère la liste de tous les domaines
     *
     * @return Year[]
     */
    public function fetchAll(){
        $query = $this->dbAdapter->iterator("SELECT year FROM years ORDER BY year DESC");
        $res = [];
        foreach($query as $row){
            $res[] = $row['year'];
        }
        return $res;
    }

    /**
     * Recherche un domaine à partir d'un string donné
     *
     * @param $search
     * @param bool $strict
     * @param int $num
     * @param int $offset
     * @param bool $orderByYear
     * @return Year[]|Year
     */
    public function search($search, $strict = false, $num = null, $offset = null, $orderByYear = false){
        $query = $this->dbAdapter->iterator('
            SELECT y.*,count(c.yid) AS count 
            FROM years AS y 
            FULL JOIN comments AS c ON c.yid = y.yid
            WHERE ' . ($strict ? 'y.year = ?' : 'LOWER(y.year::text) LIKE LOWER(?)') . '
            GROUP BY y.yid
            ORDER BY ' . ($orderByYear ? 'y.year DESC' : 'count(c.yid) DESC') . (!is_null($num) ? " LIMIT $num" . (!is_null($offset) ? " OFFSET $offset" : '') : ''),
            $strict ? [$search] : ['%' . $search . '%']);
        if($strict){
            foreach($query as $row){
                return $row['yid'];
            }
            return null;
        }
        $res = [];
        foreach($query as $row){
            $year = Year::fromDbRow($row);
            $year->{'comments'} = $row['count'];
            $res[] = $year;
        }
        return $res;
    }
}