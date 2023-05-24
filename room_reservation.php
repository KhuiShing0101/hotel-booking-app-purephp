<?php
    require("require/db_connect.php");
    require("require/config.php");
    require("require/include_functions.php");
    require("require/common.php");
    $title             = "Hotel Booking::Room Reservation";
    $id                = (int)($_GET["id"]);
    $table_customer    = "customers";
    $table_reservation = "reservations";
    $proc_error        = false;
    $error_message     = ""; 
    $success           = false;
    $success_message   = "";
    $general_name      = "";
    $bathroom_name     = "";
    $other_name        = "";
    $checkin_date      = date("M d Y");
    $tomorrow_date     = new DateTime("tomorrow");
    $checkout_date     = $tomorrow_date->format("M d Y");
    $date1             = new DateTime("today");
    $interval          = date_diff($date1, $tomorrow_date);
    $date_diff         = $interval->days;
    
    $res               = getRoomAllDetailByID($mysqli, $id);
    while ($row = $res->fetch_assoc()) {
        $room_name               = htmlspecialchars($row["name"]);
        $price_per_day           = (int)($row["price_per_day"]);
        $extra_bed_price_per_day = (int)($row["extra_bed_price_per_day"]);
        $occupancy               = (int)($row["occupancy"]);
        $room_charge             = $price_per_day * $date_diff;
        $size                    = (int)($row["size"]);
        $type                    = (int)($row["type"]);
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
        $view                   = htmlspecialchars($row["view_name"]);
        $bed                    = htmlspecialchars($row["bed_name"]);
    }

    $amenities_general_res  = getRoomAmenitiesByID($mysqli, $id, 1);
    $amenities_bathroom_res = getRoomAmenitiesByID($mysqli, $id, 2);
    $amenities_other_res    = getRoomAmenitiesByID($mysqli, $id, 3);

    if (isset($_POST["submit"]) && $_POST["form-submit"] == 1) {
        $room_id          = (int)($_POST["room-id"]);
        $room_id          = $mysqli->real_escape_string($room_id);
        $customer_name    = $mysqli->real_escape_string($_POST["customer-name"]);
        $customer_email   = $mysqli->real_escape_string($_POST["customer-email"]);
        $customer_phone   = $mysqli->real_escape_string($_POST["customer-phone"]);
        $extra_bed        = (isset($_POST["extra-bed"]) ? $_POST["extra-bed"] : "");
        if ($extra_bed == 1) {
            $room_charge  = $room_charge + $extra_bed_price_per_day;
        }
        $customer_request = $mysqli->real_escape_string($_POST["customer-request"]);
        $check_in_date        = date("Y-m-d");
        $check_out_date       = $tomorrow_date->format("Y-m-d");
        
        /** Check Customer Existence */
        $customer_data     = [
            "name"         => $customer_name,
            "email"        => $customer_email,
            "phone"        => $customer_phone
        ];
        $check_customer    = checkCustomerExistence($mysqli, $customer_data);
        if (isset($check_customer["error"]) == true) {
            $proc_error    = true;
            $error_message = $check_customer["error_message"];
        }

        /** Check Room Booking */
        $is_booking        = isRoomBooking($mysqli, $room_id, $check_in_date, $check_out_date);
        print_r($is_booking);
        $is_booking_row    = $is_booking->num_rows;
      
        if ($is_booking_row >= 1) {
            $proc_error    = true;
            $error_message = "This room already in booking";
        }

        if ($proc_error == false) {
            $res_query            = insertQuery($mysqli, $table_customer, $customer_data);

            if ($res_query) {
                $customer_id      = $mysqli->insert_id;
            }

            $check_data           = ["customer_id"];
            $check_customer_query = selectQuery($mysqli, $table_reservation, $check_data);
            $row_customer_id      = $check_customer_query->fetch_assoc();
            $check_customer_id    = $row_customer_id["customer_id"];
        
            if ($check_customer_id != $customer_id) {
                $reservation_data = [
                    "check_in_date"    => $check_in_date,
                    "check_out_date"   => $check_out_date,
                    "room_id"          => $room_id,
                    "is_extra_bed"     => $extra_bed,
                    "price"            => $room_charge,
                    "customer_id"      => $customer_id,
                    "customer_request" => $customer_request,
                    "status"           => 0
                ];  
                $res_reserve           = insertQuery($mysqli, $table_reservation, $reservation_data);
            }
        }        
    }
    
    require("templates/frontend_header.php");
