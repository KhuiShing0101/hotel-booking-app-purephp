<?php

$server_name = "localhost";
$user_name   = "root";
$password    = "root";
$db_name     = "hotel_booking";

/** Build Database Connection */
$mysqli      = new mysqli($server_name, $user_name, $password, $db_name);

/** Check Database Connection */
if ($mysqli->connect_error) {
    echo "Connect Error ->".$mysqli->connect_error;
} 