<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?= $title ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= $base_url ?>assets/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/animate.css">
    
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/magnific-popup.css">

    <link rel="stylesheet" href="<?= $base_url ?>assets/css/aos.css">

    <link rel="stylesheet" href="<?= $base_url ?>assets/css/ionicons.min.css">

    <link rel="stylesheet" href="<?= $base_url ?>assets/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/flaticon.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/icomoon.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/frontend.style.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/reservation.css">

    <!-- PNotify -->
    <link href="<?= $base_url ?>assets/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?= $base_url ?>assets/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?= $base_url ?>assets/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="javascript:void(0)">Hotel<span>Booking</span></a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"><a href="<?= $base_url ?>index.php" class="nav-link">Home</a></li>
	          <li class="nav-item"><a href="<?= $base_url ?>rooms.php" class="nav-link">Our Rooms</a></li>
	          <li class="nav-item"><a href="about.html" class="nav-link">About Us</a></li>
	          <li class="nav-item"><a href="<?= $base_url ?>contact_us.php" class="nav-link">Contact</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->

    <div class="hero">
        <section class="home-slider owl-carousel">
            <div class="slider-item" style="background-image:url(<?= $base_url ?>assets/images/bg_1.jpg);">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row no-gutters slider-text align-items-center justify-content-end">
                        <div class="col-md-6 ftco-animate">
                            <div class="text">
                                <h2>More than a hotel... an experience</h2>
                                <h1 class="mb-3">Hotel for the whole family, all year round.</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="slider-item" style="background-image:url(<?= $base_url ?>assets/images/bg_2.jpg);">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row no-gutters slider-text align-items-center justify-content-end">
                        <div class="col-md-6 ftco-animate">
                            <div class="text">
                                <h2>Harbor Lights Hotel &amp; Resort</h2>
                                <h1 class="mb-3">It feels like staying in your own home.</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	</div>