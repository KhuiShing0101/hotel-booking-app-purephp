<?php
    require("../require/check_auth.php");
    $header_title                 = "Hotel Booking::Create Room";
    $proc_error                   = false;
    $error_message                = "";
    $table                        = "rooms";
    $table_bed                    = "beds";
    $table_view                   = "views";
    $table_special_feature        = "special_features";
    $table_special_feature_id     = "room_special_features_id";
    $table_amenities              = "amenities";
    $table_room_amenities         = "room_amenities";

    $data                         = ["id", "name"];
    $res_bed_sql                  = selectQuery($mysqli, $table_bed, $data);
    $res_view_sql                 = selectQuery($mysqli, $table_view, $data);
    $res_special_features_sql     = selectQuery($mysqli, $table_special_feature, $data);

    $amenities_data               = ["id", "name", "type"];
    $general_amenities_select_sql = selectQuery($mysqli, $table_amenities, $amenities_data, 1);
    $bedroom_amenities_select_sql = selectQuery($mysqli, $table_amenities, $amenities_data, 2);
    $other_amenities_select_sql   = selectQuery($mysqli, $table_amenities, $amenities_data, 3);

    if (isset($_POST["submit"]) && $_POST["form-submit"] == 1) {
        $room_name       = $mysqli->real_escape_string($_POST["room_name"]);
        $room_type       = $_POST["room_type"];
        $occupancy       = $mysqli->real_escape_string($_POST["occupancy"]);
        $bed_type        = $_POST["bed"];
        $room_size       = $mysqli->real_escape_string($_POST["room_size"]);
        $room_view       = $_POST["room_view"];
        $room_price      = $mysqli->real_escape_string($_POST["room_price"]);
        $extra_bed_price = $mysqli->real_escape_string($_POST["extra_bed_price"]);

        if (isset($_POST["special_features"])) {
            $special_features = $_POST["special_features"];
        } else {
            $special_features = [];
        }

        if (isset($_POST["amenities"])) {
            $amenities        = $_POST["amenities"];
        } else {
            $amenities        = [];
        }

        $description     = $mysqli->real_escape_string($_POST["description"]);
        $detail          = $mysqli->real_escape_string($_POST["detail"]);

        if ($extra_bed_price > $room_price) {
            $proc_error     = true;
            $error_message .= "Extra Bed price cannot be greater than Room Price! <br/>";
        }

        /** Validate Check Blank Input */
        $blank_data            = [
            "Room Name"        => $room_name,
            "Room Type"        => $room_type,
            "Occupancy"        => $occupancy,
            "Bed Type"         => $bed_type,
            "Room Size"        => $room_size,
            "Room View"        => $room_view,
            "Room Price"       => $room_price,
            "Extra Bed Price"  => $extra_bed_price,
            "Description"      => $description,
            "Detail"           => $detail,
            "Special Features" => $special_features,
            "Amenities"        => $amenities
        ];

        $check_blank_input     = checkBlankInput($blank_data);
        if ($check_blank_input["error"] == true) {
            $proc_error        = true;
            $error_message    .= $check_blank_input["error_message"];
        }
        /** End Check Blank Input */

        /** Check Database Existence */
        $check_database_existence  = checkDatabaseExistence($mysqli, $table, $room_name);
        if (isset($check_database_existence["error"]) == true) {
            $proc_error            = true;
            $error_message        .= $check_database_existence["error_message"];
        }
        /** End of Check Database Existence */

        if ($proc_error == false) {
            $data                         = [
                "name"                    => $room_name,
                "type"                    => $room_type,
                "occupancy"               => $occupancy,
                "bed_id"                  => $bed_type,
                "size"                    => $room_size,
                "view_id"                 => $room_view,
                "description"             => $description,
                "detail"                  => $detail,
                "price_per_day"           => $room_price,
                "extra_bed_price_per_day" => $extra_bed_price
            ];

            $insert_query                 = insertQuery($mysqli, $table, $data); 

            if ($insert_query) {
                $last_insert_id           = $mysqli->insert_id;
            }

            foreach ($special_features as $special_feature) {
                $data_special_features    = [
                    "room_id"             => $last_insert_id,
                    "special_features_id" => $special_feature
                ];
                $amenities_insert_query   = insertQuery($mysqli,$table_special_feature_id, $data_special_features);
            }

            foreach ($amenities as $amenity) {
                $data_amenities           = [
                    "room_id"             => $last_insert_id,
                    "amenities_id"        => $amenity
                ];
                $amenities_insert_query   = insertQuery($mysqli,$table_room_amenities, $data_amenities);
            }

            $url                          = $cp_base_url . "manage_room_image.php?id=" . $last_insert_id;
            header("Location:" . $url);
            exit();
        }
    } else {
        $room_name        = "";
        $room_type        = "";
        $occupancy        = "";
        $bed_type         = "";
        $room_size        = "";
        $room_view        = "";
        $room_price       = "";
        $extra_bed_price  = "";
        $description      = "";
        $detail           = "";  
        $special_features = [];
        $amenities        = [];
    }
    require("../templates/cp_header.php");
    require("../templates/cp_left_side_bar.php");
    require("../templates/cp_top_nav.php");
