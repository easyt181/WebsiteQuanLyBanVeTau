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
        <script src="https://kit.fontawesome.com/2217645a51.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Nhom17PHP/css/Datve.css">
    <title>Document</title>
</head>
<body>
    <?php
    include "../Nhom17PHP/Model/ticket.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["DiemDi"])) {
        $Diemdi = $_POST["DiemDi"];
        $Diemden = $_POST["DiemDen"];
        $date = $_POST["date"];
        $sdt = $_POST["sdt"];
        $email = $_POST["email"];
        if (isset($_POST['date_'])  ) {
        $date_=$_POST['date_'];
        $Ngaydi_ = date("d/m/Y", strtotime($date_));
        } 
        $Ngaydi = date("d/m/Y", strtotime($date));
    }else if(isset($_SESSION['username']) && $_SESSION['username'] != ""){
        $Diemdi = $_SESSION['diemdi'];
        $Diemden = $_SESSION['diemden'];
        $date = $_SESSION['date'];
        $Ngaydi = $_SESSION['ngaydi'];
        if(isset($_SESSION['ngaydi_'])){
            $Ngaydi_ = $_SESSION['ngaydi_'];
        }
    }

   
    $conn = DBConnection::Connect();
    $location = array($Diemdi, $Diemden);
    $sqlLc = "SELECT * FROM gatau WHERE GT_Ten = ?;";
    $Diemdi_ = null;
    $Diemden_ = null;
    for ($i = 0; $i < sizeof($location); $i++) {
        $stmt = $conn->prepare($sqlLc);
        $stmt->bind_param("s", $location[$i]);
        $stmt->execute();
        if ($stmt->errno) {
            echo "Lỗi truy vấn: " . $stmt->error;
        } else {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($i === 0) {
                $Diemdi_ = $row;
            } else if ($i === 1) {
                $Diemden_ = $row;
            }
        }

        

        
        
    }
    $stmt->close();
    ?>


    <div id="body">
        <div class="container">
            <div class="tickets">
                <div class="title">
                    <h5><strong>Chiều đi: </strong>Từ <?php echo "<span class='spdiemdi'>".$Diemdi ."</span>" ." đến " ."<span class='spdiemden'>".$Diemden ."</span>" ." ngày " ."<span class='spngaydi'>".$Ngaydi ."</span>"?></h5>
                </div>
                <div class="trains">
                    <div class="content_train">

                       <?php 
                        //lich trinh
                        $sqlLt = "SELECT ThoiGianDi, ThoiGianDen FROM chitietlichtrinh WHERE GT_MaGaTau = ?";
                        $stmtLt = $conn->prepare($sqlLt);
                        $stmtLt->bind_param("s", $Diemdi_['GT_MaGaTau']);
                        $stmtLt->execute();
                        if ($stmtLt->errno) {
                            echo "Lỗi truy vấn: " . $stmtLt->error;
                        } else {
                            $rlLt = $stmtLt->get_result();
                            $rowLt = $rlLt->fetch_assoc();
                        }
                        $Giodi = substr($rowLt['ThoiGianDi'], 0, 5);
                        $Gioden = substr($rowLt['ThoiGianDen'], 0, 5);
                        $Ngaydi_tau = date("d/m", strtotime($date));
                        //toa
                        $sqlToa = "SELECT KHOANG_MaTau, KHOANG_Ten, KHOANG_LoaiKhoang, SUM(KHOANG_SoGhe) AS soghe FROM khoangtau GROUP BY KHOANG_MaTau;";
                        $rlToa = $conn->query($sqlToa);
                        $sqlghe = "SELECT CT_MaTau, SUM(CT_SoVeDaDat) AS soghe_ FROM chuyentau GROUP BY CT_MaTau;";
                        $rlghe = $conn->query($sqlghe);
                        $issetTau = [];
                        while($row_isset = $rlghe->fetch_assoc()){
                            $issetTau[] = $row_isset['CT_MaTau'];
                        }
                        // ngaykhoihanh
                        $diemdi_culy = Ticket::tinhKhoangCach($Diemdi);
                        $diemden_culy = Ticket::tinhKhoangCach($Diemden);
                        $culy = $diemdi_culy - $diemden_culy;
                        if($culy < 0){
                            $malichtrinh = 1;
                        }else{
                            $malichtrinh = 2;
                        }
                        if($rlToa->num_rows > 0){
                            while($rowToa = $rlToa->fetch_assoc() ){
                                if(in_array($rowToa['KHOANG_MaTau'],$issetTau)) {
                                    $soghe = 0;
                                try {
                                    // Kiểm tra xem biến tồn tại và không phải là null
                                    if (!isset($rowToa['KHOANG_MaTau']) || $rowToa['KHOANG_MaTau'] === null) {
                                        throw new Exception("KHOANG_MaTau không tồn tại hoặc là null.");
                                    }
                                
                                    // Tiếp tục với câu truy vấn SQL
                                    $sql_ngaykh = "SELECT CT_NgayKhoiHanh FROM chuyentau WHERE CT_MaTau = ? && CT_MaLichTrinh = ?";
                                    $stmt_ngaykh = $conn->prepare($sql_ngaykh);
                                
                                    if (!$stmt_ngaykh) {
                                        throw new Exception("Lỗi SQL: " . $conn->error);
                                    }
                                
                                    $stmt_ngaykh->bind_param("si", $rowToa['KHOANG_MaTau'], $malichtrinh);
                                    $stmt_ngaykh->execute();
                                    $rl_ngaykh = $stmt_ngaykh->get_result();
                                    
                                    while($ngaykhoihanh_ = $rl_ngaykh->fetch_assoc()){
                                        if ($ngaykhoihanh_ !== null) {
                                            $dateTime = new DateTime($ngaykhoihanh_['CT_NgayKhoiHanh']);
                                            $ngaykh_ = $dateTime->format('d/m/Y');
                                            if($ngaykh_ > $Ngaydi){
                                                $ngaydi_new = [
                                                    'ngaydi' => $ngaykh_,
                                                    'toa' =>  $rowToa['KHOANG_MaTau']
                                                ];
                                                break;
                                            }
                                        }
                                        
                                    }
                                    $stmt_ngaykh->close();
                                
                                } catch (Exception $e) {
                                    echo "Lỗi: " . $e->getMessage();
                                }
                                if($rlghe->num_rows > 0){
                                    while($rowghe = $rlghe->fetch_assoc() ){
                                        if(rtrim($rowToa["KHOANG_MaTau"]) === rtrim($rowghe["CT_MaTau"])){
                                            $soghe = $rowToa["soghe"]-$rowghe["soghe_"];
                                            }
                                        }
                                }
                                echo"
                                <div class='train' data-khoangmatau='{$rowToa['KHOANG_MaTau']}'>
                                    <div class='name_train'>
                                        <div class='name'>
                                            <p >{$rowToa['KHOANG_MaTau']}</p>
                                        </div>
                                            
                                    </div>
                                    
                                <div class='schedules'>
                                        <div class='schedule  schedule_'>
                                            <strong>TG đi: </strong>
                                            <p>"; 
                                            if(isset($ngaydi_new) && $ngaydi_new['toa'] === $rowToa['KHOANG_MaTau']){
                                                $ngaydi = $ngaydi_new['ngaydi'];
                                                $dateTime_ = DateTime::createFromFormat('d/m/Y', $ngaydi);
                                                $ngaydi = $dateTime->format('d/m');
                                                echo "{$ngaydi}";
                                            }else{
                                               echo" {$Ngaydi_tau}";
                                            }
                                            echo "</p> 
                                            <p class= 'p_'>{$Giodi}</p>
                                        </div>
                                        <div class='schedule'>
                                            <strong>TG đến: </strong>
                                            <p>"; 
                                            if(isset($ngaydi_new) && $ngaydi_new['toa'] === $rowToa['KHOANG_MaTau']){
                                                $ngaydi = $ngaydi_new['ngaydi'];
                                                $dateTime_ = DateTime::createFromFormat('d/m/Y', $ngaydi);
                                                $ngaydi = $dateTime->format('d/m');
                                                echo "{$ngaydi}";
                                            }else{
                                               echo" {$Ngaydi_tau}";
                                            }
                                            echo "</p> 
                                            <p class= 'p_'>{$Giodi}</p>
                                        </div>
                                        <div class='schedule'>
                                        <strong>SL chỗ trống:</strong>
                                        <p>"; 
                                        if($soghe !== 0){
                                            echo "{$soghe}";
                                        }else {
                                            echo "{$rowToa['soghe']}";
                                        }
                                        echo "</p>  
                                        </div> 
                                    </div>
                                    <div class='circles'>
                                        <div class='circle'></div>
                                        <div class='circle'></div>
                                    </div>   
                                </div>
                                ";
                                }
                            }
                        }
                        $stmtLt->close();
                       ?>
                       

                    </div>
                        
                    <div class="carriages"></div>
                </div>
                <div class="seats"></div>
                
                <div class="promotion">
                    <div class="promotion_title" >
                        <p>Khuyến mãi:</p>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Nội dung</th>
                            <th scope="col">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>Thời gian áp dụng chương trình từ 15/10/23 đến 31/03/24. Giảm giá vé khứ hồi lượt về theo VB 1269/VTSG-KD&CSKH ngày 02/10/2023</td>
                            <td>Giảm 10% khi mua vé khứ hồi lượt về</td>
                            </tr>
                            <tr>
                            <td>Thời gian áp dụng chương trình từ 15/10/23 đến 31/03/24. Giảm giá vé khi mua xa ngày (10 --19 Ngày) theo CV 1269/VTSG ngày 02/10/2023 (SE3/4, SE7/8) - Áp dụng tối đa 20 vé tới khi hết khuyến mãi</td>
                            <td>Giảm 10% giá vé khi mua xa ngày (từ 10 đến 19 ngày)- Áp dụng tối đa 20 vé tới khi hết khuyến mãi Giảm 10% giá vé khi mua xa ngày (từ 10 đến 19 ngày)- Áp dụng tối đa 20 vé tới khi hết khuyến mãi Giảm 10% giá vé khi mua xa ngày (từ 10 đến 19 ngày)- Áp dụng tối đa 20 vé tới khi hết khuyến mãi Giảm 10% giá vé khi mua xa ngày (từ 10 đến 19 ngày)- Áp dụng tối đa 20 vé tới khi hết khuyến mãi</td>
                            </tr>   
                           
                        </tbody>
                    </table>
                </div>
                
                <div class="notepad">
                    <div class="notepad_carriage">
                                <div class= "carriage_">
                                    <div class="img_carriage">
                                        <img src="../Nhom17PHP/SourceImg/trainCar2.png" alt="">
                                        
                                    </div>
                                    <p>Toa còn vé</p>
                                </div>
                                <div class= "carriage_">
                                    <div class="img_carriage">
                                        <img src="../Nhom17PHP/SourceImg/trainCar2.png" alt="">
                                    </div>
                                    <p>Toa đang chọn</p>
                                </div>
                                <div class= "carriage_">
                                    <div class="img_carriage">
                                        <img src="../Nhom17PHP/SourceImg/trainCar2.png" alt="">
                                    </div>
                                    <p>Toa hết vé</p>
                                </div>
                            </div>
                            <div class="notepad_chairs">
                                <div class="notepad_chair">
                                   <div class="line">
                                </div>
                                <div class="chair"></div>
                                    <p>Chỗ trống</p>
                                </div>
                                <div class="notepad_chair">
                                    <div class="line">
                                </div>
                                <div class="chair sold"></div>
                                    <p>Chỗ đã bán,  không bán</p>
                                </div>
                            </div>
                    </div>
                           
                    
                    <div class="attentions">
                        <div class="attentions_">
                                <strong>Chú ý:</strong>
                            <div class="attention"> 
                                <p>- Để xem quy định trả vé, đổi vé tàu Tết Giáp Thìn 2024 (và thời gian chạy tàu tết) vui lòng bấm <a href="#"> vào đây</a></p>
                                
                            </div>
                            <div class="attention">
                                <p>- Để xem quy định trả vé, đổi vé (Áp dụng với các tàu chạy từ ngày 30/8/2023 đến hết ngày 31/12/2023) vui lòng bấm <a href="#">vào đây</a></p>
                                
                            </div>
                        </div>
                </div>
                </div>
                
            <div class="find">
                    <div class="cart">
                        <div class="cart_header">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <h5>Giỏ vé</h5>
                        </div>
                        <div class="cart_content ">
                            <!--     -->
                            <div class = "ticked">
                                
                            

                            </div>
                        </div>
                        <div class="itinerary_btn">
                                    <input class="btn btn-primary btn_buy" type="submit" value="Mua vé">
                        </div>
                    </div>
                    <div class="itinerary">
                        <div class="itinerary_header">
                            <i class="fa-solid fa-ticket"></i>
                            <h5>Thông tin hàng trình</h5>
                        </div>
                        <div class="itinerary_content">
                            <form action="">
                            <div class="mb-3 input-ticket ">
                                <label for="exampleFormControlInput1" class="form-label">Ga đi:</label>
                                <div class="drop_item DiemDi">
                                    
                                    <select class="form-select" aria-label="Default select example" id="DiemDi" name="DiemDi">
                                    <option selected>Ga đi</option>
                                    <?php
                                        
                                        if ($conn->connect_error) {
                                            die("Kết nối không thành công: " . $conn->connect_error);
                                        }
                                        $sql = "SELECT GT_Ten FROM gatau ";
                                        $stmt = $conn->prepare($sql);
                                        if ($stmt === false) {
                                            die("Lỗi prepare: " . $conn->error);
                                        }
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $i = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            $i++;
                                            
                                            echo "<option value = '{$i}'";
                                            if($Diemdi === $row['GT_Ten']){
                                                echo "selected";
                                            }
                                            echo " >{$row['GT_Ten']}</option>";
                                        }
                                        $stmt->close();
                                        ?>

                                    </select>
                                </div>
                                
                                </div>
                                <div class="mb-3 input-ticket">
                                    <label for="exampleFormControlInput1" class="form-label">Ga đến:</label>
                                    <div class="drop_item DiemDen">
                                    <!-- <input type="text" class="form-control" id="exampleFormControlInput1 DiemDen" placeholder="Điểm đến"> -->
                                    <select class="form-select" aria-label="Default select example" id="DiemDen"  name="DiemDen">
                                        <option selected>Ga đến</option>
                                        <?php
                                            if ($conn->connect_error) {
                                                die("Kết nối không thành công: " . $conn->connect_error);
                                            }
                                            $sql = "SELECT GT_Ten FROM gatau WHERE GT_Ten LIKE ?";
                                            $stmt = $conn->prepare($sql);
                                            if ($stmt === false) {
                                                die("Lỗi prepare: " . $conn->error);
                                            }
                                            $name = "%" . $_POST['ipname'] . "%";
                                            $stmt->bind_param("s", $name);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $i = 0;
                                            while ($row = $result->fetch_assoc()) {
                                                $i++;
                                                echo "<option value = '{$i}'";
                                                if($Diemden === $row['GT_Ten']){
                                                    echo "selected";
                                                }
                                                echo " >{$row['GT_Ten']}</option>";
                                            }
                                            $stmt->close();
                                            ?>

                                        </select>
                                        
                                    </div>
                                    </div>
                                <div class="check">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="checkbox" id="flexRadioDefault1" checked>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Một chiều
                                        </label>
                                        </div>
                                        <div class="form-check">
                                        <input class="form-check-input" type="radio" name="checkbox" id="flexRadioDefault2" <?php if(isset($date_)){ echo "checked";}?>>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Khứ hồi
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Ngaydi" >Ngày đi:</label>
                                    <div class="input_cal">
                                        <input type="date" class="form-control" id = "Ngaydi" min="" max="" <?php echo "value = {$date}";?>>
                                        <!-- <i class="fa-solid fa-calendar-days date_icon"></i> -->
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Ngayve">Ngày về:</label>
                                    <div class="input_cal ip_cal_" >
                                        <input  type="date"  id = "Ngayve"
                                        <?php 
                                        if(isset($date_)){
                                             echo " class='form-control'value = {$date_} ";
                                             }else{
                                                echo "class='form-control disabled_' disabled = 'true'";
                                                }?>>
                                        <!-- <i 
                                        <?php 
                                        if(isset($date_)){ 
                                            echo " class='fa-solid fa-calendar-days date_icon' value = {$date_} ";
                                            }else{
                                                echo "class='fa-solid fa-calendar-days disabled_ date_icon' disabled = 'true'";
                                            }?>
                                    </i> -->
                                    </div>
                                    
                                </div>
                                <div class="itinerary_btn">
                                    <input class="btn btn-primary" type="submit" value="Tìm vé">
                                </div>
                            </form>
                        </div>
                    </div>
                    
            </div>
        
        </div>
        </div>
       
    </div>
    <?php 
    $conn->close(); 
    
    ?>
    <div id="modal">
            <div class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">HÓA ĐƠN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                        <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Thông tin</th>
                        <th scope="col">Giá</th>
                        </tr>
                    </thead>
                    <tbody class="bill_body">
                    </tbody>
                    </table>
                <div class="bill">
                    <p><strong>Tổng tiền:</strong></p>
                    <p><strong class="money"></strong></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn_success"
                <?php
                if (isset($_SESSION['username']) && $_SESSION['username'] != "") {
                    echo "data-username = {$_SESSION['username']}";
                }else {
                    echo "data-username =''";
                    $_SESSION['diemdi'] = $Diemdi;
                    $_SESSION['diemden'] = $Diemden;    
                    $_SESSION['ngaydi'] = $Ngaydi;
                    $_SESSION['date'] = $date;
                    if(isset($Ngaydi_)) {
                        $_SESSION['ngaydi_'] = $Ngaydi_;
                    }
                }
                ?>
                 >Thanh toán</button>
            </div>
            </div>
        </div>
        </div> 
    </div> 
    <script src="../Nhom17PHP/javascript/Datve.js"></script>         
</body>

</html>