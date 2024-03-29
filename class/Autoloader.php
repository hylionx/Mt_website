<?php


/**
 * Autoloader
 * Pour charger automatiquement les class
 *
 * Liste des fonctions
 *  - load
 *  - autoload
 */

class Autoloader
{
    public static function load()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    static function autoload($classname)
    {
        include CLASSDIR . $classname . '.php';
    }
}
?>