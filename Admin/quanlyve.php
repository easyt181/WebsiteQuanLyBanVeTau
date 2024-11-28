<?php
if (!(isset($_SESSION['role']) && ($_SESSION['role'] == "admin" || $_SESSION['role'] == "nhanvien"))) {
    header('location: ../index.php');
}
else {

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Đường sắt Việt Nam</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="../javascript/quanlyve.js"></script>
    </head>

    <body style="background-color:F0ECE5;">
        <div class="container" style="margin-top:150px;">
            <div class="row title mb-3" style="margin: 50px 0 0 0; width:100%;">
                <div class="col-4">
                    <hr>
                </div>
                <div class="col-4">
                    <h2 style="text-align: center;">QUẢN LÝ VÉ TÀU</h2>
                </div>
                <div class="col-4">
                    <hr>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4">
                    <form method="post">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" id="searchInput" placeholder="Nhập từ khóa">
                            <input type="submit" class="btn btn-primary" name="search" value="Tìm kiếm">
                        </div>
                    </form>
                </div>

                <div class="col-4">
                    <button style="float:right;" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        Các chuyến tàu
                    </button>
                    <form class="dropdown-menu p-4" style="width:600px;height:350px">
                        <table class="table table-bordered" style="border:2px outset black;">
                            <thead>
                                <tr style="text-align:center;">
                                    <th>Mã chuyến tàu</th>
                                    <th>Mã tàu</th>
                                    <th>Mã lịch trình</th>
                                    <th>Điểm khởi hành</th>
                                    <th>Điểm kết thúc</th>
                                    <th>Số vé đã đặt</th>
                                    <th>Ngày khởi hành</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $listChuyentau = Train::getDSChuyenTau();
                                foreach ($listChuyentau as $ve) : ?>
                                    <tr>
                                        <td><?php echo $ve['CT_Ma']; ?></td>
                                        <td><?php echo $ve['CT_MaTau']; ?></td>
                                        <td><?php echo $ve['CT_MaLichTrinh'] ?></td>
                                        <td><?php echo $ve['CT_DiemKhoiHanh'] ?></td>
                                        <td><?php echo $ve['CT_DiemKetThuc'] ?></td>
                                        <td><?php echo $ve['TongVeDaDat'] ?></td>
                                        <td><?php echo $ve['CT_NgayKhoiHanh'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="col-4">
                    <button style="float: right;" type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        Thêm vé
                    </button>
                    <form id="themve" action="indexadmin.php?act=themve" method="post" class="dropdown-menu p-4" style="width:600px;height:350px">
                        <div class="row mb-3">
                            <div class="col-5">
                                <label for="" class="form-label">Mã chuyến tàu:</label>
                                <select type="text" id="machuyentau" class="form-select" name="machuyentau">
                                    <option selected>...</option>
                                    <?php
                                    $listChuyentau = Train::getDSChuyenTau();
                                    foreach ($listChuyentau as $ct) :
                                        echo '<option value="' . $ct['CT_Ma'] . '">' . $ct['CT_Ma'] . '('.$ct['CT_MaTau'].')</option>';
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <div class="col-5">
                                <label for="" class="form-label">Mã khoang:</label>
                                <select type="text" id="makhoang" name="makhoang" class="form-select">
                                <option selected>...</option>
                                </select>
                            </div>
        
                            <div class="col-2">
                                <label for="" class="form-label">Ghế số:</label>
                                <input type="text" name="gheso" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="" class="form-label">Điểm đi:</label>
                                <select type="text" class="form-select" name="diemdi">
                                   
                                    <option selected>...</option>
                                    <option>Hà Nội</option>
                                    <option>Nam Định</option>
                                    <option>Thanh Hóa</option>
                                    <option>Vinh</option>
                                    <option>Đồng Hới</option>
                                    <option>Huế</option>
                                    <option>Đà Nẵng</option>
                                    <option>Nha Trang</option>
                                    <option>Long Khánh</option>
                                    <option>Sài Gòn</option>
                                    
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label">Điểm đến:</label>
                                <select type="text" class="form-select" name="diemden">
                                    <option selected>...</option>
                                    <option>Hà Nội</option>
                                    <option>Nam Định</option>
                                    <option>Thanh Hóa</option>
                                    <option>Vinh</option>
                                    <option>Đồng Hới</option>
                                    <option>Huế</option>
                                    <option>Đà Nẵng</option>
                                    <option>Nha Trang</option>
                                    <option>Long Khánh</option>
                                    <option>Sài Gòn</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label">Ngày đặt:</label>
                                <input type="datetime-local" class="form-control" name="ngaydatve">
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="" class="form-label">Ngày khởi hành:</label>
                                <input type="datetime-local" class="form-control" name="ngaykhoihanh">
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label">Chi phí phát sinh:</label>
                                <input type="text" class="form-control" name="giave" placeholder="Nếu có">
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label">Trạng thái:</label>
                                <select type="text" class="form-select" name="trangthai">
                                    <option selected>...</option>
                                    <option>Đã thanh toán</option>
                                    <option>Đang chờ thanh toán</option>
                                    <option>Đã hủy</option>
                                </select>
                            </div>

                        </div>
                        <input style="float:right;" type="submit" name="them" class="btn btn-success btn-lg" value="Thêm">
                    </form>
                </div>
            </div>
            <div class="mb-3">
                <h5>DANH SÁCH VÉ TÀU</h5>
                <table class="table table-bordered" style="border:2px outset black;">
                    <thead>
                        <tr style="text-align:center;">
                            <th>Mã vé tàu</th>
                            <th>Mã chuyến tàu</th>
                            <th>Mã khoang</th>
                            <th>Mã khách hàng</th>
                            <th>Mã nhân viên</th>
                            <th style="width:120px;">Điểm đi</th>
                            <th style="width:120px;">Điểm đến</th>
                            <th style="width:40px;">Ghế số</th>
                            <th style="width:100px;">Ngày đặt</th>
                            <th style="width:100px;">Ngày khởi hành</th>
                            <th style="width:100px;">Giá vé</th>
                            <th style="width:100px;">Trạng thái</th>
                            <th style="width:130px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if (isset($_POST['search']) && $_POST['search']) {
                            $keyword = $_POST['keyword'];
                            $listVe = Ticket::timkiemVe($keyword);
                        } else {
                            $listVe = Ticket::getDSVe();
                        }
                        if (!empty($listVe)) {
                            foreach ($listVe as $ve) : ?>
                                <tr>
                                    <td><?php echo $ve['VT_MaVeTau']; ?></td>
                                    <td><?php echo $ve['VT_MaChuyenTau']; ?></td>
                                    <td><?php echo $ve['VT_MaKhoang'] ?></td>
                                    <td><?php echo $ve['VT_MaKH'] ?></td>
                                    <td><?php echo $ve['VT_MaNV'] ?></td>
                                    <td><?php echo $ve['VT_DiemDi'] ?></td>
                                    <td><?php echo $ve['VT_DiemDen'] ?></td>
                                    <td><?php echo $ve['VT_GheSo'] ?></td>
                                    <td><?php echo $ve['VT_NgayDat'] ?></td>
                                    <td><?php echo $ve['VT_NgayKhoiHanh'] ?></td>
                                    <td><?php echo $ve['VT_Gia'] ?></td>
                                    <td><?php echo $ve['VT_TrangThai'] ?></td>
                                    <td>
                                        <div class="dropdown" style="float:left; margin-right:5px;">
                                            <button type="button" class="btn btn-success" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                                Sửa
                                            </button>
                                            <form id="suave" action="indexadmin.php?act=suave" method="post" class="dropdown-menu p-4" style="width:600px;height:350px">
                                                <div class="row mb-3">
                                                    <div class="col-3">
                                                        <label for="" class="form-label">Mã vé tàu:</label>
                                                        <input type="text" name="mavetau" class="form-control" readonly value="<?php echo $ve['VT_MaVeTau']; ?>">
                                                    </div>
                                                    <div class="col-3">
                                <label for="" class="form-label">Mã chuyến tàu:</label>
                                <select type="text" id="machuyentau" class="form-select" name="machuyentau">
                                    
                                    <?php
                                    $listChuyentau = Train::getDSChuyenTau();
                                    foreach ($listChuyentau as $ct) :
                                        echo '<option value="' . $ct['CT_Ma'] . '">' . $ct['CT_Ma'] . '('.$ct['CT_MaTau'].')</option>';
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="" class="form-label">Mã khoang:</label>
                                <select type="text" id="makhoang2" name="makhoang" class="form-select">
                                <option selected>...</option>
                                </select>
                            </div>
                                                    <div class="col-3">
                                                        <label for="" class="form-label">Mã khách hàng:</label>
                                                        <input type="text" name="makhachhang" class="form-control" value="<?php echo $ve['VT_MaKH']; ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-3">
                                                        <label for="" class="form-label">Mã nhân viên:</label>
                                                        <input type="text" name="manhanvien" class="form-control" value="<?php echo $ve['VT_MaNV']; ?>">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="" class="form-label">Điểm đi:</label>
                                                        <select type="text" class="form-select" name="diemdi">
                                                            <option selected><?php echo $ve['VT_DiemDi']; ?></option>
                                                            <option>Hà Nội</option>
                                                            <option>Nam Định</option>
                                                            <option>Thanh Hóa</option>
                                                            <option>Vinh</option>
                                                            <option>Đồng Hới</option>
                                                            <option>Huế</option>
                                                            <option>Đà Nẵng</option>
                                                            <option>Nha Trang</option>
                                                            <option>Long Khánh</option>
                                                            <option>Sài Gòn</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="" class="form-label">Điểm đến:</label>
                                                        <select type="text" class="form-select" name="diemden">
                                                            <option selected><?php echo $ve['VT_DiemDen']; ?></option>
                                                            <option>Hà Nội</option>
                                                            <option>Nam Định</option>
                                                            <option>Thanh Hóa</option>
                                                            <option>Vinh</option>
                                                            <option>Đồng Hới</option>
                                                            <option>Huế</option>
                                                            <option>Đà Nẵng</option>
                                                            <option>Nha Trang</option>
                                                            <option>Long Khánh</option>
                                                            <option>Sài Gòn</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="" class="form-label">Ngày đặt:</label>
                                                        <input type="datetime-local" class="form-control" name="ngaydatve" value="<?php echo $ve['VT_NgayDat']; ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-3">
                                                        <label for="" class="form-label">Ngày khởi hành:</label>
                                                        <input type="datetime-local" class="form-control" name="ngaykhoihanh" value="<?php echo $ve['VT_NgayKhoiHanh']; ?>">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="" class="form-label">Ghế số:</label>
                                                        <input type="text" name="gheso" class="form-control" value="<?php echo $ve['VT_GheSo']; ?>">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="" class="form-label">Giá vé:</label>
                                                        <input type="text" class="form-control" name="giave" value="<?php echo $ve['VT_Gia']; ?>">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="" class="form-label">Trạng thái:</label>
                                                        <select type="text" class="form-select" name="trangthai" value="<?php echo $ve['VT_TrangThai']; ?>">
                                                            <option selected><?php echo $ve['VT_TrangThai']; ?></option>
                                                            <option>Đã thanh toán</option>
                                                            <option>Đang chờ thanh toán</option>
                                                            <option>Đã hủy</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <button type="submit" style="float:right;" name="sua" class="btn btn-success btn-lg" value="1">Sửa</button>
                                            </form>
                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-Danger" onclick="confirmDelete(<?php echo $ve['VT_MaVeTau']; ?>)">Xóa</a>
                                        </div>
                                    </td>


                                </tr>
                        <?php endforeach;
                        } else {
                            // Hiển thị thông báo khi không có kết quả tìm kiếm
                            echo '<tr><td colspan="13" style="text-align: center;">Không có kết quả tìm kiếm.</td></tr>';
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </body>
    </html>
<?php
}

?>