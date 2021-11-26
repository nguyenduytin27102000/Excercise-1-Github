<!doctype html>
<html lang="vi-VN">

<head>
    <title>Thêm Nhân Viên</title>
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
               from nhanvien";
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

    //khối xử lý thêm nhân viên
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
    $ho = $ten = $ngaySinh = $diaChi = $anh = $maLoaiNV = $phongBan = "";
    $gioiTinh = "Nam";
    //biến kiểm tra thêm oke không
    $oke = 0;
    // mã nhân viên tự sinh, bằng thằng cuối, lấy cột 1 (mã) + 1
    $maNV = $data[$numRows - 1][0] + 1;
    // module thêm file 
    include 'upload.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ho = $_POST['ho'];
        $ten = $_POST['ten'];
        $ngaySinh = $_POST['ngaySinh'];
        $gioiTinh = $_POST['gioiTinh'];
        $diaChi = $_POST['diaChi'];
        if (basename($_FILES["fileToUpload"]["name"])!="")
            $anh = basename($_FILES["fileToUpload"]["name"]);
        else $anh = "anhnv.png";
        $maLoaiNV = $_POST['maLoaiNV'];
        $phongBan = $_POST['phongBan'];
        // do định dạng không khớp nên phải điều chỉnh
        $maLoaiNVFormat = explode('-', $maLoaiNV)[0];
        $phongBanFormat = explode('-', $phongBan)[0];
        // thêm vào cơ sở dữ liệu
        $sql = "INSERT INTO `nhanvien` (`MaNV`, `Ho`, `Ten`, `NgaySinh`, `GioiTinh`, `DiaChi`, `Anh`, `MaLoaiNV`, `MaPhong`) 
      VALUES (NULL, '$ho', '$ten', '$ngaySinh', '$gioiTinh', '$diaChi', '$anh', '$maLoaiNVFormat', '$phongBanFormat')";
        // kết quả của truy vấn 
        $result = mysqli_query($conn, $sql);
        $oke = 1;
    }


    // đóng kết nối csdl, nên có, đừng quên đóng 
    mysqli_close($conn);
    if ($oke == 1) header('Location: ThongTinNV.php');
    ?>


    <!-- khối html giao diện  -->
    <!-- header -->
    <?php include 'header.html'; ?>
    <!-- form  -->
    <div class="container w-75 border text-center">
        <form action="" class="was-validated" method="POST" id="form1" enctype="multipart/form-data">
            <!-- row tiêu đề -->
            <div class="form-group row " style="background-color:pink;">
                <div class="col-sm-12">
                    <h3>Thêm nhân viên</h3>
                </div>
            </div>
            <!-- Mã nhân viên tự sinh -->
            <div class="form-group row text-center">
                <!-- Mã nhân viên  -->
                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="maNV" class="mr-sm-2">Mã nhân viên:</label>
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="maNV" name="maNV" value="<?php echo $maNV ?>" readonly>
                    <div class="valid-feedback col-sm">Hợp lệ</div>
                    <div class="invalid-feedback col-sm">Vui lòng nhập giá trị hợp lệ</div>
                </div>
            </div>
            <!-- Họ nhân viên  -->
            <div class="form-group row text-center">
                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="ho" class="mr-sm-2">Họ nhân viên</label>
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="ho" placeholder="Nhập họ nhân viên:" name="ho" required value="<?php echo $ho  ?>">
                    <div class="valid-feedback col-sm">Hợp lệ</div>
                    <div class="invalid-feedback col-sm">Vui lòng nhập giá trị hợp lệ</div>
                </div>
            </div>
            <!-- tên nhân viên  -->
            <div class="form-group row text-center">
                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="ten" class="mr-sm-2">Tên nhân viên</label>
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="ten" placeholder="Nhập tên nhân viên:" name="ten" required value="<?php echo $ten  ?>">
                    <div class="valid-feedback col-sm">Hợp lệ</div>
                    <div class="invalid-feedback col-sm">Vui lòng nhập giá trị hợp lệ</div>
                </div>
            </div>
            <!-- ngày sinh nhân viên  -->
            <div class="form-group row text-center">
                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="ngaySinh" class="mr-sm-2">Ngày sinh nhân viên</label>
                </div>
                <div class="col-sm-7">
                    <input type="date" class="form-control" id="ngaySinh" placeholder="Nhập ngày sinh nhân viên:" name="ngaySinh" required value="<?php echo $ngaySinh ?>" min="1950-01-01" max="2030-12-31">
                    <div class="valid-feedback col-sm">Hợp lệ</div>
                    <div class="invalid-feedback col-sm">Vui lòng nhập giá trị hợp lệ</div>
                </div>
            </div>
            <!-- chọn giới tính -->
            <!-- các nút button radio inline  -->
            <div class="form-group row">

                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="gioiTinh" class="mr-sm-2">Giới tính</label>
                </div>
                <div class="col-sm-7 text-left">
                    <!-- Nam -->
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="gioiTinh" value="Nam" <?php if ($gioiTinh == "Nam") echo 'checked'; ?>> Nam
                        </label>
                    </div>
                    <!-- Nữ -->
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="gioiTinh" value="Nữ" <?php if ($gioiTinh == "Nữ") echo 'checked' ?>>Nữ
                        </label>
                    </div>
                </div>
            </div>
            <!-- địa chỉ -->
            <div class="form-group row text-center">
                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="diaChi" class="mr-sm-2">Địa chỉ nhân viên</label>
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="diaChi" placeholder="Nhập địa chỉ nhân viên:" name="diaChi" required value="<?php echo $diaChi  ?>">
                    <div class="valid-feedback col-sm">Hợp lệ</div>
                    <div class="invalid-feedback col-sm">Vui lòng nhập giá trị hợp lệ</div>
                </div>
            </div>
            <!-- ảnh nhân viên  -->
            <div class="form-group row text-center ">
                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="anh" class="mr-sm-2">Ảnh nhân viên</label>
                    <br>
                    <img src="image/anhnv.png" alt="ảnh nv">
                </div>

                <div class="col-sm-7">
                    <div class="form-group row">
                        <div class="col-sm-7 ">

                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-sm-7">
                            <input type="file" name="fileToUpload" id="fileToUpload" class="btn" style="background-color: pink;">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- để khỏi form nó validate mấy cái list có icon cuối :3  -->
        <!-- Mã loại nv-->
        <div class="form-group row">
            <div class="col-sm-5 col-form-label font-weight-bold">
                <label for="theLoai">Mã loại nhân viên:</label>
            </div>
            <div class="col-sm-7">
                <select class="form-control" id="loaiNV" name="maLoaiNV" form="form1">

                    <?php
                    for ($j = 0; $j < count($dataLoaiNV); $j++) {
                        echo "<option>";
                        echo  $dataLoaiNV[$j][0];
                        echo '-';
                        echo  $dataLoaiNV[$j][1];
                        echo "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- phòng ban -->
        <div class="form-group row">
            <div class="col-sm-5 col-form-label font-weight-bold">
                <label for="theLoai">Mã phòng ban:</label>
            </div>
            <div class="col-sm-7">
                <select class="form-control" id="phongBan" name="phongBan" form="form1">
                    <?php
                    for ($j = 0; $j < count($dataPhongBan); $j++) {
                        echo "<option>";
                        echo $dataPhongBan[$j][0];
                        echo '-';
                        echo $dataPhongBan[$j][1];
                        echo "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- row submit   -->
        <div class="form-group row ">
            <div class="col-sm-12">
                <button type="submit" class="btn " form="form1" style="background-color:pink;" onclick="alert('Đã thực hiện thao tác xong')">Thêm</button>
                <a href="ThongTinNV.php"> <button class="btn " style="background-color:pink;">Quay Lại</button> </a>
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