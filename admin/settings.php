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

    Lure Admin : Settings
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

// check for post
if ($_POST && isset($_POST['username']) && isset($_POST['password']))
{
	putAdmin(array('username'=>$_POST['username'], 'password'=>$_POST['password']));
	$updated = 1;
}


// get settings data
$admin = json_decode(getAdmin(), true);

// show settings page
include("templates/settings.html");
exit();