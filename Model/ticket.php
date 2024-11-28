<?php 
Class Ticket{
    public $mave;
    public $machuyentau;
    public $makhoang;
    public $makhachhang;
    public $manhanvien;
    public $diemdi;
    public $diemden;
    public $gheso;
    public $ngaydat;
    public $ngaykhoihanh;
    public $giave;
    public $trangthai;

    public function __construct($mave=null,$machuyentau,$makhoang, $makhachhang=null, $manhanvien, $diemdi,$diemden,$gheso,$ngaydat,$ngaykhoihanh,$giave,$trangthai){
        $this->mave = $mave;
        $this->machuyentau = $machuyentau ;
        $this->makhoang = $makhoang ;
        $this->makhachhang = $makhachhang ;
        $this->manhanvien = $manhanvien;
        $this->diemdi = $diemdi;
        $this->diemden =$diemden ;
        $this->gheso = $gheso;
        $this->ngaydat = $ngaydat;
        $this->ngaykhoihanh = $ngaykhoihanh;
        $this->giave =$giave ;
        $this->trangthai =$trangthai ;
    }
    //Thêm vé
    public static function themVe(Ticket $ticket){
        try {
            $conn = DBConnection::Connect();
            $stmt = $conn->prepare("INSERT INTO vetau(VT_MaChuyenTau, VT_MaKhoang, VT_MaNV, VT_DiemDi, VT_DiemDen, VT_Gheso, VT_NgayDat, VT_NgayKhoiHanh, VT_Gia, VT_TrangThai)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
            $stmt->bind_param("iiississds", $ticket->machuyentau, $ticket->makhoang, $ticket->manhanvien, $ticket->diemdi, $ticket->diemden, $ticket->gheso, $ticket->ngaydat, $ticket->ngaykhoihanh, $ticket->giave, $ticket->trangthai);
            $stmt->execute();
            $stmt->close();    
            $conn->close();
            return true;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }

    public static function suaVe(Ticket $ticket){
        try{
            $conn = DBConnection::Connect();
            $stmt = $conn->prepare("UPDATE vetau
    SET 
        VT_MaVeTau = ?,
        VT_MaChuyenTau = ?,
        VT_MaKhoang = ?,
        VT_MaKH = ?,
        VT_MaNV = ?,
        VT_DiemDi = ?,
        VT_DiemDen = ?,
        VT_GheSo = ?,
        VT_NgayDat = ?,
        VT_NgayKhoiHanh = ?,
        VT_Gia = ?,
        VT_TrangThai = ?
    WHERE VT_MaVeTau = ?;");
            $stmt->bind_param("iiiiississdsi",$ticket->mave,$ticket->machuyentau, $ticket->makhoang,$ticket->makhachhang, $ticket->manhanvien, $ticket->diemdi, $ticket->diemden, $ticket->gheso, $ticket->ngaydat, $ticket->ngaykhoihanh, $ticket->giave, $ticket->trangthai,$ticket->mave);
            $stmt->execute();
            return true;
        }catch(mysqli_sql_exception $e){
            return $e->getMessage();
        }
    }
    // ***
    public static function tinhKhoangCach($ga){ 
        $conn = DBConnection::Connect();
        // Sửa câu lệnh SQL thành một câu lệnh với dấu UNION
        $sql = "SELECT GT_MaGaTau FROM gatau WHERE GT_Ten = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $ga);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $position = $row['GT_MaGaTau'];
        return $position;
    }
    // ***
    public static function tinhTienLoaiVe($makhoang){
        $conn = DBConnection::Connect();
        $sql = "SELECT KHOANG_LoaiKhoang FROM khoangtau WHERE KHOANG_Ma = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $makhoang);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Kiểm tra xem có dữ liệu hay không
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['KHOANG_LoaiKhoang'] != null) {
                if ($row['KHOANG_LoaiKhoang'] == "Ghế thường") {
                    $price = 50000.00;
                } else if ($row['KHOANG_LoaiKhoang'] == "Ghế nằm 4") {
                    $price = 150000.00;
                } else {
                    $price = 100000.00;
                }
            } else {
                $price = null;
            }
        } else {
           
            $price = null;
        }
    
        $stmt->close();
        $conn->close();
        return $price;
    }

    public static function getDSVe() {
        $conn = DBConnection::Connect();
        $sql = "SELECT * FROM vetau";
        $result = $conn->query($sql);
        $listVe = array();
        while ($row = $result->fetch_assoc()) {
            $listVe[] = $row;
        }
        return $listVe;
    }

    public static function xoaVe($mave){
        try {
            $conn = DBConnection::Connect();
            $sql = "DELETE FROM vetau WHERE VT_MaVeTau=?";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("i", $mave);
            $stmt->execute(); 
            $stmt->close();    
            $conn->close();   
            return true;
        } catch(mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }


    public static function timkiemVe($keyword){
        try {
            $conn = DBConnection::Connect();
            $keyword = "%$keyword%";
            $sql = "SELECT * FROM vetau WHERE 
                VT_MaVeTau LIKE ? OR
                VT_MaChuyenTau LIKE ? OR 
                VT_MaKhoang LIKE ? OR 
                VT_MaKH LIKE ? OR 
                VT_MaNV LIKE ? OR 
                VT_DiemDi LIKE ? OR 
                VT_DiemDen LIKE ? OR 
                VT_GheSo LIKE ? OR 
                VT_NgayDat LIKE ? OR 
                VT_NgayKhoiHanh LIKE ? OR 
                VT_Gia LIKE ? OR 
                VT_TrangThai LIKE ?
                ;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssss",$keyword,$keyword,$keyword,$keyword,$keyword,$keyword,$keyword,$keyword,$keyword,$keyword,$keyword,$keyword);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $listVe = array();
            while ($row = $result->fetch_assoc()) {
                $listVe[] = $row;
            }
            $stmt->close();
            $conn->close();
            return $listVe;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }



}
?>