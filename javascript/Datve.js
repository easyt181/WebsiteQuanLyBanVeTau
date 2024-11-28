var i = 0;
var ma = null;
var diemdi;
var diemden;
var ngaydi;
var nametoa;
var giodi;
var sotoa;
var sogheold = [];
var lastCall = null;
var timeoutId = null;
var today = new Date();
var maxDate = new Date();
maxDate.setMonth(today.getMonth() + 2);
var formattedToday = today.toISOString().split('T')[0];
var formattedMaxDate = maxDate.toISOString().split('T')[0];
function getCurrentDateTime() {
    var currentDate = new Date();
    // Lấy thông tin ngày, tháng, năm, giờ, phút
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1; // Tháng bắt đầu từ 0
    var year = currentDate.getFullYear();
    var hours = currentDate.getHours();
    var minutes = currentDate.getMinutes();

    // Định dạng số để thêm số 0 phía trước nếu cần
    day = (day < 10) ? '0' + day : day;
    month = (month < 10) ? '0' + month : month;
    hours = (hours < 10) ? '0' + hours : hours;
    minutes = (minutes < 10) ? '0' + minutes : minutes;

    // Tạo chuỗi ngày giờ
    var formattedDateTime = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes;

    return formattedDateTime;
}

function hasDiv(e) {
    return $(e).find('div').length > 0;
  }
function xoa(chuoi) {
    return chuoi.replace(/\s/g, '');
}
function xoa_(chuoi) {
    return chuoi.replace(/,/g, '')
}
function _money(rl, money) {
    var money_ = xoa_(money);
    money_ = parseFloat(money_);
    var moneys = money.toLocaleString('en-US', {
        style: 'decimal',
        minimumFractionDigits: 0,
        maximumFractionDigits: 2
    });

    rl.text(`${moneys}`);
}
function money(){
    var money = 0;
    $('.money_').each(function(){
        var money_ = parseFloat(xoa_($(this).text()));
        money += money_;
    })
    var moneys = money.toLocaleString('en-US', {
        style: 'decimal',
        minimumFractionDigits: 0,
        maximumFractionDigits: 2
    });

    $('.money').text(`${moneys} VNĐ` );
}
function updateSTT() {
    var i = 1;
    $(".bill_body tr").each(function () {
      $(this).find("th").text(i);
      i++;
    });
  }

