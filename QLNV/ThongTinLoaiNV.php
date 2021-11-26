<!doctype html>
<html lang="vi-VN">

<head>
    <title>Thôn Tin Loại Nhân Viên</title>
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
    <!-- khối xử lý php  -->
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
    $sql = "SELECT * FROM loainv";
    // kết quả của truy vấn 
    $result = mysqli_query($conn, $sql);
    // biến số hàng trả về, số thuộc tính có trong bảng
    $numRows = mysqli_num_rows($result);
    $numFields = mysqli_num_fields($result);
    // dữ liệu truy vấn được lấy ra bỏ vô 1 mảng để tiện thao tác, khỏi truy vấn sql mệt 
    $data = createData($result, $numRows);



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
    // in tất cả dữ liệu 
    function printDataAll($result, $numRows, $numFields)
    {
        $arrayData = array();
        // check xem truy vấn có trả về kết quả được không 
        if ($numRows > 0) {
            // nếu truy vấn có kết quả: khối lệnh cần xử lý
            for ($i = 1; $i <= $numRows; $i++) {
                $arrayData = mysqli_fetch_row($result);
                echo "<tr>";
                // in ra  tr
                for ($j = 0; $j < $numFields; $j++)
                    // in ra ảnh của nv, 6 là vị trí cột của ảnh
                    if ($j == 6)
                        echo "<td class='align-middle'> <img src='image/$arrayData[$j]' alt='Ảnh NV'> </td>";
                    else
                        echo "<td class='align-middle'>" . $arrayData[$j] . "</td>";
                echo "</tr>";
            }
        }
        // báo truy vấn không trả về kết quả 
        else {
            echo "<td>Không tìm thấy kết quả nào</td>";
        }
    }
    // in dữ liệu theo trang 
    function printDataPage($data, $pageRecent, $numRowPerPage)
    {
        // số dòng, số cột thuộc tính
        $numRows = count($data);
        if ($numRows > 0) {
            $numFields = count($data[0]);

            if ($numRowPerPage < 1)
                $numRowPerPage = 2;

            $index = ($pageRecent - 1) * $numRowPerPage;
            for ($i = 1; $i <= $numRowPerPage; $i++) {
                echo "<tr>";
                for ($j = 0; $j < $numFields; $j++) {
                    echo "<td class='align-middle'>" . $data[$index][$j] . "</td>";
                }
                // mã nó khó in nên làm vậy
                $maLoaiNV = $data[$index][0];
                echo "<td class='align-middle'>";
                echo "<a href='SuaLoaiNV.php?maLoaiNV=$maLoaiNV' alt='Sửa LOẠI NV'><button class='btn' style='background-color: pink;'>Sửa</button> </a>";
                echo  "</td>";
                echo "<td class='align-middle'>";
                echo "<a href='XoaLoaiNV.php?maLoaiNV=$maLoaiNV' alt='Xóa LOẠI NV'><button class='btn' style='background-color: pink;'>Xóa</button> </a>";
                echo  "</td>";
                // nếu số lượng dòng không đủ 1 trang 
                if ($index + 1 == $numRows)
                    break;
                $index++;
                echo "</tr>";
            }
        } else
            echo "<tr> <td  colspan='10'>Không có dữ liệu</td> </tr>";
    }
    // module phân trang (tự xây) 

    $numRowPerPage = 2;
    // làm tròn vì có những trang không đủ row mong muốn 
    $numPages =  ceil($numRows / $numRowPerPage);
    $numPagesView = 5;
    $pageRecent = 1;
    $pageName = $_SERVER['PHP_SELF'];
    //nhận kết quả truy vấn trang
    if (!empty($_GET['pageRecent']))
        $pageRecent = $_GET['pageRecent'];
    if ($pageRecent > $numPages)
        $pageRecent = $numPages;
    if ($pageRecent < 1)
        $pageRecent = 1;


    // hàm này trả về các trang trước sau của trang hiện tại 
    function aroundPage($pageRecent, $numPages, $numPagesView, $pageName)
    {

        if ($numPagesView % 2 == 0) {
            $dlPhai = $numPagesView / 2;
            $dlTrai = $dlPhai - 1;
        }
        if ($numPagesView % 2 != 0) {
            $dlPhai = ($numPagesView - 1) / 2;
            $dlTrai = $dlPhai;
        }
        // trang đầu
        echo " <li class='page-item'> ";
        echo " <a class='page-link' ";
        echo " href='$pageName?pageRecent=1' ";
        echo  "style='background-color: pink;'>";
        echo "Start</a></li>";
        // phía trái page recent
        for ($i = $dlTrai; $i >= 1; $i--) {
            $pageTemp = $pageRecent - $i;
            if ($pageTemp >= 1) {
                echo  " <li class='page-item'> ";
                echo  " <a class='page-link' ";
                echo  " href='$pageName?pageRecent=$pageTemp' ";
                echo " style='background-color: pink;'> ";
                echo $pageTemp;
                echo "</a></li>";
            }
        }
        // trang hiện tại
        echo  " <li class='page-item'> ";
        echo  " <a class='page-link' ";
        echo  " href='$pageName?pageRecent=$pageRecent' ";
        echo " style='background-color: #f984ef;'> ";
        echo $pageRecent;
        echo "</a></li>";
        // phía sau page recent
        for ($i = 1; $i <= $dlPhai; $i++) {
            $pageTemp = $pageRecent + $i;
            if ($pageTemp <= $numPages) {
                echo  " <li class='page-item'> ";
                echo  " <a class='page-link' ";
                echo  " href='$pageName?pageRecent=$pageTemp' ";
                echo " style='background-color: pink;'> ";
                echo $pageTemp;
                echo "</a></li>";
            }
        }
        // trang cuối
        echo " <li class='page-item'> ";
        echo " <a class='page-link' ";
        echo " href='$pageName?pageRecent=$numPages' ";
        echo  "style='background-color: pink;'>";
        echo "End</a></li>";

        //số lượng 
        echo "<li class='page-item'>";
        echo "<span class='page-link' ";
        echo "style='background-color: pink;'>";
        // chú ý numpage có thể làm thay đổi giá trị
        if ($numPages == 0) $numPages++;
        echo "Số lượng trang: $numPages</span> </li>";
        $numPages--;
    }


    // đóng kết nối csdl, nên có, đừng quên đóng 
    mysqli_close($conn);
    ?>
    <!-- khối html giao diện  -->
    <!-- header -->
    <?php include 'header.html'; ?>
    <!-- table  -->
    <div class="container container-sm">
        <table class="table table-striped text-center table-bordered table-hover">
            <!-- đặc biệt -->
            <thead>
                <tr>
                    <th colspan="9" style="color:red" class='align-middle'>
                        <h4>BẢNG THÔNG TIN LOẠI NHÂN VIÊN</h4>
                    </th>
                </tr>
                <tr>
                    <th class='align-middle'>Mã loại nhân viên</th>
                    <th class='align-middle'>Tên loại nhân viên</th>
                    <th class='align-middle' colspan="2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php printDataPage($data, $pageRecent, $numRowPerPage) ?>
            </tbody>
        </table>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php aroundPage($pageRecent, $numPages, $numPagesView, $pageName) ?>
        </ul>

    </nav>




    <!-- footer -->
    <?php include 'footer.html'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script> -->
</body>

</html>