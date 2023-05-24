<?php
    require("require/db_connect.php");
    require("require/config.php");
    require("require/include_functions.php");
    require("require/common.php");
    $id      = (int)($_GET["id"]);
    $res     = getRoomAllDetailByID($mysqli, $id);
    $res_row = $res->num_rows;
    
    if ($res_row >= 1) {
      while ($detail_row = $res->fetch_assoc()) {
        $room_name   = htmlspecialchars($detail_row["name"]);
        $description = htmlspecialchars($detail_row["description"]);
        $occupancy   = (int)($detail_row["occupancy"]);
        $detail      = htmlspecialchars($detail_row["detail"]);
        $size        = (int)($detail_row["size"]);
        $type        = (int)($detail_row["type"]);
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
        $view        = htmlspecialchars($detail_row["view_name"]);
        $bed         = htmlspecialchars($detail_row["bed_name"]);
      }
    } else {
      $url           = $base_url . "rooms.php";
      header("Location:" . $url);
      exit();
    }

    $gallery_res          = selectGalleryById($mysqli, $id);
    $special_features_res = getRoomSpecialFeaturesByID($mysqli, $id);
    $amenities_res        = getRoomAmenitiesByID($mysqli, $id);
    
    $title   = "Hotel Booking::" . $room_name;
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

    <section class="ftco-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
          	<div class="row">
          		<div class="col-md-12 ftco-animate">
          			<div class="single-slider owl-carousel">
                  <?php
                    while ($gallery_row = $gallery_res->fetch_assoc()) {
                      $gallery_name     = htmlspecialchars($gallery_row["image_name"]);
                      $gallery_path     = $base_url . $image_path . $id . "/" . $gallery_name; 
                  ?>  
                      <div class="item">
                        <div class="room-img" style="background-image: url(<?= $gallery_path ?>);"></div>
                      </div>
                  <?php
                    }
                  ?>
          			</div>
          		</div>
          		<div class="col-md-12 room-single mt-4 mb-5 ftco-animate">
          			<h2 class="mb-4"><?= $room_name ?> <span>- (<?= $room_type ?> Available)</span></h2>
    						<p><?= $description ?></p>
    						<div class="d-md-flex mt-5 mb-5">
    							<ul class="list">
	    							<li><span>Max:</span> <?= $occupancy . " " . $measurement["occupancy"] ?> </li>
	    							<li><span>Size:</span> <?= $size . " " . $measurement["size"] ?> </li>
	    						</ul>
	    						<ul class="list ml-md-5">
	    							<li><span>View:</span> <?= $view ?></li>
	    							<li><span>Bed:</span> <?= $bed ?></li>
	    						</ul>
    						</div>
    						<p><?= $detail ?></p>
          		</div>
          	</div>
          </div> <!-- .col-md-8 -->
          <div class="col-lg-4 sidebar ftco-animate pl-md-5">
            <div class="sidebar-box ftco-animate">
              <div class="categories">
                <h3>Special Features</h3>
                <?php 
                  while ($special_features_row = $special_features_res->fetch_assoc()) {
                    $special_features_name     = htmlspecialchars($special_features_row["name"]);
                ?>
                    <li><a href="javascript:void(0)"><?= $special_features_name ?></li>
                <?php
                  }
                ?>
              </div>
            </div>
            
            <div style="height: 50px;"></div>

            <div class="sidebar-box ftco-animate">
              <div class="categories">
                <h3>Amenities</h3>
                <?php 
                  while ($amenities_row = $amenities_res->fetch_assoc()) {
                    $amenities_name     = htmlspecialchars($amenities_row["name"]);
                ?>
                  <li><a href="javascript:void(0)"><?= $amenities_name ?></a></li>
                <?php 
                  }
                ?>
              </div>
            </div>
          </div>
          <a href="<?= $base_url . "room_reservation.php?id=" . $id ?>" class="btn btn-success">Make Reservation</a>
        </div>
      </div>
    </section>

<?php
    require("templates/frontend_footer.php");
?>