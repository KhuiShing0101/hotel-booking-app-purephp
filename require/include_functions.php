<?php

function checkBlankInput($data) {
    $return        = [];
    $error         = false;
    $error_message = "";

    foreach ($data as $key => $val) {
        if (!(is_array($val))) {
            $val   = trim($val);
        }

        if ($val == "" || $val == []) {
            $error          = true;
            $error_message .= $val . " cannot be Empty! <br/>";
        }
    }

    if ($error == true) {
        $return["error"]         = $error;
        $return["error_message"] = $error_message;
    }

    return $return;
}

function checkDatabaseExistence($mysqli, $table, $name, $id = null) {
    $return        = [];
    $error         = false;
    $error_message = "";

    if ($id == null) {
        $sql           = "SELECT id FROM $table WHERE name = '" . $name . "' AND deleted_at IS NULL";
        $res_sql       = $mysqli->query($sql);
        $res_row       = $res_sql->num_rows;
    } else {
        $sql           = "SELECT id FROM $table WHERE name = '" . $name . "' AND id != '" . $id . "' AND deleted_at IS NULL";
        $res_sql       = $mysqli->query($sql);
        $res_row       = $res_sql->num_rows;
    }

    if ($res_row >= 1) {
        $error         = true;
        $error_message = $name ." is already exit!";
    }

    if ($error == true) {
        $return["error"]         = $error;
        $return["error_message"] = $error_message;
    }

    return $return;
}

function checkCustomerExistence ($mysqli, $data) {
    $return        = [];
    $error         = false;
    $error_message = "";

    $sql           = "";
    $sql          .= "SELECT id FROM `customers` WHERE ";
    foreach ($data as $col => $value) {
        $sql      .= $col . "='" . $value . "' OR ";
    }
    $sql           = rtrim($sql, "OR ");
    $res_sql       = $mysqli->query($sql);
    $res_row       = $res_sql->num_rows;

    if ($res_row >= 1) {
        $error          = true;
        $error_message .= "This customer already exit in database";
    }
    
    if ($error == true) {
        $return["error"]         = $error;
        $return["error_message"] = $error_message;
    }

    return $return;
}

function insertQuery($mysqli, $table, $data) {
    $currentDt   = date("Y-m-d H:i:s");

    if (isset($_SESSION["user_id"])) {
        $loginId = $_SESSION["user_id"];
    } else if (isset($_COOKIE["user_id"])) {
        $loginId = $_COOKIE["user_id"];
    } else {
        $loginId = 0;
    }

    $column      = "";
    $value       = "";

    foreach ($data as $key => $val) {
        $column .= $key . ",";
        $value  .= "'" . $val . "',";
    }

    $sql         = "";
    $sql        .= "INSERT INTO $table (";
    $sql        .= $column;
    $sql        .= "created_at,updated_at,created_by,updated_by";
    $sql        .= ")";
    $sql        .= " VALUES (";
    $sql        .= $value;
    $sql        .= "'$currentDt','$currentDt','$loginId','$loginId'";
    $sql        .= ")";
    $res_sql     = $mysqli->query($sql);

    return $res_sql;
}

function updateQuery($mysqli, $table, $data, $id) {
    $currentDt   = date("Y-m-d H:i:s");

    if (isset($_SESSION["user_id"])) {
        $loginId = $_SESSION["user_id"];
    } else if (isset($_COOKIE["user_id"])) {
        $loginId = $_COOKIE["user_id"];
    }

    $sql         = "";
    $sql        .= "UPDATE $table SET ";

    foreach ($data as $key => $val) {
        $sql    .= "$key='$val',";
    }

    $sql        .= "updated_at='$currentDt',updated_by='$loginId'";
    $sql        .= " WHERE id = '$id'";
    $res_sql     = $mysqli->query($sql); 

    return $res_sql;
}

function selectQuery($mysqli, $table, $data, $type_value = null) {
    $col         = "";

    foreach ($data as $column) {
        $col    .= $column . ",";
    }
    $col         = rtrim($col, ",");

    $sql         = "SELECT ";
    $sql        .= $col;

    if ($type_value == null) {
        $sql    .= " FROM $table WHERE deleted_at IS NULL";
    } else {
        $sql    .= " FROM $table WHERE type = '$type_value' AND deleted_at IS NULL";
    }

    $res_sql     = $mysqli->query($sql);

    return $res_sql;
}

