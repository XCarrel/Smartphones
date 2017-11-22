<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 08.11.17
 * Time: 15:15
 */

abstract class SmartPhone implements Persistable // This class cannot be instanciated because we will only have iPhones or Android objects
{
    protected $idSmartphone; // protected attributes: they will be set from the subclass (either IPhone or Android)
    protected $brand;
    protected $model;
    protected $osName;
    protected $osVersion;

    private  static $discounted = false;
    protected static $dbh = null; // PDO database handler

    /**
     * Smartphone constructor.
     */
    public function __construct()
    {
        if (self::$dbh == null)
        {
            $mdb = new MysqlDb("smartphones");
            self::$dbh = $mdb->getDbh();
        }
    }

    public function load($id)
    {
        try
        {
            $sql = "SELECT idSmartphone, brand, model, osName, osVersion FROM smartphone WHERE idSmartphone=:id";
            $query = self::$dbh->prepare($sql);
            $query->bindParam("id",$id,PDO::PARAM_INT);
            $query->execute();
            $res=$query->fetchAll(PDO::FETCH_CLASS, "Android");
            $this->setIdSmartphone($res[0]->getIdSmartphone());
            $this->setBrand($res[0]->getBrand());
            $this->setModel($res[0]->getModel());
            $this->setOsName($res[0]->getOsName());
            $this->setOsVersion($res[0]->getOsVersion());
            return true;
        } catch (PDOException $e)
        {
            error_log("SQL Error in " . __FILE__ . ":" . __LINE__ . " :\n$sql\nError message:" . $e->getMessage());
            return false;
        }
    }

    /**
     * Creates a new record for the Smartphone part in the Db
     *
     * @return int : the idSmartphone of the record that was created - or false in case of error
     */
    public function create()
    {
        try
        {
            $sql = "INSERT INTO smartphone(brand, model, osName, osVersion) VALUES (:brand,:model,:osName,:osVersion)";
            $query = self::$dbh->prepare($sql);
            $query->bindParam("brand",$this->getBrand(),PDO::PARAM_STR);
            $query->bindParam("model",$this->getModel(),PDO::PARAM_STR);
            $query->bindParam("osName",$this->getOsName(),PDO::PARAM_STR);
            $query->bindParam("osVersion",$this->getOsVersion(),PDO::PARAM_STR);
            $query->execute();
            $this->setIdSmartphone(self::$dbh->lastInsertId());
            return $this->getIdSmartphone();
        } catch (PDOException $e)
        {
            error_log("SQL Error in " . __FILE__ . ":" . __LINE__ . " :\n$sql\nError message:" . $e->getMessage());
            return false;
        }
    }

    /**
     * Updates the Smartphone part of the object in the Db record
     *
     * @return bool : success
     */
    public function update()
    {
        try
        {
            $sql = "UPDATE smartphone SET brand=:brand, model=:model, osName=:osName, osVersion=:osVersion WHERE idSmartphone=:id";
            $query = self::$dbh->prepare($sql);
            $query->bindParam("id",$this->getIdSmartphone(),PDO::PARAM_INT);
            $query->bindParam("brand",$this->getBrand(),PDO::PARAM_STR);
            $query->bindParam("model",$this->getModel(),PDO::PARAM_STR);
            $query->bindParam("osName",$this->getOsName(),PDO::PARAM_STR);
            $query->bindParam("osVersion",$this->getOsVersion(),PDO::PARAM_STR);
            $query->execute();
            return true;
        } catch (PDOException $e)
        {
            error_log("SQL Error in " . __FILE__ . ":" . __LINE__ . " :\n$sql\nError message:" . $e->getMessage());
            return false;
        }
    }


    /**
     * @return mixed
     */
    public function getIdSmartphone()
    {
        return $this->idSmartphone;
    }

    /**
     * @return bool
     */
    public static function isDiscounted()
    {
        return self::$discounted;
    }

    /**
     * @param bool $discounted
     */
    public static function setDiscounted($discounted)
    {
        self::$discounted = $discounted;
    }

    /**
     * @param mixed $idSmartphone
     */
    public function setIdSmartphone($idSmartphone)
    {
        $this->idSmartphone = $idSmartphone;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getOsName()
    {
        return $this->osName;
    }

    /**
     * @param mixed $osName
     */
    public function setOsName($osName)
    {
        $this->osName = $osName;
    }

    /**
     * @return mixed
     */
    public function getOsVersion()
    {
        return $this->osVersion;
    }

    /**
     * @param mixed $osVersion
     */
    public function setOsVersion($osVersion)
    {
        $this->osVersion = $osVersion;
    }

    /**
     * @return mixed
     */
    public function getRamSize()
    {
        return $this->ramSize;
    }

    /**
     * @param mixed $ramSize
     */
    public function setRamSize($ramSize)
    {
        $this->ramSize = $ramSize;
    }

    /**
     * @return mixed
     */
    public function getStorageSize()
    {
        return $this->storageSize;
    }

    /**
     * @param mixed $storageSize
     */
    public function setStorageSize($storageSize)
    {
        $this->storageSize = $storageSize;
    }

}