function toaval(val){
    var index = null;
    var toatype = null;
    ma = $('.carriage').data('ma');
    diemdi = $('.spdiemdi').text();
    diemden = $('.spdiemden').text();
    const ghe= 'GHE';
    const seats = $('.seats');
    const carr = $('.carriage').first();
    index = carr.data('index');
    toatype = carr.data('toa');
    carr.find('.img_carriage').addClass('select_carriage');
    sen(seats, toatype, ghe, index, val, diemdi, diemden, ma);
    $('.carriage').off('click').on('click', function() {
        ma = $(this).data('ma');
        $('.carriage').find('.img_carriage').removeClass('select_carriage');
        $(this).find('.img_carriage').addClass('select_carriage');
        index = $(this).data('index');
        toatype = $(this).data('toa');
        sen(seats, toatype, ghe, index, val,diemdi, diemden, ma);
    });
   }
   
   function gheval(){
    
    diemdi = $('.spdiemdi').text();
    diemden = $('.spdiemden').text();
    ngaydi = $('.spngaydi').text();
    nametoa = $('.nametoa').text();
    giodi = $('.giodi').text();
    sotoa = $('.sotoa').text();
    
    $('.seat').on('click', function() {
        var check = 0;
        if(!$(this).find('.chair ').hasClass('sold')){
            $(this).find('.chair ').toggleClass('sold_');
            var soghe = $(this).find('.chair').contents().filter(function() {
                return this.tagName !== 'DIV';
            }).text();
            if($(this).find('.chair').hasClass('sold_') && i < 10){
                i++;
                var price = $(this).find('._price').text();
               $('.ticked').append(
                `<div class=" toa${soghe} toaa">
                 <div class="ticked_content">
                 <p>` + nametoa + " " + diemdi + "-" + diemden + '<br>' + ngaydi + " " + giodi + '<br>'  + sotoa + 
                 ` số ghế <span class = 'soghe${soghe} soghe_'> ${soghe}   </span></p>` +
                 ' <i class="fa-solid fa-trash-can trash"></i> </div>'
                );
                $('.bill_body').append(
                        `<tr class="toaa">
                        <th scope="row">${i}</th>
                        <td>${nametoa} ${diemdi}- ${diemden} ${ngaydi} ${giodi} ${sotoa} Số ghế <span class = 'soghe${soghe} soghe_'> ${soghe}   </span></td>
                        <td class="money_" style="text-align: end;"><span>${price}</span> VNĐ</td>
                        </tr>`

                )
                
                $(this).find('.chair ').addClass(`soghe_${soghe}`);
                sogheold.push(soghe);
            }else if(!$(this).find('.chair ').hasClass('sold_') && i >  0){
                
                if (sogheold.includes(soghe)) {
                    $(`.soghe${soghe}`).closest(`.toaa`).remove();
                    updateSTT();
                    i--;
                    
                }
            }else if( i >= 10){
                check = 1;
                alert('Bạn không thể giữ quá 10 chỗ!')
            }
            
    
        }
        if(check == 1) {
            $(this).find('.chair ').removeClass('sold_');
        }
    });
   
    $(".seat").mouseenter(function(){
        $(this).find('.price').show();
      }).mouseleave(function(){
        $(this).find('.price').hide();
      });
      $(".price").mouseenter(function(){
        $(this).hide();
      });
   }
   function sen(rl, data, text, index, val_,diemdi_, diemden_, ma) {
    $.ajax({
        
        url: '../Nhom17PHP/view/update_content.php',
        type: 'POST',
        data: { data: data, text: text, index: index, val_: val_, diemdi_: diemdi_, diemden_: diemden_, ma: ma},
        success: function(response) {
            // Hiển thị kết quả từ PHP
            if (text == 'TOA') {
                rl.html(response);
                toaval(data);
            } 
            else if (text == 'GHE') {
                rl.html(response);
                gheval();
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            console.log(status);
            console.log(error);
            alert('Failed to process AJAX request.');
        },
    });
}

$(document).ready(function() {
    const carriage = $('.carriages');
    
    //Tàu
    const toa = "TOA";
    const train = $('.train').first();
    train.addClass('select_train');
    train.find('.name').find('p').addClass('nametoa');
    train.find('.schedule_').find('.p_').addClass('giodi');
    var val = train.data('khoangmatau');
    sen(carriage,val, toa);
    $('.train').on('click', function() {
        val = $(this).data('khoangmatau');
        $('.train').removeClass('select_train');
        $(this).addClass('select_train');
        $('.train').find('.name').find('p').removeClass('nametoa');
        $('.train').find('.schedule_').find('.p_').removeClass('giodi');
        $(this).find('.name').find('p').addClass('nametoa');
        $(this).find('.schedule_').find('.p_').addClass('giodi');
        sen(carriage,val,toa);
    });
    $("input[name='checkbox']").change(function () {

        if ($("#flexRadioDefault1").is(":checked")) {
            $('.ip_cal_').find('input').addClass('disabled_');
            $('.ip_cal_').find('input').prop('disabled', true);
            $('.ip_cal_').find('input').val("");
            $('#Ngayve').attr('min', "");
            $('#Ngayve').attr('max', "");
        } else if ($("#flexRadioDefault2").is(":checked")) {
            $('.ip_cal_').find('input').removeClass('disabled_');
            $('.ip_cal_').find('input').prop('disabled', false);
            $('#Ngayve').attr('min', formattedToday);
            $('#Ngayve').attr('max', formattedMaxDate);
        }
    });
    
    $(document).on('click', '.trash', function() {
        var a =  $(this).siblings('p').find('.soghe_').text();
        var b = `.soghe_${a}`;
        var c = `.soghe${a}`;
        $(this).closest('.toaa').remove();
        $(xoa(c)).closest(`.toaa`).remove();
        $(xoa(b)).removeClass('sold_');
        updateSTT();
        i--;
    });
    
    $('.btn_buy').on('click', function() {
        if(hasDiv($('.ticked'))){
            $('.modal').addClass('display_modal');
            $('.money_').each(function(){
                var price_chane = $(this).find('span').text();
                _money($(this).find('span'), price_chane)
            })
            
            
            
            money();
        }else{
            alert("Vui lòng chọn vé!!");
        }
    })
    $('.btn-close').on('click', function() {
        $('.modal').removeClass('display_modal');
    });
    $('.modal').on('click', function() {
        $(this).removeClass('display_modal');
    });
    $('.modal-dialog').on('click', function(e) {
        e.stopPropagation();
    });
    $('#Ngaydi').attr('min', formattedToday);
    $('#Ngaydi').attr('max', formattedMaxDate);
    $('.btn_success').on('click', function() {
        const user = $(this).data('username');
        if(user != ""){
            giodi = $('.giodi').text();
            ngaydi = $('.spngaydi').text();
            var makhachhang = $('.btn_success').data('username');
            diemdi = $('.spdiemdi').text();
            diemden = $('.spdiemden').text();
            var gheso = [];
            $('.sold_ ').each(function() {
                soghe = $(this).contents().filter(function() {
                    return this.tagName !== 'DIV';
                }).text();
                gheso.push(soghe);
            })
            var ngaydatve = getCurrentDateTime;
            var ngaykhoihanh = ngaydi + " " + giodi;
            var gia = [];
            $('.money_').each(function() {
                gia.push(xoa_($(this).find('span').text()))
            })
            $.ajax({
            
                url: '../Nhom17PHP/Model/buy.php',
                type: 'POST',
                data: { them: 'them', makhoang: ma, makhachhang: makhachhang, diemdi: diemdi, diemden: diemden, gheso: gheso, ngaydatve: ngaydatve,ngaykhoihanh: ngaykhoihanh, gia: gia},
                success: function(response) {
                    if(response == 'true') {
                        Swal.fire({
                            icon: "success",
                            title: "Thông báo!",
                            text: "Thanh toán thành công!"
                        }).then(function() {
                            location.reload();
                        });
                    }else{
                        console.log(response);
                        Swal.fire({
                            icon: "error",
                            title: "Thông báo!",
                            text: "Thanh toán thất bại!"
                        }).then(function() {
                            window.location.href = "../Nhom17PHP/index.php?act=datve";
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.log(status);
                    console.log(error);
                    alert('Failed to process AJAX request.');
                },
            });
        }else{
            Swal.fire({
                icon: "error",
                title: "Thông báo!",
                text: "Đăng nhập để thanh toán!"
            }).then(function() {
                window.location.href = "index.php?act=dangnhap";
            });
        }

    })
});
