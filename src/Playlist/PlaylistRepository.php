<?php namespace Playlist;
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
require_once 'Karas/Kara.php';


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
            ->setPublik($query['publik']);
        return $playlist;
    }

    public function fetchAllPublik()
    {
        $playlists = $this->dbAdapter->query('SELECT playlist.id, name, creator, content, publik, username FROM playlist JOIN "user" ON "user".id=creator WHERE publik IS TRUE');
        return $this->fromQueryToArray($playlists);
    }

    public function getOwner($playlistId)
    {
        $public = $this->dbAdapter->prepare('SELECT creator FROM playlist WHERE id=:id');
        $public->bindParam('id', $playlistId, \PDO::PARAM_INT);
        $public->execute();
        return $public->fetch(\PDO::FETCH_COLUMN);
    }

    public function isOwner($playlistId, $userId)
    {
        return  ( $this->getOwner($playlistId) === $userId );
    }

    public function canAccess($playlistId, $userId)
    {
        $public = $this->dbAdapter->prepare('SELECT creator, publik FROM playlist WHERE id=:id');
        $public->bindParam('id', $playlistId, \PDO::PARAM_INT);
        $public->execute();
        $test = $public->fetch(\PDO::FETCH_ASSOC);
        if ( $test['publik'] === true || $test['creator']===$userId )
            return true;
        return false;
    }

    public function fetchAllOf($userId)
    {
        $req = 'SELECT * FROM playlist WHERE creator=:id';
        $playlists = $this->dbAdapter->prepare($req);
        $playlists->bindParam('id', $userId, \PDO::PARAM_INT);
        $playlists->execute();
        return $this->fromQueryToArray($playlists->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function fetchPlaylist($id, $userId, $mode)
    {
        if ( $mode === 0 ) // Read-only
        {
            if ( !$this->canAccess($id, $userId) )
                throw new \Exception("You don't have the rights to see this playlist");
        }
        elseif ( $mode === 1 ) // Read-write
        {
            if ( !$this->isOwner($id, $userId) )
                throw new \Exception("You don't have the rights to see this playlist");
        }
        else
            throw new \Exception("Unknown access mode to playlist");

        $req = 'SELECT playlist.id, name, creator, publik, username FROM playlist JOIN "user" ON "user".id=creator WHERE playlist.id=:id';
        $playlist_info = $this->dbAdapter->prepare($req);
        $playlist_info->bindParam('id', $id, \PDO::PARAM_INT);
        $playlist_info->execute();
        $arrPlaylistInfo = $this->fromPlaylistToArray($playlist_info->fetch(\PDO::FETCH_ASSOC));

        $req =
            'SELECT karas.id, karas.song_name, karas.source_name, karas.category, karas.author_name, karas.song_number, karas.language
             FROM playlist 
                JOIN karas 
                ON karas.id = ANY (content)
             WHERE playlist.id=:id;';
        $karas = $this->dbAdapter->prepare($req);
        $karas->bindParam('id', $id, \PDO::PARAM_INT);
        $karas->execute();
        $karasData = $karas->fetchAll(\PDO::FETCH_ASSOC);
        $arrKaras = [];
        foreach ($karasData as $karaDatum) {
            $kara = new \Kara\Kara();
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
            $arrKaras[] = $kara;
        }

        $ret = [];
        array_push($ret, $arrPlaylistInfo);
        array_push($ret, $arrKaras);

        return $ret;
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

    public function deletePlaylist($id, $idAsker)
    {
        if ( !$this->isOwner($id, $idAsker) )
            throw new \Exception("You don't have the rights to delete this playlist");

        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM playlist where id=:id');
        $stmt->bindParam('id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteKaraFromPlaylist($idPlaylist, $idKara, $idAsker)
    {
        if ( !$this->isOwner($idPlaylist, $idAsker) )
            throw new \Exception("You don't have the rights to delete from this playlist");

        $yeet = $this
            ->dbAdapter
            ->prepare(
                'UPDATE playlist
                    SET content=(SELECT array(SELECT unnest(content) 
                        FROM playlist 
                        WHERE id=:idPlaylist 
                        EXCEPT SELECT :idKara))
                 WHERE id=:idPlaylist;');
        $yeet->bindParam('idPlaylist', $idPlaylist, \PDO::PARAM_INT);
        $yeet->bindParam('idKara', $idKara, \PDO::PARAM_INT);
        return $yeet->execute();
    }

    public function isInPlaylist($idKara, $idPlaylist, $idAsker)
    {
        if ( !$this->canAccess($idPlaylist, $idAsker) )
            throw new \Exception("You don't have the rights to access this playlist");

        $stmt = $this
            ->dbAdapter
            ->prepare("SELECT '{:idKara}' && (SELECT content FROM playlist WHERE id=:idPlaylist);");
        $stmt->bindParam('idKara', $idKara, \PDO::PARAM_INT);
        $stmt->bindParam('idPlaylist', $idPlaylist, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_COLUMN);
    }

    public function addKaraToPlaylist($idPlaylist, $idKara, $idAsker)
    {
        if ( !$this->isOwner($idPlaylist, $idAsker) )
            throw new \Exception("You don't have the rights to delete from this playlist");

        elseif ( $this->isInPlaylist($idPlaylist, $idKara, $idAsker) )
            throw new \Exception("This kara is already in the playlist");

        $add = $this
            ->dbAdapter
            ->prepare(
                'UPDATE playlist
                    SET content=content||:idKara 
                 WHERE id=:idPlaylist;');
        $add->bindParam('idPlaylist', $idPlaylist, \PDO::PARAM_INT);
        $add->bindParam('idKara', $idKara, \PDO::PARAM_INT);
        return $add->execute();
    }
}
