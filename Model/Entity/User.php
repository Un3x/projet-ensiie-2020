<?php

namespace Model\Entity;

class User {
    private $id;
    private $username;
    private $created_at;
    private $role;
    private $gamespseudo;

    public function getId () { return $this->id; }
    public function getUsername () { return $this->username; }
    public function getCreation () { return $this->created_at; }
    public function getRole () { return $this->role; }
    public function getGamespseudo () { return $this->gamespseudo; }
    public function setId ($data) { $this->id = $data; return $this; }
    public function setUsername ($data) { $this->username = $data; return $this; }
    public function setCreation ($data) { $this->created_at = $data; return $this; }
    public function setRole ($data) { $this->role = $data; return $this; }
    public function setGamespseudo ($data) { $this->gamespseudo = $data; return $this; }
}