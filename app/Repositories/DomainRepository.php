<?php


namespace App\Repositories;

use App\Core\App;
use App\Core\Pgsql;
use App\Models\Domain;

/**
 * Class DomainRepository
 * @package App\Repositories
 */
class DomainRepository
{
    /** @var Pgsql|null */
    private $dbAdapter;

    /**
     * DomainRepository constructor.
     */
    public function __construct()
    {
        $this->dbAdapter = App::resolve(Pgsql::class);
    }

    /**
     * Insert un domaine dans la bdd
     *
     * @param Domain $domain
     * @return array|int|string|null
     */
    public function addDomain(Domain $domain){
        return $this->dbAdapter->insert('domains', [
            'name' => $domain->getName(),
            'tags' => $domain->getTags(false),
        ], true, "RETURNING did");
    }

    /**
     * Récupère un domaine par son id
     *
     * @param $did
     * @return Domain|null
     */
    public function get($did){
        $res = $this->dbAdapter->query("SELECT * FROM domains WHERE did = ?", [$did]);
        return $res !== null ? Domain::fromDbRow($res[0]) : null;
    }

    /**
     * Récupère la liste de tous les domaines
     *
     * @return Domain[]
     */
    public function fetchAll(){
        $query = $this->dbAdapter->iterator("SELECT name FROM domains ORDER BY name");
        $res = [];
        foreach($query as $row){
            $res[] = $row['name'];
        }
        return $res;
    }

    /**
     * Recherche et renvoie l'id si un résultat existe, sinon insert
     * le domaine et renvoie l'id attribué
     *
     * @param $name
     * @return int
     */
    public function getIdOrInsert($name){
        $res = $this->search($name, true);
        if(!$res){
            $res = $this->dbAdapter->insert('domains', [
                'name' => $name,
                'tags' => ''
            ], false, "RETURNING did");
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
     * @param bool $orderByName
     * @return Domain[]|Domain
     */
    public function search($search, $strict = false, $num = null, $offset = null, $orderByName = false){
        $query = $this->dbAdapter->iterator('
            SELECT d.*,count(c.did) AS count 
            FROM domains AS d 
            FULL JOIN comments AS c ON c.did = d.did
            WHERE ' . ($strict ? 'd.name = ?' : 'LOWER(d.name) LIKE LOWER(?) OR LOWER(d.name) % ?') . '
            GROUP BY d.did 
            ORDER BY ' . ($orderByName ? 'd.name ASC' : 'count(c.did) DESC') . (!is_null($num) ? " LIMIT $num" . (!is_null($offset) ? " OFFSET $offset" : '') : ''),
            $strict ? [$search] : ['%' . $search . '%', $search]);
        if($strict){
            foreach($query as $row){
                return $row['did'];
            }
            return null;
        }
        $res = [];
        foreach($query as $row){
            $domain = Domain::fromDbRow($row);
            $domain->{'comments'} = $row['count'];
            $res[] = $domain;
        }
        return $res;
    }
}