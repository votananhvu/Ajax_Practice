<?php
include('connectDB.php');

$query = mysqli_query($con,"SELECT * FROM tbl_image WHERE image_id='".$_POST['image_id']."'");
while($row = mysqli_fetch_array($query)) {
    $file_array = explode(".",$row['image_name']);
    $output['img_name'] = $file_array[0];
    $output['img_description'] = $row['image_description'];
    $output['imgID'] = $row['image_id'];
}
echo json_encode($output);

?>