<?php


namespace App\Models;


use App\Core\File;

/**
 * Class Year
 * @package App\Models
 */
class Year
{
    /**
     * @var int L'id de l'année
     */
    private $id;
    /**
     * @var int L'année
     */
    private $year;
    /**
     * @var string Les tags
     */
    private $tags;

    /**
     * Construit un Year à partir d'une ligne de bdd
     *
     * @param $row
     * @return Year
     */
    public static function fromDbRow($row){
        $year = new Year();
        $year->setId($row['yid']);
        $year->setYear($row['year']);
        $year->setTags($row['tags']);
        return $year;
    }

    /**
     * Récupère le chemin de l'image de l'année
     *
     * @return string
     */
    public function getImagePath(){
        return self::getImagePathFromId($this->getId());
    }

    /**
     * Récupère le chemin de l'image de l'année
     *
     * @param $id
     * @return string
     */
    public static function getImagePathFromId($id){
        $path = 'img/years/' . $id . '.jpg';
        return File::exists(File::asset($path)) ? $path : 'img/years/default.jpg';
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
     * @return Year
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     * @return Year
     */
    public function setYear($year)
    {
        $this->year = $year;
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
     * @return Year
     */
    public function setTags($tags){
        $this->tags = is_array($tags) ? implode(',', $tags) : $tags;
        return $this;
    }
}