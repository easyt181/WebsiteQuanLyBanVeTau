<?php 
Class Schedule{
public static function getLichTrinh(){
    $conn = DBConnection::Connect();
    $sql = "SELECT lichtrinh.LT_MaLichTrinh,lichtrinh.LT_TenLichTrinh,gatau.GT_Ten,
    chitietlichtrinh.ThoiGianDen,chitietlichtrinh.ThoiGianDi FROM lichtrinh 
    INNER JOIN chitietlichtrinh ON lichtrinh.LT_MaLichTrinh = chitietlichtrinh.LT_MaLichTrinh 
    LEFT JOIN gatau ON gatau.GT_MaGaTau = chitietlichtrinh.GT_MaGaTau;";
    $result = $conn->query($sql);
    $listLichtrinh = array();
    while ($row = $result->fetch_assoc()) {
        $listLichtrinh[] = $row;
    }
    return $listLichtrinh;
}
}

?>