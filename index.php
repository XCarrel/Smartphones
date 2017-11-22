<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 08.11.17
 * Time: 15:22
 */

require_once ("autoload.php"); // Load all necessary class definitions

// after execution of the data.sql script, there are 4 smartphones in the db: 2 Androids and 2 iPhones

// Validate ability to create both types
// create a new Android phone
$ap = new Android();
$ap->setBrand("Nexus");
$ap->setModel("EX-9");
$ap->setOsName("Android");
$ap->setOsVersion("4.2");
$ap->setSd(16);
$ap->create(); // save it to the db -> that makes a third Android

// create a new iPhone phone
$ip = new IPhone();
$ip->setBrand("Apple");
$ip->setModel("5");
$ip->setOsName("iOS");
$ip->setOsVersion("8");
$ip->setThreeDT(false);
$ip->create(); // save it to the db -> that makes a third iPhone


// Validate ability to load from db and update
// create a new Android phone
$ap = new Android();
$ap->setBrand("Samsung");
$ap->setModel("G8");
$ap->setOsName("Android");
$ap->setOsVersion("7.1");
$ap->setSd(64);
$id = $ap->create(); // save it to the db -> that makes a fourth Android phone. We keep the id to now reload and modify

$phone = new Android();
$phone->load($id); // read back the new phone into new object
$phone->setSd(128); // modify object in memory
$phone->setOsVersion("7.2");
$phone->update(); // commit changes to db

// create a new iPhone phone
$ip = new IPhone();
$ip->setBrand("Apple");
$ip->setModel("7");
$ip->setOsName("iOS");
$ip->setOsVersion("9");
$ip->setThreeDT(true);
$id = $ip->create(); // save it to the db -> that makes a fourth iPhone. We keep the id to now reload and modify
$phone = new IPhone();
$phone->load($id); // read back the new phone into new object
$phone->setThreeDT(false); // modify object in memory
$phone->setOsVersion("9.1");
$phone->update(); // commit changes to db


// Initialize collection with phones of the database
$source = new SmartPhoneProvider();
$phones = array_merge($source->getAndroidSmartphones(),$source->getIPhoneSmartphones()); // we have 8 phones in the list: 4 Androids first, then 4 iPhones

// well... let's see ...
include("view/home.html");
?>