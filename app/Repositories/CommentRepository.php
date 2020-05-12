<?php

namespace App\Repositories;

use App\Controllers\API\CommentsAPIController;
use App\Core\App;
use App\Core\Pgsql;
use App\Models\Comment;
use Exception;

/**
 * Class CommentRepository
 * @package App\Repositories
 */
class CommentRepository
{
    /** @var Pgsql|null */
    private $dbAdapter;

    /**
     * CommentRepository constructor.
     */
    public function __construct()
    {
        $this->dbAdapter = App::resolve(Pgsql::class);
    }

    /**
     * Récupère le commentaire avec l'id donné
     * @param $id
     * @return Comment|bool
     * @throws \Exception
     */
    public function get($id){
        $res = $this->dbAdapter->query('SELECT * from comments WHERE cid = ?', [$id]);
        if($res === null || count($res) == 0){
            return false;
        }

        return Comment::fromDbRow($res[0]);
    }

    /**
     * Insert un commentaire dans la base de données
     * @param Comment $comment
     * @return array|int|string|null
     */
    public function addComment(Comment $comment){
        return $this->dbAdapter->insert('comments', [
            'uid' => $comment->getUser(),
            'wid' => $comment->getWine(),
            'did' => $comment->getDomain(),
            'yid' => $comment->getYear(),
            'tid' => $comment->getType(),
            'posted_at' => $comment->getPostedAt()->format('Y-m-d H:i:s'),
            'msg' => $comment->getMsg(),
            'in_response_to' => $comment->getReplyTo()
        ], true, "RETURNING cid");
    }

    /**
     * Met à jour un commentaire dans la bdd
     *
     * @param Comment $comment
     * @return array|bool|int|string|null
     */
    public function saveComment(Comment $comment){
        return $this->dbAdapter->update('comments', $comment->toDbRow(), 'WHERE cid = ?', [$comment->getId()]);
    }

    public function deleteComment($cid){
        return $this->dbAdapter->query('DELETE FROM comments WHERE cid = ?', [$cid]);
    }

    /**
     * Récupère le nombre de commentaire postés par un user
     * @param $uid
     * @return int|mixed
     */
    public function getCountPostedByUser($uid){
        $res = $this->dbAdapter->query('SELECT COUNT(*) AS count FROM comments WHERE uid = ?', [$uid]);
        return $res !== null ? $res[0]['count'] : -1;
    }

    /**
     * Récupère le nombre de like d'un commentaire
     *
     * @param $cid
     * @return int|mixed
     */
    public function getLikes($cid){
        $res = $this->dbAdapter->query('SELECT COUNT(*) AS count FROM comment_likes WHERE cid = ?', [$cid]);
        return $res !== null ? $res[0]['count'] : -1;
    }

    /**
     * Vérifie si l'utilisateur a liké ou non le commentaire
     *
     * @param $uid
     * @param $cid
     * @return bool|null
     */
    public function isLiked($uid, $cid){
        $res = $this->dbAdapter->query('SELECT * FROM comment_likes WHERE uid = ? AND cid = ?', [$uid, $cid]);
        return $res !== null ? count($res) == 1 : null;
    }

    /**
     * Définit le like d'un commentaire par un user
     *
     * @param $uid
     * @param $cid
     * @param $isLiked
     * @return bool
     */
    public function setLiked($uid, $cid, $isLiked){
        if($isLiked){
            return $this->dbAdapter->insert('comment_likes', [
                'cid' => $cid,
                'uid' => $uid
            ], true) > 0;
        }else{
            return $this->dbAdapter->query('DELETE FROM comment_likes WHERE uid = ? AND cid = ?', [
                $uid,
                $cid
            ]) > 0;
        }
    }

    /**
     * Récupère les commentaires pour la combinaison de vin, domaine, type et année
     *
     * @param $wineId
     * @param $domainId
     * @param $typeId
     * @param $yearId
     * @return array|bool
     * @throws Exception
     */
    public function getCommentsFor($wineId, $domainId, $typeId, $yearId){
        $query = 'SELECT * from comments WHERE ';
        $tmp = [];
        $args = [];
        if($wineId){
            $tmp[] = 'wid = ?';
            $args[] = $wineId;
        }
        if($domainId){
            $tmp[] = 'did = ?';
            $args[] = $domainId;
        }
        if($typeId){
            $tmp[] = 'tid = ?';
            $args[] = $typeId;
        }
        if($yearId){
            $tmp[] = 'yid = ?';
            $args[] = $yearId;
        }

        $q = $this->dbAdapter->iterator($query . implode(' AND ', $tmp) . ' ORDER BY posted_at DESC', $args);
        if($q === null){
            return false;
        }
        $res = [];
        foreach($q as $row){
            $com = Comment::fromDbRow($row);
            $com->{'canEdit'} = CommentsAPIController::canEdit($com);
            $res[] = $com;
        }

        return $res;
    }

    /**
     * Renvoie un tableau de Comment trouvé grâce à une requête
     * de bdd
     *
     * @param $query
     * @param $args
     * @return array|bool
     * @throws Exception
     */
    private function getResults($query, $args){
        $q = $this->dbAdapter->iterator($query, $args);
        if($q === null){
            return false;
        }
        $res = [];
        foreach($q as $row){
            $res[] = Comment::fromDbRow($row);
        }

        return $res;
    }

    /**
     * Récupère les commentaires les plus aimés
     *
     * @param int $nb
     * @param int $wid
     * @param int $did
     * @param int $tid
     * @param int $yid
     * @return Comment[]
     * @throws Exception
     */
    public function getMostLiked($nb = 3, $wid = null, $did = null, $tid = null, $yid = null){
        $tmp = [];
        $args = [];
        if($wid){
            $tmp[] = 'c.wid = ?';
            $args[] = $wid;
        }
        if($did){
            $tmp[] = 'c.did = ?';
            $args[] = $did;
        }
        if($tid){
            $tmp[] = 'c.tid = ?';
            $args[] = $tid;
        }
        if($yid){
            $tmp[] = 'c.yid = ?';
            $args[] = $yid;
        }

        $query = $this->dbAdapter->query("SELECT c.*, count(cl.*) as count 
                FROM comments as c 
                FULL JOIN comment_likes as cl 
                ON c.cid=cl.cid
                " . (count($args) > 0 ? ' WHERE ' . implode(' AND ', $tmp) : '') . " 
                GROUP BY c.cid
                ORDER BY count(cl.*) DESC LIMIT ?", array_merge($args, [$nb]));

        $res = [];
        $uRepo = new UserRepository();
        $wRepo = new WineRepository();
        foreach($query as $row){
            $com = Comment::fromDbRow($row);
            $com->{'likes'} = $row['count'];
            $com->setUser($uRepo->get($com->getUser()));
            $com->setWine($wRepo->get($com->getWine()));
            $res[] = $com;
        }
        return $res;
    }

    public function getAllComments($limit = 50){
        $query = $this->dbAdapter->query("SELECT * FROM comments LIMIT " . $limit);
        $res = [];
        foreach($query as $row){
            $res[] = Comment::fromDbRow($row);
        }
        return $res;
    }
}