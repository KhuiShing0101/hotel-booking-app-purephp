<?php
    require("require/db_connect.php");
    require("require/config.php");
    require("require/include_functions.php");
    require("require/common.php");
    $title = "Hotel Booking::Hotel Rooms";


    $show_sql     = "SELECT rooms.*,beds.name AS bed_name,views.name AS view_name FROM $table LEFT JOIN $table_bed ON rooms.bed_id = beds.id LEFT JOIN $table_view ON rooms.view_id = views.id WHERE rooms.deleted_at IS NULL ORDER BY RAND()";
    $res_show_sql = $mysqli->query($show_sql);
    $res_row      = $res_show_sql->num_rows; 

    require("templates/frontend_header.php");
?>

    <section class="ftco-booking ftco-section ftco-no-pt ftco-no-pb">
    	<div class="container">
    		<div class="row no-gutters">
    			<div class="col-lg-12">
    				<?php require("templates/room_search.php") ?>
	    		</div>
    		</div>
    	</div>
    </section>

    <section class="ftco-section ftco-no-pb ftco-room">
    	<div class="container-fluid px-0">
    		<div class="row no-gutters justify-content-center mb-5 pb-3">
          <div class="col-md-7 heading-section text-center ftco-animate">
          	<span class="subheading">Harbor Lights Rooms</span>
            <h2 class="mb-4">Hotel Master's Rooms</h2>
          </div>
        </div>  
    		<div class="row no-gutters">
				<?php
					if ($res_row >= 1) {
					$count          = 0;
					$line           = 1;
					while ($row = $res_show_sql->fetch_assoc()) {
						$count++;
						$id         = $row["id"];
						$room_name  = htmlspecialchars($row["name"]);
						$room_price = htmlspecialchars($row["price_per_day"]);
						$thumbnail  = htmlspecialchars($row["thumbnail"]);
						$thumb_path = $base_url . $image_path . $id . "/thumb/" . $thumbnail;
						$view_link  = $base_url . "room_details.php?id=" . $id;

						if ($count > 2) {
							$line++;
							$count  = 1;
						}

						if ($line % 2 == 0) {
							$class_ltrt  = "img order-md-last";
							$class_arrow = "right-arrow";						
						} else {
							$class_ltrt  = "img";
							$class_arrow = "left-arrow";
						}
				?>
    			<div class="col-lg-6">
    				<div class="room-wrap d-md-flex ftco-animate">
    					<a href="<?= $view_link ?>" class="<?= $class_ltrt ?>" style="background-image: url(<?= $thumb_path ?>);"></a>
    					<div class="half <?= $class_arrow ?> d-flex align-items-center">
    						<div class="text p-4 text-center">
    							<p class="star mb-0"><span class="ion-ios-star"></span><span class="ion-ios-star"></span><span class="ion-ios-star"></span><span class="ion-ios-star"></span><span class="ion-ios-star"></span></p>
    							<p class="mb-0"><span class="price mr-1"><?= $room_price . " " . $measurement["price"] ?></span> <span class="per">per night</span></p>
	    						<h3 class="mb-3"><a href="<?= $view_link ?>"><?= $room_name ?></a></h3>
	    						<p class="pt-1"><a href="<?= $view_link ?>" class="btn-custom px-3 py-2 rounded">View Details <span class="icon-long-arrow-right"></span></a></p>
    						</div>
    					</div>
    				</div>
    			</div>
				<?php 
						}
					}
				?>
    		</div>
    	</div>
    </section>
				
	

<?php
    require("templates/frontend_footer.php");
?>