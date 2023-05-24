<?php

require("../require/db_connect.php");
require("../require/config.php");
require("../require/include_functions.php");

$id          = (int)($_GET["id"]);
$table       = "reservations";
$res_del_sql = deleteQuery($mysqli, $table, $id); 

if ($res_del_sql) {
    $url     = $cp_base_url . "show_reservations.php?message=delete";
    header("Location:" . $url);
    exit();
}