<?php

namespace Model\Entity;

class Game {
    private $abrev;
    private $fullname;
    private $description;
    private $players;
    private $note;
    private $genres;

    public function getAbrev () { return $this->abrev; }
    public function getFullname () { return $this->fullname; }
    public function getDescription () { return $this->description; }
    public function getPlayers () { return $this->players; }
    public function getNote () { return $this->note; }
    public function getGenres () { return $this->genres; }
    public function setAbrev ($data) { $this->abrev = $data; return $this; }
    public function setFullname ($data) { $this->fullname = $data; return $this; }
    public function setDescription ($data) { $this->description = $data; return $this; }
    public function setPlayers ($data) { $this->players = $data; return $this; }
    public function setNote ($data) { $this->note = $data; return $this; }
    public function setGenres ($data) { $this->genres = $data; return $this; }
}