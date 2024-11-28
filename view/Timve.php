<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Nhom17PHP/css/Timve.css">
    <title>Document</title>
</head>
<body>
    <div id="body">
       <div class="container">
            <div class="form-tickets">
              <div class="tickets">
                <div id="title"> 
                  <div class="col line col-md-4"></div>
                  <div class="col col-md-4"><h1>
                      đặt vé trực tuyến
                  </h1></div>
                  <div class="col line col-md-4"></div>
              </div>
                <form action="index.php?act=datve" class="input_" method="POST" id="timve">
                    <div class="mb-3 input-ticket ">
                      <label for="exampleFormControlInput1" class="form-label">Điểm xuất phát</label>
                      <div class="drop_item DiemDi">
                        <!-- <input type="text" class="form-control ipDiemDi" id="exampleFormControlInput1" placeholder="Điểm xuất phát"> -->
                        <select class="form-select" aria-label="Default select example" id="DiemDi" name="DiemDi">
                          <option selected>Điểm đi</option>
                          <?php
                                if (isset($_SESSION['iduser'])) {
                                  $iduser = $_SESSION['iduser'];
                                  $info = User::getUserInfo($iduser);
                              }
                            
                              $conn = DBConnection::Connect();
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
                                  echo "<option value'{$i}'>{$row['GT_Ten']}</option>";
                              }
                              $stmt->close();
                              $conn->close();
                              ?>

                        </select>
                        <div class="err hidden">
                          <p>*Ga đi không hợp lệ</p>
                        </div>
                      </div>
                      
                    </div>
                    <div class="mb-3 input-ticket">
                      <label for="exampleFormControlInput1" class="form-label">Điểm đến</label>
                      <div class="drop_item DiemDen">
                      <!-- <input type="text" class="form-control" id="exampleFormControlInput1 DiemDen" placeholder="Điểm đến"> -->
                      <select class="form-select" aria-label="Default select example" id="DiemDen"  name="DiemDen">
                          <option selected>Điểm đến</option>
                          <?php
                              $conn = DBConnection::Connect();
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
                                  echo "<option value'{$i}'>{$row['GT_Ten']}</option>";
                              }
                              $stmt->close();
                              $conn->close();
                              ?>

                        </select>
                        <div class="err hidden">
                          <p>*Ga đến không hợp lệ</p>
                        </div>
                      </div>
                    </div>
                    <div class="mb-3 input-ticket">
                      <label for="exampleFormControlInput1" class="form-label">Ngày khởi hành</label>
                      <div>
                      <input type="date" class="form-control" id="exampleFormControlInput1" min="" max="" placeholder="Ngày khởi hành" name = "date">
                      <div class="err hidden">
                          <p>*Ngày khởi hành không hợp lệ</p>
                        </div>
                      </div>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input check" type="checkbox" value="" id="flexCheckDefault">
                      <label class="form-check-label" for="flexCheckDefault">
                        Vé 2 chiều
                      </label>
                    </div>
                    <div class="mb-3 input-ticket">
                      <label for="exampleFormControlInput2" class="form-label">Khứ hồi</label>
                     <div>
                     <input type="date" class="form-control KhuHoi disabled" id="exampleFormControlInput2" min="" max="" placeholder="Khứ hồi" disabled="true" name = "date_" >
                      <div class="err hidden disabled_err">
                          <p>*Ngày khởi hành không hợp lệ</p>
                        </div>
                     </div>
                    </div>
                    <div class="mb-3 input-ticket">
                      <label for="exampleFormControlInput1" class="form-label">Số điện thoại</label>
                      <div>
                      <input type="text" class="form-control sdt" id="exampleFormControlInput1" placeholder="Số điện thoại" name = "sdt" value="<?php if(isset($info[0]['KH_SDT'])){echo $info[0]['KH_SDT'];} ?>">
                      <div class="err hidden">
                          <p>*Số điện thoại không hợp lệ</p>
                        </div>
                      </div>
                    </div>
                    <div class="mb-3 input-ticket">
                     <div>
                     <label for="exampleFormControlInput1" class="form-label">Email</label>
                      <input type="Email" class="form-control" id="exampleFormControlInput1" placeholder="Email" name = "email" value="<?php if(isset($info[0]['KH_SDT'])){echo $info[0]['KH_Email'];} ?>">
                      <div class="err hidden">
                          <p>*Email không hợp lệ</p>
                        </div>
                     </div>
                    </div>
                    <div class="btn-ticket">
                      <input class="btn btn-primary " type="submit" value="Tìm vé">
                    </div>
                </form>
            </div>
          </div>
          <div class="trains">
            <div id="title" class="title-train">
              <div class="col line col-md-4"></div>
              <div class="col col-md-4"><h1>
                  Thông tin tàu
              </h1></div>
              <div class="col line col-md-4"></div>
          </div>
          <div class="table-trains">
            <!-- hiển thị thông tin tàu -->
            
            <table class="table ">
              <thead>
                <tr>
                  <th scope="col">mã tàu</th>
                  <th scope="col">các loại vé</th>
                  <th scope="col">lịch trình</th>
                </tr>
              </thead>
              <tbody>
               <tr>
                <td>SE2</td>
                <td>
                  <p> Ghế thường</p>
                  <p>	Ghế nằm 4</p>
                  <p>	Ghế nằm 6</p>
                </td>
                <td>Hà Nội-Sài Gòn</td>
               </tr>
               <tr>
                <td>SE4</td>
                <td>
                  <p>Ghế thường</p>
                  <p>	Ghế nằm 4</p>
                  <p>	Ghế nằm 6</p>
                </td>
                <td>Hà Nội-Sài Gòn</td>
               </tr>
               <tr>
                <td>SE6</td>
                <td>
                  <p>Ghế thường</p>
                  <p>	Ghế nằm 4</p>
                  <p>	Ghế nằm 6</p>
                </td>
                <td>Hà Nội-Sài Gòn</td>
               </tr>
                
              </tbody>
              
            </table>
          </div>
          </div>
       </div>
    </div>
   
    <script src="../Nhom17PHP/javascript/Timve.js"></script>
</body>
</html>