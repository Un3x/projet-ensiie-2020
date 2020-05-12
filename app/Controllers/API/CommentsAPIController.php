<?php


namespace App\Controllers\API;


use App\Composers\CommentsComposer;
use App\Core\App;
use App\Core\Auth;
use App\Core\Blade;
use App\Core\Request;
use App\Models\Comment;
use App\Models\User;
use App\Repositories\CommentRepository;

class CommentsAPIController
{
    public function handleLikes(Request $req, $cid){
        $liked = $req->input('liked');
        if(!Auth::isLogged()){
            App::addError('Vous devez être connecté !');
            return App::jsonPayload(false);
        }
        if($liked === null){
            App::addError('Il faut décrire si le like est présent ou non !');
            return App::jsonPayload(false);
        }
        $repo = new CommentRepository();
        $comment = $repo->get($cid);
        if($comment === null){
            App::addError('Impossible de trouver le commentaire');
            return App::jsonPayload(false);
        }

        $res = $repo->setLiked(Auth::loggedUser()->getId(), $cid, $liked);
        return App::jsonPayload($res, ['count' => $repo->getLikes($cid)]);
    }

    public function handleDelete(Request $req, $cid){
        $cRepo = new CommentRepository();
        $comment = $cRepo->get($cid);
        if($comment === null){
            App::addError('Impossible de trouver le commentaire');
            return App::jsonPayload(false);
        }
        if(!self::canEdit($comment)){
            App::addError('Vous n\'avez pas la permission de faire cette action !');
            return App::jsonPayload(false);
        }

        return App::jsonPayload($cRepo->deleteComment($cid));
    }

    public function handlePostComment(Request $req){
        $msg = $req->input('msg');
        $replyTo = $req->input('replyTo');
        $wid = $req->input('wid');
        $did = $req->input('did');
        $tid = $req->input('tid');
        $yid = $req->input('yid');

        $msg = str_replace("&#10;", "\n", $msg);

        if(!Auth::isLogged()){
            App::addError('Vous devez être connecté !');
            return App::jsonPayload(false);
        }

        if(!$wid && !$did && !$tid && !$yid){
            App::addError('Impossible de trouver la destination pour l\'envoi du commentaire');
            return App::jsonPayload(false);
        }

        $repo = new CommentRepository();
        $comment = new Comment();
        $comment
            ->setMsg($msg)
            ->setReplyTo($replyTo)
            ->setType($tid)
            ->setDomain($did)
            ->setWine($wid)
            ->setYear($yid)
            ->setPostedAt(new \DateTime())
            ->setUser(Auth::loggedUser()->getId());

        $id = $repo->addComment($comment);
        if($id > 0){
            $comment->setId($id);
            $comment->setUser(Auth::loggedUser());
            $comment->{'likes'} = 0;
            $comment->{'canEdit'} = true;
            $root = new Comment();
            $root->setId($replyTo);

            $display = Blade::create('components.comments.item',
                \array_merge([
                    'com' => $comment,
                    'children' => [],
                    'respId' => CommentsComposer::respId
                ], $replyTo ? ['root' => $root] : []));

            return App::jsonPayload(true, ['elem' => $display]);
        }

        return App::jsonPayload(false);
    }

    public static function canEdit(Comment $comment){
        $can = Auth::isLogged() && (Auth::loggedUser()->getRole() & User::ADMIN_ROLE ||
                (Auth::loggedUser()->getRole() & User::VIEWER_ROLE && $comment->getUser() === Auth::loggedUser()->getId()));
        return $can;
    }
}