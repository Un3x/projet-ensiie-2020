<?php

namespace App\Core;

use Iterator;
use PDO;
use PDOException;
use PDOStatement;

/**
 * Cette classe est une surcouche à PDO, qui simplifie beaucoup l'utilisation de la
 * base de donnée PgSql
 *
 * Class Pgsql
 * @package App\Core
 */
class Pgsql
{
    /** @var int  */
    public $querycount = 0;
    /** @var string */
    private $host;
    /** @var string */
    private $dbName;
    /** @var string */
    private $dbUser;
    /** @var string */
    private $dbPwd;
    /** @var PDO */
    private $pdo;
    /** @var PDOStatement */
    private $sQuery;
    /** @var bool */
    private $connectionStatus = false;
    /** @var array  */
    private $parameters;

    /**
     * Constructeur de la bdd
     * @param $host
     * @param $dbName
     * @param $dbUser
     * @param $dbPwd
     */
    public function __construct($host, $dbName, $dbUser, $dbPwd)
    {
        $this->host       = $host;
        $this->dbName     = $dbName;
        $this->dbUser     = $dbUser;
        $this->dbPwd      = $dbPwd;
        $this->parameters = array();
        $this->connect();
        $this->query('CREATE EXTENSION IF NOT EXISTS pg_trgm');
    }

    /**
     * Permet la connexion à la base de données
     */
    private function connect()
    {
        try {
            $dsn = 'pgsql:';
            $dsn .= 'host=' . $this->host . ';';
            if (!empty($this->dbName)) {
                $dsn .= 'dbname=' . $this->dbName . ';';
            }
            $this->pdo = new PDO($dsn,
                $this->dbUser,
                $this->dbPwd,
                array(
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                )
            );
            $this->connectionStatus = true;
        }
        catch (PdoException $e) {
            error_log("Impossible de se connecter au SQL : $dsn ; erreur : " . $e->getMessage());
            throw new PDOException('Impossible de se connecteur au serveur PostgreSQL !');
        }
    }

    /**
     * Permet de rentrer dans une transaction
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * Permet de valider une transaction
     * @return bool
     */
    public function commit()
    {
        return $this->pdo->commit();
    }

    /**
     * Permet de rollback dans la bdd
     * @return bool
     */
    public function rollBack()
    {
        return $this->pdo->rollBack();
    }

    /**
     * Permet de savoir si on est dans une transaction
     * @return bool
     */
    public function inTransaction()
    {
        return $this->pdo->inTransaction();
    }

