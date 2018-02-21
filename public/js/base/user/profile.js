$(document).ready(function () {
    // Default file input style
    $(".file-styled").uniform({
        fileButtonClass: 'action btn btn-primary'
    });
    // init date picker
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy'
    });
    // formatter
    $('#no_telp').inputmask("9999-9999-9999");
    // config jquery validator
    $.extend($.validator.messages, {
        required: "tidak boleh kosong.",
        equalTo: 'harus sama.',
        email: 'format email tidak valid.'
    });
    // set function validation
    function setFormValidation(id) {
        $(id).validate({
            errorPlacement: function (error, element) {
                $(element).parent().parent('div').addClass('has-error');
                error.insertAfter(element);
            }
        });
    }
    // call function validation
    setFormValidation('#edit-user');
    // get log portal
    $("#load-logportal").click(function () {
        var $btn = $(this);
        $btn.html('<i class="fa fa-spinner fa-spin"></i> Loading .');
        var url =  $(this).attr('data-url');
        var default_date =  $(this).attr('default-date');
        var count_row =  $('.timeline-portal').length;
        var next_page  = Math.round((count_row / 10) + 1);
        $.ajax({
            url: url+'?page='+ parseInt(next_page),
            type: 'POST',
            data: {_method: 'GET', 'default_date' : default_date},
            success: function (data) {
                $('#more-timeline').remove();
                $(".timeline").append(data.logs);
                $(".timeline").append('<li id="more-timeline"><i class="fa fa-clock-o bg-gray"></i></li>');
                $btn.text('Lainnya .');
                if(data.status == 'failed'){
                    swal({
                        title: data.status,
                        text: data.message,
                        confirmButtonColor: "#EF5350",
                        type: "error"
                    });
                }
                if(data.end == true){
                    $('#load-logportal').remove();
                }
            },
            error:function(data){
                swal({
                    title: "Gagal !",
                    text: "Kesalahan pada server, mohon hubungi admin.",
                    confirmButtonColor: "#1e88e5 ",
                    type: "info"
                });
            }
        });
    });
    // get log user
    $("#load-loguser").click(function () {
        var $btn = $(this);
        $btn.html('<i class="fa fa-spinner fa-spin"></i> Loading .');
        var url =  $(this).attr('data-url');
        var count_row =  $('.user-activity').length;
        var next_page  = Math.round((count_row / 10) + 1);
        $.ajax({
            url: url+'?page='+ parseInt(next_page),
            type: 'POST',
            data: {_method: 'GET'},
            success: function (data) {
                $(".list-user-activity").append(data.logs);
                $btn.text('Lainnya .');
                if(data.status == 'failed'){
                    swal({
                        title: data.status,
                        text: data.message,
                        confirmButtonColor: "#EF5350",
                        type: "error"
                    });
                }
                if(data.end == true){
                    $('#load-loguser').remove();
                }
            },
            error:function(data){
                swal({
                    title: "Gagal !",
                    text: "Kesalahan pada server, mohon hubungi admin.",
                    confirmButtonColor: "#1e88e5 ",
                    type: "info"
                });
            }
        });
    });
});