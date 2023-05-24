<?php

require("../require/db_connect.php");
require("../require/config.php");
require("../require/include_functions.php");

$room_id = (int)($_GET["rid"]);
$id      = (int)($_GET["id"]);

$res_delete_gallery = softDeleteGallery($mysqli, $id);

if ($res_delete_gallery) {
    $url            = $cp_base_url . "manage_room_image.php?id=" . $room_id;
    header("Location:" . $url);
    exit();
}

