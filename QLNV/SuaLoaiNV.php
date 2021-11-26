<!doctype html>
<html lang="vi-VN">

<head>
    <title>Sửa Loại Nhân Viên</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"> -->

    <!-- bootstrap cdn  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- css tự làm -->
    <link rel="stylesheet" type="text/css" href="css/ThongTinNV.css">
</head>

<body>
    <!-- khối xử lý  -->
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "qlnv";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }



    // hàm vòng lặp in ra kết quả trên bảng 
    //  input là kết quả truy vấn, và numRow, numFields (cho tiện khỏi mysql_num_...), output là các dòng tr td 
    function createData($result, $numRows)
    {
        $data = array();
        if ($numRows > 0) {
            // output data of each row
            for ($i = 1; $i <= $numRows; $i++) {
                array_push($data, mysqli_fetch_row($result));
            }
        }
        return $data;
    }

    //khối xử lý Sửa Loại Nhân Viên
    // thực hiện 2 truy vấn để tiện làm list mã phòng ban, loại nv 

    // viết truy vấn sql loại nv
    $sql2 = "Select *
               from loainv";
    // kết quả của truy vấn 
    $result2 = mysqli_query($conn, $sql2);
    // biến số hàng trả về, số thuộc tính có trong bảng
    $numRows2 = mysqli_num_rows($result2);
    //
    $numFields2 = mysqli_num_fields($result2);
    // dữ liệu truy vấn được lấy ra bỏ vô 1 mảng để tiện thao tác, khỏi truy vấn sql mệt 
    $dataLoaiNV = createData($result2, $numRows2);
    // phòng ban 
    $sql2 = "Select *
    from phongban";
    // kết quả của truy vấn 
    $result2 = mysqli_query($conn, $sql2);
    // biến số hàng trả về, số thuộc tính có trong bảng
    $numRows2 = mysqli_num_rows($result2);
    //
    $numFields2 = mysqli_num_fields($result2);
    // dữ liệu truy vấn được lấy ra bỏ vô 1 mảng để tiện thao tác, khỏi truy vấn sql mệt 
    $dataPhongBan = createData($result2, $numRows2);

    // các biến thuộc tính
    $tenLoaiNV = "";
    // mã Loại Nhân Viên muốn sửa
    $maLoaiNV = "";
    // biến kiểm tra có muốn in cái form ra không ?
    $oke = false;
    // tìm kiếm Loại Nhân Viên trùng khớp
    if (!empty($_GET['maLoaiNV'])) {
        $maLoaiNV = $_GET['maLoaiNV'];
        // viết truy vấn sql 
        $sql = "Select *
               from loainv
            where MaLoaiNV like $maLoaiNV";
        // kết quả của truy vấn 
        $result = mysqli_query($conn, $sql);
        // biến số hàng trả về, số thuộc tính có trong bảng
        $numRows = mysqli_num_rows($result);
        //
        $numFields = mysqli_num_fields($result);
        // dữ liệu truy vấn được lấy ra bỏ vô 1 mảng để tiện thao tác, khỏi truy vấn sql mệt 
        $data = createData($result, $numRows);
        //gắn giá trị cho các biến sau khi tìm thấy Loại Nhân Viên trùng khớp
        if ($numRows > 0) {
            $maLoaiNV = $data[0][0];
            $tenLoaiNV = $data[0][1];
            $oke = true;
        }
    }
    // thao tác xong thì quay lại trang thông tin 
    $back=0;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $maLoaiNV = $_POST['maLoaiNV'];
        $tenLoaiNV = $_POST['tenLoaiNV'];

        // // do định dạng ngày sinh không khớp nên phải điều chỉnh
        // $maLoaiNVFormat = explode('-', $maLoaiNV)[0];
        // $phongBanFormat = explode('-', $phongBan)[0];

        // Sửa vào cơ sở dữ liệu
        $sql = "UPDATE `loainv` 
        SET `TenLoaiNV`='$tenLoaiNV'
        WHERE `MaLoaiNV` = '$maLoaiNV'";
        // kết quả của truy vấn 
        $result = mysqli_query($conn, $sql);
    $back=1;
    }
    // đóng kết nối csdl, nên có, đừng quên đóng 
    mysqli_close($conn);
    if ($back == 1) header('Location: ThongTinLoaiNV.php');
    ?>


    <!-- khối html giao diện  -->
    <!-- header -->
    <?php include 'header.html'; ?>
    <!-- form  -->
    <div class="container w-75 border text-center">
        <!-- nếu không tìm thấy kết quả -->
        <?php
        if ($oke == false) echo "<h1>KHÔNG TÌM THẤY KẾT QUẢ NÀO</h1>";
        ?>
        <form action="" class="was-validated" method="POST" id="form1" <?php if ($oke == false) echo 'hidden';
                                                                        ?>>
            <!-- row tiêu đề -->
            <div class="form-group row " style="background-color:pink;">
                <div class="col-sm-12">
                    <h3>Sửa Loại Nhân Viên</h3>
                </div>
            </div>
            <!-- Mã Loại Nhân Viên tự sinh -->
            <div class="form-group row text-center">
                <!-- Mã Loại Nhân Viên  -->
                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="maLoaiNV" class="mr-sm-2">Mã Loại Nhân Viên:</label>
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="maLoaiNV" name="maLoaiNV" value="<?php echo $maLoaiNV ?>" readonly>
                    <div class="valid-feedback col-sm">Hợp lệ</div>
                    <div class="invalid-feedback col-sm">Vui lòng nhập giá trị hợp lệ</div>
                </div>
            </div>
            <!-- Tên Loại Nhân Viên  -->
            <div class="form-group row text-center">
                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="tenLoaiNV" class="mr-sm-2">Tên Loại Nhân Viên</label>
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="tenLoaiNV" placeholder="Nhập họ Loại Nhân Viên:" name="tenLoaiNV" required value="<?php echo $tenLoaiNV  ?>">
                    <div class="valid-feedback col-sm">Hợp lệ</div>
                    <div class="invalid-feedback col-sm">Vui lòng nhập giá trị hợp lệ</div>
                </div>
            </div>

        </form>
        <!-- row submit   -->
        <div class="form-group row " <?php if ($oke == false) echo 'hidden' ?>>
            <div class="col-sm-12">
                <button type="submit" class="btn " form="form1" style="background-color:pink;" onclick="alert('Đã thực hiện thao tác xong')">Sửa</button>
                <a href="ThongTinLoaiNV.php"> <button class="btn " style="background-color:pink;">Quay Lại</button> </a>
            </div>
        </div>
    </div>


    <!-- footer -->
    <?php include 'footer.html'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script> -->
</body>

</html>