function selectQueryById($mysqli, $table, $id, $type_value = null) {
    if ($type_value == null) {
        $sql     = "SELECT id,name FROM $table WHERE id = '$id'";
    } else {
        $sql     = "SELECT id,name,type FROM $table WHERE id = '$id'";
    }

    $res_sql     = $mysqli->query($sql);

    return $res_sql;
}

function listingQuery($mysqli, $table) {
    $sql         = "SELECT id,name FROM $table WHERE deleted_at IS NULL";
    $res_sql     = $mysqli->query($sql);

    return $res_sql;
}

function listingRoomQuery($mysqli) {
    $sql         = "SELECT rooms.*,beds.name AS bed_name,views.name AS view_name FROM rooms LEFT JOIN beds ON rooms.bed_id = beds.id LEFT JOIN views ON rooms.view_id = views.id WHERE rooms.deleted_at IS NULL";
    $res_sql     = $mysqli->query($sql);

    return $res_sql;
}

function deleteQuery($mysqli, $table, $id) {
    $currentDt   = date("Y-m-d H:i:s");

    if (isset($_SESSION["user_id"])) {
        $loginId = $_SESSION["user_id"];
    } else if (isset($_COOKIE["user_id"])) {
        $loginId = $_COOKIE["user_id"];
    }

    $sql         = "UPDATE $table SET deleted_at = '$currentDt',deleted_by = '$loginId' WHERE id = '$id'";
    $res_sql     = $mysqli->query($sql);
    
    return $res_sql;
}

function getRoomDetailByID($mysqli, $id) {
    $sql         = "SELECT id,name,description,detail,occupancy,type,size FROM `rooms` WHERE id = '$id'";
    $res_sql     = $mysqli->query($sql);
    return $res_sql;
}

function getRoomGalleryById($mysqli, $id) {
    $sql         = "SELECT id,image_name FROM `room_gallery` WHERE room_id = '$id' AND deleted_at IS NULL";
    $res_sql     = $mysqli->query($sql);

    return $res_sql;
}

function getRoomAllDetailByID($mysqli, $id) {
    $sql         = "SELECT T1.*,T2.name AS bed_name,T3.name AS view_name FROM rooms T1 LEFT JOIN beds T2 ON T1.bed_id = T2.id LEFT JOIN views T3 ON T1.view_id = T3.id WHERE T1.id = $id AND T1.deleted_at IS NULL";
    $res_sql     = $mysqli->query($sql);

    return $res_sql;
}

function getRoomSpecialFeaturesByID($mysqli, $id) {
    $sql         = "SELECT T2.name FROM room_special_features_id T1 LEFT JOIN special_features T2 ON T2.id = T1.special_features_id WHERE T1.room_id = $id";
    $res_sql     = $mysqli->query($sql);

    return $res_sql;
}

function getRoomAmenitiesByID($mysqli, $id, $type = null) {
    if ($type == null) {
        $sql         = "SELECT T2.name FROM room_amenities T1 LEFT JOIN amenities T2 ON T2.id = T1.amenities_id WHERE T1.room_id = $id";
        $res_sql     = $mysqli->query($sql);
    } else {
        $sql         = "SELECT T2.name FROM room_amenities T1 LEFT JOIN amenities T2 ON T2.id = T1.amenities_id WHERE T1.room_id = $id AND T2.type = $type";
        $res_sql     = $mysqli->query($sql);
    }

    return $res_sql;
}

function softDeleteGallery($mysqli, $id) {
    $currentDt   = date("Y-m-d H:i:s");

    if (isset($_SESSION["user_id"])) {
        $loginId = $_SESSION["user_id"];
    } else if (isset($_COOKIE["user_id"])) {
        $loginId = $_COOKIE["user_id"];
    }

    $sql         = "UPDATE `room_gallery` SET deleted_at = '$currentDt',deleted_by = '$loginId' WHERE id = '$id'";
    $res_sql     = $mysqli->query($sql);

    return $res_sql;
}

function selectGalleryById($mysqli, $id) {
    $sql         = "SELECT image_name FROM `room_gallery` WHERE room_id = '$id'";
    $res_sql     = $mysqli->query($sql);

    return $res_sql;
}

