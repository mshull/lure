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
    v.0.1.1
    
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
$pest->curl_opts[CURLOPT_HTTPHEADER][] = "API-USER: ".LURE_USERKEY;
$pest->curl_opts[CURLOPT_HTTPHEADER][] = "API-PASS: ".LURE_PASSKEY;
$pest->curl_opts[CURLOPT_HTTPHEADER][] = "API-ADMIN: ".LURE_ADMINKEY;
$pest->curl_opts[CURLOPT_HTTPHEADER][] = "API-FORMAT: ".LURE_DATA_FORMAT;

// ----------------------------------
// Client Functions
// ----------------------------------

// get all users
function getUsers()
{
	global $pest;
	$users = $pest->get('/users');
	return $users;
}

// get user by id
function getUser($id)
{
	global $pest;
	$user = $pest->get('/user/'.$id);
	return $user;
}

// post user
function postUser($arr)
{
	global $pest;
	$result = $pest->post('/user/', $arr);
	return $result;
}

// update user
function putUser($id, $arr)
{
	global $pest;
	$result = $pest->get('/user/'.$id, $arr);
	return $result;
}

// delete user
function deleteUser($id)
{
	global $pest;
	$result = $pest->delete('/user/'.$id);
	return $result;
}

// get all data
function getDatas()
{
	global $pest;
	$datas = $pest->get('/datas');
	return $datas;
}

// get data by id
function getData($id)
{
	global $pest;
	$data = $pest->get('/data/'.$id);
	return $data;
}

// post data
function postData($arr)
{
	global $pest;
	$result = $pest->post('/data/', $arr);
	return $result;
}

// update data
function putData($id, $arr)
{
	global $pest;
	$result = $pest->put('/data/'.$id, $arr);
	return $result;
}

// delete user
function deleteData($id)
{
	global $pest;
	$result = $pest->delete('/data/'.$id);
	return $result;
}