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

    Lure Admin : Data Object
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

// check for edit
if (isset($_GET['id']))
{
	$data = json_decode(getData($_GET['id']), true);
}

// check for edit post
if ($_POST)
{
	if (isset($_POST['dat']))
	{
		putData($_POST['dat'], array(
			'tag' => $_POST['tag'],
			'data' => $_POST['data'],
			'updated' => $_POST['updated'],
			'created' => $_POST['created']
		));

		$data = json_decode(getData($_POST['dat']), true);
		$updated = 1;
	}
	else
	{
		$res = json_decode(postData(array(
			'tag' => $_POST['tag'],
			'data' => $_POST['data'],
			'updated' => $_POST['updated'],
			'created' => $_POST['created']
		)), true);

		$data = json_decode(getData($res['id']), true);
		$created = 1;
	}
}

// show data page
include("templates/data.html");
exit();