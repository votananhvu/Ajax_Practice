<?php
include('connectDB.php');

if(count($_FILES['list_of_files']['name'])) {
    for ($count=0; $count < count($_FILES['list_of_files']['name']); $count++) {
        $file_name = $_FILES['list_of_files']['name'][$count];
        $tmp_name = $_FILES['list_of_files']['tmp_name'][$count];
        $file_array = explode('.',$file_name);
        $file_extension = end($file_array);
        if(file_already_uploaded($file_name)) {
            $file_name = $file_array[0].'-'.rand().'.'.$file_extension;
        }

        $location = '../uploads/'.$file_name;
        if(move_uploaded_file($tmp_name, $location)) {
            $query = mysqli_query($con,"INSERT INTO tbl_image(image_name,image_description) VALUES ('".$file_name."','')");
        }
    }
}

function file_already_uploaded($file_name) {
    $query = mysqli_query($con,"SELECT * FROM tbl_image WHERE image_name='".$file_name."'");
    $number_of_rows = mysqli_num_rows($query);
    if ($number_of_rows > 0) {
        return true;
    } else {
        return false;
    }
}
?>