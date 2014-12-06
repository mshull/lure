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
    - SQLite (Built into PHP 5.3+)

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

// ----------------------------------
// Routes
// ----------------------------------

// Home Test
$app->get('/',
    function () {
        echo 'home page';
    }
);

// Get Users
$app->get('/users',
    function () {
        echo 'list of users';
    }
);

// Get User
$app->get('/user/:id',
    function ($id) {
        echo 'user '.$id;
    }
);

// Create User
$app->post('/user',
    function () {
        echo 'creating user';
    }
);

// Edit User
$app->put('/user/:id',
    function ($id) {
        echo 'updating user '.$id;
    }
);

// Remove User
$app->delete('/user/:id',
    function ($id) {
        echo 'deleting user '.$id;
    }
);

// Get Data Object List
$app->get('/datas',
    function () {
        echo 'list of data objects';
    }
);

// Get Data Object
$app->get('/data/:id',
    function ($id) {
        echo 'data object'.$id;
    }
);

// Create Data Object
$app->post('/data',
    function () {
        echo 'creating data object';
    }
);

// Edit Data Object
$app->put('/data/:id',
    function ($id) {
        echo 'updating data object '.$id;
    }
);

// Remove Data Object
$app->delete('/data/:id',
    function ($id) {
        echo 'deleting data object '.$id;
    }
);


// ----------------------------------
// Start Application and Cleanup
// ----------------------------------

// run app
$app->run();

// close database
$db->close();