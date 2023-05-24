<?php
    require("../require/check_auth.php");
    $header_title    = "Hotel Booking::Edit Room Bed";
    $proc_error      = false;
    $error_message   = "";
    $table           = "beds";

    if (isset($_GET["id"])) {
        $id                       = (int)($_GET["id"]);
        $res_sql                  = selectQueryById($mysqli, $table, $id);
        $row                      = $res_sql->num_rows;

        if ($row <= 0) {
            $url                  = $cp_base_url . "show_room_bed.php";
            header("Location:" . $url);
            exit();
        } else {  
            $res_row              = $res_sql->fetch_assoc();
            $name                 = htmlspecialchars($res_row["name"]);
        }
    } else if (isset($_POST["submit"]) && $_POST["form-submit"] == 2) {
        $id                       = (int)($_POST["id"]);
        $name                     = $mysqli->real_escape_string($_POST["name"]);

        /** Check Blank Input */
        $check_blank_data         = [
            "Bed"                 => $name
        ];
        $check_blank_input        = checkBlankInput($check_blank_data);
        if (isset($check_blank_input["error"]) == true) {
            $proc_error           = true;
            $error_message        = $check_blank_input["error_message"];
        }
        /** End of Check Blank Input */

        /** Check Database Existence */
        $check_database_existence = checkDatabaseExistence($mysqli, $table, $name, $id);
        if (isset($check_database_existence["error"]) == true) {
            $proc_error           = true;
            $error_message        = $check_database_existence["error_message"];
        }
        /** End of Check Database Existence */

        if ($proc_error == false) {
            $data                 = [
                "name"            => $name,
            ];
            
            $update_query         = updateQuery($mysqli, $table, $data, $id);

            $url                  = $cp_base_url . "show_room_bed.php?message=update";
            header("Location:" . $url);
            exit();
        }
    } else {
        $name                     = "";
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
                            <form class="" action="<?= $cp_base_url ?>edit_room_bed.php" method="post" novalidate>
                                <span class="section">Edit Room Bed</span>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Name<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="name" value="<?= $name ?>" placeholder="eg. Lake View" required="required" />
                                    </div>
                                </div>
                                <div class="ln_solid">
                                    <div class="form-group">                                  
                                        <div class="col-md-6 offset-md-3 mt-2">
                                            <button type='submit' name="submit" class="btn btn-primary">Update</button>
                                            <a href="<?= $cp_base_url ?>show_room_bed.php" class="btn btn-success">Cancel</a>
                                            <input type="hidden" name="form-submit" value="2">
                                            <input type="hidden" name="id" value="<?= $id ?>">
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


