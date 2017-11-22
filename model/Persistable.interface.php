<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 21.11.17
 * Time: 08:25
 */

/**
 * Interface Persistable
 *
 * Confers to objects the ability to store their state in a persistent storage
 */
interface Persistable
{
    public function create();   // Create new records in the storage. Returns the new id
    public function update();   // Store values in the storage
    public function load($id);  // Initialize object with value from the storage
}