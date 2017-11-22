<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 10.11.17
 * Time: 10:53
 */

function autoloader($class) {
    $fn = 'model/' . $class . '.class.php';
    if (file_exists($fn))
        require_once $fn;
    else
    {
        $fn = 'model/' . $class . '.interface.php';
        if (file_exists($fn))
            require_once $fn;
        else
        {
            error_log("Unknown class or interface $fn");
        }
    }
}

spl_autoload_register('autoloader');

?>