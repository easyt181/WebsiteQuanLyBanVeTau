<?php
class Account
{
    // Lấy tên thông tin đối tượng
    public static function getuserinfo($user, $pass)
    {
        $conn = DBConnection::Connect();
        $stmt = $conn->prepare("SELECT * FROM taikhoan WHERE TK_TenDangNhap=? AND TK_MatKhau=?");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();
        $kq = $result->fetch_all(MYSQLI_ASSOC);
        return $kq;
    }

    //Thêm tài khoản
    public static function addAccount($user, $pass, $phanquyen)
    {
        $conn = DBConnection::Connect();
        $stmt = $conn->prepare("INSERT INTO taiKhoan(TK_TenDangNhap,TK_MatKhau,TK_PhanQuyen) VALUES(?,?,?);");
        $stmt->bind_param("sss", $user, $pass, $phanquyen);
        $stmt->execute();
        $id = $conn->insert_id;
        return $id;
    }


    //Kiểm tra tên đăng nhập trước khi thêm
    public static function checkAccount($user)
    {
        $conn = DBConnection::Connect();
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM taikhoan WHERE TK_TenDangNhap =?;");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $count = $row['count'];
            return $count;
        } else {
            return 0;
        }
    }

    public static function doiMatKhau($user, $newpass)
    {
        try {
            $conn = DBConnection::Connect();
            $stmt = $conn->prepare("UPDATE taikhoan SET TK_MatKhau=? WHERE TK_TenDangNhap=?;");
            $stmt->bind_param("ss", $newpass, $user);
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }

    public static function checkMatKhau($user)
    {
        try {
            $conn = DBConnection::Connect();
            $stmt = $conn->prepare("SELECT TK_MatKhau FROM taikhoan WHERE TK_TenDangNhap=?;");
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['TK_MatKhau'];
            } else {
                // Tên đăng nhập không tồn tại
                return null;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
}
