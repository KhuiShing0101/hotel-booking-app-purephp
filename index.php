<?php
    require("require/db_connect.php");
    require("require/config.php");
    require("require/include_functions.php");
    require("require/common.php");
    $title        = "Hotel Booking";
    $table        = "rooms";
    $table_bed    = "beds";
    $table_view   = "views";

    $show_sql     = "SELECT rooms.*,beds.name AS bed_name,views.name AS view_name FROM $table LEFT JOIN $table_bed ON rooms.bed_id = beds.id LEFT JOIN $table_view ON rooms.view_id = views.id WHERE rooms.deleted_at IS NULL ORDER BY RAND() LIMIT 6";
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

        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center mb-5 pb-3">
                    <div class="col-md-7 heading-section text-center ftco-animate">
                        <span class="subheading">Welcome to Harbor Lights Hotel</span>
                        <h2 class="mb-4">You'll Never Want To Leave</h2>
                    </div>
                </div>
                <div class="row d-flex">
                    <div class="col-md pr-md-1 d-flex align-self-stretch ftco-animate">
                        <div class="media block-6 services py-4 d-block text-center">
                            <div class="d-flex justify-content-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="flaticon-reception-bell"></span>
                                </div>
                            </div>
                            <div class="media-body">
                                <h3 class="heading mb-3">Friendly Service</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md px-md-1 d-flex align-self-stretch ftco-animate">
                        <div class="media block-6 services active py-4 d-block text-center">
                            <div class="d-flex justify-content-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="flaticon-serving-dish"></span>
                                </div>
                            </div>
                            <div class="media-body">
                                <h3 class="heading mb-3">Get Breakfast</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md px-md-1 d-flex align-sel Searchf-stretch ftco-animate">
                        <div class="media block-6 services py-4 d-block text-center">
                            <div class="d-flex justify-content-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="flaticon-car"></span>
                                </div>
                            </div>
                            <div class="media-body">
                                <h3 class="heading mb-3">Transfer Services</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md px-md-1 d-flex align-self-stretch ftco-animate">
                        <div class="media block-6 services py-4 d-block text-center">
                            <div class="d-flex justify-content-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="flaticon-spa"></span>
                                </div>
                            </div>
                            <div class="media-body">
                                <h3 class="heading mb-3">Suits &amp; SPA</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md pl-md-1 d-flex align-self-stretch ftco-animate">
                        <div class="media block-6 services py-4 d-block text-center">
                            <div class="d-flex justify-content-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="ion-ios-bed"></span>
                                </div>
                            </div>
                            <div class="media-body">
                                <h3 class="heading mb-3">Cozy Rooms</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="ftco-section ftco-wrap-about ftco-no-pt ftco-no-pb">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-md-7 order-md-last d-flex">
                        <div class="img img-1 mr-md-2 ftco-animate"
                            style="background-image: url(<?= $base_url ?>assets/images/about-1.jpg);"></div>
                        <div class="img img-2 ml-md-2 ftco-animate"
                            style="background-image: url(<?= $base_url ?>assets/images/about-2.jpg);"></div>
                    </div>
                    <div class="col-md-5 wrap-about pb-md-3 ftco-animate pr-md-5 pb-md-5 pt-md-4">
                        <div class="heading-section mb-4 my-5 my-md-0">
                            <span class="subheading">About Harbor Lights Hotel</span>
                            <h2 class="mb-4">Harbor Lights Hotel the Most Recommended Hotel All Over the World</h2>
                        </div>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live
                            the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large
                            language ocean.</p>
                        <p><a href="#" class="btn btn-secondary rounded">Reserve Your Room Now</a></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="testimony-section">
            <div class="container">
                <div class="row no-gutters ftco-animate justify-content-center">
                    <div class="col-md-5 d-flex">
                        <div class="testimony-img aside-stretch-2"
                            style="background-image: url(<?= $base_url ?>assets/images/testimony-img.jpg);"></div>
                    </div>
                    <div class="col-md-7 py-5 pl-md-5">
                        <div class="py-md-5">
                            <div class="heading-section ftco-animate mb-4">
                                <span class="subheading">Testimony</span>
                                <h2 class="mb-0">Happy Customer</h2>
                            </div>
                            <div class="carousel-testimony owl-carousel ftco-animate">
                                <div class="item">
                                    <div class="testimony-wrap pb-4">
                                        <div class="text">
                                            <p class="mb-4">A small river named Duden flows by their place and supplies it with
                                                the necessary regelialia. It is a paradisematic country, in which roasted parts
                                                of sentences fly into your mouth.</p>
                                        </div>
                                        <div class="d-flex">
                                            <div class="user-img"
                                                style="background-image: url(<?= $base_url ?>assets/images/person_1.jpg)">
                                            </div>
                                            <div class="pos ml-3">
                                                <p class="name">Gerald Hodson</p>
                                                <span class="position">Businessman</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="testimony-wrap pb-4">
                                        <div class="text">
                                            <p class="mb-4">A small river named Duden flows by their place and supplies it with
                                                the necessary regelialia. It is a paradisematic country, in which roasted parts
                                                of sentences fly into your mouth.</p>
                                        </div>
                                        <div class="d-flex">
                                            <div class="user-img"
                                                style="background-image: url(<?= $base_url ?>assets/images/person_2.jpg)">
                                            </div>
                                            <div class="pos ml-3">
                                                <p class="name">Gerald Hodson</p>
                                                <span class="position">Businessman</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="testimony-wrap pb-4">
                                        <div class="text">
                                            <p class="mb-4">A small river named Duden flows by their place and supplies it with
                                                the necessary regelialia. It is a paradisematic country, in which roasted parts
                                                of sentences fly into your mouth.</p>
                                        </div>
                                        <div class="d-flex">
                                            <div class="user-img"
                                                style="background-image: url(<?= $base_url ?>assets/images/person_3.jpg)">
                                            </div>
                                            <div class="pos ml-3">
                                                <p class="name">Gerald Hodson</p>
                                                <span class="position">Businessman</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="testimony-wrap pb-4">
                                        <div class="text">
                                            <p class="mb-4">A small river named Duden flows by their place and supplies it with
                                                the necessary regelialia. It is a paradisematic country, in which roasted parts
                                                of sentences fly into your mouth.</p>
                                        </div>
                                        <div class="d-flex">
                                            <div class="user-img"
                                                style="background-image: url(<?= $base_url ?>assets/images/person_4.jpg)">
                                            </div>
                                            <div class="pos ml-3">
                                                <p class="name">Gerald Hodson</p>
                                                <span class="position">Businessman</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="ftco-section ftco-no-pb ftco-room">
            <div class="container-fluid px-0">
                <div class="row no-gutters justify-content-center mb-5 pb-3">
                    <div class="col-md-7 heading-section text-center ftco-animate">
                        <span class="subheading">Hotel Booking</span>
                        <h2 class="mb-4">Hotel Master's Rooms</h2>
                    </div>
                </div>
                <div class="row no-gutters">
                    <?php
                    if ($res_row >= 1) {
                    $count        = 0;
                    $line         = 1;

                    while ($row   = $res_show_sql->fetch_assoc()) {
                        $id         = $row["id"];
                        $count++;
                        $room_name  = htmlspecialchars($row["name"]);
                        $room_price = htmlspecialchars($row["price_per_day"]);
                        $thumbnail  = htmlspecialchars($row["thumbnail"]);
                        $thumb_path = $base_url . $image_path . $id . "/thumb/" . $thumbnail;
                        $view_link  = $base_url . "room_details.php?id=" . $id;

                        if ($count > 2) {
                        $line++;
                        $count    = 1;
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
                            <a href="<?= $view_link ?>" class="<?= $class_ltrt ?>"
                                style="background-image: url(<?= $thumb_path ?>);"></a>
                            <div class="half <?= $class_arrow ?> d-flex align-items-center">
                                <div class="text p-4 text-center">
                                    <p class="star mb-0"><span class="ion-ios-star"></span><span
                                            class="ion-ios-star"></span><span class="ion-ios-star"></span><span
                                            class="ion-ios-star"></span><span class="ion-ios-star"></span></p>
                                    <p class="mb-0"><span
                                            class="price mr-1"><?= $room_price . " " . $measurement["price"] ?></span> <span
                                            class="per">per night</span></p>
                                    <h3 class="mb-3"><a href="<?= $view_link ?>"><?= $room_name ?></a></h3>
                                    <p class="pt-1"><a href="<?= $view_link ?>" class="btn-custom px-3 py-2 rounded">View
                                            Details <span class="icon-long-arrow-right"></span></a></p>
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

        <section class="ftco-section ftco-menu bg-light">
            <div class="container-fluid px-md-4">
                <div class="row justify-content-center mb-5 pb-3">
                    <div class="col-md-7 heading-section text-center ftco-animate">
                        <span class="subheading">Restaurant</span>
                        <h2>Restaurant</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xl-4 d-flex">
                        <div class="pricing-entry rounded d-flex ftco-animate">
                            <div class="img" style="background-image: url(<?= $base_url ?>assets/images/menu-1.jpg);"></div>
                            <div class="desc p-4">
                                <div class="d-md-flex text align-items-start">
                                    <h3><span>Grilled Crab with Onion</span></h3>
                                    <span class="price">$20.00</span>
                                </div>
                                <div class="d-block">
                                    <p>A small river named Duden flows by their place and supplies</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4 d-flex">
                        <div class="pricing-entry rounded d-flex ftco-animate">
                            <div class="img" style="background-image: url(<?= $base_url ?>assets/images/menu-2.jpg);"></div>
                            <div class="desc p-4">
                                <div class="d-md-flex text align-items-start">
                                    <h3><span>Grilled Crab with Onion</span></h3>
                                    <span class="price">$20.00</span>
                                </div>
                                <div class="d-block">
                                    <p>A small river named Duden flows by their place and supplies</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4 d-flex">
                        <div class="pricing-entry rounded d-flex ftco-animate">
                            <div class="img" style="background-image: url(<?= $base_url ?>assets/images/menu-3.jpg);"></div>
                            <div class="desc p-4">
                                <div class="d-md-flex text align-items-start">
                                    <h3><span>Grilled Crab with Onion</span></h3>
                                    <span class="price">$20.00</span>
                                </div>
                                <div class="d-block">
                                    <p>A small river named Duden flows by their place and supplies</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4 d-flex">
                        <div class="pricing-entry rounded d-flex ftco-animate">
                            <div class="img" style="background-image: url(<?= $base_url ?>assets/images/menu-4.jpg);"></div>
                            <div class="desc p-4">
                                <div class="d-md-flex text align-items-start">
                                    <h3><span>Grilled Crab with Onion</span></h3>
                                    <span class="price">$20.00</span>
                                </div>
                                <div class="d-block">
                                    <p>A small river named Duden flows by their place and supplies</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4 d-flex">
                        <div class="pricing-entry rounded d-flex ftco-animate">
                            <div class="img" style="background-image: url(<?= $base_url ?>assets/images/menu-5.jpg);"></div>
                            <div class="desc p-4">
                                <div class="d-md-flex text align-items-start">
                                    <h3><span>Grilled Crab with Onion</span></h3>
                                    <span class="price">$20.00</span>
                                </div>
                                <div class="d-block">
                                    <p>A small river named Duden flows by their place and supplies</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4 d-flex">
                        <div class="pricing-entry rounded d-flex ftco-animate">
                            <div class="img" style="background-image: url(<?= $base_url ?>assets/images/menu-6.jpg);"></div>
                            <div class="desc p-4">
                                <div class="d-md-flex text align-items-start">
                                    <h3><span>Grilled Crab with Onion</span></h3>
                                    <span class="price">$20.00</span>
                                </div>
                                <div class="d-block">
                                    <p>A small river named Duden flows by their place and supplies</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center ftco-animate">
                        <p><a href="#" class="btn btn-primary rounded">View All Menu</a></p>
                    </div>
                </div>
            </div>
        </section>


        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center mb-5 pb-3">
                    <div class="col-md-7 heading-section text-center ftco-animate">
                        <span class="subheading">Read Blog</span>
                        <h2>Recent Blog</h2>
                    </div>
                </div>
                <div class="row d-flex">
                    <div class="col-md-4 d-flex ftco-animate">
                        <div class="blog-entry align-self-stretch">
                            <a href="blog-single.html" class="block-20 rounded"
                                style="background-image: url('<?= $base_url ?>assets/images/image_1.jpg');">
                            </a>
                            <div class="text mt-3 text-center">
                                <div class="meta mb-2">
                                    <div><a href="#">Oct. 30, 2019</a></div>
                                    <div><a href="#">Admin</a></div>
                                    <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div>
                                </div>
                                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind
                                        texts</a></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex ftco-animate">
                        <div class="blog-entry align-self-stretch">
                            <a href="blog-single.html" class="block-20 rounded"
                                style="background-image: url('<?= $base_url ?>assets/images/image_2.jpg');">
                            </a>
                            <div class="text mt-3 text-center">
                                <div class="meta mb-2">
                                    <div><a href="#">Oct. 30, 2019</a></div>
                                    <div><a href="#">Admin</a></div>
                                    <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div>
                                </div>
                                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind
                                        texts</a></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex ftco-animate">
                        <div class="blog-entry align-self-stretch">
                            <a href="blog-single.html" class="block-20 rounded"
                                style="background-image: url('<?= $base_url ?>assets/images/image_3.jpg');">
                            </a>
                            <div class="text mt-3 text-center">
                                <div class="meta mb-2">
                                    <div><a href="#">Oct. 30, 2019</a></div>
                                    <div><a href="#">Admin</a></div>
                                    <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div>
                                </div>
                                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind
                                        texts</a></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="instagram">
            <div class="container-fluid">
                <div class="row no-gutters justify-content-center pb-5">
                    <div class="col-md-7 text-center heading-section ftco-animate">
                        <span class="subheading">Photos</span>
                        <h2><span>Instagram</span></h2>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-sm-12 col-md ftco-animate">
                        <a href="<?= $base_url ?>assets/images/insta-1.jpg" class="insta-img image-popup"
                            style="background-image: url(<?= $base_url ?>assets/images/insta-1.jpg);">
                            <div class="icon d-flex justify-content-center">
                                <span class="icon-instagram align-self-center"></span>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md ftco-animate">
                        <a href="<?= $base_url ?>assets/images/insta-2.jpg" class="insta-img image-popup"
                            style="background-image: url(<?= $base_url ?>assets/images/insta-2.jpg);">
                            <div class="icon d-flex justify-content-center">
                                <span class="icon-instagram align-self-center"></span>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md ftco-animate">
                        <a href="<?= $base_url ?>assets/images/insta-3.jpg" class="insta-img image-popup"
                            style="background-image: url(<?= $base_url ?>assets/images/insta-3.jpg);">
                            <div class="icon d-flex justify-content-center">
                                <span class="icon-instagram align-self-center"></span>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md ftco-animate">
                        <a href="<?= $base_url ?>assets/images/insta-4.jpg" class="insta-img image-popup"
                            style="background-image: url(<?= $base_url ?>assets/images/insta-4.jpg);">
                            <div class="icon d-flex justify-content-center">
                                <span class="icon-instagram align-self-center"></span>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md ftco-animate">
                        <a href="<?= $base_url ?>assets/images/insta-5.jpg" class="insta-img image-popup"
                            style="background-image: url(<?= $base_url ?>assets/images/insta-5.jpg);">
                            <div class="icon d-flex justify-content-center">
                                <span class="icon-instagram align-self-center"></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

<?php
    require("templates/frontend_footer.php");
?>