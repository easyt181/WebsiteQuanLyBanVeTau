<?php
require_once '../Model/Train.php';
require_once '../Model/DBConnection.php';
if (isset($_POST['CT_Ma'])) {
    $ct_ma = $_POST['CT_Ma'];
    $dsKhoang = Train::getDSKhoang($ct_ma);
    foreach ($dsKhoang as $khoang) {
        echo '<option value="' . $khoang['KHOANG_Ma'] . '">' . $khoang['KHOANG_Ma'] . '('.$khoang['KHOANG_LoaiKhoang'].')</option>';
    }
}
?>