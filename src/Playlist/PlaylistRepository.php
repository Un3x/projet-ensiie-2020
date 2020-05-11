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
            $playlist->setId($playlistDatum['id']);
            if ( isset($playlistDatum['username']) )
                $playlist->setCreatorUsername($playlistDatum['username']);
            $playlist
                ->setName($playlistDatum['name'])
                ->setCreator($playlistDatum['creator'])
                ->setContent($playlistDatum['content'])
                ->setPublik($playlistDatum['publik']);
            $playlists[] = $playlist;
        }
        return $playlists;
    }

    public function fromPlaylistToArray($query)
    {
        $playlist = new Playlist();
        $playlist
            ->setId($query['id'])
            ->setCreatorUsername($query['username'])
            ->setName($query['name'])
            ->setCreator($query['creator'])
            ->setContent($query['content'])
            ->setPublik($query['publik']);
        return $playlist;
    }

    public function fetchAllPublik()
    {
        $playlists = $this->dbAdapter->query('SELECT playlist.id, name, creator, content, publik, username FROM playlist JOIN "user" ON "user".id=creator WHERE publik IS TRUE');
        return $this->fromQueryToArray($playlists);
    }

    public function fetchAllOf($userId)
    {
        $req = 'SELECT * FROM playlist WHERE creator=:id';
        $playlists = $this->dbAdapter->prepare($req);
        $playlists->bindParam('id', $userId, \PDO::PARAM_INT);
        $playlists->execute();
        return $this->fromQueryToArray($playlists->fetch());
    }

    public function fetchPlaylist($id, $userId)
    {
        $public = $this->dbAdapter->prepare('SELECT creator, publik FROM playlist WHERE id=:id');
        $public->bindParam('id', $id, \PDO::PARAM_INT);
        $public->execute();
        $public->fetch();
        //if ( $public['publik'] === false && $public['creator']2

        $req = 'SELECT * FROM playlist WHERE id=:id';
        $playlists = $this->dbAdapter->prepare($req);
        $playlists->bindParam('id', $id, \PDO::PARAM_INT);
        $playlists->execute();
        return $this->fromPlaylistToArray($playlists->fetch(\PDO::FETCH_ASSOC));
    }

    public function createPlaylist($name, $creator, $public)
    {
        $req =
            'INSERT INTO playlist (name, creator, content, publik)
             VALUES (:name, :creator, ARRAY[]::integer[], :publik);';
        $newPlaylist = $this
            ->dbAdapter
            ->prepare($req);
        $newPlaylist->bindParam('name', $name, \PDO::PARAM_STR);
        $newPlaylist->bindParam('creator', $creator, \PDO::PARAM_INT);
        $newPlaylist->bindParam('publik', $public, \PDO::PARAM_BOOL);
        return $newPlaylist->execute();
    }

    public function deletePlaylist($id)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM playlist where id=:id');
        $stmt->bindParam('id', $id, \PDO::PARAM_INT);
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
