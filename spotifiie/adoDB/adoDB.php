<?php
class Database {
    public function createService ()
    {
        $config = include 'config.php';
        return new \PDO(
            sprintf('pgsql:host=%s;dbname=%s', $config['db']['host'], $config['db']['dbname']),
            $config['db']['user'],
            $config['db']['password']
        );
    }

}

function getAssos($dbh) {
        $query = "SELECT * FROM assos";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $tab = array();
        while ($courant = $sth->fetch(PDO::FETCH_ASSOC)) {
            array_push($tab, $courant['asso']);
        }
        $sth->closeCursor();
        return $tab;
    };



