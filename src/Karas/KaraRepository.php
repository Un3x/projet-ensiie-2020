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
            $string = $karaDatum['source_name'] . " - " . $karaDatum['category'] . $karaDatum['song_number'] . " - " . $karaDatum['song_name'];
            $kara
                ->setId($karaDatum['id'])
                ->setString($string)
                ->setSourceName($karaDatum['source_name'])
                ->setSongName($karaDatum['song_name'])
                ->setCategory($karaDatum['category'])
                ->setAuthorName($karaDatum['author_name'])
                ->setSongNumber($karaDatum['song_number'])
                ->setLanguage($karaDatum['language']);
            $karas[] = $kara;
        }
        return $karas;
    }

    public function fetchAllNotInPlaylist($id)
    {
        $karasData = $this
            ->dbAdapter
            ->prepare(
                'SELECT karas.id, source_name, song_name, category, author_name, song_number, language 
                 FROM karas JOIN playlist
                    ON karas.id <> ALL (content)
                    WHERE playlist.id=:id;');
        $karasData->bindParam('id', $id, \PDO::PARAM_INT);
        $karasData->execute();
        $karas = [];
        foreach ($karasData as $karaDatum) {
            $kara = new Kara();
            $string = $karaDatum['source_name'] . " - " . $karaDatum['category'] . $karaDatum['song_number'] . " - " . $karaDatum['song_name'];
            $kara
                ->setId($karaDatum['id'])
                ->setString($string)
                ->setSourceName($karaDatum['source_name'])
                ->setSongName($karaDatum['song_name'])
                ->setCategory($karaDatum['category'])
                ->setAuthorName($karaDatum['author_name'])
                ->setSongNumber($karaDatum['song_number'])
                ->setLanguage($karaDatum['language']);
            $karas[] = $kara;
        }
        return $karas;
    }
}
