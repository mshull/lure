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
    
    By Michael Shull
    Github: @mshull
    mshull@g.harvard.edu
    
    Lure is a central backend application for web, mobile and desktop 
    applications. Lure provides a common REST API for your applications 
    to interface with and optional JSON or serialized PHP response formats. 
    With Lure you can immediately focus on the UI portion of your 
    applications and spend less time re-inventing the wheel trying 
    create backend administration tools and cross-platform services.

    Lure Provides:
    - REST API for Backend
    - Data Administration Tool
    - Skeleton Code Generator for ...
      + Personal Website
      + Simple Blog
      + Small Online Community

    Requirements:
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

// api authentication settings
define("USERKEY", "test");
define("PASSKEY", "test");

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
        auth();
        global $db;
        $statement = $db->prepare("SELECT * from USERS");
        $result = sqlResultsToArr($statement->execute());
        echo json_encode($result);
    }
);

// Get User
$app->get('/user/:id',
    function ($id) {
        auth();
        global $db;
        echo 'user '.$id;
    }
);

// Create User
$app->post('/user',
    function () {
        auth();
        global $db;
        echo 'creating user';
    }
);

// Edit User
$app->put('/user/:id',
    function ($id) {
        auth();
        global $db;
        echo 'updating user '.$id;
    }
);

// Remove User
$app->delete('/user/:id',
    function ($id) {
        auth();
        global $db;
        echo 'deleting user '.$id;
    }
);

// Get Data Object List
$app->get('/datas',
    function () {
        auth();
        global $db;
        echo 'list of data objects';
    }
);

// Get Data Object
$app->get('/data/:id',
    function ($id) {
        auth();
        global $db;
        echo 'data object'.$id;
    }
);

// Create Data Object
$app->post('/data',
    function () {
        auth();
        global $db;
        echo 'creating data object';
    }
);

// Edit Data Object
$app->put('/data/:id',
    function ($id) {
        auth();
        global $db;
        echo 'updating data object '.$id;
    }
);

// Remove Data Object
$app->delete('/data/:id',
    function ($id) {
        auth();
        global $db;
        echo 'deleting data object '.$id;
    }
);

// Edit User
$app->put('/admincred',
    function () {
        global $db, $app, $headers;
        if (!isset($headers['API-USER']) || !isset($headers['API-PASS'])) {
            $app->halt(403, 'Permission Denied');
        }
        if ($headers['API-USER'] != USERKEY || $headers['API-PASS'] != PASSKEY) {
            $app->halt(403, 'Permission Denied');
        }

        echo 'updating user '.$id;
    }
);


// ----------------------------------
// Start Application and Cleanup
// ----------------------------------

// run app
$app->run();

// close database
$db->close();