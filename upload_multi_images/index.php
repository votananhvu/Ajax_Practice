<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <!-- script Jquery phải đặt trước script boostrap.min.js để tránh lỗi function modal  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container">
        <h3 align="center">Upload nhiều hình ảnh bằng Ajax</h3>
        <br>
        <input type="file" name="multiple_files" id="multiple_files" multiple />
        <small class="text-muted">Chỉ cho phép định dạng: jpg, jpeg, png, gif</small><br />
        <small id="error_multiple_files"></small><br>
        <div class="table-responsive" id="image_table">

        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal" tabindex="-1" role="dialog" id="edit_Modal">
        <div class="modal-dialog" role="document">
            <form method="post" id="edit_image_form">
                <!-- Modal Content -->
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title text-white">EDIT IMAGE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Tên hình ảnh</label>
                            <input type="text" name="image_name" id="image_name" class="form-control" placeholder=""
                                aria-describedby="helpId">
                            <label for="">Mô tả chi tiết</label>
                            <input type="text" name="image_description" id="image_description" class="form-control" placeholder=""
                                aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="image_id" id="image_id">
                        <input type="submit" name="submit" class="btn btn-info" value="Update">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        //Hàm load dữ liệu
        function load_image_data() {
            $.ajax({
                url: "fetch.php",
                method: "POST",
                success: function(data) {
                    $('#image_table').html(data);
                }
            })
        }
        load_image_data();

        //Kiểm tra và gửi đi dữ liệu nhiều hình ảnh cần upload
        $('#multiple_files').change(function() {
            var error_images = '';
            var form_data = new FormData();
            var files = $('#multiple_files')[0].files;
            if (files.length > 10) {
                error_images = "Bạn không được upload quá 10 hình ảnh";
            } else {
                for (let i = 0; i < files.length; i++) {
                    var name = document.getElementById('multiple_files').files[i].name;
                    var img_extension = name.split('.').pop().toLowerCase();
                    if ($.inArray(img_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                        error_images = "Tập tin " + name + " Không đúng định dạng ảnh";
                    }
                    var oFReader = new FileReader();
                    var f = document.getElementById("multiple_files").files[i];
                    oFReader.readAsDataURL(f);
                    var fsize = f.size || f.fileSize;
                    if (fsize > 2000000) {
                        error_images = "file " + name + " quá lớn";
                    } else {
                        //Gửi dữ liệu mảng chứa các file đến upload.php thông qua $_FILES['list_of_files']
                        form_data.append("list_of_files[]", f);
                    }
                }
            }

            if (error_images == '') {
                $.ajax({
                    url: "upload.php",
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    processData: false,
                    cache: false,
                    beforeSend: function() {
                        $('#error_multiple_files').html(
                            '<label class="text-primary">Đang tải...</label>');
                    },
                    success: function(data) {
                        $('#error_multiple_files').html(
                            '<label class="text-success">Đã tải thành công</label>');
                        load_image_data();
                    }
                })
            }
            $('#error_multiple_files').html('<span class="text-danger">' + error_images + '</span>');
        });

        //Xóa hình ảnh
        $(document).on('click', '.delete_button', function() {
            //Cách 1: lấy ra image_id dựa vào attribute img_id
            var image_id = $(this).attr('img_id');
            //Cách 2: lấy ra image_id bằng data-delete_img
            // var image_id = $(this).data('delete_img');
            var image_name = $(this).data('img_name');
            if (confirm('Bạn có muốn xóa ảnh này không?')) {
                $.ajax({
                    url: "delete.php",
                    method: "POST",
                    data: {
                        image_id: image_id,
                        image_name: image_name
                    },
                    success: function(data) {
                        alert("Xóa thành công");
                        load_image_data();
                    }
                });
            }
        });

        //Edit hình ảnh
        $(document).on('click', '.edit_button', function() {
            var image_id = $(this).attr('img_id');
            $.ajax({
                url: "edit.php",
                method: "POST",
                dataType: "json",
                data: {image_id:image_id},
                success: function(data) {
                    console.log(data);
                    $('#edit_Modal').modal('show');
                    $('#image_id').val(data.imgID);
                    $('#image_name').val(data.img_name);
                    $('#image_description').val(data.img_description);
                }
            });
            
        });

        $('#edit_image_form').on('submit',function (e) {
            e.preventDefault();
            if($('#image_name').val() == '') {
                alert("Vui lòng điền tên hình ảnh");
            } else {
                $.ajax({
                    url: "update.php",
                    method: "post",
                    //Hàm serialize() sắp xếp theo thứ tự một tập hợp các phần tử input vào trong một chuỗi dữ liệu lấy từ form
                    data: $('#edit_image_form').serialize(),
                    success: function(data) {
                        $('#edit_Modal').modal('hide');
                        load_image_data();
                        alert("Update hình ảnh thành công");
                    }
                });
            }
        });
    });
    </script>
</body>

</html>