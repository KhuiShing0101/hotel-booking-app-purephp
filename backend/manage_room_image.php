<?php
    require("../require/check_auth.php");
    $header_title    = "Hotel Booking::Manage Room Image";
    $proc_error      = false;
    $error           = false;
    $error_message   = "";
    $table           = "room_gallery";
    $table_room      = "rooms";
    $success         = false;
    $success_message = "";
    $status_message  = (isset($_GET["message"])) ? $_GET["message"] : "";

    switch ($status_message) {
        case "update":
            $success         = true;
            $success_message = "Image Updated Successfully!";
    }
   
    if (isset($_GET["id"])) {
        $room_id      = (int)($_GET["id"]);
        $room_id      = $mysqli->real_escape_string($room_id);
        
        $result       = getRoomDetailByID($mysqli, $room_id);
        $room_gallery = getRoomGalleryById($mysqli, $room_id);
        $res_gallery  = $room_gallery->num_rows;

        if ($result <= 0) {
            $url      = $cp_base_url . "show_room.php";
            header("Location:" . $url);
            exit();
        }
    } else if (isset($_POST["submit"]) && $_POST["form-submit"] == 1) {
        $room_id         = (int)($_POST["id"]);
        $room_id         = $mysqli->real_escape_string($room_id);

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
                $is_thumb         = getThumbnailByID($mysqli, $room_id);
                
                while ($row_thumb = $is_thumb->fetch_assoc()) {
                    $thumb_name   = $row_thumb["thumbnail"];
                }

                if ($thumb_name == "") {
                    require("generate_thumb.php");
                }
            } else {
                $image_room_dir   = realpath($root_path . "upload/" . $room_id. "/");

                if (is_dir($image_room_dir) == false) {
                    mkdir($root_path . "upload/" . $room_id . "/");
                    chmod($root_path . "upload/" . $room_id . "/", 0777);

                    move_uploaded_file($_FILES["file"]["tmp_name"], $upload_dir . "/" . $room_id . "/" . $image_name);
                    $is_thumb         = getThumbnailByID($mysqli, $room_id);
                
                    while ($row_thumb = $is_thumb->fetch_assoc()) {
                        $thumb_name   = $row_thumb["thumbnail"];
                    }

                    if ($thumb_name == "") {
                        require("generate_thumb.php");
                    }
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"], $image_room_dir . "/" . $image_name);                    
                    $is_thumb         = getThumbnailByID($mysqli, $room_id);

                    while ($row_thumb = $is_thumb->fetch_assoc()) {
                        $thumb_name   = $row_thumb["thumbnail"];
                    }

                    if ($thumb_name == "") {
                        require("generate_thumb.php");
                    }
                }
            }
        } else {
            $error         = true;
            $proc_error    = true;
            $error_message = "Image only allow jpg,jpeg & png!";
        }

        if ($proc_error == false) {
            $data             = [
                "room_id"     => $room_id,
                "image_name"  => $image_name
            ];
            $thumb_data       = [
                "thumbnail"   => $thumb_name
            ];
            $res_insert_query = insertQuery($mysqli, $table, $data);
            $update_query     = updateQuery($mysqli, $table_room, $thumb_data, $room_id);

            $url              = $cp_base_url . "manage_room_image.php?id=" . $room_id;
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
                           <h1 style="font-size:20px">Manage Hotel Room Image</h1>
                           <form action="<?= $cp_base_url ?>manage_room_image.php" method="post" enctype="multipart/form-data">
                                <div class="row">           
                                    <div class="col-md-6 col-sm-6">
                                        <div class="row">
                                            <?php             
                                                if (isset($res_gallery) >= 1) {
                                                    while ($row_gallery  = $room_gallery->fetch_assoc()) {
                                                        $room_image_id   = (int)($row_gallery["id"]);
                                                        $room_image_name = htmlspecialchars($row_gallery["image_name"]);
                                                        $room_image_url  = $base_url . "upload/" . $room_id . "/" . $room_image_name;
                                                        $delete_url      = $cp_base_url . "delete_room_image.php?rid=" . $room_id . "&id=" . $room_image_id;
                                                        $edit_url        = $cp_base_url . "edit_room_image.php?rid=" . $room_id . "&id=" . $room_image_id;
                                            ?>
                                                        <div class="col-md-3 col-sm-3 m-2 p-0">
                                                            <img src="<?= $room_image_url ?>" class="preview-img mb-2" style="height: 100px;">
                                                            <div>
                                                                <a href="<?= $edit_url ?>" class="btn btn-sm px-3 btn-secondary">Edit</a>
                                                                <?php 
                                                                    $thumb             = getThumbnailByID($mysqli, $room_id);

                                                                    while ($row_thumb  = $thumb->fetch_assoc()) {
                                                                        $is_thumb_name = $row_thumb["thumbnail"];
                                                                    }
                                                                    $is_thumb_name     = str_replace("thumb_", "", $is_thumb_name);
                                                                    if (!($is_thumb_name == $room_image_name)) {
                                                                ?>
                                                                        <a href="<?= $delete_url ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are your Sure to Delete?')">Delete</a>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
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
                                                <img src="" class="preview-image" alt="" onclick="browseFile()">
                                            </div>
                                        </div>
                                        <div id="upload-btn" class="upload-btn field item form-group">
                                            <div class="form-group">
                                                <div class="col-md-12 col-sm-12">
                                                    <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                                                    <button type="button" class="btn btn-danger" onclick="clearFile()">Clear</button>
                                                    <input type="hidden" name="form-submit" value="1">
                                                    <input type="hidden" name="id" value="<?= $room_id ?>">
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

<script>
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
            $(".file-browse").hide();
        } else {
            alert("Please upload valid Image Type");
            $(".drag-area").removeClass("active");
        }
    }

    function clearFile() {
        $(".show-img-preview").hide();
        $(".upload-btn").hide();
        $(".file-browse").show();
        $("#fileInput").attr("val", "");
        $(".drag-area").removeClass("active");
        $(".preview-image").attr("src", "");
    }
</script>

<?php 
    require("../templates/cp_footer.php");
?>


