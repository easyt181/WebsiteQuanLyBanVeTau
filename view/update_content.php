<?php
    include "../Model/dbconnection.php";
    mb_internal_encoding("UTF-8");

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['data'])){
    $conn = DBConnection::connect();
    if( $_POST['text'] == 'TOA'){
        $dataFromJS = $_POST['data'];
        $index = 1;
        $sql = "SELECT *  FROM khoangtau WHERE KHOANG_MaTau = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $dataFromJS);
        $stmt->execute();
        if ($stmt->errno) {
            echo "Lỗi truy vấn: " . $stmt->error;
        } else {
            $rl = $stmt->get_result();
        if($rl->num_rows > 0 ){
            while($row = $rl->fetch_assoc()){
                echo "<div class='carriage' data-toa='{$row["KHOANG_LoaiKhoang"]}' data-index='{$index}' data-ma = '{$row["KHOANG_Ma"]}'>
                <div class='img_carriage'><img src='../Nhom17PHP/SourceImg/trainCar2.png' alt=''></div>
                <p>{$row["KHOANG_LoaiKhoang"]}</p>
                </div>";

            $index++;
            }
            $stmt->close();
        }
        }
    }else if($_POST['text'] == 'GHE' && isset($_POST["data"])){
        $diem_culy = [];
        $sql = "SELECT GT_MaGaTau FROM gatau WHERE GT_Ten = ?";
        foreach ([$_POST['diemdi_'], $_POST['diemden_']] as $index => $diem) {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $diem);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $row = $result->fetch_assoc();
                if ($row) {
                    $diem_culy[$index] = $row['GT_MaGaTau'];
                } else {
                    $diem_culy[$index] = "Không có dữ liệu";
                }
            } else {
                $diem_culy[$index] = "Lỗi truy vấn";
            }
    
            $stmt->close();
        }
        $culy = $diem_culy[0] - $diem_culy[1];

        // 
        $LoaiKhoang = $_POST['data'];
        $toa = $_POST['val_'];
        $index = $_POST['index'];
        $sql = "SELECT *  FROM khoangtau WHERE KHOANG_MaTau = ? AND KHOANG_LoaiKhoang = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $toa, $LoaiKhoang );
        $stmt->execute();
        $rl = $stmt->get_result();
        $row = $rl->fetch_assoc();
        $title = '';
        $a =  $row['KHOANG_SoGhe'];
        // sold
        $sql_sold = "SELECT VT_MaKhoang, VT_GheSo, VT_TrangThai FROM vetau WHERE VT_MaKhoang = ?";
        $stmt_sold = $conn->prepare($sql_sold);
        $stmt_sold->bind_param("s", $_POST['ma']);
        $stmt_sold->execute();
        $rl_sold = $stmt_sold->get_result();
        $sold = [];
        while ($row_sold = $rl_sold->fetch_assoc()) {
            if (rtrim($row_sold['VT_TrangThai']) === "Đã thanh toán") {
                $sold[] = $row_sold["VT_GheSo"];
            }
        }
        $price = abs($culy)*50000;
        if(rtrim(rtrim(mb_strtoupper($LoaiKhoang))) === 'GHẾ THƯỜNG'){
            $price =number_format($price + 50000);
            $title = 'Ngồi mềm điều hòa';
            echo"
            <div class='title'>
                    <h5><span class='sotoa' >Toa {$index}</span>: {$title}</h5>
            </div>
            ";
            echo "<div class='chairs'>";
            if($a > 32){  
                $d = 0;
                $ghe = 1;
                $c = 0;
                echo "<div class='chair_ '>
                <div class='left_chair'>
                   <div class='left_chair_'>";
                   while($d < 32){
                       if($c === 0) {
                           echo"<ul>";
                           $c = 2;
                       }else if($c === 1){
                           echo "</ul>";
                           $c = 0;
                       }else if($c === 2){
                           echo "<li class='seat'><div class='line'></div>
                           <span class='chair";
                           if (in_array($ghe, $sold)) {
                            echo " sold";
                            }
                           echo "'>{$ghe}<div class='price'>
                           <div>
                           <h3>Chỗ trống</h3>
                           <div class='price_'>Giá: <span class = '_price'>{$price}</span> VNĐ</div>
                           </div>
                           </div></span>
                           </li>";
                           $ghe++;
                           $d++;
                           if($d%8 === 0 && $d%16 !== 0) {
                               $c = 1;
                           }else if($d%16 === 0 && $d !== 32) {
                               echo"</ul></div><div class='left_chair_'>";
                               $c = 1;
                           }else if($d === 32) {
                               echo"</ul></div></div>";
                               $c = 1;
                           }
                       }
                   }
               echo   "
              <div class='line_'>
                  <div></div>
                  <div></div>
              </div>"; 
              echo " <div class='right_chair'>
                    <div class='left_chair_'>";
              while( $d < $a){
                  if($c === 0) {
                      echo"<ul>";
                      $c = 2;
                  }else if($c === 1){
                      echo "</ul>";
                      $c = 0;
                  }else if($c === 2){
                    echo "<li class='seat'><div class='line'></div>
                           <span class='chair";
                           if (in_array($ghe, $sold)) {
                            echo " sold";
                            }
                           echo "'>{$ghe}<div class='price'>
                           <div>
                           <h3>Chỗ trống</h3>
                           <div class='price_'>Giá: <span class = '_price'>{$price}</span> VNĐ</div>
                           </div>
                           </div></span>
                           </li>";
                      $ghe++;
                      $d++;
                      if($d%8 === 0 && $d%16 !== 0) {
                          $c = 1;
                      }if($d%16 === 0 && $d !== 64){
                          echo"</ul><div class='left_chair_'>";
                          $c = 1;
                      }else if($d === $a) {
                          echo"</ul></div></div></div></div>";
                      }
                  }
              }
                

            }else if($a <= 32) {
                $d = 0;
                $ghe = 1;
                $c = 0;
                echo "<div class='chair_ '>
                 <div class='left_chair'>
                    <div class='left_chair_'>";
                    while($d < $a){
                        if($c === 0) {
                            echo"<ul>";
                            $c = 2;
                        }else if($c === 1){
                            echo "</ul>";
                            $c = 0;
                        }else if($c === 2){
                            echo "<li class='seat'><div class='line'></div>
                           <span class='chair";
                           if (in_array($ghe, $sold)) {
                            echo " sold";
                            }
                           echo "'>{$ghe}<div class='price'>
                           <div>
                           <h3>Chỗ trống</h3>
                           <div class='price_'>Giá: <span class = '_price'>{$price}</span> VNĐ</div>
                           </div>
                           </div></span>
                           </li>";
                            $ghe++;
                            $d++;
                            if($d%8 === 0 && $d%16 !== 0) {
                                $c = 1;
                            }else if($d%16 === 0 && $d !== 32) {
                                echo"</ul></div><div class='left_chair_'>";
                                $c = 1;
                            }else if($d === $a) {
                                echo"</ul></div></div>";
                                $c = 1;
                            }
                        }
                    }
                echo   "
               <div class='line_'>
                   <div></div>
                   <div></div>
                   </div></div>"; 
            }
            echo"</div>";
        }else if(rtrim(mb_strtoupper($LoaiKhoang)) === 'GHẾ NẰM 4' || rtrim(mb_strtoupper($LoaiKhoang)) === 'GHẾ NẰM 6'){
            if(rtrim(mb_strtoupper($LoaiKhoang)) === 'GHẾ NẰM 4'){
                $price =number_format($price + 150000);
                $title = 'Giường nằm khoang 4 điều hòa';
                $t = 2;
            }else if(rtrim(mb_strtoupper($LoaiKhoang)) === 'GHẾ NẰM 6'){
                $price =number_format($price + 100000);
                $title = 'Giường nằm khoang 6 điều hòa';
                $t = 3;
            }
            echo "
            <div class='title'>
                    <h5><span class='sotoa' >Toa {$index}</span>: {$title}</h5>
            </div>
            ";
            echo "<div class='chairs'>";
            $d = 0;
                                $ghe = 1;
                                $c = 0;
                                $e = 1;
                                    echo" <div class='chair_vip ''>
                                        <ul>";
                                        for($i = $t; $i > 0; $i--) {
                                            echo"<li class='chair'>T{$i}</li>";
                                        }
                                       echo" </ul><ul>" ;
                                        while($d < $a){
                                            if($c === 0) {
                                                echo"<li>
                                                <span>khoang $e</span> 
                                                <div class='chair_T_'>";
                                                $c = 2;
                                            }else if($c === 1){
                                                echo "</div></li>";
                                                $e++;
                                                $c = 0;
                                            }else if($c === 2 ){
                                                for($i = 0; $i < $t;$i++){
                                                   if($d !== $a){
                                                    echo"
                                                    <div class='chair_T'>
                                                        <div class = 'seat'>
                                                        <span class='chair"; 
                                                        if (in_array($ghe, $sold)) {
                                                            echo " sold";
                                                            }
                                                        echo "'>{$ghe}<div class='price'>
                                                        <div>
                                                        <h3>Chỗ trống</h3>
                                                        <div class='price_'>Giá: <span class = '_price'>{$price}</span> VNĐ</div>
                                                        </div>
                                                        </div></span>
                                                        <div class='chair_T_line'></div>
                                                        </div>";
                                                    $ghe++;
                                                    echo" <div class = 'seat'>
                                                        <span class='chair";
                                                        if (in_array($ghe, $sold)) {
                                                            echo " sold";
                                                            }
                                                        echo "'>{$ghe}<div class='price'>
                                                        <div>
                                                        <h3>Chỗ trống</h3>
                                                        <div class='price_'>Giá: <span class = '_price'>{$price}</span> VNĐ</div>
                                                        </div>
                                                        </div></span>
                                                        <div class='chair_T_line'></div>
                                                        </div>
                                                        </div>
                                                    ";
                                                    $ghe++;
                                                    $d+=2;
                                                   }
                                                    
                                                }
                                                if($d%4 === 0 || $d%6 === 0) {
                                                    $c = 1;
                                                }else if($d === $a) {
                                                    echo"</ul>";
                                                    $c = 0;
                                                }
                                            }
                                        }
                                        echo"</div>";
            echo "</div>";
        }
        $stmt_sold->close();
        $stmt->close();
    }
    
    }
?>
