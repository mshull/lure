<?php

// connect to lure
require 'libs/LureClient.php';

// get users
$result = getUsers();

// print results
echo $result;