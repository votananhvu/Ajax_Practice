<?php
include('connectDB.php');

if (isset($_POST['image_id'])) {
    $id = $_POST['image_id'];
    $image_name = $_POST['image_name'];
    $file_path = '../uploads/'.$image_name;
    if (unlink($file_path)) {
        $query = mysqli_query($con,"DELETE FROM tbl_image WHERE image_id=$id");
    }
}
?>