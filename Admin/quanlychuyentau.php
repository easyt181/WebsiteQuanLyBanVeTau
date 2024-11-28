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
            function confirmDelete(machuyentau) {
                Swal.fire({
                    title: "Bạn chắc chắn muốn xóa chuyến tàu này?",
                    text: "Hành động này không thể hoàn tác!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Xóa",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'indexadmin.php?act=xoachuyentau&machuyentau=' + machuyentau;
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
                    <h2 style="text-align: center;">QUẢN LÝ CHUYẾN TÀU</h2>
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
                        Chi tiết lịch trình
                    </button>
                    <form class="dropdown-menu p-4" style="width:700px;height:auto;">
                    <table class="table table-bordered" style="border:2px outset black;">
                            <thead>
                                <tr style="text-align:center;">
                                    <th>Mã lịch trình</th>
                                    <th>Tên lịch trình</th>
                                    <th>Tên Ga tàu</th>
                                    <th>Thời gian đến</th>
                                    <th>Thời gian đi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $listLichTrinh = Schedule::getLichTrinh();
                                $merge = null;
                                
                                foreach ($listLichTrinh as $lichTrinh) {

                                    if ($lichTrinh['LT_MaLichTrinh'] !== $merge) {

                                        echo '<tr>';
                                        echo '<td rowspan="10">'  . $lichTrinh['LT_MaLichTrinh'] . '</td>';
                                        echo '<td rowspan="10">' . $lichTrinh['LT_TenLichTrinh'] . '</td>';
                                       
                                    } else {                                   
                                      
                                    }
                                    echo '<td>' . $lichTrinh['GT_Ten'] . '</td>';
                                    echo '<td>' . $lichTrinh['ThoiGianDen'] . '</td>';
                                    echo '<td>' . $lichTrinh['ThoiGianDi'] . '</td>';
                                    echo '</tr>';
                                    $merge = $lichTrinh['LT_MaLichTrinh'];
                                } 
                                ?>
                            </tbody>
                </table>
                    </form>
                    </div>
                    <div class="col-4">
                    <button style="float: right;"  type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        Thêm chuyến tàu
                    </button>
                    <form action="indexadmin.php?act=themchuyentau" method="post" class="dropdown-menu p-4" style="width:600px;height:300px">
                    <div class="row mb-3">     
                                <div class="col-4">
                                    <label for="" class="form-label">Mã Tàu:</label>
                                    <input type="text" name="matau" class="form-control">
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label">Mã lịch trình:</label>
                                    <input type="text" name="malichtrinh" class="form-control">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                            <div class="col-4">
                                    <label for="" class="form-label">Điểm khởi hành:</label>
                                    <input type="text" name="diemkhoihanh" class="form-control">
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label">Điểm kết thúc:</label>
                                    <input type="text" class="form-control" name="diemketthuc">
                                        
                                </div>
                                
                            
                                <div class="col-4">
                                    <label for="" class="form-label">Ngày khởi hành:</label>
                                    <input type="datetime-local" class="form-control" name="ngaykhoihanh">
                                </div>
                                
                            </div>
                            
                            <button type="submit" style="float:right;" name="them" class="btn btn-success btn-lg" value="1">Thêm</button>
                    </form>
                    </div>   
            </div>      
            <div class="mb-3">
                <h5>DANH SÁCH CHUYẾN TÀU</h5>
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
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                if(isset($_POST['search']) && $_POST['search']){
                                    $keyword = $_POST['keyword'];
                                    $listCT = Train::searchChuyenTau($keyword);
                                      
                                }else{
                                    $listCT = Train::getDSChuyenTau();
                                    foreach ($listCT as $ve):
                                        $tongve = $ve['TongVeDaDat'];
                                        $machuyentau = $ve['CT_Ma'];
                                        $sovedadat = Train::updateSVDD($tongve,$machuyentau);       
                                    endforeach;               
                                }
                                if (!empty($listCT)) {
                                foreach ($listCT as $ve) : ?>
                                    <tr>
                                        <td><?php echo $ve['CT_Ma']; ?></td>
                                        <td><?php echo $ve['CT_MaTau']; ?></td>
                                        <td><?php echo $ve['CT_MaLichTrinh'] ?></td>
                                        <td><?php echo $ve['CT_DiemKhoiHanh'] ?></td>
                                        <td><?php echo $ve['CT_DiemKetThuc'] ?></td>
                                        <td><?php echo $ve['TongVeDaDat']?></td>
                                        <td><?php echo $ve['CT_NgayKhoiHanh'] ?></td>
                                        <td>
                                            <div class="dropdown" style="float:left; margin-right:5px;">
                                                <button type="button" class="btn btn-success" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                                    Sửa
                                                </button>
                                                <form action="indexadmin.php?act=suachuyentau" method="post" class="dropdown-menu p-4" style="width:600px;height:350px">
                                                    <div class="row mb-3">
                                
                                                        <div class="col-3">
                                                            <label for="" class="form-label">Mã chuyến tàu:</label>
                                                            <input type="text" readonly class="form-control" name="machuyentau" value="<?php echo $ve['CT_Ma']; ?>">
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="" class="form-label">Mã Tàu:</label>
                                                            <input type="text" name="matau" class="form-control" value="<?php echo $ve['CT_MaTau']; ?>">
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="" class="form-label">Mã lịch trình:</label>
                                                            <input type="text" name="malichtrinh" class="form-control" value="<?php echo $ve['CT_MaLichTrinh']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-3">
                                                            <label for="" class="form-label">Điểm khởi hành:</label>
                                                            <input type="text" name="diemkhoihanh" class="form-control" value="<?php echo $ve['CT_DiemKhoiHanh']; ?>">
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="" class="form-label">Điểm kết thúc:</label>
                                                            <input type="text" class="form-control" name="diemketthuc" value="<?php echo $ve['CT_DiemKetThuc']; ?>">
                                                                
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="" class="form-label">Số vé đã đặt:</label>
                                                            <input type="text" class="form-control" readonly name="sovedadat" value="<?php echo $ve['TongVeDaDat']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-6">
                                                            <label for="" class="form-label">Ngày khởi hành:</label>
                                                            <input type="datetime-local" class="form-control" name="ngaykhoihanh" value="<?php echo $ve['CT_NgayKhoiHanh']; ?>">
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <button type="submit" style="float:right;" name="sua" class="btn btn-success btn-lg" value="1">Sửa</button>
                                                </form>
                                            </div>
                                            <div>
                                            <a href="#" class="btn btn-Danger" onclick="confirmDelete(<?php echo $ve['CT_Ma']; ?>)">Xóa</a>
                                            </div>
                                        </td>


                                    </tr>
                                    
                                <?php endforeach; 
                                
                                } else {
                // Hiển thị thông báo khi không có kết quả tìm kiếm
                echo '<tr><td colspan="13" style="text-align: center;">Không có kết quả tìm kiếm.</td></tr>';
            }?>
                            </tbody>
                </table>
            </div>











        </div>
    </body>

    </html>
<?php } ?>