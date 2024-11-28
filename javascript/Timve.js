

const checkbox = $('.check');
const ipKhuHoi = $('.KhuHoi');
const ipForm = $('.input_');
const disable_err = $('.disabled_err')
const sdt = $('.sdt');
const DiemDi = $('#DiemDi');
const DiemDen = $('#DiemDen');
var today = new Date();
var maxDate = new Date();
maxDate.setMonth(today.getMonth() + 2);
var formattedToday = today.toISOString().split('T')[0];
var formattedMaxDate = maxDate.toISOString().split('T')[0];

$(document).ready(function() {
    $('.check').change(function() {
        if (!checkbox.prop('checked')) {
            ipKhuHoi.prop('disabled', true);
            ipKhuHoi.addClass('disabled');
            disable_err.addClass('hidden');
            ipKhuHoi.attr('min', "");
            ipKhuHoi.attr('max', "");
        } else {
            ipKhuHoi.prop('disabled', false);
            ipKhuHoi.removeClass('disabled'); 
            ipKhuHoi.attr('min', formattedToday);
            ipKhuHoi.attr('max', formattedMaxDate);
        }
    });
});

function isPhone(sdt) {
    sdt = sdt.replace(/[^0-9]/g, ''); 
    if (sdt.length == 10 || sdt.length == 11) {
        if (sdt.charAt(0) == '0') {
            return true;
        }
    }
    return false;
}

function isDiemDi(diemDiVal, diemDenVal) {
    if (diemDiVal == diemDenVal){
        return false;
    }
    return true;
}

$(document).ready(function () {
    $('.input_').submit(function () {
        var isForm = true;

        var diemDiVal = DiemDi.val();
        var diemDenVal = DiemDen.val();

        
        $('select').each(function () {
            var err = $(this).siblings('.err');
            if ($(this).val() === $(this).find('option:first').val()) {
                err.removeClass('hidden');
                isForm = false;
            } else {
                if (!isDiemDi(diemDiVal, diemDenVal)) {
                    DiemDi.siblings('.err').removeClass('hidden');
                    DiemDen.siblings('.err').removeClass('hidden');
                    isForm = false;
                } else {
                    DiemDi.siblings('.err').addClass('hidden');
                    DiemDen.siblings('.err').addClass('hidden');
                }
            }
        });

        // Kiểm tra các input khác
        $('input').each(function () {
            var inputType = $(this).attr('type');
            var isDisabled = $(this).prop('disabled');
            var inputValue = $(this).val();

            if ((inputType !== 'submit' && inputType !== 'button' && inputType !== 'checkbox') && !isDisabled) {
                var err = $(this).siblings('.err');
                if (inputValue === '' ) {
                    err.removeClass('hidden');
                    isForm = false;
                } else {
                    err.addClass('hidden');
                }
                if ($(this).hasClass('sdt') && !isPhone(inputValue)) {
                    err.removeClass('hidden');
                    isForm = false;
                }
            }
        });

        // Kiểm tra số điện thoại
        $('.sdt').each(function () {
            var inputValue = $(this).val();
            var err = $(this).siblings('.err');
            if (!isPhone(inputValue)) {
                err.removeClass('hidden');
                isForm = false;
            } else {
                err.addClass('hidden');
            }
        });

        return isForm;
    });
    $('#exampleFormControlInput1').attr('min', formattedToday);
    $('#exampleFormControlInput1').attr('max', formattedMaxDate);
    
});
