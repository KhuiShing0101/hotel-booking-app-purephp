<?php
    require("../require/check_auth.php");
    $header_title  = "Hotel Booking::Update Room Image";
    $proc_error    = false;
    $error         = false;
    $error_message = "";
    $table         = "room_gallery";
    $table_room    = "rooms";

    if (isset($_GET["id"])) {
        $room_id   = (int)($_GET["rid"]);
        $image_id  = (int)($_GET["id"]);
        $image_id  = $mysqli->real_escape_string($image_id);

        $result_image = selectGalleryById($mysqli, $image_id);
        $result_row   = $result_image->num_rows;

        if ($result_row <= 0) {
            $url              = $cp_base_url . "manage_room_image.php?id=" . $room_id;
            header("Location:" . $url);
            exit();
        }
    } else if (isset($_POST["submit"]) && $_POST["form-submit"] == 1) {
        $room_id         = (int)($_POST["room_id"]);
        $image_id        = (int)($_POST["image_id"]);
        $image_id        = $mysqli->real_escape_string($image_id);

        if ($_FILES["file"]["name"] == "") {
            $url              = $cp_base_url . "manage_room_image.php?id=" . $room_id;
            header("Location:" . $url);
            exit();
        }

        $valid_extension = ["jpg", "jpeg", "png"];
        $file_name       = $mysqli->real_escape_string($_FILES["file"]["name"]);
        $img_name        = explode(".", $file_name);
        $extension       = strtolower(end($img_name));
        $rand            = rand(100000, 999999);
        $unique_number   = $rand . time();
        $image_name      = $img_name[0] . "_" . $unique_number . "." . $extension;
        
        if (in_array($extension, $valid_extension)) {
            $upload_dir  = realpath($root_path . "upload/");
        
            if (is_dir($upload_dir) == false) {
                mkdir($root_path . "upload/");
                chmod($root_path . "upload/", 0777);

                mkdir($root_path . "upload/" . $room_id . "/");
                chmod($root_path . "upload/" . $room_id . "/", 0777);

                move_uploaded_file($_FILES["file"]["tmp_name"], $root_path . "upload/" . $room_id . "/" . $image_name);
            } else {
                $image_room_dir = realpath($root_path . "upload/" . $room_id. "/");

                if (is_dir($image_room_dir) == false) {
                    mkdir($root_path . "upload/" . $room_id . "/");
                    chmod($root_path . "upload/" . $room_id . "/", 0777);

                    move_uploaded_file($_FILES["file"]["tmp_name"], $upload_dir . "/" . $room_id . "/" . $image_name);
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"], $image_room_dir . "/" . $image_name);
                }
            }
        } else {
            $error         = true;
            $proc_error    = true;
            $error_message = "Image only allow jpg,jpeg & png!";
        }

        if ($proc_error == false) {
            $data             = [
                "image_name"  => $image_name
            ];
            
            require("generate_thumb.php");
            
            $thumb_data       = [
                "thumbnail"   => $thumb_name
            ];

            $res_insert_query = updateQuery($mysqli, $table, $data, $image_id);
            $update_query     = updateQuery($mysqli, $table_room, $thumb_data, $room_id);
            
            $url              = $cp_base_url . "manage_room_image.php?id=" . $room_id . "&message=update";
            header("Location:" . $url);
            exit();
        }
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
                           <h1 style="font-size:20px">Update Hotel Room Image</h1>
                           <form action="<?= $cp_base_url ?>edit_room_image.php" method="post" enctype="multipart/form-data">
                                <div class="row">    
                                    <div class="col-md-6 col-sm-6">
                                        <div class="drag-area">
                                            <div class="file-browse">
                                                <div class="icon">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                </div>
                                                <header>Drag & Drop to Upload File</header>
                                                <span>OR</span>
                                                <label class="input-file">
                                                    Choose File <input type="file" name="file" id="fileInput" onchange="chooseFile()">
                                                </label>
                                            </div>
                                            <div class="show-img-preview">
                                                <?php
                                                    if ($result_row >= 1) {
                                                        while ($row_image = $result_image->fetch_assoc()) {
                                                            $image_name   = htmlspecialchars($row_image["image_name"]);
                                                ?>
                                                            <img src="<?= $base_url . "upload/" . $room_id . "/" . $image_name ?>" class="preview-image" alt="" onclick="browseFile()">
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div id="upload-btn" class="upload-btn field item form-group">
                                            <div class="form-group">
                                                <div class="col-md-12 col-sm-12">
                                                    <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                                                    <a href="<?= $cp_base_url . "manage_room_image.php?id=" . $room_id ?>" type="button" class="btn btn-danger">Back</a>
                                                    <input type="hidden" name="form-submit" value="1">
                                                    <input type="hidden" name="room_id" value="<?= $room_id ?>">
                                                    <input type="hidden" name="image_id" value="<?= $image_id ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
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

<script>
    showEditImage();

    function showEditImage() {
        $(".file-browse").hide();
        $(".show-img-preview").show();
        $(".upload-btn").show();
    }

    function browseFile() {
        $("#fileInput").trigger("click");
    }

    function chooseFile() {
        file = $("#fileInput")[0].files[0];
        $(".drag-area").addClass("active");
        previewImage(file);
    }

    function previewImage(file) {
        let fileType          = file.type;
        let validExtensions   = ["image/jpeg", "image/jpg", "image/png"];

        if (validExtensions.includes(fileType)) {
            let fileReader    = new FileReader();
            fileReader.onload = () => {
                let fileUrl   = fileReader.result;
                $(".preview-image").attr("src", fileUrl);
            }
            fileReader.readAsDataURL(file);
            $(".show-img-preview").show();
            $(".upload-btn").show();
        } else {
            alert("Please upload valid Image Type");
            $(".drag-area").removeClass("active");
        }
    }

</script>

<?php 
    require("../templates/cp_footer.php");
?>


