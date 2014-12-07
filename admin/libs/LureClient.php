<?php

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

    Lure PHP Client : Connect to Lure API
    v.0.1.2
    
    By Michael Shull
    Github: @mshull
    mshull@g.harvard.edu
    
    This code provides functions allowing you to easily 
    connect to a Lure REST API.

*/

// ----------------------------------
// Libraries and Constants
// ----------------------------------

// pest REST client library
require 'Pest/Pest.php';

// code constants
define("LURE_SERVER", "http://localhost");
define("LURE_USERKEY", "usertest");
define("LURE_PASSKEY", "passtest");
define("LURE_ADMINKEY", "admintest");
define("LURE_DATA_FORMAT", "php");

// ----------------------------------
// Instantiate
// ----------------------------------

$pest = new Pest(LURE_SERVER);
$headers = array(
	"API-USER: ".LURE_USERKEY,
	"API-PASS: ".LURE_PASSKEY,
	"API-ADMIN: ".LURE_ADMINKEY,
	"API-FORMAT: ".LURE_DATA_FORMAT
);

// ----------------------------------
// Client Functions
// ----------------------------------

// get all users
function getUsers()
{
	global $pest, $headers;
	$users = $pest->get('/users', array(), $headers);
	return $users;
}

// get user by id
function getUser($id)
{
	global $pest, $headers;
	$user = $pest->get('/user/'.$id, array(), $headers);
	return $user;
}

// post user
function postUser($arr)
{
	global $pest, $headers;
	$result = $pest->post('/user', $arr, $headers);
	return $result;
}

// update user
function putUser($id, $arr)
{
	global $pest, $headers;
	$result = $pest->put('/user/'.$id, $arr, $headers);
	return $result;
}

// delete user
function deleteUser($id)
{
	global $pest, $headers;
	$result = $pest->delete('/user/'.$id, $headers);
	return $result;
}

// get all data
function getDatas()
{
	global $pest, $headers;
	$datas = $pest->get('/datas', array(), $headers);
	return $datas;
}

// get data by id
function getData($id)
{
	global $pest, $headers;
	$data = $pest->get('/data/'.$id, array(), $headers);
	return $data;
}

// get data by tag
function getDataByTag($tag)
{
	global $pest, $headers;
	$datas = $pest->get('/data/tag/'.$tag, array(), $headers);
	return $datas;
}

// post new data object
function postData($arr)
{
	global $pest, $headers;
	$result = $pest->post('/datao', $arr, $headers);
	return $result;
}

// update data object
function putData($id, $arr)
{
	global $pest, $headers;
	$result = $pest->put('/data/'.$id, $arr, $headers);
	return $result;
}

// delete data object
function deleteData($id)
{
	global $pest, $headers;
	$result = $pest->delete('/data/'.$id, $headers);
	return $result;
}


// post admin authentication
function postAdminAuth($arr)
{
	global $pest, $headers;
	$result = $pest->post('/adminauth', $arr, $headers);
	return $result;
}

// post admin authentication
function getAdmin()
{
	global $pest, $headers;
	$result = $pest->get('/admincred', $arr, $headers);
	return $result;
}

// update admin settings
function putAdmin($arr)
{
	global $pest, $headers;
	$result = $pest->put('/admincred', $arr, $headers);
	return $result;
}