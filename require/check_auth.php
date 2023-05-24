<?php

session_start();
require("../require/db_connect.php");
require("../require/config.php");
require("../require/include_functions.php");
require("../require/common.php");

if (isset($_COOKIE["user_id"]) || isset($_COOKIE["user_name"])) {
    $user_id               = $_COOKIE["user_id"];
    $check_db_name_sql     = "SELECT".
                             " id ".
                             "FROM".
                             " `users` ".
                             "WHERE".
                             " id = '" . 
                             $user_id . 
                             "'";
    $res_check_db_name_sql = $mysqli->query($check_db_name_sql);
    $res_row               = $res_check_db_name_sql->num_rows;

    if ($res_row <= 0) {
        $url               = $cp_base_url . "login.php";
        header("Location:" . $url);
        exit();
    }
} else if (isset($_SESSION["user_id"]) || isset($_SESSION["user_name"])) {
    $user_id               = $_SESSION["user_id"];
    $check_db_name_sql     = "SELECT".
                             " id ".
                             "FROM".
                             " `users` ".
                             "WHERE".
                             " id = '" . 
                             $user_id . 
                             "'";
    $res_check_db_name_sql = $mysqli->query($check_db_name_sql);
    $res_row               = $res_check_db_name_sql->num_rows;

    if ($res_row <= 0) {
        $url               = $cp_base_url . "login.php";
        header("Location:" . $url);
        exit();
    }
} else {
    $url                   = $cp_base_url . "login.php";
    header("Location:" . $url);
    exit();
}