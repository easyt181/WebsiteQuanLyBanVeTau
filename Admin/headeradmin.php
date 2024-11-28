<?php
if (!(isset($_SESSION['role']) && ($_SESSION['role'] == "admin" || $_SESSION['role'] == "nhanvien"))) {
    header('location: ../index.php');
}else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/header.css">
</head>
<body>
<div class="header fixed-top">
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <a href="indexadmin.php?act=quanlyve">
                            <img src="../SourceImg/Logo-DSVN.png" alt="Logo" style="width:210px;height:120px;">
                        </a>
                    </div>
                    <div class="col-2">
                        <a href="indexadmin.php?act=quanlyve">
                            <div style="width: 100%; height: 100%; position: relative;">
                                <div style="width: 100%; height: 24px; top: 43px; position: absolute; text-align: center; color: white; font-size: 18px; font-family: Radio Canada; font-weight: 500;">
                                    QUẢN LÝ VÉ </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-2">
                        <a href="indexadmin.php?act=quanlychuyentau">
                            <div style="width: 100%; height: 100%; position: relative;">
                                <div style="width: 100%; height: 24px; top: 43px; position: absolute; text-align: center; color: white; font-size: 18px; font-family: Radio Canada; font-weight: 500; word-wrap: break-word">
                                    QUẢN LÝ CHUYẾN TÀU</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-2">
                        <a href="indexadmin.php?act=quanlynhanvien">
                            <div style="width: 100%; height: 100%; position: relative;">
                                <div style="width: 100%; height: 24px; top: 43px; position: absolute; text-align: center; color: white; font-size: 18px; font-family: Radio Canada; font-weight: 500; word-wrap: break-word">
                                    QUẢN LÝ NHÂN VIÊN</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-2">
                        <?php if($_SESSION['role'] == "nhanvien"){
                            echo '<a href="indexadmin.php?act=quanlytaikhoan">
                            <div style="width: 100%; height: 100%; position: relative;">
                                <div style="width: 32.08px; height: 35px; left: 45px; top: 40px; position: absolute; background-image: url(\'../SourceImg/user.png\');"></div>
                                <div style="width: 230px; height: 24px; top: 43px; position: absolute; text-align: center; color: white; font-size: 18px; font-family: Radio Canada; font-weight: 500; word-wrap: break-word;">
                                    '.$_SESSION['username'].'</div>
                            </div>
                        </a>';
                        }else{ ?>
                        <a href="indexadmin.php?act=quanlytaikhoan">
                            <div style="width: 100%; height: 100%; position: relative;">
                                <div style="width: 32.08px; height: 35px; left: 45px; top: 40px; position: absolute; background-image: url('../SourceImg/user.png');"></div>
                                <div style="width: 230px; height: 24px; top: 43px; position: absolute; text-align: center; color: white; font-size: 18px; font-family: Radio Canada; font-weight: 500; word-wrap: break-word;">
                                    ADMIN</div>
                            </div>
                        </a>
                        <?php } ?>
                    </div>
                    <div class="col-1">
                        <a href="../index.php?act=logout">
                            <div style="width: 100%; height: 100%; position: relative;">
                                <div style="width: 35px; height: 35px; top: 43px; position: absolute; background-image: url('../SourceImg/log-out.png');">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>

<?php } ?>