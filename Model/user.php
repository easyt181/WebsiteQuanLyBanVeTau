<?php
class User
{
    public $matk;
    public $hoten;
    public $sdt;
    public $email;
    public $diachi;
    public $ngaysinh;
    public $gioitinh;
    public function __construct($matk, $hoten,$gioitinh,$ngaysinh, $sdt, $email,$diachi)
    {
        $this->matk = $matk;
        $this->hoten = $hoten;
        $this->gioitinh = $gioitinh;
        $this->ngaysinh = $ngaysinh;
        $this->sdt = $sdt;
        $this->email = $email;
        $this->diachi = $diachi;

    }

    //Thêm khách hàng
    public static function addKH(User $khach)
    {
        $conn = DBConnection::Connect();
        $stmt = $conn->prepare("INSERT INTO khachhang(KH_MaTaiKhoan,KH_Ten,KH_SDT,KH_Email) VALUES(?,?,?,?);");
        $stmt->bind_param("isss", $khach->matk, $khach->hoten, $khach->sdt, $khach->email);
        $stmt->execute();
        return true;
    }
    
    //Kiểm tra email và sđt trước khi thêm
    public static function checkUser($sdt, $email)
    {
        $conn = DBConnection::Connect();
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM khachhang WHERE KH_SDT =? OR KH_Email =?;");
        $stmt->bind_param("ss", $sdt, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $count = $row['count'];
            return $count;
        } else {
            return 0;
        }
    }
    public static function updateInfo(User $user){
        try{
            $conn = DBConnection::Connect();
            $stmt = $conn->prepare("UPDATE khachhang SET KH_Ten=?,KH_GioiTinh=?,KH_NgaySinh=?,KH_SDT=?,KH_Email=?,KH_DiaChi=? WHERE KH_MaTaiKhoan = ?;");
            $stmt->bind_param("ssssssi", $user->hoten,$user->gioitinh,$user->ngaysinh,$user->sdt,$user->email,$user->diachi,$user->matk);
            $stmt->execute();
            return true;
        }catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    
    public static function getUserInfo($userid){
        try{
            $conn = DBConnection::Connect();
            $stmt = $conn->prepare("SELECT * FROM khachhang INNER JOIN taikhoan ON taikhoan.TK_MaTaiKhoan = khachhang.KH_MaTaiKhoan WHERE taikhoan.TK_MaTaiKhoan = ?;");
            $stmt->bind_param("i", $userid);
            $stmt->execute();
            $result = $stmt->get_result();
            $kq = $result->fetch_all(MYSQLI_ASSOC);
            return $kq;
        }catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    


}
