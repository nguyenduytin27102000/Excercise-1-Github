<!doctype html>
<html lang="vi-VN">

<head>
    <title>Sửa Nhân Viên</title>
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

    //khối xử lý Sửa nhân viên
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
    // mã nhân viên muốn sửa
    $maNV = "";
    // biến kiểm tra có muốn in cái form ra không ?
    $oke = false;
    // tìm kiếm nhân viên trùng khớp
    if (!empty($_GET['maNV'])) {
        $maNV = $_GET['maNV'];
        // viết truy vấn sql 
        $sql = "Select *
               from nhanvien
            where MaNV like $maNV";
        // kết quả của truy vấn 
        $result = mysqli_query($conn, $sql);
        // biến số hàng trả về, số thuộc tính có trong bảng
        $numRows = mysqli_num_rows($result);
        //
        $numFields = mysqli_num_fields($result);
        // dữ liệu truy vấn được lấy ra bỏ vô 1 mảng để tiện thao tác, khỏi truy vấn sql mệt 
        $data = createData($result, $numRows);
        //gắn giá trị cho các biến sau khi tìm thấy nhân viên trùng khớp
        if ($numRows > 0) {
            $maNV = $data[0][0];
            $ho = $data[0][1];
            $ten = $data[0][2];
            $ngaySinh = $data[0][3];
            $gioiTinh = $data[0][4];
            $diaChi = $data[0][5];
            $anh = $data[0][6];
            $maLoaiNV = $data[0][7];
            $phongBan = $data[0][8];
            $oke = true;
        }
    }
    //sửa thành công thì trở về trang thông tin
    $back=0;
    // module thêm file 
    include 'upload.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $maNV = $_POST['maNV'];
        $ho = $_POST['ho'];
        $ten = $_POST['ten'];
        $ngaySinh = $_POST['ngaySinh'];
        $gioiTinh = $_POST['gioiTinh'];
        $diaChi = $_POST['diaChi'];
        if ( basename($_FILES["fileToUpload"]["name"])!="")
            $anh = basename($_FILES["fileToUpload"]["name"]); 
        else 
        $anh = $_POST['anh'];
        $maLoaiNV = $_POST['maLoaiNV'];
        $phongBan = $_POST['phongBan'];
        // do định dạng ngày sinh không khớp nên phải điều chỉnh
        $maLoaiNVFormat = explode('-', $maLoaiNV)[0];
        $phongBanFormat = explode('-', $phongBan)[0];


        // Sửa vào cơ sở dữ liệu
        $sql = "UPDATE `nhanvien` 
        SET `Ho`='$ho', `Ten`='$ten', `NgaySinh`='$ngaySinh', `GioiTinh`='$gioiTinh', `DiaChi`='$diaChi', `Anh`='$anh', `MaLoaiNV`='$maLoaiNVFormat', `MaPhong`='$phongBanFormat'
        WHERE `MaNV` = '$maNV'";
        // kết quả của truy vấn 
        $result = mysqli_query($conn, $sql);
        $back=1;
    }
    // đóng kết nối csdl, nên có, đừng quên đóng 
    mysqli_close($conn);
    if ($back == 1) header('Location: ThongTinNV.php');
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
        <form action="" class="was-validated" method="POST" enctype="multipart/form-data" id="form1" <?php if ($oke == false) echo 'hidden';
                                                                        ?>>
            <!-- row tiêu đề -->
            <div class="form-group row " style="background-color:pink;">
                <div class="col-sm-12">
                    <h3>Sửa nhân viên</h3>
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
            <div class="form-group row text-center ">
                <div class="col-sm-5 col-form-label font-weight-bold">
                    <label for="anh" class="mr-sm-2">Ảnh nhân viên</label>
                    <br>
                    <img src='<?php echo "image/$anh"?>' alt="ảnh nv">
                    <input type="text" name="anh" value="<?php echo $anh?>" hidden>
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
        <div class="form-group row" <?php if ($oke == false) echo 'hidden' ?>>
            <div class="col-sm-5 col-form-label font-weight-bold">
                <label for="theLoai">Mã loại nhân viên:</label>
            </div>
            <div class="col-sm-7">
                <select class="form-control" id="loaiNV" name="maLoaiNV" form="form1">

                    <?php
                    for ($j = 0; $j < count($dataLoaiNV); $j++) {
                        // nối cái mã của nhân viên với bảng nó tham chiếu 
                        echo "<option ";
                        if ($data[0][7] == $dataLoaiNV[$j][0])
                            echo " selected";
                        echo " >";
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
        <div class="form-group row" <?php if ($oke == false) echo 'hidden' ?>>
            <div class="col-sm-5 col-form-label font-weight-bold">
                <label for="theLoai">Mã phòng ban:</label>
            </div>
            <div class="col-sm-7">
                <select class="form-control" id="phongBan" name="phongBan" form="form1">
                    <?php
                    for ($j = 0; $j < count($dataPhongBan); $j++) {
                        // nối cái mã của nhân viên với bảng nó tham chiếu 
                        echo "<option ";
                        if ($data[0][8] == $dataPhongBan[$j][0])
                            echo " selected";
                        echo " >";
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
        <div class="form-group row " <?php if ($oke == false) echo 'hidden' ?>>
            <div class="col-sm-12">
                <button type="submit" class="btn " form="form1" style="background-color:pink;" onclick="alert('Đã thực hiện thao tác xong')">Sửa</button>
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