<?php
    require("../require/check_auth.php");
    $header_title            = "Hotel Booking::Hotel Room Listing";
    $proc_error              = false;
    $error_message           = "";
    $table_no                = 1;
    $success                 = false;
    $success_message         = "";
    $status_message          = (isset($_GET["message"])) ? $_GET["message"] : "";

    switch ($status_message) {
        case "success":
            $success         = true;
            $success_message = "Room Created Successfully!";
            break;
        case "update":
            $success         = true;
            $success_message = "Room Updated Successfully!";
            break;
        case "delete":
            $success         = true;
            $success_message = "Room Deleted Successfully!";
            break;
    }

    $res_show_sql            = listingRoomQuery($mysqli);
    $res_row                 = $res_show_sql->num_rows;

    require("../templates/cp_header.php");
    require("../templates/cp_left_side_bar.php");
    require("../templates/cp_top_nav.php");
?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Hotel Room Listing</h3>
                </div>
            </div>

            <div class="row" style="display: block;">
                <div class="col-md-12 col-sm-12  ">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr class="headings">
                                            <th>
                                                <input type="checkbox" id="check-all" class="flat">
                                            </th>
                                            <th class="column-title">Id </th>
                                            <th class="column-title">Name </th>
                                            <th class="column-title">Type </th>
                                            <th class="column-title">Occupancy </th>
                                            <th class="column-title">Bed </th>
                                            <th class="column-title">Size </th>
                                            <th class="column-title">View </th>
                                            <th class="column-title">Price </th>
                                            <th class="column-title">Extra Bed Price </th>
                                            <th class="column-title">Action </th>
                                            <th class="bulk-actions" colspan="12">
                                            <a class="antoo" style="color:#fff; font-weight:500;"> ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if ($res_row >= 1) {
                                                while ($row = $res_show_sql->fetch_assoc()) { 
                                                    $id                = $row["id"];
                                                    $name              = htmlspecialchars($row["name"]); 

                                                    $type              = (int)($row["type"]);
                                                    switch ($type) {
                                                        case 1:
                                                            $room_type = "Standard";
                                                            break;
                                                        case 2:
                                                            $room_type = "Club Floor";
                                                            break;
                                                        case 3:
                                                            $room_type = "Suite";
                                                            break;
                                                        default:
                                                            $room_type = "";
                                                            break;
                                                    }

                                                    $occupancy         = (int)($row["occupancy"]);
                                                    $bed               = htmlspecialchars($row["bed_name"]);
                                                    $size              = (int)($row["size"]);
                                                    $view              = htmlspecialchars($row["view_name"]);
                                                    $price             = (int)($row["price_per_day"]);
                                                    $extra_bed         = (int)($row["extra_bed_price_per_day"]);
                                                    $edit_url          = $cp_base_url . "edit_room.php?id=" . $id;  
                                                    $edit_photo_url    = $cp_base_url . "manage_room_image.php?id=" . $id;
                                                    $delete_url        = $cp_base_url . "delete_room.php?id=" . $id;
                                        ?>
                                        <tr class="even pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td class=" "><?= $table_no++ ?></td>
                                            <td class=" "><?= $name ?></td>
                                            <td class=" "><?= $room_type ?></td>
                                            <td class=" "><?= $occupancy . " " . $measurement["occupancy"] ?></td>
                                            <td class=" "><?= $bed ?></td>
                                            <td class=" "><?= $size . " " . $measurement["size"] ?></td>
                                            <td class=" "><?= $view ?></td>
                                            <td class=" "><?= $price . " " . $measurement["price"] ?></td>
                                            <td class=" "><?= $extra_bed . " " . $measurement["price"] ?></td>
                                            <td class=" ">
                                                <a href="<?= $edit_url ?>" class="btn btn-info btn-sm">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                                <a href="<?= $edit_photo_url ?>" class="btn btn-secondary btn-sm">
                                                    <i class="fa fa-photo"></i> Edit Photo
                                                </a>
                                                <a href="<?= $delete_url ?>" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                                } 
                                            } 
                                        ?>
                                    </tbody>
                                </table>
                            </div> 
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

<?php if ($success == true) : ?>
    <script>
        $(document).ready(function () {
            new PNotify({
                title   : 'Regular Success',
                text    : '<?= $success_message ?>',
                type    : 'success',
                styling : 'bootstrap3'
            });
        })
    </script>
<?php endif ?> 

<?php 
    require("../templates/cp_footer.php");
?>