?>

    <section class="ftco-booking ftco-section ftco-no-pt ftco-no-pb">
    	<div class="container">
    		<div class="row no-gutters">
    			<div class="col-lg-12">
    				<h1 class="py-3">Hotel Booking</h1>
	    		</div>
    		</div>

            <hr/>

            <div class="row no-gutters">
                <div class="col-lg-12">
                    <h4 class="py-3">Reservation Options</h4>
                </div>
                <?php 
                    if ($proc_error == true) {
                ?>
                        <p><?= $error_message ?></p>
                <?php
                    } 
                ?>
                <div class="col-lg-12 border p-5 mb-5">
                    <div class="row">
                        <div class="col-lg-7">
                            <p class="mb-4"><strong><?= $room_name . " " . "( " . $room_type . " )" ?></strong></p>

                            <hr/>

                            <p class="mt-4"><strong>Special Requests</strong></p>

                            <form action="<?= $base_url ?>room_reservation.php?id=<?= $id ?>" method="POST" class="bg-white contact-form">
                                <div class="form-group">
                                    <input type="text" name="customer-name" class="form-control" placeholder="Your Name" />
                                </div>
                                <div class="form-group">
                                    <input type="text" name="customer-email" class="form-control" placeholder="Your Email" />
                                </div>
                                <div class="form-group">
                                    <input type="text" name="customer-phone" class="form-control" placeholder="Your Phone"required />
                                </div>
                                <div class="form-group">
                                    <label for="extra-bed-check">
                                        <input type="checkbox" name="extra-bed" value="1" id="extra-bed-check" onchange="changeExtraBedPrice(this)"> Extra Bed
                                        <input type="hidden" name="" value="<?= $extra_bed_price_per_day ?>" id="extra-bed-charge">
                                    </label>
                                </div>
                                <div class="form-group">
                                    <textarea name="customer-request" id="" cols="30" rows="7" class="form-control" placeholder="Requests..."></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" value="Book Now" class="btn btn-primary py-3 px-5" />
                                    <input type="hidden" name="form-submit" value="1" />
                                    <input type="hidden" name="room-id" value="<?= $id ?>" />
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-5 px-5 bg-light mt-5" style="height: 350px;">
                            <div class="row mt-5">
                                <p><strong>Room Charge</strong></p>
                            </div>
                            <div class="row justify-content-between">
                                <p><strong>Checkin Date</strong></p>
                                <p><?= $checkin_date ?></p>
                            </div>
                            <div class="row justify-content-between">
                                <p><strong>Checkout Date</strong></p>
                                <p><?= $checkout_date ?></p>
                            </div>
                            <div class="row justify-content-between">
                                <p><strong>Room Price </strong></p>
                                <p><?= $room_charge ?> Kyats</p>
                            </div>
                            <div class="row justify-content-between">
                                <p><strong>Extra Bed Price</strong></p>
                                <div>
                                    <span id="extra-bed">0</span><span> Kyats</span>
                                </div>
                            </div>
                            <hr/>
                            <div class="row justify-content-between">
                                <p><strong>Total charges</strong></p>
                                <div>
                                    <span id="total-charge"><?= $room_charge ?></span><span> Kyats</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr/>

            <div class="no-gutters">
                <h4 class="py-3">Rate Policies</h4>
                <p>
                    [REWARDS Members Only] Best Available Rate Room Only <br/>
                    Prevailing taxes and service charges apply <br/>
                    Enjoy Buffet Breakfast at La Seine with extra charge 19 USD++ per person <br/>
                    Complimentary Wi-Fi Usage <br/>
                    This offer cannot be used in conjunction with any other promotion. <br/>
                </p>
            </div>

            <hr/>

            <div class="no-gutters">
                <h4 class="py-3">Cancellation Regulations</h4>
                <p>
                    Reservations may be canceled or changed until 2:00 PM (Myanmar time) 3 days prior to the date of check-in
                </p>
            </div>

            <hr/>

            <div class="no-gutters">
                <h4 class="py-3">Room Information</h4>
                <div class="row">
                    <div class="col-lg-4">
                        <strong class="mr-5">Occupancy</strong> <span><?= $occupancy . " " . $measurement["occupancy"] ?></span>
                    </div>
                    <div class="col-lg-4">
                        <strong class="mr-5">View</strong> <span><?= $view ?></span>
                    </div>
                    <div class="col-lg-4">
                        <strong class="mr-5">Size</strong> <span><?= $size . " " . $measurement["size"] ?></span>
                    </div>
                    <div class="col-lg-4">
                        <strong class="mr-5">Check-in / Check-out</strong> <span>14:00/12:00</span>
                    </div>
                </div>
            </div>

            <hr/>

            <div class="no-gutters">
                <h4 class="py-3">Amenities</h4>
                <div class="row">
                    <div class="col-lg-2">
                        <p>General</p>
                    </div>
                    <div class="col-lg-10">
                        <?php 
                            while ($general_row = $amenities_general_res->fetch_assoc()){
                                $general_name  .= htmlspecialchars($general_row["name"]);   
                                $general_name  .= " / "; 
                            }
                            $general_name   = rtrim($general_name, " / ");   
                        ?>
                        <span><?= $general_name ?></span>                    
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <p>Bathroom</p>
                    </div>
                    <div class="col-lg-10">
                        <?php 
                                while ($bathroom_row = $amenities_bathroom_res->fetch_assoc()){
                                    $bathroom_name   = htmlspecialchars($bathroom_row["name"]);
                                    $bathroom_name  .= " / ";
                                }
                                $bathroom_name = rtrim($bathroom_name, " / ");
                        ?>
                        <span><?= $bathroom_name ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <p>Others</p>
                    </div>
                    <div class="col-lg-10">
                        <?php 
                            while ($other_row = $amenities_other_res->fetch_assoc()){
                                $other_name   = htmlspecialchars($other_row["name"]);
                                $other_name  .= " / ";
                            }
                            $other_name = rtrim($other_name, " / ");
                        ?>
                        <span><?= $other_name ?></span>
                    </div>
                </div>
            </div>
    	</div>
    </section>

    <script>
        function changeExtraBedPrice(element) {
            if (element.checked) {
                let extra_bed_charge = parseInt(document.querySelector("#extra-bed-charge").value);
                document.querySelector("#extra-bed").textContent = extra_bed_charge;
                document.querySelector("#total-charge").textContent = extra_bed_charge + <?= $room_charge ?>;
            } else {
                extra_bed_charge     = 0;
                document.querySelector("#extra-bed").textContent = extra_bed_charge;
                document.querySelector("#total-charge").textContent = extra_bed_charge + <?= $room_charge ?>;
            }
        }
    </script>

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
    require("templates/frontend_footer.php");
?>