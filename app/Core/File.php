<?php


namespace App\Core;


/**
 * Class File
 * @package App\Core
 */
class File
{
    /**
     * Les types d'images supportés
     */
    const IMAGE_TYPES = [
        IMAGETYPE_GIF,
        IMAGETYPE_JPEG,
        IMAGETYPE_PNG,
        IMAGETYPE_WBMP,
        IMAGETYPE_JPEG2000,
        IMAGETYPE_XBM,
        IMAGETYPE_ICO,
        IMAGETYPE_WEBP,
    ];

    /**
     * Vérifie si le fichier existe
     * @param $path
     * @return bool
     */
    public static function exists($path){
        $tmp = self::absolute($path);
        return file_exists($tmp) || file_exists($path);
    }

    /**
     * Permet de supprimer un fichier
     * Renvoie faux uniquement si le fichier est encore présent (donc vrai si le fichier n'existe pas)
     *
     * @param $path
     * @return bool
     */
    public static function delete($path){
        if(file_exists($path)){
            return unlink($path);
        }
        $tmp = self::absolute($path);
        if(file_exists($tmp)){
            return unlink($path);
        }
        return true;
    }

    /**
     * Renvoie le chemin absolu du fichier
     * @param $path
     * @return string
     */
    public static function absolute($path){
        // Petit fix hacky pour Windows
        return str_replace('\\', '/', __ROOT__) . '/' . ltrim($path, '/');
    }

    /**
     * Permet de récupérer un chemin absolu pour un asset
     * @param $path
     * @return string
     */
    public static function asset($path){
        return str_replace('\\', '/', __PUBLIC__) . '/assets/' . ltrim($path, '/');
    }

    /**
     * Liste les fichiers dans le dossier donné
     *
     * @param $folder
     * @return array|bool|false
     */
    public static function listFiles($folder){
        $path = File::absolute($folder);
        if(!file_exists($path)){
            $path = $folder;
        }
        if(!file_exists($path)){
            return false;
        }

        return array_diff(scandir($path), array('..', '.'));
    }

    /**
     * Permet de convertir une image donnée en resource au chemin indiqué
     *
     * @param $input_file
     * @param $imageType
     * @param $output_file
     * @return bool|false|resource
     */
    public static function convertImage($input_file){
        $type = \exif_imagetype($input_file);
        if(!in_array($type, self::IMAGE_TYPES, true)){
            App::addError("Type d'image non supporté !");
            return false;
        }
        $input = \imagecreatefromstring( file_get_contents( $input_file ) );
        list($width, $height) = \getimagesize($input_file);
        $output = \imagecreatetruecolor($width, $height);
        if($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF){
            imagecolortransparent($output, imagecolorallocatealpha($output, 0, 0, 0, 127));
            imagealphablending($output, false);
            imagesavealpha($output, true);
            imagecopyresampled( $output, $input,
                0, 0,
                0, 0,
                $width, $height,
                $width, $height);
        }else{
            $white = \imagecolorallocate($output,  255, 255, 255);
            \imagefilledrectangle($output, 0, 0, $width, $height, $white);
            \imagecopy($output, $input, 0, 0, 0, 0, $width, $height);
        }

        return $output; //imagejpeg($output, $output_file);
    }
}