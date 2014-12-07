<?php

// error checking on
error_reporting(E_ALL);
ini_set('display_errors', 1);

// connect to lure
require 'libs/LureClient.php';

// get users
$result = getUsers();

// print results
echo $result;