function hardDelete($mysqli, $table, $id) {
    $sql         = "DELETE FROM $table WHERE room_id = '$id'";
    $res_sql     = $mysqli->query($sql);

    return $res_sql;
}

function getThumbnailByID($mysqli, $id) {
    $sql        = "SELECT thumbnail FROM `rooms` WHERE id = '$id' AND deleted_at IS NULL";
    $res_sql    = $mysqli->query($sql);

    return $res_sql;
}

function isRoomBooking ($mysqli, $room_id, $check_in_date, $check_out_date) {
    $sql        = "";
    $res_sql    = $mysqli->query($sql);

    return $res_sql;
}

function selectReservationQuery($mysqli) {
    $sql     = "SELECT reservations.*,rooms.name as room_name,customers.name as customer_name FROM reservations LEFT JOIN rooms ON reservations.room_id = rooms.id LEFT JOIN customers ON reservations.customer_id = customers.id WHERE reservations.deleted_at IS NULL";
    $res_sql = $mysqli->query($sql);

    return $res_sql;
}

function createThumbnail($source_image,$destination,$tn_w = 100,$tn_h = 100,$quality = 80, $wmsource = false) {
    // The getimagesize functions provides an "imagetype" string contstant, which can be passed to the image_type_to_mime_type function for the corresponding mime type
    $info    = getimagesize($source_image);
    $imgtype = image_type_to_mime_type($info[2]);

    // Then the mime type can be used to call the correct function to generate an image resource from the provided image
    switch ($imgtype) {
    case 'image/jpeg':
        $source = imagecreatefromjpeg($source_image);
        break;
    case 'image/gif':
        $source = imagecreatefromgif($source_image);
        break;
    case 'image/png':
        $source = imagecreatefrompng($source_image);
        break;
    default:
        die('Invalid image type.');
    }

    // Now, we can determine the dimensions of the provided image, and calculate the width/height ratio
    $src_w = imagesx($source);
    $src_h = imagesy($source);
    $src_ratio = $src_w/$src_h;

    // Now we can use the power of math to determine whether the image needs to be cropped to fit the new dimensions, and if so then whether it should be cropped vertically or horizontally. We're just going to crop from the center to keep this simple.
    if ($tn_w/$tn_h > $src_ratio) {
    $new_h = ceil($tn_w/$src_ratio);
    $new_w = $tn_w;
    } else {
    $new_w = $tn_h*$src_ratio;
    $new_h = $tn_h;
    }
    $x_mid = $new_w/2;
    $y_mid = $new_h/2;

    // Now actually apply the crop and resize!
    $newpic = imagecreatetruecolor(round($new_w), round($new_h));
    imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
    $final = imagecreatetruecolor($tn_w, $tn_h);
    imagecopyresampled($final, $newpic, 0, 0, ($x_mid-($tn_w/2)), ($y_mid-($tn_h/2)), $tn_w, $tn_h, $tn_w, $tn_h);

    if($wmsource) {
        $info = getimagesize($wmsource);
        $imgtype = image_type_to_mime_type($info[2]);
        switch ($imgtype) {
          case 'image/jpeg':
            $watermark = imagecreatefromjpeg($wmsource);
            break;
          case 'image/gif':
            $watermark = imagecreatefromgif($wmsource);
            break;
          case 'image/png':
            $watermark = imagecreatefrompng($wmsource);
            break;
          default:
            die('Invalid watermark type.');
        }
        // Determine the size of the watermark, because we're going to specify the placement from the top left corner of the watermark image, so the width and height of the watermark matter.
        $wm_w = imagesx($watermark);
        $wm_h = imagesy($watermark);
        // Now, figure out the values to place the watermark in the bottom right hand corner. You could set one or both of the variables to "0" to watermark the opposite corners, or do your own math to put it somewhere else.
        $wm_x = $tn_w - $wm_w;
        $wm_y = $tn_h - $wm_h;
        // Copy the watermark onto the original image
        // The last 4 arguments just mean to copy the entire watermark
        imagecopy($final, $watermark, $wm_x, $wm_y, 0, 0, $tn_w, $tn_h);
    }

    // Ok, save the output as a jpeg, to the specified destination path at the desired quality.
    // You could use imagepng or imagegif here if you wanted to output those file types instead.
    if(Imagejpeg($final,$destination,$quality)) {
        return true;
    }

    // If something went wrong
    return false;

}

