<?php
    require("../require/check_auth.php");
    $header_title = "Hotel Booking::Reservations";
    $proc_error   = false;
    $success      = false;
    $table_no     = 1;
    $result_sql   = selectReservationQuery($mysqli);
    $res_num_rows = $result_sql->num_rows;     
    require("../templates/cp_header.php");
    require("../templates/cp_left_side_bar.php");
    require("../templates/cp_top_nav.php");
?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Reservations</h3>
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
                                            <th class="column-title"># </th>
                                            <th class="column-title">Check In Date </th>
                                            <th class="column-title">Check Out Date </th>
                                            <th class="column-title">Room Name </th>
                                            <th class="column-title">Is Extra Bed </th>
                                            <th class="column-title">Price </th>
                                            <th class="column-title">Customer Name </th>
                                            <th class="column-title">Customer Request </th>
                                            <th class="column-title">Status </th>
                                            <th class="column-title">Action </th>
                                            <th class="bulk-actions" colspan="12">
                                            <a class="antoo" style="color:#fff; font-weight:500;"> ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if ($res_num_rows >= 1) {
                                                while ($res_row = $result_sql->fetch_assoc()){
                                                    $id               = $res_row["id"];
                                                    $check_in_date    = $res_row["check_in_date"];
                                                    $check_out_date   = $res_row["check_out_date"];
                                                    $room_name        = $res_row["room_name"];
                                                    $is_extra_bed     = $res_row["is_extra_bed"];
                                                    $price            = $res_row["price"];
                                                    $customer_name    = $res_row["customer_name"];
                                                    $customer_request = $res_row["customer_request"];
                                                    $status           = $res_row["status"];                                                 
                                                    $delete_url       = $cp_base_url . "delete_reservation.php?id=" . $id;
                                        ?>
                                                    <tr class="even pointer">
                                                        <td class="a-center ">
                                                            <input type="checkbox" class="flat" name="table_records">
                                                        </td>
                                                        <td class=" "><?= $table_no++ ?></td>
                                                        <td class=" "><?= $check_in_date ?></td>
                                                        <td class=" "><?= $check_out_date ?></td>
                                                        <td class=" "><?= $room_name ?></td>
                                                        <td class=" "><?= $is_extra_bed ?></td>
                                                        <td class=" "><?= $price ?></td>
                                                        <td class=" "><?= $customer_name ?></td>
                                                        <td class=" "><?= $customer_request ?></td>
                                                        <td class=" "><?= $status ?></td>
                                                        <td class=" ">
                                                           
                                                            
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


