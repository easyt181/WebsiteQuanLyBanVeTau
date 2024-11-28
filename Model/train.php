<?php 
Class Train{
    public $machuyentau;
    public $matau;
    public $malichtrinh;
    public $diemkhoihanh;
    public $diemketthuc;
    public $sovedadat;
    public $ngaykhoihanh;

    public function __construct($machuyentau=null,$matau,$malichtrinh,$diemkhoihanh,$diemketthuc,$sovedadat,$ngaykhoihanh){
        $this->machuyentau = $machuyentau;
        $this->matau = $matau;
        $this->malichtrinh = $malichtrinh;
        $this->diemkhoihanh = $diemkhoihanh;
        $this->diemketthuc = $diemketthuc;
        $this->sovedadat = $sovedadat;
        $this->ngaykhoihanh = $ngaykhoihanh;
    }


    // Thêm chuyến tàu
    public static function addChuyenTau(Train $train){
        try{
            $conn = DBConnection::Connect();
            $sql = "INSERT INTO chuyentau(CT_MaTau,CT_MaLichTrinh,CT_DiemKhoiHanh,CT_DiemKetThuc,CT_SoVeDaDat,CT_NgayKhoiHanh)
            VALUES (?,?,?,?,'0',?);";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sisss",$train->matau,$train->malichtrinh,$train->diemkhoihanh,$train->diemketthuc,$train->ngaykhoihanh);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            return true;
        }
        catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }


    // Sửa chuyến tàu
    public static function updateChuyenTau(Train $train){
        try{
            $conn = DBConnection::Connect();
            $sql = "UPDATE chuyentau
            SET CT_MaTau=?,CT_MaLichTrinh=?,CT_DiemKhoiHanh=?,CT_DiemKetThuc=?, CT_SoVeDaDat =? , CT_NgayKhoiHanh=?
            WHERE CT_Ma =?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sissisi",$train->matau,$train->malichtrinh,$train->diemkhoihanh,$train->diemketthuc,$train->sovedadat,$train->ngaykhoihanh,$train->machuyentau);
            $stmt->execute();
            return true;
        }
        catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public static function updateSVDD($sovedadat,$machuyentau){
        try{
            $conn = DBConnection::Connect();
            $stmt = $conn->prepare("UPDATE chuyentau SET CT_SoVeDaDat = ? WHERE CT_Ma = ?");
            $stmt->bind_param("ii", $sovedadat,$machuyentau);
            $stmt->execute();
            return true;
        }catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    // Xóa chuyến tàu
    public static function removeChuyenTau($machuyentau){
        try {
            $conn = DBConnection::Connect();
            $sql = "DELETE FROM chuyentau WHERE CT_Ma=?";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("i", $machuyentau);
            $stmt->execute(); 
            $stmt->close();    
            $conn->close();   
            return true;
        } 
        catch(mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }

    // In danh sách chuyến tàu
    public static function getDSChuyenTau() {
        $conn = DBConnection::Connect();
        $sql = "SELECT chuyentau.*, COUNT(vetau.VT_MaChuyenTau) AS TongVeDaDat FROM chuyentau LEFT JOIN
        vetau ON chuyentau.CT_Ma = vetau.VT_MaChuyenTau
        GROUP BY
        chuyentau.CT_Ma;";       
        $result = $conn->query($sql);
        $listChuyentau = array();
        while ($row = $result->fetch_assoc()) {
            $listChuyentau[] = $row;
        }
        return $listChuyentau;
    }


    //Tìm kiếm chuyến tàu
    public static function searchChuyenTau($keyword){
        try {
            $conn = DBConnection::Connect();
            $keyword = "%$keyword%";
            $sql = "SELECT * FROM chuyentau WHERE 
                CT_Ma LIKE ? OR
                CT_MaTau LIKE ? OR 
                CT_MaLichTrinh LIKE ? OR 
                CT_DiemKhoiHanh LIKE ? OR
                CT_DiemKetThuc LIKE ? OR
                CT_SoVeDaDat LIKE ? OR
                CT_NgayKhoiHanh LIKE ? 
                ;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss",$keyword,$keyword,$keyword,$keyword,$keyword,$keyword,$keyword,);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $listChuyentau = array();
            while ($row = $result->fetch_assoc()) {
                $listChuyentau[] = $row;
            }
            $stmt->close();
            $conn->close();
            return $listChuyentau;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }

    //Lấy danh sách khoang
    public static function getDSKhoang($machuyentau){
        try{
        $conn = DBConnection::Connect();
        $dsKhoang = array();
        $stmt = $conn->prepare("SELECT khoangtau.KHOANG_Ma,khoangtau.KHOANG_LoaiKhoang FROM chuyentau 
        INNER JOIN khoangtau ON khoangtau.KHOANG_MaTau = chuyentau.CT_MaTau 
        WHERE chuyentau.CT_Ma = ?");
        $stmt->bind_param("i",$machuyentau);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $dsKhoang[] = $row;
        }
        return $dsKhoang;
        }catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }






}
?>