<?php

namespace Model\Entity;

class Message {
    private $id;
    private $user;
    private $content;
    private $created_at;
    private $visibility;
    private $type;
    private $reply;
    private $reactions;

    public function getId () { return $this->id; }
    public function getUser () { return $this->user; }
    public function getContent () { return $this->content; }
    public function getCreation () { return $this->created_at; }
    public function getVisibility () { return $this->visibility; }
    public function getType () { return $this->type; }
    public function getReply () { return $this->reply; }
    public function getReactions () { return $this->reactions; }
    public function setId ($data) { $this->id = $data; return $this; }
    public function setUser ($id, $username, $role) {
        $this->user = new User();
        $this->user
            ->setId($id)
            ->setUsername($username)
            ->setRole($role);
        return $this;
    }
    public function setContent ($data) { $this->content = $data; return $this; }
    public function setCreation ($data) { $this->created_at = $data; return $this; }
    public function setVisibility ($data) { $this->visibility = $data; return $this; }
    public function setType ($data) { $this->type = $data; return $this; }
    public function setReply ($data) { $this->reply = $data; return $this; }
    public function setReactions ($data) { $this->reactions = $data; return $this; }
}