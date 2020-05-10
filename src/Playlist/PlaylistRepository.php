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

    public function fromQueryToArray($query)
    {
        $playlists = [];
        foreach ($query as $playlistDatum) {
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

    public function fetchAllPublik()
    {
        $playlistsData = $this->dbAdapter->query('SELECT * FROM playlist WHERE publik IS TRUE');
        return fromQueryToArray($playlists);
    }

    public function fetchAllOf($userId)
    {
        $req = 'SELECT * FROM playlist WHERE creator=:id';
        $playlists = $this->dbAdapter->prepare($req);
        $playlists->bindParam('id', $userId, PDO::PARAM_INT);
        $playlists->execute();
        return $playlists->fetchAll();
    }

    public function fetchPlaylist($id)
    {
        $req = 'SELECT * FROM playlist WHERE id=:id';
        $playlists = $this->dbAdapter->prepare($req);
        $playlists->bindParam('id', $id, PDO::PARAM_INT);
        $playlists->execute();
        return $playlists->fetchColumn();
    }

    public function createPlaylist($name, $creator, $public)
    {
        $req =
            'INSERT INTO playlist (name, creator, content, publik)
             VALUES (:name, :creator, ARRAY[], :publik);';
        $newPlaylist = $this
            ->dbAdapter
            ->prepare($req);
        var_dump($newPlaylist);
        $newPlaylist->bindParam('name', $name, PDO::PARAM_STR);
        $newPlaylist->bindParam('creator', $creator, PDO::PARAM_INT);
        $newPlaylist->bindParam('publik', $public, PDO::PARAM_BOOL);
        return $newPlaylist->execute();
    }

    public function deletePlaylist($id)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM playlist where id=:id');
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /*
    public function addToPlaylist($kara, $playlist)
    {
        $req =
            'UPDATE playlist';
    }
     */
}
