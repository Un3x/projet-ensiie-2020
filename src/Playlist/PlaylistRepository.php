<?php

namespace Playlist;

class PlaylistRepository
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
        $playlistsData = $this->dbAdapter->query('SELECT * FROM playlist');
        $playlists = [];
        foreach ($playlistsData as $playlistDatum) {
            $playlist = new Playlist();
            $playlist
                ->setId($playlistDatum['id'])
                ->setName($playlistDatum['name'])
                ->setCreator($playlistDatum['creator']);
                ->setContent($playlistDatum['content']);
                ->setPublik($playlistDatum['publik']);
            $playlists[] = $playlist;
        }
        return $playlists;
    }
}