    /**
     * @brief Permet de simplifier l'utilisation des curseurs
     *
     * Exécute une requête Pgsql et renvoie un itérateur si on a fait une sélection
     * sinon on renvoie le nombre de lignes affectés.
     * En cas d'erreur, on renvoie null.
     *
     * @param string $query
     * @param null $params
     * @param int $fetchMode
     * @param bool $ignoreError
     * @return int|null|PdoIterator
     */
    public function iterator($query, $params = null, $fetchMode = PDO::FETCH_ASSOC, $ignoreError = FALSE)
    {
        $query        = trim($query);
        $rawStatement = explode(" ", $query);
        if(!$this->init($query, $params, $ignoreError, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL))){
            return null;
        }
        $statement = strtolower($rawStatement[0]);
        if ($statement === 'select' || $statement === 'show' || $statement === 'call' || $statement === 'describe') {
            return new PdoIterator($this->sQuery, $fetchMode);
        } elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
            return $this->sQuery->rowCount();
        } else {
            return null;
        }
    }

    /**
     * Permet d'initialiser une requête et de l'exécuter
     * @param $query
     * @param null $parameters
     * @param bool $ignoreError
     * @param array $driverOptions
     * @return bool
     */
    private function init($query, $parameters = null, $ignoreError = FALSE, $driverOptions = array())
    {
        if (!$this->connectionStatus) {
            $this->connect();
        }
        try {
            $this->parameters = $parameters;
            $this->sQuery     = $this->pdo->prepare($this->buildParams($query, $this->parameters), $driverOptions);

            if (!empty($this->parameters)) {
                if (array_key_exists(0, $parameters)) {
                    $parametersType = true;
                    array_unshift($this->parameters, "");
                    unset($this->parameters[0]);
                } else {
                    $parametersType = false;
                }
                foreach ($this->parameters as $column => $value) {
                    $this->sQuery->bindParam($parametersType ? intval($column) : ":" . $column, $this->parameters[$column], $this->typeConvert($value));
                }
            }

            if (!isset($driverOptions[PDO::ATTR_CURSOR])) {
                $this->sQuery->execute();
            }
            $this->querycount++;
        } catch (PdoException $e) {
            if(!$ignoreError){
                error_log("Erreur SQL : " . $e->getMessage());
            }
            return false;
        }

        $this->parameters = array();
        return true;
    }

    /**
     * Permet de construire les attributs d'une requête
     * @param $query
     * @param null $params
     * @return string|string[]|null
     */
    private function buildParams($query, $params = null)
    {
        if (!empty($params)) {
            $array_parameter_found = false;
            foreach ($params as $parameter_key => $parameter) {
                if (is_array($parameter)){
                    $array_parameter_found = true;
                    $in = "";
                    foreach ($parameter as $key => $value){
                        $name_placeholder = $parameter_key."_".$key;
                        // On concatène params comme un placeholder nommé
                        $in .= ":".$name_placeholder.", ";
                        // On ajoute chaque paramètres à $params
                        $params[$name_placeholder] = $value;
                    }
                    $in = rtrim($in, ", ");
                    $query = preg_replace("/:".$parameter_key."/", $in, $query);
                    // On supprime le tableau de $params
                    unset($params[$parameter_key]);
                }
            }

            // On update $this->params si $params et $query ont changés
            if ($array_parameter_found) $this->parameters = $params;
        }
        return $query;
    }

    /**
     * Permet de convertir le type PHP en type PDO pour les variables supportées
     * @param $data
     * @return int
     */
    private function typeConvert($data){
        switch (gettype($data)){
            case "integer":
                return PDO::PARAM_INT;
            case "boolean":
                return PDO::PARAM_BOOL;
            default:
                return PDO::PARAM_STR;
        }
    }

    /**
     * Permet d'insérer une ligne dans la base de données
     *
     * @param $tableName
     * @param array $params On donne un tableau de type dictionnaire avec array('colonne1' => 'valeur1', 'colonne2' => 'valeur2') etc ...
     * @param bool $orIgnore Si on veut ignorer la requête si la ligne existe déjà
     * @return null|string
     */
    public function insert($tableName, $params = null, $orIgnore = FALSE, $endQuery = "", $endParams = [])
    {
        $keys = array_keys($params);
        $rowCount = $this->query(
            'INSERT INTO ' . $tableName . ' (' . implode(',', $keys) . ')
			VALUES (:' . implode(',:', $keys) . ') ' . ($orIgnore ? "ON CONFLICT DO NOTHING " : " ") . $endQuery,
            \array_merge($params, $endParams)
        );
        if ($rowCount === 0 || $rowCount == null) {
            return null;
        }
        try{
            return $this->lastInsertId();
        }catch (PDOException $e){
            return $rowCount;
        }

    }

    /**
     * Exécute une requête Pgsql et renvoie un tableau contenant toutes les lignes si on a fait une sélection
     * sinon on renvoie le nombre de lignes affectés.
     * En cas d'erreur, on renvoie null.
     *
     * @param string $query
     * @param null $params
     * @param int $fetchMode
     * @param bool $ignoreError
     * @return array|int|null
     */
    public function query($query, $params = null, $ignoreError = FALSE, $fetchMode = PDO::FETCH_ASSOC)
    {
        $query        = trim($query);
        $rawStatement = explode(" ", $query);
        if(!$this->init($query, $params, $ignoreError)){
            return null;
        }
        $statement = strtolower($rawStatement[0]);
        if ($statement === 'select' || $statement === 'show' || $statement === 'call' || $statement === 'describe') {
            return $this->sQuery->fetchAll($fetchMode);
        } elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
            return $this->sQuery->rowCount();
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Permet de faire un update dans la base de données
     *
     * @param $tableName
     * @param null $params Du type array('colonne1' => 'valeur1', 'colonne2' => 'valeur2')
     * @param string $endQuery
     * @param array $endParams
     * @return bool|string
     */
    public function update($tableName, $params, $endQuery = "", $endParams = [])
    {
        if($params == null){
            return false;
        }
        $rowCount = $this->query(
            'UPDATE ' . $tableName . ' SET ' . implode(' = ?, ', array_keys($params)) . ' = ? ' . $endQuery,
            array_merge(array_values($params), $endParams)
        );

        if($rowCount === null){
            return null;
        }

        if ($rowCount === 0) {
            return false;
        }
        return $rowCount;
    }
}

class PdoIterator implements Iterator {
    private $position = 0;
    private $pdo;
    private $fetchMode;
    private $nextResult;

    public function __construct(PDOStatement $pdo, $fetchMode = PDO::FETCH_ASSOC) {
        $this->position = 0;
        $this->pdo = $pdo;
        $this->fetchMode = $fetchMode;
    }

    function rewind() {
        $this->position = 0;
        $this->pdo->execute();
        $this->nextResult = $this->pdo->fetch($this->fetchMode, PDO::FETCH_ORI_NEXT);
    }

    function current() {
        return $this->nextResult;
    }

    function key() {
        return $this->position;
    }

    function next() {
        ++$this->position;
        $this->nextResult = $this->pdo->fetch($this->fetchMode, PDO::FETCH_ORI_NEXT);
    }

    function valid() {
        $invalid = $this->nextResult === false;
        if ($invalid) {
            $this->pdo->closeCursor();
        }
        return !$invalid;
    }
}

