<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// --------------------------------------------------------
//             __                             
//    |       /\ \                            
//    |       \ \ \      __  __  _ __    __   
//    !        \ \ \  __/\ \/\ \/\`'__\/'__`\ 
//    J         \ \ \L\ \ \ \_\ \ \ \ /\  __/ 
//    _/o        \ \____/\ \____/\ \_\\ \____\
//  ~~\_)\~~~     \/___/  \/___/  \/_/ \/____/
// 
// --------------------------------------------------------
/*

    Lure : A BaaS (Backend as a Service)
    v.0.1.2
    
    By Michael Shull
    Github: @mshull
    mshull@g.harvard.edu
    
    Lure is a central backend service for web, mobile and desktop 
    applications. Lure provides a common REST API and optional JSON 
    or serialized PHP response formats. With Lure you can immediately 
    focus on the UI portion of your applications and spend less time 
    re-inventing the wheel trying to create backend administration 
    tools and cross-platform services.

    Lure Provides:
    - REST API for Backend
    - Administration Tool w/ Docs
    - Example Website

    Requirements:
    - Linux (Tested on Ubuntu and Mint)
    - PHP 5.3+
    - Apache w/.htaccess enabled
    - PHP SQLite Mod

    Installation:
    - Installation Shell Script: 
      https://github.com/mshull/install-lure
    - Manual Installation Instructions:
      https://github.com/mshull/lure

*/

// ----------------------------------
// Libraries and Constants
// ----------------------------------

// Slim PHP Framework
require 'libs/Slim/Slim.php';

// database file (created if not found)
define("DBFILE", "data/database.db");

// api authentication keys
define("USERKEY", "usertest");
define("PASSKEY", "passtest");
define("ADMINKEY", "admintest");

// ----------------------------------
// Instantiate
// ----------------------------------

// auto load Slim framework
\Slim\Slim::registerAutoloader();

// create master app variable
$app = new \Slim\Slim();

// database class
class DataBase extends SQLite3 { 
    function __construct() { $this->open(DBFILE); } 
}

// create db variable
$db = new DataBase();

// error check for database
if (!$db) exit($db->lastErrorMsg());

// get headers
$headers = $app->request->headers;

// auth function
function auth() {
    global $app, $headers;
    if (!isset($headers['API-USER']) || !isset($headers['API-PASS'])) $app->halt(403, 'Permission Denied');
    if ($headers['API-USER'] != USERKEY || $headers['API-PASS'] != PASSKEY) $app->halt(403, 'Permission Denied');
}

// sqlite result to array
function sqlResultsToArr($result) {
    $arr = array();
    while($row = $result->fetchArray(SQLITE3_ASSOC)) $arr[] = $row;
    return $arr;
}

// ----------------------------------
// Routes
// ----------------------------------

// Get Users
$app->get('/users',
    function () {
        global $db;
        auth();
        $statement = $db->prepare("SELECT * FROM Users");
        $result = sqlResultsToArr($statement->execute());
        echo json_encode($result);
    }
);

// Get User
$app->get('/user/:id',
    function ($id) {
        auth();
        global $db;
        $statement = $db->prepare("SELECT * FROM Users WHERE id = :id");
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        $row = array();
        if ($result) $row = $result->fetchArray(SQLITE3_ASSOC);
        echo json_encode($row);
    }
);

// Create User
$app->post('/user',
    function () {
        global $db, $app;
        $vars = $app->request->post();
        auth();
        $statement = $db->prepare("INSERT INTO Users (username, password, created) VALUES (:un, :pw, :time)");
        $statement->bindValue(':un', $vars['username']);
        $statement->bindValue(':pw', $vars['password']);
        $statement->bindValue(':time', time(), SQLITE3_INTEGER);
        $result = $statement->execute();
        $res = array('id'=>$db->lastInsertRowid());
        echo json_encode($res);
    }
);

