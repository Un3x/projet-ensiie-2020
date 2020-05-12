<?php

namespace App\Repositories;

use App\Core\App;
use App\Core\Pgsql;
use App\Models\Type;

/**
 * Class TypeRepository
 * @package App\Repositories
 */
class TypeRepository
{
    /** @var Pgsql|null */
    private $dbAdapter;

    /**
     * TypeRepository constructor.
     */
    public function __construct()
    {
        $this->dbAdapter = App::resolve(Pgsql::class);
    }

    /**
     * Insert un Type dans la bdd
     *
     * @param Type $type
     * @return array|int|string|null
     */
    public function addType(Type $type){
        return $this->dbAdapter->insert('types', [
            'name' => $type->getName(),
            'tags' => $type->getTags(false),
        ], true, "RETURNING tid");
    }

    /**
     * Récupère un Type par son id
     *
     * @param $tid
     * @return Type|null
     */
    public function get($tid){
        $res = $this->dbAdapter->query("SELECT * FROM types WHERE tid = ?", [$tid]);
        return $res !== null ? Type::fromDbRow($res[0]) : null;
    }

    /**
     * Récupère la liste de tous les domaines
     *
     * @return Type[]
     */
    public function fetchAll(){
        $query = $this->dbAdapter->iterator("SELECT name FROM types ORDER BY name");
        $res = [];
        foreach($query as $row){
            $res[] = $row['name'];
        }
        return $res;
    }


    /**
     * Recherche et renvoie l'id si un résultat existe, sinon insert
     * le type et renvoie l'id attribué
     *
     * @param $name
     * @return int
     */
    public function getIdOrInsert($name){
        $res = $this->search($name, true);
        if(!$res){
            $res = $this->dbAdapter->insert('types', [
                'name' => $name,
                'tags' => ''
            ], false, "RETURNING tid");
        }
        return $res;
    }

    /**
     * Recherche un type à partir d'un string donné
     *
     * @param $search
     * @param bool $strict
     * @param int $num
     * @param int $offset
     * @param bool $orderByName
     * @return Type[]|Type
     */
    public function search($search, $strict = false, $num = null, $offset = null, $orderByName = false){
        $query = $this->dbAdapter->iterator('
            SELECT t.*,count(c.tid) AS count 
            FROM types AS t 
            FULL JOIN comments AS c ON c.tid = t.tid
            WHERE ' . ($strict ? 't.name = ?' : 'LOWER(t.name) LIKE LOWER(?) OR LOWER(t.name) % ?') . '
            GROUP BY t.tid 
            ORDER BY ' . ($orderByName ? 't.name ASC' : 'count(c.tid) DESC') . (!is_null($num) ? " LIMIT $num" . (!is_null($offset) ? " OFFSET $offset" : '') : ''),
            $strict ? [$search] : ['%' . $search . '%', $search]);
        if($strict){
            foreach($query as $row){
                return $row['tid'];
            }
            return null;
        }
        $res = [];
        foreach($query as $row){
            $type = Type::fromDbRow($row);
            $type->{'comments'} = $row['count'];
            $res[] = $type;
        }
        return $res;
    }
}