?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <form class="" action="<?= $cp_base_url ?>create_room.php" method="post" novalidate>
                                <span class="section">Create Hotel Room</span>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Room Name<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="room_name" value="<?= $room_name ?>" placeholder="eg. Deluxe Room" required="required" />
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Room Type<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <select name="room_type" id="" class="form-control">
                                            <option value="">Choose Room Type</option>
                                            <option value="1" <?= ($room_type == 1) ? "selected" : "" ?>>Standard</option>
                                            <option value="2" <?= ($room_type == 2) ? "selected" : "" ?>>Club Floor</option>
                                            <option value="3" <?= ($room_type == 3) ? "selected" : "" ?>>Suite</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Room Occupancy<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="number" class="form-control" name="occupancy" value="<?= $occupancy ?>" required="required" />
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Room Bed<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <select name="bed" id="" class="form-control">
                                            <option value="">Choose Bed</option>
                                            <?php  
                                                while ($res_bed_row = $res_bed_sql->fetch_assoc()) {
                                                    $bed_id         = (int)($res_bed_row["id"]);
                                                    $bed_name       = htmlspecialchars($res_bed_row["name"]);
                                            ?>
                                                <option value="<?= $bed_id ?>" <?= ($bed_id == $bed_type) ? "selected" : "" ?>><?= $bed_name ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Room Size<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="number" class="form-control" name="room_size" value="<?= $room_size ?>" required="required" />
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Room View<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <select name="room_view" id="" class="form-control">
                                            <option value="">Choose Room View</option>
                                            <?php  
                                                while ($res_view_row = $res_view_sql->fetch_assoc()) {
                                                    $view_id         = (int)($res_view_row["id"]);
                                                    $view_name       = htmlspecialchars($res_view_row["name"]);
                                            ?>
                                                <option value="<?= $view_id ?>" <?= ($view_id == $room_view) ? "selected" : "" ?>><?= $view_name ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Room Price Per Day<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="number" class="form-control" name="room_price" value="<?= $room_price ?>" required="required" />
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Room Extra Bed Price Per Day<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="number" class="form-control" name="extra_bed_price" value="<?= $extra_bed_price ?>" required="required" />
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Room Special Features<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <?php 
                                            while ($res_special_features_row = $res_special_features_sql->fetch_assoc()) {
                                                $special_features_id         = (int)($res_special_features_row["id"]);
                                                $special_features_name       = htmlspecialchars($res_special_features_row["name"]);

                                                if (in_array($special_features_id, $special_features)) {
                                        ?>
                                                    <div class="mb-2">
                                                        <label for="<?= $special_features_name ?>" class="form-check-label">
                                                            <input type="checkbox" name="special_features[]" value="<?= $special_features_id ?>" id="<?= $special_features_name ?>" checked />
                                                            <?= $special_features_name ?>
                                                        </label>
                                                    </div>
                                        <?php
                                                } else {
                                        ?>
                                                    <div class="mb-2">
                                                        <label for="<?= $special_features_name ?>" class="form-check-label">
                                                            <input type="checkbox" name="special_features[]" value="<?= $special_features_id ?>" id="<?= $special_features_name ?>" />
                                                            <?= $special_features_name ?>
                                                        </label>
                                                    </div>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Room Amenities<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h4>General</h4>
                                                <?php 
                                                    while ($res_amenities_1_row = $general_amenities_select_sql->fetch_assoc()) {
                                                        $amenities_1_id         = (int)($res_amenities_1_row["id"]);
                                                        $amenities_1_name       = htmlspecialchars($res_amenities_1_row["name"]);

                                                        if (in_array($amenities_1_id, $amenities)) {
                                                ?>
                                                            <div class="mb-2">
                                                                <label for="<?= $amenities_1_name ?>">
                                                                    <input type="checkbox" name="amenities[]" value="<?= $amenities_1_id ?>" id="<?= $amenities_1_name ?>" checked />
                                                                    <?= $amenities_1_name ?>
                                                                </label>
                                                            </div>   
                                                <?php
                                                        } else {
                                                ?>
                                                            <div class="mb-2">
                                                                <label for="<?= $amenities_1_name ?>">
                                                                    <input type="checkbox" name="amenities[]" value="<?= $amenities_1_id ?>" id="<?= $amenities_1_name ?>" />
                                                                    <?= $amenities_1_name ?>
                                                                </label>
                                                            </div>   
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <h4>Bedroom</h4>
                                                <?php 
                                                    while ($res_amenities_2_row = $bedroom_amenities_select_sql->fetch_assoc()) {
                                                        $amenities_2_id         = (int)($res_amenities_2_row["id"]);
                                                        $amenities_2_name       = htmlspecialchars($res_amenities_2_row["name"]);

                                                        if (in_array($amenities_2_id, $amenities)) {
                                                ?>
                                                            <div class="mb-2">
                                                                <input type="checkbox" name="amenities[]" value="<?= $amenities_2_id ?>" id="<?= $amenities_2_name ?>" checked />
                                                                <label for="<?= $amenities_2_name ?>"><?= $amenities_2_name ?></label>
                                                            </div> 
                                                <?php
                                                        } else {
                                                ?>
                                                            <div class="mb-2">
                                                                <input type="checkbox" name="amenities[]" value="<?= $amenities_2_id ?>" id="<?= $amenities_2_name ?>" />
                                                                <label for="<?= $amenities_2_name ?>"><?= $amenities_2_name ?></label>
                                                            </div> 
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <h4>Others</h4>
                                                <?php 
                                                    while ($res_amenities_3_row = $other_amenities_select_sql->fetch_assoc()) {
                                                        $amenities_3_id         = (int)($res_amenities_3_row["id"]);
                                                        $amenities_3_name       = htmlspecialchars($res_amenities_3_row["name"]);
                                                    
                                                        if (in_array($amenities_3_id, $amenities)) {
                                                ?>
                                                            <div class="mb-2">
                                                                <input type="checkbox" name="amenities[]" value="<?= $amenities_3_id ?>" id="<?= $amenities_3_name ?>" checked />
                                                                <label for="<?= $amenities_3_name ?>"><?= $amenities_3_name ?></label>
                                                            </div>    
                                                <?php
                                                        } else {
                                                ?>
                                                            <div class="mb-2">
                                                                <input type="checkbox" name="amenities[]" value="<?= $amenities_3_id ?>" id="<?= $amenities_3_name ?>" />
                                                                <label for="<?= $amenities_3_name ?>"><?= $amenities_3_name ?></label>
                                                            </div>    
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Description<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea name="description" id="" cols="30" rows="3" class="form-control"><?= $description ?></textarea>
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="detail">Detail<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea name="detail" id="detail" required="required" cols="30" rows="3" class="form-control"><?= $detail ?></textarea>
                                    </div>
                                </div>
                                <div class="ln_solid">
                                    <div class="form-group">                                       
                                        <div class="col-md-6 offset-md-3 mt-2">
                                            <button type='submit' name="submit" class="btn btn-primary">Submit</button>
                                            <a href="<?= $cp_base_url ?>show_room.php" type='reset' class="btn btn-success">Cancel</a>
                                            <input type="hidden" name="form-submit" value="1" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
<?php if ($proc_error == true) : ?>
    <script>
        $(document).ready(function () {
            new PNotify({
                title   : 'Oh No!',
                text    : '<?= $error_message ?>',
                type    : 'error',
                styling : 'bootstrap3'
            });
        })
    </script>
<?php endif ?> 

<?php 
    require("../templates/cp_footer.php");
?>


