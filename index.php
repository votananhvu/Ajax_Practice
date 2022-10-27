<?php
    include('connectDB.php');
    $sql_select_quocgia = mysqli_query($con,"SELECT * FROM tbl_quocgia ORDER BY quocgia_id ASC");

?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <h2>INSERT DỮ LIỆU FORM</h2>
        <div class="col-md-12">
            <form class="form-group" method="post" id="form_hoten">
                <label for="">Họ và tên</label>
                <input type="text" name="" id="hoten" class="form-control" placeholder="" aria-describedby="helpId">
                <label for="">Số phone</label>
                <input type="text" name="" id="phone" class="form-control" placeholder="" aria-describedby="helpId">
                <label for="">Địa chỉ</label>
                <input type="text" name="" id="address" class="form-control" placeholder="" aria-describedby="helpId">
                <label for="">Email</label>
                <input type="email" name="" id="email" class="form-control" placeholder="" aria-describedby="helpId">
                <label for="">Ghi chú</label>
                <input type="text" name="" id="note" class="form-control" placeholder="" aria-describedby="helpId">
                <input type="button" value="Insert" name="insert_data" id="insert_button" class="btn btn-primary">
            </form>
        </div>
        <h2>LOAD DATA</h2>
        <!-- Hiển thị dữ liệu -->
        <div id="load_data"></div>

        <!-- Bảng select -->
        <h2>Bảng select Quốc gia & Thủ đô tương ứng</h2>
        <div class="form-group">
            <label for="">Quốc gia</label>
            <select class="form-control" name="quocgia" id="quocgia">
                <option>-----Chọn quốc gia-----</option>
                <?php
            while ($row = mysqli_fetch_array($sql_select_quocgia)) {
                echo '<option value="'.$row['quocgia_id'].'">'.$row['tenquocgia'].'</option>';
            }
            ?>
            </select>
        </div>
        <div class="form-group" style="margin-bottom:300px;">
            <label for="">Thủ đô</label>
            <select class="form-control" name="thudo" id="thudo">
                <option>-----Chọn Thủ đô-----</option>
            </select>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#quocgia').change(function() {
            var id_quocgia = $(this).val();
            $.ajax({
                url: "ajax_action.php",
                method: "post",
                data: {id_quocgia: id_quocgia},
                success: function(data) {
                    $('#thudo').html(data);
                }
            });
        })
    });
    </script>

    <script type="text/javascript">
    $(document).ready(function() { //load lại trang
        //Hàm lấy dữ liệu
        function fetch_data() {
            $.ajax({
                url: "ajax_action.php",
                method: "post",
                success: function(data) {
                    $('#load_data').html(data);
                }
            });
        }
        fetch_data();

        //Xóa dữ liệu
        $(document).on('click', '.del_data', function() {
            var id_delete = $(this).data('id_xoa');
            $.ajax({
                url: "ajax_action.php",
                method: "post",
                data: {
                    id_del: id_delete
                },
                success: function(data) {
                    alert("Xóa thành công");
                    fetch_data();
                }
            });
        })

        //Hàm edit dữ liệu, truyền vào params gồm: id khách hàng, nội dung của cột, tên cột
        function edit_data(id, text, column_name) {
            $.ajax({
                url: "ajax_action.php",
                method: "post",
                data: {
                    id: id,
                    text: text,
                    column_name
                },
                success: function(data) {
                    alert("Edit thành công");
                    fetch_data();
                }
            });
        }
        //Thực hiện lưu thay đổi khi click chuột và bất kì trên trang sau khi dữ liệu thay đổi
        //Thay đổi dữ liệu cột Họ và tên
        $(document).on('blur', '.hoten', function() {
            var id = $(this).data('id1');
            var text = $(this).text();
            edit_data(id, text, "hoten");
        });
        //Thay đổi dữ liệu cột SĐT 
        $(document).on('blur', '.phone', function() {
            var id = $(this).data('id2');
            var text = $(this).text();
            edit_data(id, text, "phone");
        });
        //Thay đổi dữ liệu cột EMAIL
        $(document).on('blur', '.email', function() {
            var id = $(this).data('id3');
            var text = $(this).text();
            edit_data(id, text, "email");
        });
        //Thay đổi dữ liệu cột Địa chỉ
        $(document).on('blur', '.address', function() {
            var id = $(this).data('id4');
            var text = $(this).text();
            edit_data(id, text, "address");
        });
        //Thay đổi dữ liệu cột Ghi chú
        $(document).on('blur', '.ghichu', function() {
            var id = $(this).data('id5');
            var text = $(this).text();
            edit_data(id, text, "ghichu");
        });
        //insert dữ liệu
        $('#insert_button').on('click', function() {
            var hoten = $('#hoten').val();
            var sdt = $('#phone').val();
            var diachi = $('#address').val();
            var email = $('#email').val();
            var ghichu = $('#note').val();
            if (hoten == '' || sdt == '' || diachi == '' || email == '' || ghichu == '') {
                alert('Không được bỏ trống các trường!');
            } else {
                $.ajax({
                    url: "ajax_action.php",
                    method: "post",
                    data: {
                        hoten: hoten,
                        sdt: sdt,
                        diachi: diachi,
                        email: email,
                        ghichu: ghichu
                    },
                    success: function(data) {
                        alert("Insert dữ liệu thành công");
                        $('#form_hoten')[0].reset();
                        fetch_data();
                    }
                });
            }
        });
    });
    </script>

</body>

</html>