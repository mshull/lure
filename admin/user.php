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

    Lure Admin : User
    v.0.1.0
    
    By Michael Shull
    Github: @mshull
    mshull@g.harvard.edu
    
    This code uses the LureClient library to connect to 
    a local or remote Lure API.

*/

// ----------------------------------
// Libraries, Sessions and Constants
// ----------------------------------

// error checking
error_reporting(E_ALL);
ini_set('display_errors', 1);

// connect to lure
require 'libs/LureClient.php';

// start sessions
session_start();

// ----------------------------------
// Page Logic
// ----------------------------------

// check for session
if (!isset($_SESSION["auth"])) {
	header('Location: index.php');
	exit();
}

// check for edit or delete
if (isset($_GET['id']))
{
	$user = json_decode(getUser($_GET['id']), true);
}

// check for edit post
if ($_POST)
{
	if (isset($_POST['user']))
	{
		putUser($_POST['user'], array(
			'username' => $_POST['username'],
			'password' => $_POST['password'],
			'lastlogin' => $_POST['lastlogin'],
			'created' => $_POST['created']
		));

		$user = json_decode(getUser($_POST['user']), true);
		$updated = 1;
	}
	else
	{
		$res = json_decode(postUser(array(
			'username' => $_POST['username'],
			'password' => $_POST['password']
		)));

		$user = json_decode(getUser($res['id']), true);
		$created = 1;
	}
}

// show users page
include("templates/user.html");
exit();