<?php

require("../require/db_connect.php");
require("../require/config.php");
require("../require/include_functions.php");

$id          = (int)($_GET["id"]);
$table       = "rooms";
$res_del_sql = deleteQuery($mysqli, $table, $id); 

if ($res_del_sql) {
    $url     = $cp_base_url . "show_room.php?message=delete";
    header("Location:" . $url);
    exit();
}