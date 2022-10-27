<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <div class="col-12">
            <form action="ajax_action.php" method="post" id="submit_form">
                <div class="form-group">
                  <label for="">Chọn ảnh</label>
                  <input type="file" class="form-control-file" name="file" id="image_file" placeholder="">
                  <small class="help-block">Cho phép ảnh: jpg,jpeg,png,gif</small>
                </div>
                <input type="submit" name="upload_button" value="Uploads" class="btn btn-success">
            </form>
            <h3 align="center">Xem ảnh</h3>
            <div class="row" id="image_preview" align="center"></div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#submit_form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "ajax_action.php",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#image_preview').html(data);
                        $('#image_file').val('');
                    }
                })
            });

            $(document).on('click','#remove_button',function() {
                if (confirm('Bạn có muốn xóa ảnh này không?')) {
                    var path = $('#remove_button').data('path');
                    $.ajax({
                        url: "ajax_action.php",
                        method: 'POST',
                        data: {path:path},
                        success: function (data) {
                            $('#image_preview').html('');
                            alert("Đã xóa ảnh");
                        }
                    })
                }
            })
        });
    </script>
</body>

</html>