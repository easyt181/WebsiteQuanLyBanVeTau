<?php
if (!(isset($_SESSION['role']) && $_SESSION['role'] == "admin")) {
    header('location: ../index.php');
} else {
    $listVe = Ticket::getDSVe();

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Đường sắt Việt Nam</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="../css/adminhome.css">

        <script>
            function confirmDelete(mave) {
                Swal.fire({
                    title: "Bạn chắc chắn muốn xóa vé?",
                    text: "Hành động này không thể hoàn tác!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Xóa",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'indexadmin.php?act=xoave&mave=' + mave;
                    }
                });
            }


        </script>
    </head>

    <body>
        <div class="container" style="margin-top:150px;">
            <div class="row title" style="margin: 50px 0 0 0; width:100%;">
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
            <div class="row">
                <div class="dropdown mb-3"> 
                    <button style="float:right;" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        Thêm vé
                    </button>
                    <form action="indexadmin.php?act=themve" method="post" class="dropdown-menu p-4" style="width:600px;height:350px">
                        <div class="row mb-3">
                            <div class="col-3">
                                <label for="" class="form-label">Mã chuyến tàu:</label>
                                <input type="text" class="form-control" name="machuyentau">
                            </div>
                            <div class="col-3">
                                <label for="" class="form-label">Mã khoang:</label>
                                <input type="text" name="makhoang" class="form-control">
                            </div>
                            <div class="col-3">
                                <label for="" class="form-label">Mã nhân viên:</label>
                                <input type="text" name="manhanvien" class="form-control">
                            </div>
                            <div class="col-3">
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
                                <label for="" class="form-label">Giá vé:</label>
                                <input type="text" class="form-control" name="giave">
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
                <div class="mb-3">
                    <h5>DANH SÁCH VÉ TÀU</h4>
                        <table class="table table-bordered" style="border:2px outset black;">
                            <thead>
                                <tr style="text-align:center;">
                                    <th style="width:40px;">Mã vé tàu</th>
                                    <th style="width:40px;">Mã chuyến tàu</th>
                                    <th style="width:40px;">Mã khoang</th>
                                    <th style="width:40px;">Mã khách hàng</th>
                                    <th style="width:40px;">Mã nhân viên</th>
                                    <th>Điểm đi</th>
                                    <th>Điểm đến</th>
                                    <th style="width:40px;">Ghế số</th>
                                    <th style="width:100px;">Ngày đặt</th>
                                    <th style="width:100px;">Ngày khởi hành</th>
                                    <th style="width:100px;">Giá vé</th>
                                    <th style="width:100px;">Trạng thái</th>
                                    <th style="width:130px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listVe as $ve) : ?>
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
                                                <form action="indexadmin.php?act=suave" method="post" class="dropdown-menu p-4" style="width:600px;height:350px">
                                                    <div class="row mb-3">
                                                        <div class="col-3">
                                                            <label for="" class="form-label">Mã vé tàu:</label>
                                                            <input type="text" name="mavetau" class="form-control" readonly value="<?php echo $ve['VT_MaVeTau'];?>">
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="" class="form-label">Mã chuyến tàu:</label>
                                                            <input type="text" class="form-control" name="machuyentau" value="<?php echo $ve['VT_MaChuyenTau'];?>">
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="" class="form-label">Mã khoang:</label>
                                                            <input type="text" name="makhoang" class="form-control" value="<?php echo $ve['VT_MaKhoang'];?>">
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="" class="form-label">Mã khách hàng:</label>
                                                            <input type="text" name="makhachhang" class="form-control" value="<?php echo $ve['VT_MaKH'];?>">
                                                        </div>                            
                                                    </div>
                                                    <div class="row mb-3">
                                                    <div class="col-3">
                                                            <label for="" class="form-label">Mã nhân viên:</label>
                                                            <input type="text" name="manhanvien" class="form-control" value="<?php echo $ve['VT_MaNV'];?>">
                                                        </div> 
                                                        <div class="col-3">
                                                            <label for="" class="form-label">Điểm đi:</label>
                                                            <select type="text" class="form-select" name="diemdi">
                                                                <option selected><?php echo $ve['VT_DiemDi'];?></option>
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
                                                                <option selected><?php echo $ve['VT_DiemDen'];?></option>
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
                                                            <input type="datetime-local" class="form-control" name="ngaydatve" value="<?php echo $ve['VT_NgayDat'];?>">
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row mb-3">
                                                    <div class="col-3">
                                                            <label for="" class="form-label">Ngày khởi hành:</label>
                                                            <input type="datetime-local" class="form-control" name="ngaykhoihanh" value="<?php echo $ve['VT_NgayKhoiHanh'];?>">
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="" class="form-label">Ghế số:</label>
                                                            <input type="text" name="gheso" class="form-control" value="<?php echo $ve['VT_GheSo'];?>">
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="" class="form-label">Giá vé:</label>
                                                            <input type="text" class="form-control" name="giave" value="<?php echo $ve['VT_Gia'];?>">
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="" class="form-label">Trạng thái:</label>
                                                            <select type="text" class="form-select" name="trangthai" value="<?php echo $ve['VT_TrangThai'];?>">
                                                                <option selected><?php echo $ve['VT_TrangThai'];?></option>
                                                                <option>Đã thanh toán</option>
                                                                <option>Đang chờ thanh toán</option>
                                                                <option>Đã hủy</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- <input type="submit" style="float:right;" name="sua" class="btn btn-success btn-lg" value="Sửa"> -->
                                                    <button type="submit" style="float:right;" name="sua" class="btn btn-success btn-lg" value="1">Sửa</button>
                                                </form>
                                            </div>
                                            <a href="#" class="btn btn-Danger" onclick="confirmDelete(<?php echo $ve['VT_MaVeTau']; ?>)">Xóa</a>
                                        </td>


                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                </div>
            </div>

        </div>
    </body>

    </html>
<?php
}
?>