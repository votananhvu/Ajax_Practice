<?php
include('connectDB.php');

//Lấy dữ liệu
$query = mysqli_query($con,"SELECT * FROM tbl_image ORDER BY image_id DESC");
$number_of_rows = mysqli_num_rows($query);
$output = '';
$output .= '<table class="table table-striped table-inverse">
                <thead class="thead-inverse">
                    <tr>
                        <th>STT</th>
                        <th>Hình ảnh</th>
                        <th>Tên hình ảnh</th>
                        <th>Mô tả</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>';
if ($number_of_rows > 0) {
    $count = 0;
    while($row = mysqli_fetch_array($query)) {
        $count++;
        $output .= '<tr>
                        <td>'.$count.'</td>
                        <td>
                            <img src="../uploads/'.$row['image_name'].'" class="img img-thumbnail" width="100" height="100" />
                        </td>
                        <td>'.$row['image_name'].'</td>
                        <td>'.$row['image_description'].'</td>
                        <td>
                            <button type="button" class="btn btn-warning edit_button" img_id="'.$row['image_id'].'" data-img_name="'.$row['image_name'].'">Edit</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger delete_button" img_id="'.$row['image_id'].'" data-img_name="'.$row['image_name'].'">Delete</button>
                        </td>
                    </tr>';
    }
} else {
    $output .= '<tr>
                    <td colspan="6" align="center">No Image Data</td>
                </tr>';
}
$output .= '</tbody>
        </table>';
echo $output;
?>