<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
session_start();
ob_start();
include "../Model/ticket.php";
include "../Model/dbconnection.php";
include "../Model/account.php";
include "../Model/user.php";
include "../Model/train.php";
include "../Model/schedule.php";
include "../Model/nhanvien.php";
include "headeradmin.php";
if (isset($_GET['act'])) {
    switch ($_GET['act']) {
    
        case 'buy':
            include "buy.php";
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
                            include "quanlytaikhoanadmin.php";
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
                            include "quanlytaikhoanadmin.php";
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
                            include "quanlytaikhoanadmin.php";
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
                            include "quanlytaikhoanadmin.php";
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
                            include "quanlytaikhoanadmin.php";
                            break;
                    }
                    $doimatkhau = Account::doiMatKhau($user,$newpass);
                    if($doimatkhau === true){
                        include "quanlytaikhoanadmin.php";
                        echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Thông báo!",
                            text: "Đổi mật khẩu thành công! Vui lòng Đăng nhập lại.",
                        }).then(() => {
                            // Chuyển hướng sau khi người dùng đóng thông báo
                            window.location.href = "../index.php";
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
                            include "quanlytaikhoanadmin.php";
                            break;
                    }
    
    
                }
                break;
        case 'quanlytaikhoan':
            include "quanlytaikhoanadmin.php";
            break;
        case 'quanlyve':
            include "quanlyve.php";
            break;
        case 'quanlychuyentau':
            if (isset($_SESSION['role']) && $_SESSION['role'] == "nhanvien") {
                echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Chỉ Quản lý mới có quyền truy cập chức năng này!",
                            }).then(function() {
                                window.location.href = "indexadmin.php";
                                });
                          </script>';
                include "quanlyve.php";
                break;
            } else {
                include "quanlychuyentau.php";
            }
            break;
        case 'themve':
            if (isset($_POST['them']) && $_POST['them']) {

                $machuyentau = $_POST['machuyentau'];
                $makhoang = $_POST['makhoang'];
                $manhanvien = Nhanvien::getNhanVienID($_SESSION['iduser']);
                $diemdi = $_POST['diemdi'];
                $diemden = $_POST['diemden'];
                $gheso = $_POST['gheso'];
                $ngaydat = $_POST['ngaydatve'];
                $ngaykhoihanh = $_POST['ngaykhoihanh'];
                if (isset($diemden) && isset($diemdi)) {
                    $kc1 = Ticket::tinhKhoangCach($diemdi);
                    $kc2 = Ticket::tinhKhoangCach($diemden);
                    $distance = abs($kc2 - $kc1);
                    $giavetheoga = $distance * 50000.00;
                } else {
                    $giavetheoga = null;
                }
                $trangthai = $_POST['trangthai'];
                if ($_POST['giave'] == null) {
                    $giavecongthem = 0.00;
                } else {
                    $giavecongthem = $_POST['giave'];
                }
                if (isset($makhoang)) {
                    $giavetheokhoang = Ticket::tinhTienLoaiVe($makhoang);
                } else {
                    $giavetheokhoang = null;
                }
                $giave = $giavecongthem + $giavetheoga + $giavetheokhoang;

                if (
                    $machuyentau == null || $makhoang == null || $diemdi == null || $diemden == null ||
                    $gheso == null || $ngaydat == null || $ngaykhoihanh == null || $trangthai == null
                ) {
                    echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Hãy nhập đầy đủ thông tin cần thiết trước khi thêm!",
                            }).then(function() {
                                window.location.href = "indexadmin.php?act=quanlyve";
                                });
                          </script>';

                    break;
                }
                if ($diemdi == $diemden) {
                    echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Điểm đi và đến không hợp lệ!",
                            }).then(function() {
                                window.location.href = "indexadmin.php?act=quanlyve";
                                });
                          </script>';

                    break;
                }
                $ticket = new Ticket(
                    null,
                    $machuyentau,
                    $makhoang,
                    null,
                    $manhanvien,
                    $diemdi,
                    $diemden,
                    $gheso,
                    $ngaydat,
                    $ngaykhoihanh,
                    $giave,
                    $trangthai
                );
                $themve = Ticket::themVe($ticket);

                if ($themve === true) {
                    echo '<script>
                            Swal.fire({
                            icon: "success",
                            title: "Thông báo!",
                            text: "Thêm vé thành công!"
                            }).then(function() {
                            window.location.href = "indexadmin.php?act=quanlyve";
                            });
                                </script>';
                    break;
                } else {
                    echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Thất bại!",
                            }).then(function() {
                                window.location.href = "indexadmin.php?act=quanlyve";
                                });
                          </script>';

                    break;
                }
            }
            break;
        case 'xoave':
            if (isset($_GET['mave'])) {
                $mave = $_GET['mave'];
                $xoave = Ticket::xoaVe($mave);
                if ($xoave === true) {
                    echo '<script>
                                Swal.fire({
                                    icon: "success",
                                    title: "Thông báo!",
                                    text: "Xóa vé thành công!"
                                }).then(function() {
                                    window.location.href = "indexadmin.php?act=quanlyve";
                                });
                            </script>';
                    break;
                } else {
                    echo '<script>
                                Swal.fire({
                                    icon: "error",
                                    title: "Thông báo!",
                                    text: "Xóa vé thất bại!"
                                }).then(function() {
                                    window.location.href = "indexadmin.php?act=quanlyve";
                                });
                            </script>';
                    break;
                }
            }
            break;
        case 'suave':
            if (isset($_POST['sua']) && $_POST['sua'] == 1) {
                $mave = $_POST['mavetau'];
                $machuyentau = $_POST['machuyentau'];
                $makhoang = $_POST['makhoang'];
                if ($_POST['makhachhang'] == "") {
                    $makhachhang = null;
                } else {
                    $makhachhang = $_POST['makhachhang'];
                }
                if ($_POST['manhanvien'] == "") {
                    $manhanvien = null;
                } else {
                    $manhanvien = $_POST['manhanvien'];
                }
                $diemdi = $_POST['diemdi'];
                $diemden = $_POST['diemden'];
                $gheso = $_POST['gheso'];
                $ngaydat = $_POST['ngaydatve'];
                $ngaykhoihanh = $_POST['ngaykhoihanh'];
                $giave = $_POST['giave'];
                $trangthai = $_POST['trangthai'];

                if (
                    $machuyentau == "" || $makhoang == "" || $manhanvien == "" || $diemdi == "" || $diemden == "" ||
                    $gheso == "" || $ngaydat == "" || $ngaykhoihanh == "" || $giave == "" || $trangthai == ""
                ) {
                    echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Các thông tin cần thiết không được để trống!",
                            }).then(function() {
                                window.location.href = "indexadmin.php?act=quanlyve";
                                });
                          </script>';
                    break;
                }
                $ticket = new Ticket(
                    $mave,
                    $machuyentau,
                    $makhoang,
                    $makhachhang,
                    $manhanvien,
                    $diemdi,
                    $diemden,
                    $gheso,
                    $ngaydat,
                    $ngaykhoihanh,
                    $giave,
                    $trangthai
                );
                $suave = Ticket::suaVe($ticket);
                if ($suave === true) {
                    echo '<script>
                            Swal.fire({
                            icon: "success",
                            title: "Thông báo!",
                            text: "Sửa vé thành công!"
                            }).then(function() {
                            window.location.href = "indexadmin.php?act=quanlyve";
                            });
                                </script>';
                    break;
                } else {
                    echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Thất bại!",
                            }).then(function() {
                                window.location.href = "indexadmin.php?act=quanlyve";
                                });
                          </script>';
                    break;
                }
            }
            break;

        case 'themchuyentau':
            if (isset($_POST['them']) && $_POST['them']) {
                $matau = $_POST['matau'];
                $malichtrinh = $_POST['malichtrinh'];
                $diemkhoihanh = $_POST['diemkhoihanh'];
                $diemketthuc = $_POST['diemketthuc'];
                $ngaykhoihanh = $_POST['ngaykhoihanh'];
                $train = new Train(
                    null,
                    $matau,
                    $malichtrinh,
                    $diemkhoihanh,
                    $diemketthuc,
                    null,
                    $ngaykhoihanh
                );
                $themchuyentau = Train::addChuyenTau($train);
                if (
                    $matau == "" || $malichtrinh == "" || $diemkhoihanh == "" || $diemketthuc == "" ||
                    $ngaykhoihanh == ""
                ) {
                    echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Hãy nhập đầy đủ thông tin cần thiết trước khi thêm!",
                            }).then(function() {
                                window.location.href = "indexadmin.php?act=quanlychuyentau";
                                });
                          </script>';

                    break;
                }
                if ($themchuyentau === true) {
                    echo '<script>
                            Swal.fire({
                            icon: "success",
                            title: "Thông báo!",
                            text: "Thêm chuyến tàu thành công!"
                            }).then(function() {
                            window.location.href = "indexadmin.php?act=quanlychuyentau";
                            });
                                </script>';
                    break;
                } else {
                    echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Thất bại!",
                            }).then(function() {
                                window.location.href = "indexadmin.php?act=quanlychuyentau";
                                });
                          </script>';

                    break;
                }
            }
            break;

        case 'suachuyentau':
            if (isset($_POST['sua']) && $_POST['sua'] == 1) {
                $machuyentau = $_POST['machuyentau'];
                $matau = $_POST['matau'];
                $malichtrinh = $_POST['malichtrinh'];
                $diemkhoihanh = $_POST['diemkhoihanh'];
                $diemketthuc = $_POST['diemketthuc'];
                $sovedadat = $_POST['sovedadat'];
                $ngaykhoihanh = $_POST['ngaykhoihanh'];
                $train = new Train(
                    $machuyentau,
                    $matau,
                    $malichtrinh,
                    $diemkhoihanh,
                    $diemketthuc,
                    $sovedadat,
                    $ngaykhoihanh
                );
                if (
                    $machuyentau == "" || $matau == "" || $malichtrinh == "" || $diemkhoihanh == "" || $diemketthuc == "" ||
                    $ngaykhoihanh == ""
                ) {
                    echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Các thông tin cần thiết không được để trống!",
                            }).then(function() {
                                window.location.href = "indexadmin.php?act=quanlychuyentau";
                                });
                          </script>';
                    break;
                }
                $suachuyentau = Train::updateChuyenTau($train);
                if ($suachuyentau === true) {
                    echo '<script>
                            Swal.fire({
                            icon: "success",
                            title: "Thông báo!",
                            text: "Sửa chuyến tàu thành công!"
                            }).then(function() {
                            window.location.href = "indexadmin.php?act=quanlychuyentau";
                            });
                                </script>';
                    break;
                } else {
                    echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Thất bại!",
                            }).then(function() {
                                window.location.href = "indexadmin.php?act=quanlychuyentau";
                                });
                          </script>';
                    break;
                }
            }
            break;

        case 'xoachuyentau':
            if (isset($_GET['machuyentau'])) {
                $machuyentau = $_GET['machuyentau'];
                $xoachuyentau = Train::removeChuyenTau($machuyentau);
                if ($xoachuyentau === true) {
                    echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Thông báo!",
                            text: "Xóa chuyến tàu thành công!"
                        }).then(function() {
                            window.location.href = "indexadmin.php?act=quanlychuyentau";
                        });
                    </script>';
                    break;
                } else {
                    echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Xóa vé thất bại!"
                        }).then(function() {
                            window.location.href = "indexadmin.php?act=quanlychuyentau";
                        });
                    </script>';
                    break;
                }
            }
            break;

        case 'quanlynhanvien':
            if (isset($_SESSION['role']) && $_SESSION['role'] == "nhanvien") {

                echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Chỉ Quản lý mới có quyền truy cập chức năng này!",
                            }).then(function() {
                                window.location.href = "indexadmin.php";
                                });
                          </script>';
                include "quanlyve.php";
                break;
            } else {
                include "quanlynhanvien.php";
            }
            break;
        case 'themnhanvien':
            if (isset($_POST['them']) && $_POST['them']) {
                // $manhanvien = $_POST['manhanvien'];
                $mataikhoan = $_POST['mataikhoan'];
                $tennhanvien = $_POST['tennhanvien'];
                $gioitinh = $_POST['gioitinh'];
                $sodienthoai = $_POST['sodienthoai'];
                $diachi = $_POST['diachi'];
                $chucvu = $_POST['chucvu'];
                $luongthang = $_POST['luongthang'];

                $nhanvien = new Nhanvien(null, $mataikhoan, $tennhanvien, $gioitinh, $sodienthoai, $diachi, $chucvu, $luongthang);
                $themnhanvien = Nhanvien::addNhanvien($nhanvien);
                if (
                    $mataikhoan == "" || $tennhanvien == "" || $sodienthoai == "" ||
                    $diachi == "" || $chucvu == "" || $luongthang == ""
                    || $gioitinh == ""
                ) {
                    echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Hãy nhập đầy đủ thông tin cần thiết trước khi thêm!",
                            }).then(function() {
                                window.location.href = "indexadmin.php?act=quanlynhanvien";
                                });
                          </script>';
                    break;
                }
                if ($themnhanvien === true) {
                    echo '<script>
                            Swal.fire({
                            icon: "success",
                            title: "Thông báo!",
                            text: "Thêm nhân viên thành công!"
                            }).then(function() {
                            window.location.href = "indexadmin.php?act=quanlynhanvien";
                            });
                                </script>';
                    break;
                } else {
                    echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Thất bại!",
                            }).then(function() {
                                window.location.href = "indexadmin.php?act=quanlynhanvien";
                                });
                          </script>';
                    break;
                }
            }
            break;
        case 'suanhanvien':
            if (isset($_POST['sua_nhanvien']) && $_POST['sua_nhanvien'] == 1) {
                $manhanvien = $_POST['manhanvien'];
                $mataikhoan = $_POST['mataikhoan'];
                $tennhanvien = $_POST['tennhanvien'];
                $gioitinh = $_POST['gioitinh'];
                $sodienthoai = $_POST['sodienthoai'];
                $diachi = $_POST['diachi'];
                $chucvu = $_POST['chucvu'];
                $luongthang = $_POST['luongthang'];
                $nhanvien = new Nhanvien(
                    $manhanvien,
                    $mataikhoan,
                    $tennhanvien,
                    $gioitinh,
                    $sodienthoai,
                    $diachi,
                    $chucvu,
                    $luongthang
                );

                if (
                    $manhanvien == "" || $mataikhoan == "" || $tennhanvien == "" || $gioitinh == "" ||
                    $sodienthoai == "" || $diachi == "" ||
                    $chucvu == "" || $luongthang == ""
                ) {
                    echo '<script>
                                Swal.fire({
                                icon: "error",
                                title: "Thông báo!",
                                text: "Các thông tin cần thiết không được để trống!",
                                }).then(function() {
                                    window.location.href = "indexadmin.php?act=quanlynhanvien";
                                    });
                              </script>';
                    break;
                }

                $suanhanvien = Nhanvien::updateNhanVien($nhanvien);
                if ($suanhanvien === true) {
                    echo '<script>
                                Swal.fire({
                                icon: "success",
                                title: "Thông báo!",
                                text: "Sửa nhân viên thành công!"
                                }).then(function() {
                                window.location.href = "indexadmin.php?act=quanlynhanvien";
                                });
                                    </script>';
                    break;
                } else {
                    echo '<script>
                                Swal.fire({
                                icon: "error",
                                title: "Thông báo!",
                                text: "Thất bại!",
                                }).then(function() {
                                    window.location.href = "indexadmin.php?act=quanlynhanvien";
                                    });
                              </script>';
                    break;
                }
            }
            break;

        case 'xoanhanvien':
            if (isset($_GET['manhanvien'])) {
                $manhanvien = $_GET['manhanvien'];
                $xoanhanvien = Nhanvien::removeNhanVien($manhanvien);
                if ($xoanhanvien === true) {
                    echo '<script>
                            Swal.fire({
                                icon: "success",
                                title: "Thông báo!",
                                text: "Xóa nhân viên thành công!"
                            }).then(function() {
                                window.location.href = "indexadmin.php?act=quanlynhanvien";
                            });
                        </script>';
                    break;
                } else {
                    echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "Thông báo!",
                                text: "Xóa nhân viên thất bại!"
                            }).then(function() {
                                window.location.href = "indexadmin.php?act=quanlynhanvien";
                            });
                        </script>';
                    break;
                }
            }
            break;

        default:
            include "indexadmin.php?act=quanlyve";
            break;
    }
} else {
    include "quanlyve.php";
}


?>