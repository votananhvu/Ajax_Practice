<?php

include('connectDB.php');

//Upload image
if ($_FILES['file']['name'] != '') {
    $extension = explode('.', $_FILES['file']['name']);
    $file_extension = end($extension);
    $allowed_type = array('jpg', 'jpeg', 'png', 'gif');
    if (in_array(strtolower($file_extension), $allowed_type)) {
        $new_name = rand().".".$file_extension;
        $path = "uploads/".$new_name;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
            echo '<div class="col-md-8" align="right">
                    <img src="'.$path.'" class="img-responsive" /></div>
                <div class="col-md-1" align="left">
                    <button type="button" class="btn btn-danger" id="remove_button" data-path="'.$path.'">X</button>
                </div>
                ';
        }
    } else {
        echo '<script>alert("Lỗi upload file hoặc file không đúng định dạng")</script>';
    }
} else {
    echo '<script>alert("Vui lòng chọn file ảnh")</script>';
}

//Delete image
if (!empty($_POST['path'])) {
    if (unlink($_POST['path'])) {
        echo '';
    }
}

//Select dữ liệu
if (isset($_POST['id_quocgia'])) {
    $id_quocgia = $_POST['id_quocgia'];
    $mysql_select_thudo = mysqli_query($con, "SELECT tenthudo FROM tbl_thudo WHERE quocgia_id=$id_quocgia");
    $output = '<option>-----Chọn thủ đô-----</option>';
    if (mysqli_num_rows($mysql_select_thudo) > 0) {
        while ($row = mysqli_fetch_array($mysql_select_thudo)) {
            $output = '<option value="'.$row['tenthudo'].'">'.$row['tenthudo'].'</option>';
        }
    }
    // echo $output;
}

//Chèn dữ liệu
if (isset($_POST['hoten'])) {
    $hoten = $_POST['hoten'];
    $sdt = $_POST['sdt'];
    $diachi = $_POST['diachi'];
    $email = $_POST['email'];
    $ghichu = $_POST['ghichu'];
    $result = mysqli_query($con, "INSERT INTO tbl_khachhang(hoten,phone,email,address,ghichu) VALUES ('$hoten','$sdt','$email','$diachi','$ghichu')");
}

//Xóa dữ liệu
if (isset($_POST['id_del'])) {
    $id = $_POST['id_del'];
    $result = mysqli_query($con, "DELETE FROM tbl_khachhang WHERE member_id=$id");
}

//Edit dữ liệu
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $text = $_POST['text'];
    $column_name = $_POST['column_name'];
    $result = mysqli_query($con, "UPDATE tbl_khachhang SET $column_name='$text' WHERE member_id=$id");
}


//Lấy dữ liệu
$output = '';
$mysql_select = mysqli_query($con, "SELECT * FROM tbl_khachhang ORDER BY member_id DESC");
$output .= '
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>Họ và tên</th>
                <th>SĐT</th>
                <th>EMAIL</th>
                <th>Địa chỉ</th>
                <th>Ghi chú</th>
                <th>Quản lý</th>
            </tr>
        </thead>
        <tbody>
';

if (mysqli_num_rows($mysql_select) > 0) {
    while($row = mysqli_fetch_array($mysql_select)) {
        $output .= '   
        <tr>
            <td class="hoten" data-id1='.$row['member_id'].' contenteditable>'.$row['hoten'].'</td>
            <td class="phone" data-id2='.$row['member_id'].' contenteditable>'.$row['phone'].'</td>
            <td class="email" data-id3='.$row['member_id'].' contenteditable>'.$row['email'].'</td>
            <td class="address" data-id4='.$row['member_id'].' contenteditable>'.$row['address'].'</td>
            <td class="ghichu" data-id5='.$row['member_id'].' contenteditable>'.$row['ghichu'].'</td>
            <td>
                <button class="btn btn-danger del_data" name="delete_data" data-id_xoa='.$row['member_id'].'>Xóa</button>
            </td>
        </tr>
        ';
    }
} else {
    $output .= '
            <tr>
                <td colspan="6" style="text-align: center;">Chưa có dữ liệu</td>
            </tr>
    ';
}

$output .= '
        </tbody>
    </table>
';

// echo $output;

?>
