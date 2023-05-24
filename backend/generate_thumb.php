<?php

$uploaded_img = $root_path . "upload/" . $room_id . "/" . $image_name;
$thumb_path   = "../" . "upload/" . $room_id . "/thumb/";

if (!file_exists($thumb_path)) {
    mkdir($thumb_path, 0777, true);
}

$thumb_name   = "thumb_" . $image_name;
$thumb_img    = $thumb_path . $thumb_name;
$watermark    = "../assets/images/watermark.jpg";
$thumbnail    = createThumbnail($uploaded_img, $thumb_img, $thumb_width, $thumb_height, $thumb_quality, $watermark);