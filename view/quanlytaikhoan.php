<?php
if (isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
    $info = User::getUserInfo($iduser);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        .content {
            margin-top: 150px;
            padding-left: 200px;
            padding-right: 200px;
        }
    </style>
    <script>
        
    </script>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-3">
                    <hr>
                </div>
                <div class="col-6">
                    <h3 style="text-align: center;">THÔNG TIN CÁ NHÂN</h3>
                </div>
                <div class="col-3">
                    <hr>
                </div>
            </div>
            <div class="dropdown">
                <button type="button" style="float:right; margin-bottom:25px;"  class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    ĐỔI MẬT KHẨU
                </button>
                <form action="index.php?act=doimatkhau" method="post" class="dropdown-menu p-4">
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu hiện tại:</label>
                        <input type="password" class="form-control" name="presentpass">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu mới:</label>
                        <input type="password" class="form-control" name="newpass">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Xác nhận mật khẩu:</label>
                        <input type="password" class="form-control" name="newpass2">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="confirmchange">
                            <label class="form-check-label" >
                                Xác nhận đổi mật khẩu
                            </label>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-success" name="doimatkhau" value="Đổi mật khẩu">
                </form>
            </div> 
            <br>
            <form action="../Nhom17PHP/index.php?act=updateinfo" method="post">
                <div class="mb-3">
                    <label class="form-label">Họ và tên:</label>
                    <input name="hoten" type="text" class="form-control" id="hoten" value="<?php echo $info[0]['KH_Ten']; ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Giới tính:</label>
                    <select name="gioitinh" type="select" class="form-select" id="gioitinh">
                        <?php if ($info[0]['KH_GioiTinh'] == "") {
                            echo '<option selected>...</option>';
                        } else { ?>
                            <option value="<?php echo $info[0]['KH_GioiTinh'] ?>" selected><?php echo $info[0]['KH_GioiTinh'] ?></option>
                        <?php
                        } ?>
                        <option>Nam</option>
                        <option>Nữ</option>
                        <option>Khác</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày Sinh:</label>
                    <input type="date" class="form-control" name="ngaysinh" value="<?php if ($info[0]['KH_NgaySinh']) {
                                                                                        echo $info[0]['KH_NgaySinh'];
                                                                                    } else {
                                                                                        echo '';
                                                                                    } ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Số điện thoại:</label>
                    <input type="text" class="form-control" name="sodienthoai" value="<?php echo $info[0]['KH_SDT'] ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="text" class="form-control" name="email" value="<?php echo $info[0]['KH_Email'] ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Địa chỉ:</label>
                    <input type="text" class="form-control" name="diachi" value="<?php if ($info[0]['KH_DiaChi']) {
                                                                                        echo $info[0]['KH_DiaChi'];
                                                                                    } else {
                                                                                        echo '';
                                                                                    } ?>">
                </div>
                <input type="submit" name="update" class="btn btn-success btn-lg" value="Lưu">
            </form>
        </div>
    </div>
</body>

</html>