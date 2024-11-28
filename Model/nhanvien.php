<?php
class Nhanvien
{
    public $manhanvien;
    public $mataikhoan;
    public $ten;
    public $gioitinh;
    public $sdt;
    public $diachi;
    public $chucvu;
    public $luong;
    public function __construct($manhanvien = null, $mataikhoan, $ten, $gioitinh, $sdt, $diachi, $chucvu, $luong)
    {
        $this->manhanvien = $manhanvien;
        $this->mataikhoan = $mataikhoan;
        $this->ten = $ten;
        $this->gioitinh = $gioitinh;
        $this->sdt = $sdt;
        $this->diachi = $diachi;
        $this->chucvu = $chucvu;
        $this->luong = $luong;
    }

    public static function getNhanVienID($idnhanvien)
    {
        $conn = DBConnection::Connect();
        $stmt = $conn->prepare("SELECT NV_Ma FROM nhanvien WHERE NV_MaTaiKhoan = ?");
        $stmt->bind_param("i", $idnhanvien);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    public static function getNhanVienInfo($iduser)
    {
        try {
            $conn = DBConnection::Connect();
            $stmt = $conn->prepare("SELECT * FROM nhanvien INNER JOIN taikhoan ON taikhoan.TK_MaTaiKhoan = nhanvien.NV_MaTaiKhoan WHERE taikhoan.TK_MaTaiKhoan = ?;");
            $stmt->bind_param("i", $iduser);
            $stmt->execute();
            $result = $stmt->get_result();
            $kq = $result->fetch_all(MYSQLI_ASSOC);
            return $kq;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }

    // In danh sách nhân viên
    public static function getDSNhanVien()
    {
        $conn = DBConnection::Connect();
        $sql = "SELECT nhanvien.*, taikhoan.*, COUNT(nhanvien.NV_Ma) AS TongNhanVien FROM nhanvien INNER JOIN
        taikhoan ON taikhoan.TK_MaTaiKhoan = nhanvien.NV_MaTaiKhoan
        GROUP BY
        nhanvien.NV_Ma;";
        $result = $conn->query($sql);
        $listNhanvien = array();
        while ($row = $result->fetch_assoc()) {
            $listNhanvien[] = $row;
        }
        return $listNhanvien;
    }


    //Tìm kiếm nhân viên
    public static function searchNhanVien($keyword)
    {
        try {
            $conn = DBConnection::Connect();
            $keyword = "%$keyword%";
            $sql = "SELECT nhanvien.*, taikhoan.*
            FROM nhanvien 
            INNER JOIN taikhoan ON taikhoan.TK_MaTaiKhoan = nhanvien.NV_MaTaiKhoan
            WHERE
                NV_Ma LIKE ? OR
                TK_PhanQuyen LIKE ? OR 
                NV_Ten LIKE ? OR 
                NV_GioiTinh LIKE ? OR
                NV_SDT LIKE ? OR
                NV_DiaChi LIKE ? OR
                NV_ChucVu LIKE ? OR
                NV_LuongThang LIKE ? 
                ;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssss", $keyword, $keyword, $keyword, $keyword, $keyword, $keyword, $keyword, $keyword);
            $stmt->execute();

            $result = $stmt->get_result();
            $listNhanvien = array();
            while ($row = $result->fetch_assoc()) {
                $listNhanvien[] = $row;
            }
            $stmt->close();
            $conn->close();
            return $listNhanvien;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }

    // Thêm nhân viên
    public static function addNhanvien(Nhanvien $nhanvien)
    {
        try {
            $conn = DBConnection::Connect();
            $sql = "INSERT INTO nhanvien(NV_Ma, NV_MaTaiKhoan, NV_Ten, NV_GioiTinh, NV_SDT, NV_DiaChi, NV_ChucVu, NV_LuongThang)
            VALUES (?,?,?,?,?,?,?,?);";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "iissssss",
                $nhanvien->manhanvien,
                $nhanvien->mataikhoan,
                $nhanvien->ten,
                $nhanvien->gioitinh,
                $nhanvien->sdt,
                $nhanvien->diachi,
                $nhanvien->chucvu,
                $nhanvien->luong
            );
            $stmt->execute();
            $stmt->close();
            $conn->close();
            return true;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }

    // Sửa chuyến tàu
    public static function updateNhanVien(Nhanvien $nhanvien)
    {
        try {
            $conn = DBConnection::Connect();
            $sql = "UPDATE nhanvien
            SET NV_Ma=?, NV_MaTaiKhoan=?, NV_Ten=?, NV_GioiTinh=?, NV_SDT=?,
            NV_DiaChi=?, NV_ChucVu=?, NV_LuongThang=?
            WHERE NV_Ma=?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "iissssssi",
                $nhanvien->manhanvien,
                $nhanvien->mataikhoan,
                $nhanvien->ten,
                $nhanvien->gioitinh,
                $nhanvien->sdt,
                $nhanvien->diachi,
                $nhanvien->chucvu,
                $nhanvien->luong,
                $nhanvien->manhanvien
            );
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }

    // Xóa nhân viên
    public static function removeNhanVien($manhanvien)
    {
        try {
            $conn = DBConnection::Connect();
            $sql = "DELETE FROM nhanvien WHERE NV_Ma =?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $manhanvien);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            return true;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
}
