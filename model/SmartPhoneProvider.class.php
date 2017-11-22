<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 10.11.17
 * Time: 10:57
 */

class SmartPhoneProvider
{
    private $dbh;

    /**
     * SmartphoneProvider constructor.
     */
    public function __construct()
    {
        $handler = new MysqlDb("smartphones");
        $this->dbh = $handler->getDbh();
    }

    // Returns an array of Android objetcs
    public function getAndroidSmartphones()
    {
        if (!MysqlDb::isMaintenanceInProgress())
        {
            try
            {
                $sql = "SELECT idSmartphone, brand, model, osName, osVersion, sd FROM smartphone INNER JOIN Android ON smartphone.idSmartphone = Android.fkPhone";
                $query = $this->dbh->prepare($sql);
                $query->execute();
                return $query->fetchAll(PDO::FETCH_CLASS, "Android");
            } catch (PDOException $e)
            {
                error_log("SQL Error in " . __FILE__ . ":" . __LINE__ . " :\n$sql\nError message:" . $e->getMessage());
            }
        }
        else
        {
            error_log("Attempt to access Db during maintenance - declined");
        }
    }

    // Returns an array of Android objetcs
    public function getIPhoneSmartphones()
    {
        if (!MysqlDb::isMaintenanceInProgress())
        {
            try
            {
                $sql = "SELECT idSmartphone, brand, model, osName, osVersion, threeDT FROM smartphone INNER JOIN iPhone ON smartphone.idSmartphone = iPhone.fkPhone";
                $query = $this->dbh->prepare($sql);
                $query->execute();
                return $query->fetchAll(PDO::FETCH_CLASS, "IPhone");
            } catch (PDOException $e)
            {
                error_log("SQL Error in " . __FILE__ . ":" . __LINE__ . " :\n$sql\nError message:" . $e->getMessage());
            }
        }
        else
        {
            error_log("Attempt to access Db during maintenance - declined");
        }
    }

}