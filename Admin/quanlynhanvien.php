<?php
if (!(isset($_SESSION['role']) && $_SESSION['role'] == "admin")) {
    header('location: ../index.php');
} else {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function confirmDelete(manhanvien) {
                Swal.fire({
                    title: "Bạn chắc chắn muốn xóa nhân viên này?",
                    text: "Hành động này không thể hoàn tác!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Xóa",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'indexadmin.php?act=xoanhanvien&manhanvien=' + manhanvien;
                    }
                });
            }
        </script>

    </head>

    <body style="background-color:F0ECE5;">
        <div class="container" style="margin-top:150px;">
            <div class="row title mb-3" style="margin: 50px 0 0 0; width:100%;">
                <div class="col-4">
                    <hr>
                </div>
                <div class="col-4">
                    <h2 style="text-align: center;">QUẢN LÝ NHÂN VIÊN</h2>
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

                <div class="col-4"></div>
                <div class="col-4">
                    <button style="float: right;" type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        Thêm nhân viên
                    </button>
                    <form action="indexadmin.php?act=themnhanvien" method="post" class="dropdown-menu p-4" style="width:600px;height:350px">
                        <div class="row mb-3">
                            <div class="col-8">
                                <label for="" class="form-label">Tên nhân viên:</label>
                                <input type="text" name="tennhanvien" class="form-control">
                            </div>

                            <input type="hidden" name="mataikhoan" class="form-control" value="2">

                            <!-- <div class="col-4">
                                <label for="" class="form-label">Loại tài khoản:</label>
                            </div> -->

                            <div class="col-4">
                                <label for="" class="form-label">Giới tính:</label>
                                <input type="text" class="form-control" name="gioitinh">
                            </div>
                        </div>

                        <div class="row mb-3">

                            <div class="col-4">
                                <label for="" class="form-label">Số điện thoại:</label>
                                <input type="text" name="sodienthoai" class="form-control">
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label">Địa chỉ:</label>
                                <input type="text" class="form-control" name="diachi">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="" class="form-label">Chức vụ:</label>
                                <input type="text" class="form-control" name="chucvu">
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label">Lương tháng:</label>
                                <input type="text" class="form-control" name="luongthang">
                            </div>
                        </div>

                        <button type="submit" style="float:right;" name="them" class="btn btn-success btn-lg" value="1">Thêm</button>
                    </form>
                </div>
            </div>
            <div class="mb-3">
                <h5>DANH SÁCH NHÂN VIÊN</h5>
                <table class="table table-bordered" style="border:2px outset black;">
                    <thead>
                        <tr style="text-align:center;">
                            <th>Mã NV</th>
                            <th>Tên nhân viên</th>
                            <th>Giới tính</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Chức vụ</th>
                            <th>Lương tháng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['search']) && $_POST['search']) {
                            $keyword = $_POST['keyword'];
                            $listNhanvien = Nhanvien::searchNhanVien($keyword);
                        } else {
                            $listNhanvien = Nhanvien::getDSNhanVien();
                            foreach ($listNhanvien as $nhanvien) :
                                $tongnhanvien = $nhanvien['TongNhanVien'];
                            endforeach;
                        }
                        if (!empty($listNhanvien)) {
                            foreach ($listNhanvien as $nhanvien) : ?>
                                <tr>
                                    <td><?php echo $nhanvien['NV_Ma']; ?></td>

                                    <td><?php echo $nhanvien['NV_Ten'] ?></td>
                                    <td><?php echo $nhanvien['NV_GioiTinh'] ?></td>
                                    <td><?php echo $nhanvien['NV_SDT'] ?></td>
                                    <td><?php echo $nhanvien['NV_DiaChi'] ?></td>
                                    <td><?php echo $nhanvien['NV_ChucVu'] ?></td>
                                    <td><?php echo $nhanvien['NV_LuongThang'] ?></td>
                                    <td>
                                        <div class="dropdown" style="float:left; margin-right:5px;">
                                            <button type="button" class="btn btn-success" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                                Sửa
                                            </button>
                                            <form action="indexadmin.php?act=suanhanvien" method="post" class="dropdown-menu p-4" style="width:600px;height:350px">
                                                <div class="row mb-3">
                                                    <div class="col-4">
                                                        <label for="" class="form-label">Mã nhân viên:</label>
                                                        <input type="text" readonly class="form-control" name="manhanvien" value="<?php echo $nhanvien['NV_Ma']; ?>">
                                                    </div>

                                                    <div class="col-8">
                                                        <label for="" class="form-label">Tên nhân viên:</label>
                                                        <input type="text" class="form-control" name="tennhanvien" value="<?php echo $nhanvien['NV_Ten']; ?>">
                                                    </div>

                                                    <input type="hidden" name="mataikhoan" class="form-control" value="<?php echo $nhanvien['NV_MaTaiKhoan']; ?>">

                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-3">
                                                        <label for="" class="form-label">Giới tính:</label>
                                                        <input type="text" name="gioitinh" class="form-control" value="<?php echo $nhanvien['NV_GioiTinh']; ?>">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="" class="form-label">Số điện thoại:</label>
                                                        <input type="text" name="sodienthoai" class="form-control" value="<?php echo $nhanvien['NV_SDT']; ?>">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="" class="form-label">Địa chỉ:</label>
                                                        <input type="text" class="form-control" name="diachi" value="<?php echo $nhanvien['NV_DiaChi']; ?>">
                                                    </div>

                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-6">
                                                        <label for="" class="form-label">Chức vụ:</label>
                                                        <input type="text" class="form-control" name="chucvu" value="<?php echo $nhanvien['NV_ChucVu']; ?>">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="" class="form-label">Lương tháng:</label>
                                                        <input type="text" class="form-control" name="luongthang" value="<?php echo $nhanvien['NV_LuongThang']; ?>">
                                                    </div>
                                                </div>

                                                <button type="submit" style="float:right;" name="sua_nhanvien" class="btn btn-success btn-lg" value="1">Sửa</button>
                                            </form>
                                        </div>

                                        <div>
                                            <a href="#" class="btn btn-Danger" onclick="confirmDelete(<?php echo $nhanvien['NV_Ma']; ?>)">Xóa</a>
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
<?php } ?>