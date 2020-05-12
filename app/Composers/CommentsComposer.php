<?php


namespace App\Composers;


use App\Core\Auth;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use Exception;

/**
 * Class CommentsComposer
 * @package App\Composers
 */
class CommentsComposer
{
    /**
     * L'ID de la div de réponse
     * @see comments.blade.php
     */
    public const respId = 'response-logged';

    /**
     * Compose la vue
     *
     * @param $view
     * @param $vars
     * @return array
     * @throws Exception
     */
    public function compose($view, $vars){
        $wid = array_key_exists('wid', $vars) ? $vars['wid'] : null;
        $did = array_key_exists('did', $vars) ? $vars['did'] : null;
        $tid = array_key_exists('tid', $vars) ? $vars['tid'] : null;
        $yid = array_key_exists('yid', $vars) ? $vars['yid'] : null;

        $repo = new CommentRepository();
        list($roots, $children) = $this->buildChildren($repo->getCommentsFor($wid, $did, $tid, $yid), $repo);

        return \array_merge($vars, ['roots' => $roots, 'children' => $children, 'respId' => self::respId]);
    }

    /**
     * Construit la double liste avec les commentaires racines et les enfants
     *
     * @param $vrac
     * @param CommentRepository $cRepo
     * @return array[]
     * @throws Exception
     */
    public function buildChildren($vrac, CommentRepository $cRepo){
        $roots = [];
        $children = [];
        $repo = new UserRepository();
        $users = [];
        foreach($vrac as $comment) {
            // Ici on change le user
            if(!\array_key_exists($comment->getUser(), $users)){
                $users[$comment->getUser()] = $repo->get($comment->getUser());
            }
            $comment->setUser($users[$comment->getUser()]);

            $comment->{'likes'} = $cRepo->getLikes($comment->getId());
            if(Auth::isLogged()){
                $comment->{'isLiked'} = $cRepo->isLiked(Auth::loggedUser()->getId(), $comment->getId());
            }

            if($comment->getReplyTo() === null){
                $roots[] = $comment;
            }else{
                if(!\array_key_exists($comment->getReplyTo(), $children)){
                    $children[$comment->getReplyTo()] = [];
                }
                $children[$comment->getReplyTo()][] = $comment;
            }
        }
        //On retourne le tableau enfant car on veut les plus anciens au début (contrairement au roots)
        foreach($children as $key => $child){
            $children[$key] = array_reverse($child);
        }
        return [$roots, $children];
    }
}