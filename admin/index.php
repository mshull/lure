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

    Lure Admin : Index
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

// sign in post
if ($_POST) {
	try {
		$result = postAdminAuth($_POST);
		if ($result) {
			$_SESSION["auth"] = 1;
			header('Location: home.php');
			exit();
		}
	} catch (Exception $e) {
		$error = 1;
		include("templates/signin.html");
		exit();
	}
}

// check for session
if (!isset($_SESSION["auth"])) {
	include("templates/signin.html");
	exit();
} else {
	header('Location: home.php');
	exit();
}