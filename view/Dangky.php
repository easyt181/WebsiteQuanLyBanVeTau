<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Nhom17PHP/css/Dangky.css">
    <title>Đăng ký tài khoản</title>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="background-signup"><img src="../Nhom17PHP/SourceImg/tau.jpg" alt="">
            </div>
            <div id="title">
                <div class="col line col-md-4"></div>
                <div class="col title col-md-4">
                    <h1>
                        đăng ký
                    </h1>
                </div>
                <div class="col line col-md-4"></div>
            </div>
            <div class="form-signup">
                <form action="index.php?act=signup" method="post">
                    <div class="signup">
                        <div>
                            <div class="mb-3 signup-input">
                                <label for="exampleFormControlInput1" class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" name="username" id="exampleFormControlInput1" placeholder="Tên đăng nhập">
                            </div>
                            <div class="mb-3 signup-input">
                                <label for="inputPassword5" class="form-label">Mật khẩu</label>
                                <input type="password" id="inputPassword5" name="password" class="form-control" aria-describedby="passwordHelpBlock" placeholder="Mật khẩu">
                            </div>
                            <div class="mb-3 signup-input">
                                <label for="inputPassword5" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" id="inputPassword5" name="passwordcheck" class="form-control" aria-describedby="passwordHelpBlock" placeholder="Xác nhận mật khẩu">
                            </div>
                        </div>
                        <div>
                            <div class="mb-3 signup-input">
                                <label for="exampleFormControlInput1" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" name="hoten" id="exampleFormControlInput1" placeholder="Họ và tên">
                            </div>
                            <div class="mb-3 signup-input">
                                <label for="exampleFormControlInput1" class="form-label">Email</label>
                                <input type="Email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="Email">
                            </div>
                            <div class="mb-3 signup-input">
                                <label for="exampleFormControlInput1" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" name="sodienthoai" id="exampleFormControlInput1" placeholder="Số điện thoại">
                            </div>
                        </div>
                    </div>
                    <div class="save">
                        <div>
                            <a href="index.php?act=dangnhap">Đã có tài khoản? Đăng nhập tại đây</a>
                        </div>
                        <div class="form-check checkbox">
                            <div><a href="#">Điều khoản sử dụng</a></div>
                            <div>
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="understand">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Đã đọc rõ điều khoản sử dụng
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-btn">
                        <input class="btn btn-primary" type="submit" value="Đăng ký" name="signup">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>