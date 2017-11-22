<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 21.11.17
 * Time: 10:03
 */

class Android extends SmartPhone implements Persistable
{
    private $sd; // storage size of SD card, in Gb

    /*======================================== Getter/Setters ========================================
    /**
     * @return mixed
     */
    public function getSd()
    {
        return $this->sd;
    }

    /**
     * @param mixed $sd
     */
    public function setSd($sd)
    {
        $this->sd = $sd;
    }

    //======================================== Persistable interface implementation ==================
    /**
     * Fill in the object
     * @param $id
     */
    public function load($id)
    {
        if (parent::load($id)) // Load base record was successful -> go on and load specifics
        {
            try
            {
                $sql = "SELECT sd FROM Android WHERE fkPhone=:id";
                $query = self::$dbh->prepare($sql);
                $query->bindParam("id",$id);
                $query->execute();
                $res=$query->fetch();
                $this->setSd($res["sd"]);
            } catch (PDOException $e)
            {
                error_log("SQL Error in " . __FILE__ . ":" . __LINE__ . " :\n$sql\nError message:" . $e->getMessage());
            }
        }
        else
            error_log("Load failed for id=$id");
    }

    /**
     * Create new Db records to store the object attributes
     * @return int : the id of the base record
     */
    public function create()
    {
        $baseId = parent::create();
        if ($baseId > 0) // if creation of base was successful we can continue
        {
            try
            {
                $sql = "INSERT INTO Android (fkPhone, sd) VALUES (:fk,:sd)";
                $query = self::$dbh->prepare($sql);
                $query->bindParam("fk",$baseId,PDO::PARAM_INT);
                $query->bindParam("sd",$this->getSd(),PDO::PARAM_INT);
                $query->execute();
                return $baseId; // id of the base record must be used for reference
            } catch (PDOException $e)
            {
                self::$dbh->query("DELETE FROM smartphone WHERE idSmartphone=$baseId"); // cleanup: don't leave a base record with no specifics
                error_log("SQL Error in " . __FILE__ . ":" . __LINE__ . " :\n$sql\nError message:" . $e->getMessage());
            }
        }
        else
            error_log("Create failed");
    }

    /**
     * Update an existing set of database records
     */
    public function update()
    {
        if (parent::update()) // if update of base was successful we can continue
        {
            try
            {
                $sql = "UPDATE Android SET sd=:sd WHERE fkPhone=:id";
                $query = self::$dbh->prepare($sql);
                $query->bindParam("id",$this->getIdSmartphone(),PDO::PARAM_INT);
                $query->bindParam("sd",$this->getSd(),PDO::PARAM_INT);
                $query->execute();
            } catch (PDOException $e)
            {
                error_log("SQL Error in " . __FILE__ . ":" . __LINE__ . " :\n$sql\nError message:" . $e->getMessage());
            }
        }
        else
            error_log("Update failed");
    }
}