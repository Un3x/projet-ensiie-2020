<?php

namespace Hashtag;

class Hashtag {
    /**
     * @var int
     */
    private $id_hashtag;

    /**
     * @var String
     */
    private $name;

    /**
     * @return String
     */
    public function getNameHashtag()
    {
        return $this->name;
    }
    
    /**
     * @param String $name
     */
    public function setNameHashtag($name)
    {
        $this->name=$name;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdHashtag()
    {
        return $this->id_hashtag;
    }

    /**
     * @param int $id
     */
    public function setIdHashtag($id)
    {
        $this->id_hashtag=$id;
        return $this;
    }
}