$(document).ready(function() {
    $("#themve #machuyentau").change(function() {
        var selectedCTMa = $(this).val();
        $.ajax({
            url: '../Admin/ajax_get_khoang.php',
            method: 'POST',
            data: {
                CT_Ma: selectedCTMa
            },
            success: function(response) {

                $("#themve #makhoang").html(response);
            }
        });
    });
});
$(document).ready(function() {
    $("#suave #machuyentau").change(function() {
        var selectedCTMa = $(this).val();
        $.ajax({
            url: '../Admin/ajax_get_khoang.php',
            method: 'POST',
            data: {
                CT_Ma: selectedCTMa
            },
            success: function(response) {

                $("#suave #makhoang2").html(response);
            }
        });
    });
});

function confirmDelete(mave) {
    Swal.fire({
        title: "Bạn chắc chắn muốn xóa vé?",
        text: "Hành động này không thể hoàn tác!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'indexadmin.php?act=xoave&mave=' + mave;
        }
    });
}