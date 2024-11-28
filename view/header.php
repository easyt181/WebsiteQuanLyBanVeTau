<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đường sắt Việt Nam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Nhom17PHP/css/header.css">
</head>

<body>
    <div class="header fixed-top">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <a href="index.php?act=home">
                        <img src="../Nhom17PHP/SourceImg/Logo-DSVN.png" alt="Logo" style="width:210px;height:120px;">
                    </a>
                </div>
                <div class="col-2">
                    <a href="index.php?act=timve">
                         <div style="width: 100%; height: 100%; position: relative;">
                            <div style="width: 42px; height: 28px; left: 25px; top: 46px; position: absolute; background-image: url('../Nhom17PHP/SourceImg/ticket.png');">
                            </div>
                            <div style="width: 89px; height: 24px; left: 65px; top: 43px; position: absolute; text-align: center; color: white; font-size: 20px; font-family: Radio Canada; font-weight: 500;">
                                ĐẶT VÉ</div>
                        </div>
                    </a>
                </div>
                <div class="col-2 ">
                    <a href="index.php?act=home#tintuc">
                        <div style="width: 100%; height: 100%; position: relative;">
                            <div style="width: 34.79px; height: 28px; left: 25px; top: 46px; position: absolute; background-image: url('../Nhom17PHP/SourceImg/news.png');">
                            </div>
                            <div style="width: 89px; height: 24px; left: 65px; top: 43px; position: absolute; text-align: center; color: white; font-size: 20px; font-family: Radio Canada; font-weight: 500; word-wrap: break-word">
                                TIN TỨC</div>
                        </div>
                    </a>
                </div>
                <div class="col-2 ">
                    <a href="#lienhe">
                        <div style="width: 100%; height: 100%; position: relative;">
                            <div style="width: 32.73px; height: 32.74px; left: 25px; top: 43px; position: absolute; background-image: url('../Nhom17PHP/SourceImg/contact.png');">
                            </div>
                            <div style="width: 89px; height: 24px; left: 65px; top: 43px; position: absolute; text-align: center; color: white; font-size: 20px; font-family: Radio Canada; font-weight: 500; word-wrap: break-word">
                                LIÊN HỆ</div>
                        </div>
                    </a>
                </div>
                <?php
                if (isset($_SESSION['username']) && $_SESSION['username'] != "") {
                    // Nếu đã đăng nhập
                    echo '<div class="col-2">
            <a href="index.php?act=userinfo">
                <div style="width: 100%; height: 100%; position: relative;">
                    <div style="width: 32.08px; height: 35px; left: 25px; top: 43px; position: absolute; background-image: url(\'../Nhom17PHP/SourceImg/user.png\');"></div>
                    <div style="width: 120px; height: 24px; left: 65px; top: 43px; position: absolute; text-align: center; color: white; font-size: 20px; font-family: Radio Canada; font-weight: 500; word-wrap: break-word;">
                    ' . $_SESSION['username'] . '</div>
                </div>
            </a>
        </div>
        <div class="col-1">
                    <a href="index.php?act=logout">
                        <div style="width: 100%; height: 100%; position: relative;">
                            <div style="width: 35px; height: 35px; left: 25px; top: 43px; position: absolute; background-image: url(\'../Nhom17PHP/SourceImg/log-out.png\');">
                            </div>
                        </div>
                    </a>
                </div>';
                } else {
                    // Nếu chưa đăng nhập
                    echo '<div class="col-2">
            <a href="index.php?act=dangnhap">
                <div style="width: 100%; height: 100%; position: relative;">
                    <div style="width: 32.08px; height: 35px; left: 25px; top: 43px; position: absolute; background-image: url(\'../Nhom17PHP/SourceImg/user.png\');"></div>
                    <div style="width: 120px; height: 24px; left: 65px; top: 43px; position: absolute; text-align: center; color: white; font-size: 20px; font-family: Radio Canada; font-weight: 500; word-wrap: break-word;">ĐĂNG NHẬP</div>
                </div>
            </a>
        </div>
        <div class="col-1">
                        <div style="width: 100%; height: 100%; position: relative;">
                        
                        <a style="position:absolute;top:43px;left:25px; width: 35px; height: 24.79px; background-image: url(\'../Nhom17PHP/SourceImg/Vector.png\');" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        </a>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?act=dangky">Đăng ký</a></li>
                        <li><a class="dropdown-item" href="#">Thông tin tàu</a></li>
                        <li><a class="dropdown-item" href="#lienhe">Đặt vé qua số điện thoại</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Về chúng tôi</a></li>
                        </ul>
                        
                        </div>
                   
                </div>';
                }
                ?>
                
            </div>
        </div>
    </div>
</body>

</html>