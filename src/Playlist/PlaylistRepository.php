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
                ->setCreator($playlistDatum['creator'])
                ->setContent($playlistDatum['content'])
                ->setPublik($playlistDatum['publik']);
            $playlists[] = $playlist;
        }
        return $playlists;
    }

    public function checkPlaylist ($name,$creator)
    {
    $playlists=$this->dbAdapter->prepare('SELECT COUNT(*) From "playlist" WHERE name= :Name AND creator= :Creator');
    $playlists->bindParam('Name',$name);
    $playlists->bindParam('Creator',$creator);
    $playlists->execute();
    return $playlist->fetchColumn();
    }
}
