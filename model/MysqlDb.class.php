<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 10.11.17
 * Time: 10:43
 */

class MysqlDb
{
    private $dbh;
    private static $maintenanceInProgress = false; // informs all apps that the service is unavailable

    /**
     * @return bool
     */
    public static function isMaintenanceInProgress()
    {
        return self::$maintenanceInProgress;
    }

    /**
     * @param bool $maintenanceInProgress
     */
    public static function setMaintenanceInProgress($maintenanceInProgress)
    {
        self::$maintenanceInProgress = $maintenanceInProgress;
    }

    /**
     * @return PDO
     */
    public function getDbh()
    {
        return $this->dbh;
    } // database handler

    /**
     * MysqlDb constructor.
     *
     * Initialises the connection for a given database, but always on the same server and with the same credentials
     */
    public function __construct($dbname)
    {
        $hostname = "localhost";
        $username = "root";
        $password = "root";
        try
        {
            $this->dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
            $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // return associative arrays. FETCH_OBJ won't work since we distribute inherited attributes in separate tables
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // throw exceptions in case of error
            $this->dbh->exec("SET NAMES 'utf8'");
        } catch (PDOException $e)
        {
            error_log ("erreur de connexion au serveur (" . $e->getMessage() . ")");
        }
    }

}