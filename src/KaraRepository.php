<?php

namespace Kara;

class KaraRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAll()
    {
        $karasData = $this->dbAdapter->query('SELECT * FROM "karas"');
        $karas = [];
        foreach ($karasData as $karaDatum) {
            $kara = new Kara();
            $string = $karaDatum['source_name'] . " - " . $karaDatum['category'] . $karaDatum['song_number'] . " - " . $karaDatum['song_name'] . " [" .$karaDatum['author_name'] . "]";
            $kara
                ->setId($karaDatum['id'])
                ->setString($string)
                ->setSourceName($karaDatum['source_name'])
                ->setSongName($karaDatum['song_name'])
                ->setCategory($karaDatum['category'])
                ->setAuthorName($karaDatum['author_name'])
                ->setSongNumber($karaDatum['song_number'])
                ->setLanguage('language');
            $karas[] = $kara;
        }
        return $karas;
    }
}
