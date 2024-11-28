<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Nhom17PHP/css/DangNhap.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
            <div class="content">
                <div class="background-login"><img src="../Nhom17PHP/SourceImg/tau.jpg" alt=""></div>
                <div id="title">
                    <div class="col line col-md-4"></div>
                    <div class="col title col-md-4">
                        <h1>
                            đăng nhập
                        </h1>
                    </div>
                    <div class="col line col-md-4"></div>
                </div>
                <div class="form-login">
                    <form action='../Nhom17PHP/index.php?act=login' method="post">
                        <div class="login">
                            <div class="mb-3 user">
                                <label for="exampleFormControlInput1" autocomplete="off" class="form-label">Tài khoản</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1"
                                    placeholder="Tài khoản" name="username">
                            </div>
                            <div class="mb-3 password">
                                <label for="inputPassword5" class="form-label">Mật khẩu</label>
                                <input type="password" id="inputPassword5" class="form-control"
                                    aria-describedby="passwordHelpBlock" autocomplete="off" placeholder="Mật khẩu" name="password">
                            </div>
                        </div>

                        <div class="save">
                            <div style="margin-right: 50px;">
                                <a href="index.php?act=dangky">Chưa có tài khoản? Đăng ký tại đây</a>
                            </div>
                            <div class="form-check checkbox">

                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="remember">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Lưu thông tin đăng nhập
                                </label>
                            </div>
                        </div>
                        <div class="form-btn">
                            <input class="btn btn-primary" type="submit" value="Đăng nhập" name="login">
                        </div>
                    </form>
                </div>
            </div>
    </div>

</body>

</html>