// Edit User
$app->put('/user/:id',
    function ($id) {
        global $db, $app;
        $vars = $app->request->put();
        auth();
        $cols = array();
        $handles = array();
        $vals = array();
        foreach ($vars as $key => $value) {
            $cols[] = $key." = :".$key;
            $handles[] = ":".$key;
            $vals[] = $value;
        }
        $statement = $db->prepare("UPDATE Users SET ".implode(",",$cols)." WHERE id = :id");
        for ($i=0; $i<count($handles); $i++) {
            $statement->bindValue($handles[$i], $vals[$i]);
        }
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        echo json_encode(array('success'=>'true'));
    }
);

// Remove User
$app->delete('/user/:id',
    function ($id) {
        global $db;
        auth();
        $statement = $db->prepare("DELETE FROM Users WHERE id = :id");
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        echo json_encode(array('success'=>'true'));
    }
);

// Get Data Object List
$app->get('/datas',
    function () {
        global $db;
        auth();
        $statement = $db->prepare("SELECT * FROM Data");
        $result = sqlResultsToArr($statement->execute());
        echo json_encode($result);
    }
);

// Get Data Object
$app->get('/data/:id',
    function ($id) {
        auth();
        global $db;
        $statement = $db->prepare("SELECT * FROM Data WHERE id = :id");
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        $row = array();
        if ($result) $row = $result->fetchArray(SQLITE3_ASSOC);
        echo json_encode($row);
    }
);

// Create Data Object
$app->post('/data',
    function () {
        global $db, $app;
        $vars = $app->request->post();
        if (!isset($vars['tag'])) $vars['tag'] = "";
        auth();
        $statement = $db->prepare("INSERT INTO Data (tag, data, created) VALUES (:tag, :data, :time)");
        $statement->bindValue(':tag', $vars['tag']);
        $statement->bindValue(':data', $vars['data']);
        $statement->bindValue(':time', time(), SQLITE3_INTEGER);
        $result = $statement->execute();
        $res = array('id'=>$db->lastInsertRowid());
        echo json_encode($res);
    }
);

// Edit Data Object
$app->put('/data/:id',
    function ($id) {
        global $db, $app;
        $vars = $app->request->put();
        auth();
        $cols = array();
        $handles = array();
        $vals = array();
        foreach ($vars as $key => $value) {
            $cols[] = $key." = :".$key;
            $handles[] = ":".$key;
            $vals[] = $value;
        }
        $statement = $db->prepare("UPDATE Data SET ".implode(",",$cols)." WHERE id = :id");
        for ($i=0; $i<count($handles); $i++) {
            $statement->bindValue($handles[$i], $vals[$i]);
        }
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        echo json_encode(array('success'=>'true'));
    }
);

// Remove Data Object
$app->delete('/data/:id',
    function ($id) {
        global $db;
        auth();
        $statement = $db->prepare("DELETE FROM Data WHERE id = :id");
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        echo json_encode(array('success'=>'true'));
    }
);

// Edit Admin Cred
$app->put('/admincred',
    function () {
        global $db, $app, $headers;
        if (!isset($headers['API-USER']) || !isset($headers['API-PASS'])) {
            $app->halt(403, 'Permission Denied');
        }
        if ($headers['API-USER'] != USERKEY || $headers['API-PASS'] != PASSKEY) {
            $app->halt(403, 'Permission Denied');
        }
        if (!isset($headers['API-ADMIN'])) {
            $app->halt(403, 'Permission Denied');
        }
        if ($headers['API-ADMIN'] != ADMINKEY) {
            $app->halt(403, 'Permission Denied');
        }
        $vars = $app->request->put();
        auth();
        $cols = array();
        $handles = array();
        $vals = array();
        foreach ($vars as $key => $value) {
            $cols[] = $key." = :".$key;
            $handles[] = ":".$key;
            $vals[] = $value;
        }
        $statement = $db->prepare("UPDATE Settings SET ".implode(",",$cols));
        for ($i=0; $i<count($handles); $i++) {
            $statement->bindValue($handles[$i], $vals[$i]);
        }
        $result = $statement->execute();
        echo json_encode(array('success'=>'true'));
    }
);


// ----------------------------------
// Start Application and Cleanup
// ----------------------------------

// run app
$app->run();

// close database
$db->close();