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

    Lure Admin : Log Out Page
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

// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 

// back to sign in
header('Location: index.php');

// exit to be safe
exit();