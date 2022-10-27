<?php
include('connectDB.php');

if (isset($_POST['image_id'])) {
    $id = $_POST['image_id'];
    $name = $_POST['image_name'];
    $description = $_POST['image_description'];
    $old_name = get_old_image_name($con,$id);
    // $select = mysqli_query($con,"SELECT * FROM tbl_image WHERE image_id=$id");
    // while ($row = mysqli_fetch_array($select)) {
    //     $old_name = $row['image_name'];
    // }
    $file_array = explode('.',$old_name);
    $file_extension = end($file_array);
    $new_name = $name.'.'.$file_extension;
    if ($old_name != $new_name) {
        $old_path = '../uploads/'.$old_name;
        $new_path = '../uploads/'.$new_name;
        if (rename($old_path, $new_path)) {
            $query = mysqli_query($con,"UPDATE tbl_image SET image_name='$new_name',image_description='$description'
                     WHERE image_id=$id");
        }
    } else {
        $query = mysqli_query($con,"UPDATE tbl_image SET image_description='$description'
                 WHERE image_id=$id");
    }
}

function get_old_image_name($con,$id) { //Lưu ý phải gửi thêm tham số là $con kết nối db
    $imgName = '';
    $query = mysqli_query($con,"SELECT * FROM tbl_image WHERE image_id=$id");
    while ($row = mysqli_fetch_array($query)) {
        $imgName = $row['image_name'];
    }
    return $imgName;
}
?>