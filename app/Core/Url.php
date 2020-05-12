<?php


namespace App\Core;


/**
 * Class Url
 * @package App\Core
 * @see Request
 */
class Url
{
    /**
     * @var string
     */
    public $pathUrl = null;
    /**
     * @var string
     */
    public $url = null;
    /**
     * @var string
     */
    public $baseUrl = null;
    /**
     * @var string
     */
    public $fullUrl = null;
    /**
     * @var string
     */
    public $queryString = null;

    /**
     * Url constructor.
     * @param string $pathUrl
     * @param string $url
     * @param string $baseUrl
     * @param string $fullUrl
     * @param string $queryString
     */
    public function __construct($pathUrl = null, $url = null, $baseUrl = null, $fullUrl = null, $queryString = null){
        $this->pathUrl = $pathUrl;
        $this->url = $url;
        $this->baseUrl = $baseUrl;
        $this->fullUrl = $fullUrl;
        $this->queryString = $queryString;
    }
}