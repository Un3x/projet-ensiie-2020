<?php


namespace App\Models;


use App\Core\File;

/**
 * Class Type
 * @package App\Models
 */
class Type
{
    /**
     * @var int L'id du type
     */
    private $id;
    /**
     * @var string Le nom du type
     */
    private $name;
    /**
     * @var string Les tags du type
     */
    private $tags;

    /**
     * Construit un Type à partir d'une ligne de la bdd
     *
     * @param $row
     * @return Type
     */
    public static function fromDbRow($row){
        $type = new Type();
        $type->setId($row['tid']);
        $type->setName($row['name']);
        $type->setTags($row['tags']);
        return $type;
    }

    /**
     * Récupère le chemin de l'image du Type
     *
     * @return string
     */
    public function getImagePath(){
        return self::getImagePathFromId($this->getId());
    }

    /**
     * Récupère le chemin de l'image du Type
     *
     * @param $id
     * @return string
     */
    public static function getImagePathFromId($id){
        $path = 'img/types/' . $id . '.jpg';
        return File::exists(File::asset($path)) ? $path : 'img/types/default.jpg';
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Type
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Type
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param bool $array
     * @return mixed
     */
    public function getTags($array = true){
        return $array ? explode(',', $this->tags) : $this->tags;
    }

    /**
     * @param mixed $tags
     * @return Type
     */
    public function setTags($tags){
        $this->tags = is_array($tags) ? implode(',', $tags) : $tags;
        return $this;
    }
}