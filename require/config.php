<?php

$base_url    = "http://localhost/hotel_booking/";
$cp_base_url = "http://localhost/hotel_booking/backend/";
$sha_key     = "CX29834KD355FIU8ZE";
$currentDt   = date("Y-m-d H:i:s");

if (isset($_SESSION["user_id"])) {
    $loginId = $_SESSION["user_id"];
} else if (isset($_COOKIE["user_id"])) {
    $loginId = $_COOKIE["user_id"];
}   