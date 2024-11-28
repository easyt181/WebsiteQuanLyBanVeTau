<?php
    include "../Model/dbconnection.php";
    include "../Model/ticket.php";

    ini_set('display_errors', 1);
    mb_internal_encoding("UTF-8");

    $conn = DBConnection::Connect();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['them'])) {
        if ($_POST['them'] === 'them') {
            $makhoang = $_POST['makhoang'];
            $username = $_POST['makhachhang'];
            $diemdi = $_POST['diemdi'];
            $diemden = $_POST['diemden'];
            $gheso = $_POST['gheso'];
            $ngaydat = $_POST['ngaydatve'];
            $ngaykhoihanh = $_POST['ngaykhoihanh'];
            $giave = $_POST['gia'];
            $trangthai = 'Đã thanh toán';
            $diemdi_ = ticket::tinhKhoangCach($diemdi);
            $diemden_ = ticket::tinhKhoangCach($diemden);
            $culy = $diemdi_ - $diemden_;
            // intval
                $machuyentau = 1;
            $sql_ = "SELECT TK_MaTaiKhoan FROM taikhoan WHERE TK_TenDangNhap = ?";
            $stmt_ = $conn->prepare($sql_);
            $stmt_->bind_param('s', $username);
            $stmt_->execute();
            $rl_ = $stmt_->get_result();
            $makhachhang = $rl_->fetch_assoc();
            $ngaydat_ = DateTime::createFromFormat('d/m/Y H:i', $ngaydat);
            $ngaydat_db = $ngaydat_->format('Y-m-d H:i');
            $ngaykhoihanh_ = DateTime::createFromFormat('d/m/Y H:i', $ngaykhoihanh);
            $ngaykhoihanh_db = $ngaykhoihanh_->format('Y-m-d H:i');
            $i = 0;
            try {
                $stmt = $conn->prepare("INSERT INTO vetau(VT_MaChuyenTau, VT_MaKhoang, VT_MaKH, VT_DiemDi, VT_DiemDen, VT_Gheso, VT_NgayDat , VT_NgayKhoiHanh, VT_Gia, VT_TrangThai)VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
                while($i < sizeof($gheso)){
                    $stmt->bind_param("iiississds", $machuyentau, $makhoang, $makhachhang, $diemdi, $diemden, $gheso[$i], $ngaydat_db, $ngaykhoihanh_db, $giave[$i], $trangthai);
                    $stmt->execute();
                    $i++;
                }
                    $stmt_->close();
                    $stmt->close();
                    $conn->close();
                    echo 'true';
            } catch (mysqli_sql_exception $e) {
                echo $e->getMessage();
            }
        } else {
            echo 'false';
        }
    } else {
        echo 'false';
    }
?>
