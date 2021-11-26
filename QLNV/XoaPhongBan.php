<!doctype html>
<html lang="vi-VN">

<head>
    <title>Sửa Phòng Ban</title>
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

    //khối xử lý Sửa Phòng Ban
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
    $tenPhong = "";
    // mã Loại Nhân Viên muốn sửa
    $maPhong = "";
    // biến kiểm tra có muốn in cái form ra không ?
    $oke = false;
    // tìm kiếm Loại Nhân Viên trùng khớp
    if (!empty($_GET['maPhong'])) {
        $maPhong = $_GET['maPhong'];
        // viết truy vấn sql 
        $sql = "Select *
               from phongban
            where MaPhong like $maPhong";
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
            $maPhong = $data[0][0];
            $tenPhong = $data[0][1];
            $oke = true;
        }
    }
    $xoaConfirm = 0;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $maPhong = $_POST['maPhong'];
        $tenPhong = $_POST['tenPhong'];

        $xoaConfirm = $_POST['xoaConfirm'];
        if ($xoaConfirm == 1) {
            // Sửa vào cơ sở dữ liệu
            $sql = "DELETE FROM `phongban` 
        WHERE `MaPhong` = '$maPhong'";
            // kết quả của truy vấn 
            $result = mysqli_query($conn, $sql);
        }
        header("Location: ThongTinPB.php");
    }
    // đóng kết nối csdl, nên có, đừng quên đóng 
    mysqli_close($conn);
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
                    <h3>Sửa Phòng Ban</h3>
                </div>
            </div>
            <!-- Mã Loại Phòng Ban tự sinh -->
            <div class="form-group row text-center">
                <!-- Mã Loại Phòng Ban  -->
                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="maPhong" class="mr-sm-2">Mã Loại Phòng Ban:</label>
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="maPhong" name="maPhong" value="<?php echo $maPhong ?>" readonly>
                    <div class="valid-feedback col-sm">Hợp lệ</div>
                    <div class="invalid-feedback col-sm">Vui lòng nhập giá trị hợp lệ</div>
                </div>
            </div>
            <!-- Tên Loại Phòng Ban  -->
            <div class="form-group row text-center">
                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="tenPhong" class="mr-sm-2">Tên Loại Phòng Ban</label>
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="tenPhong" placeholder="Nhập Loại Phòng Ban:" name="tenPhong" required value="<?php echo $tenPhong  ?>" readonly>
                    <div class="valid-feedback col-sm">Hợp lệ</div>
                    <div class="invalid-feedback col-sm">Vui lòng nhập giá trị hợp lệ</div>
                </div>
            </div>
            <!-- row submit   -->
            <div class="form-group row " <?php if ($oke == false) echo 'hidden' ?>>
                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="xoaConfirm"><b>CÓ CHẮC MUỐN XÓA ??</b></label>
                </div>
                <div class="col-sm-7 text-left">
                    <button type="submit" id="xoaConfirm" value="1" name="xoaConfirm" class="btn " form="form1" style="background-color:pink;" onclick="alert('Đã thực hiện thao tác xong')">Có</button>
                    <button type="submit" id="xoaConfirm" value="0" name="xoaConfirm" class="btn " form="form1" style="background-color:pink;" onclick="alert('Đã thực hiện thao tác xong')">Không</button>
                </div>
                
            </div>
        </form>
    </div>


    <!-- footer -->
    <?php include 'footer.html'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script> -->
</body>

</html>