<!doctype html>
<html lang="vi-VN">

<head>
    <title>Thêm Phòng Ban</title>
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


    // viết truy vấn sql 
    $sql = "Select *
               from phongban";
    // kết quả của truy vấn 
    $result = mysqli_query($conn, $sql);
    // biến số hàng trả về, số thuộc tính có trong bảng
    $numRows = mysqli_num_rows($result);
    //
    $numFields = mysqli_num_fields($result);
    // dữ liệu truy vấn được lấy ra bỏ vô 1 mảng để tiện thao tác, khỏi truy vấn sql mệt 
    $data = createData($result, $numRows);
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
        } else {
            echo "0 results";
        }
        return $data;
    }

    //khối xử lý thêm Phòng Ban


    // các biến thuộc tính
    $tenPhongBan =  "";
    // mã Phòng Ban tự sinh, bằng thằng cuối, lấy cột 1 (mã) + 1
    $maPhongBan = $data[$numRows - 1][0] + 1;
    // kiểm tra thêm có oke không 
    $oke=0;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tenPhongBan = $_POST['tenPhongBan'];

        // thêm vào cơ sở dữ liệu
        $sql = "INSERT INTO `phongban` (`MaPhong`, `TenPhong`) 
        VALUES (NULL, '$tenPhongBan')";
        // kết quả của truy vấn 
        $result = mysqli_query($conn, $sql);
    $oke=1;
    }



    // đóng kết nối csdl, nên có, đừng quên đóng 
    mysqli_close($conn);
    if($oke==1) header('Location: ThongTinPB.php');
    ?>


    <!-- khối html giao diện  -->
    <!-- header -->
    <?php include 'header.html'; ?>
    <!-- form  -->
    <div class="container w-75 border text-center">
        <form action="" class="was-validated" method="POST" id="form1">
            <!-- row tiêu đề -->
            <div class="form-group row " style="background-color:pink;">
                <div class="col-sm-12">
                    <h3>Thêm Phòng Ban</h3>
                </div>
            </div>
            <!-- Mã Phòng Ban tự sinh -->
            <div class="form-group row text-center">
                <!-- Mã Phòng Ban  -->
                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="maPhongBan" class="mr-sm-2">Mã Phòng Ban:</label>
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="maPhongBan" name="maPhongBan" value="<?php echo $maPhongBan ?>" readonly>
                    <div class="valid-feedback col-sm">Hợp lệ</div>
                    <div class="invalid-feedback col-sm">Vui lòng nhập giá trị hợp lệ</div>
                </div>
            </div>
            <!-- Tên Phòng Ban  -->
            <div class="form-group row text-center">
                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="tenPhongBan" class="mr-sm-2">Tên Phòng Ban</label>
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="tenPhongBan" placeholder="Nhập Tên Phòng Ban:" name="tenPhongBan" required value="<?php echo $tenPhongBan  ?>">
                    <div class="valid-feedback col-sm">Hợp lệ</div>
                    <div class="invalid-feedback col-sm">Vui lòng nhập giá trị hợp lệ</div>
                </div>
            </div>
        </form>
        <!-- row submit   -->
        <div class="form-group row ">
            <div class="col-sm-12">
                <button type="submit" class="btn " form="form1" style="background-color:pink;" onclick="alert('Đã thực hiện thao tác xong')">Thêm</button>
                <a href="ThongTinPB.php"> <button class="btn " style="background-color:pink;">Quay Lại</button> </a>
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