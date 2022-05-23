<?php
namespace App;

class FileFactory
{
    private static $path;

    function __construct($label = null)
    {
        self::$path = './'.$label?$label.'/':'';
    }

    public static function init($config)
    {
        
    }

    public static function SaveFile($file = null)
    {
        if($file){
            return json_encode(array('success'=>true));
        }
        else
        return json_encode(array('success'=>false));
    }

}

?>