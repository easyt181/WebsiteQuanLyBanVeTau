<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
session_start();
ob_start();
include "../Nhom17PHP/Model/user.php";
include "../Nhom17PHP/Model/dbconnection.php";
include "../Nhom17PHP/view/header.php";
include "../Nhom17PHP/Model/account.php";


if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        
        case 'updateinfo':
            if (isset($_POST['update']) && $_POST['update']) {
                $matk = $_SESSION['iduser'];
                $hoten = $_POST['hoten'];
                $gioitinh = $_POST['gioitinh'];
                $ngaysinh = $_POST['ngaysinh'];
                $sdt = $_POST['sodienthoai'];
                $email = $_POST['email'];
                $diachi = $_POST['diachi'];
                if ($hoten == null || $sdt == null || $email == null) {
                    echo '<script>
                        Swal.fire({
                        icon: "error",
                        title: "Thông báo!",
                        text: "Các thông tin quan trọng không được để trống! Vui lòng thử lại.",
                        });
                        </script>';
                    include "../Nhom17PHP/view/quanlytaikhoan.php";
                    break;
                }
                $getsdtemail = User::getUserInfo($matk);
                if ($getsdtemail[0]['KH_SDT'] !== $sdt) {
                    $checksdt = User::checkUser($sdt, null);
                    if ($checksdt > 0) {
                        echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Số điện thoại đã tồn tại! Vui lòng thử lại.",
                            });
                            </script>';
                        include "../Nhom17PHP/view/quanlytaikhoan.php";
                        break;
                    }
                }
                if ($getsdtemail[0]['KH_Email'] !== $email) {
                    $checkemail = User::checkUser(null, $email);
                    if ($checkemail > 0) {
                        echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Email đã tồn tại! Vui lòng thử lại.",
                            });
                            </script>';
                        include "../Nhom17PHP/view/quanlytaikhoan.php";
                        break;
                    }
                }
                $user = new User($matk, $hoten, $gioitinh, $ngaysinh, $sdt, $email, $diachi);
                echo '<script>
                            Swal.fire({
                                title: "Bạn chắc chắn muốn cập nhật thông tin cá nhân?",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Đồng ý",
                                cancelButtonText: "Hủy",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Người dùng đã nhấn nút "Đồng ý"
                                    var updateuser = ' . json_encode(User::updateInfo($user)) . ';
                                    if (updateuser === true) {
                                        Swal.fire({
                                            icon: "success",
                                            title: "Thông báo!",
                                            text: "Cập nhật thông tin cá nhân thành công!"
                                        }).then(() => {
                                            window.location.href = "../Nhom17PHP/index.php?act=userinfo";
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: "error",
                                            title: "Thông báo!",
                                            text: "Lỗi khi cập nhật thông tin! Xin thử lại."
                                        });
                                    }
                                }
                            });
                        </script>';
                include "../Nhom17PHP/view/quanlytaikhoan.php";
            }
            break;
        case 'userinfo':
            include "../Nhom17PHP/view/quanlytaikhoan.php";
            break;
        case 'timve':
            include "../Nhom17PHP/view/Timve.php";
            break;
        case 'datve':
            include "../Nhom17PHP/view/Datve.php";
            break;
        case 'home':
            if (isset($_COOKIE['remember_token'])) {
                $token = $_COOKIE['remember_token'];
            }
            include "../Nhom17PHP/view/home.php";
            break;
        case 'dangnhap':
            echo '<script>document.title = "Đăng nhập";</script>';
            if (isset($_SESSION['username'])) {
                include "../Nhom17PHP/view/home.php";
            } else {
                include "../Nhom17PHP/view/dangnhap.php";
            }
            break;
        case 'dangky':
            echo '<script>document.title = "Đăng ký";</script>';
            include "../Nhom17PHP/view/dangky.php";
            break;
            case 'doimatkhau':
                if(isset($_POST['doimatkhau']) && $_POST['doimatkhau']){
                    $presentpass = $_POST['presentpass'];
                    $newpass = $_POST['newpass'];
                    $newpass2 = $_POST['newpass2'];
                    $user = $_SESSION['username'];
                    if($newpass == null || $newpass2 == null || $presentpass == null){
                        echo '<script>
                                Swal.fire({
                                icon: "error",
                                title: "Thông báo!",
                                text: "Các thông tin không được để trống.",
                                });
                                </script>';
                            include "../Nhom17PHP/view/quanlytaikhoan.php";
                            break;
                    }
                    if(!isset($_POST['confirmchange']) && !$_POST['confirmchange']){
                        echo '<script>
                                Swal.fire({
                                icon: "error",
                                title: "Thông báo!",
                                text: "Hãy tích đồng ý đổi mật khẩu trước.",
                                });
                                </script>';
                            include "../Nhom17PHP/view/quanlytaikhoan.php";
                            break;
                    }
                    if($newpass != $newpass2){
                        echo '<script>
                                Swal.fire({
                                icon: "error",
                                title: "Thông báo!",
                                text: "Xác nhận mật khẩu không khớp. Xin thử lại.",
                                });
                                </script>';
                            include "../Nhom17PHP/view/quanlytaikhoan.php";
                            break;
                    }
                    $checkmatkhau = Account::checkMatKhau($user);
                    if($presentpass != $checkmatkhau){
                        echo '<script>
                                Swal.fire({
                                icon: "error",
                                title: "Thông báo!",
                                text: "Mật khẩu hiện tại không đúng.",
                                });
                                </script>';
                            include "../Nhom17PHP/view/quanlytaikhoan.php";
                            break;
                    }
                    if($newpass == $presentpass){
                        echo '<script>
                                Swal.fire({
                                icon: "error",
                                title: "Thông báo!",
                                text: "Mật khẩu mới không được giống với mật khẩu cũ.",
                                });
                                </script>';
                            include "../Nhom17PHP/view/quanlytaikhoan.php";
                            break;
                    }
                    $doimatkhau = Account::doiMatKhau($user,$newpass);
                    if($doimatkhau === true){
                        include "../Nhom17PHP/view/quanlytaikhoan.php";
                        echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Thông báo!",
                            text: "Đổi mật khẩu thành công! Vui lòng Đăng nhập lại.",
                        }).then(() => {
                            // Chuyển hướng sau khi người dùng đóng thông báo
                            window.location.href = "index.php";
                        });
                      </script>';
                            unset($_SESSION['role']);
                            unset($_SESSION['username']);
                            unset($_SESSION['iduser']);
                            if (isset($_COOKIE['remember_token'])) {
                                setcookie('remember_token', '', time() - 3600, '/', '', false, true);
                            }
                           
                           
                            
                    }else{
                        echo '<script>
                                Swal.fire({
                                icon: "error",
                                title: "Thông báo!",
                                text: "Đổi mật khẩu thất bại do có lỗi.",
                                });
                                </script>';
                            include "../Nhom17PHP/view/quanlytaikhoan.php";
                            break;
                    }
    
    
                }
                break;
        case 'signup':
            if (isset($_POST['signup']) && ($_POST['signup'])) {
                $user = $_POST['username'];
                $pass = $_POST['password'];
                $phanquyen = "khachhang";
                $passcheck = $_POST['passwordcheck'];
                $hoten = $_POST['hoten'];
                $email = $_POST['email'];
                $sodienthoai = $_POST['sodienthoai'];
                $checkaccount = Account::checkAccount($user);
                $checkuser = User::checkUser($sodienthoai, $email);
                if ($user == "" || $pass == "" || $passcheck == "" || $hoten == "" || $email == "" || $sodienthoai == "") {
                    echo '<script>
                        Swal.fire({
                        icon: "error",
                        title: "Thông báo!",
                        text: "Vui lòng nhập đầy đủ thông tin trước khi đăng ký! Hãy thử lại.",
                        });
                        </script>';
                    include "../Nhom17PHP/view/dangky.php";
                    break;
                }
                if ($pass != $passcheck) {
                    echo '<script>
                        Swal.fire({
                        icon: "error",
                        title: "Thông báo!",
                        text: "Xác minh mật khẩu không trùng khớp! Hãy thử lại.",
                        });
                        </script>';
                    include "../Nhom17PHP/view/dangky.php";
                    break;
                }

                if (!isset($_POST['understand']) && !($_POST['understand'])) {
                    echo '<script>
                        Swal.fire({
                        icon: "error",
                        title: "Thông báo!",
                        text: "Bạn phải chấp thuận điều khoản sử dụng trước!",
                        });
                        </script>';
                    include "../Nhom17PHP/view/dangky.php";
                    break;
                }
                if ($checkuser > 0) {
                    echo '<script>
                        Swal.fire({
                        icon: "error",
                        title: "Thông báo!",
                        text: "Số điện thoại hoặc Email đăng ký đã tồn tại! Vui lòng thử lại.",
                        });
                        </script>';
                    include "../Nhom17PHP/view/dangky.php";
                    break;
                }
                if ($checkaccount > 0) {
                    echo '<script>
                        Swal.fire({
                        icon: "error",
                        title: "Thông báo!",
                        text: "Tài khoản đã tồn tại! Vui lòng thử lại.",
                        });
                        </script>';
                    include "../Nhom17PHP/view/dangky.php";
                    break;
                } else {
                    $matk = Account::addAccount($user, $pass, $phanquyen);
                    $khach = new User($matk, $hoten, null, null, $sodienthoai, $email, null);
                    $khachhang = User::addKH($khach);
                    echo '<script>
                        Swal.fire({
                        icon: "success",
                        title: "Thông báo!",
                        text: "Đăng ký thành công! Xin cảm ơn!",
                        });
                        </script>';
                    include "../Nhom17PHP/view/DangNhap.php";
                    break;
                }
            }
            break;
        case 'login':
            if (isset($_POST['login']) && ($_POST['login'])) {
                $user = $_POST['username'];
                $pass = $_POST['password'];
                $kq = Account::getuserinfo($user, $pass);
                if (count($kq) > 0) {
                    $role = $kq[0]['TK_PhanQuyen'];
                    if (isset($role) && $role == "admin") {
                        $_SESSION['role'] = "admin";
                        $_SESSION['iduser'] = $kq[0]['TK_MaTaiKhoan'];
                        $_SESSION['username'] = $kq[0]['TK_TenDangNhap'];
                        header('location: ../Nhom17PHP/Admin/indexadmin.php');
                        exit();
                    } else if (isset($role) && $role == "nhanvien") {
                        $_SESSION['role'] = "nhanvien";
                        $_SESSION['username'] = $kq[0]['TK_TenDangNhap'];
                        $_SESSION['iduser'] = $kq[0]['TK_MaTaiKhoan'];
                        header('location: ../Nhom17PHP/Admin/indexadmin.php');
                        exit();
                    } else {
                        $_SESSION['role'] = $role;
                        $_SESSION['username'] = $kq[0]['TK_TenDangNhap'];
                        $_SESSION['iduser'] = $kq[0]['TK_MaTaiKhoan'];
                        if (isset($_POST['remember']) && ($_POST['remember'])) {
                            $token = bin2hex(random_bytes(16));
                            setcookie('remember_token', $token, time() + (86400 * 30), '/', '', false, true);
                        }
                        if(isset($_SESSION['diemdi']) && $_SESSION['diemdi'] !== ""){
                            echo '<script>
                            Swal.fire({
                            icon: "success",
                            title: "Thông báo!",
                            text: "Đăng nhập thành công!"
                            }).then(function() {
                            window.location.href = "../Nhom17PHP/index.php?act=datve";
                            });
                                </script>';
                        }else{
                            echo '<script>
                            Swal.fire({
                            icon: "success",
                            title: "Thông báo!",
                            text: "Đăng nhập thành công!"
                            }).then(function() {
                            window.location.href = "../Nhom17PHP/index.php";
                            });
                                </script>';
                        }
                        exit();
                    }
                } else {
                    echo '<script>
                        Swal.fire({
                        icon: "error",
                        title: "Thông báo!",
                        text: "Tài khoản hoặc mật khẩu không chính xác!",
                        });
                        </script>';
                    include "../Nhom17PHP/view/DangNhap.php";
                    break;
                }
            }
        case 'logout':
            unset($_SESSION['role']);
            unset($_SESSION['username']);
            unset($_SESSION['iduser']);
            unset($_SESSION['diemdi']);
            unset($_SESSION['diemden']);
            unset($_SESSION['ngaydi']);
            unset($_SESSION['date']);
            unset($_SESSION['ngaydi_']);
            if (isset($_COOKIE['remember_token'])) {
                setcookie('remember_token', '', time() - 3600, '/', '', false, true);
            }
            header('location: ../Nhom17PHP/index.php');
            break;
        default:
            include "../Nhom17PHP/view/home.php";
            break;
    }
} else {
    if (isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];
    }
    include "../Nhom17PHP/view/home.php";
}
include "../Nhom17PHP/view/footer.php";


?>