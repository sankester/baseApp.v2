/**
 * Created by achva on 20/08/2017.
 */
$(document).ready(function () {

    // config jquery validator
    $.extend($.validator.messages, {
        required: "tidak boleh kosong.",
        equalTo: 'harus sama.',
        email: 'format email tidak valid.'
    });

    var form = $(".validation-wizard").show();
    // wizard
    $(".validation-wizard").steps({
        headerTag: "h6"
        , bodyTag: "section"
        , transitionEffect: "none"
        , titleTemplate: '<span class="step">#index#</span> #title#'
        , labels: {
            finish  : "Simpan",
            next    : "Selanjutnya",
            previous: "Sebelumnya"
        }
        , onStepChanging: function (event, currentIndex, newIndex) {
            return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
        }
        , onFinishing: function (event, currentIndex) {
            return form.validate().settings.ignore = ":disabled", form.valid()
        }
        , onFinished: function (event, currentIndex) {
            return form.submit();
        }
    }), $(".validation-wizard").validate({
        ignore: "input[type=hidden]"
        , errorClass: "text-danger"
        , successClass: "text-success"
        , highlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        }
        , unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        }
        , errorPlacement: function (error, element) {
            error.insertAfter(element)
        }
        , rules: {
            email: {
                email: !0
            }
        }
    }), $('.select2').select2();
    // select portal changed
    $("#portal_id").change(function () {
        // get value
        var portal_id  = $(this).val();
        var data_url = $(this).attr('data-url');
        var data_url_permission = $(this).attr('data-url-permission');
        var data_token = $(this).attr('data-token');
        // ajax get list menu
        $.ajax({
            url: data_url,
            type: 'POST',
            data: {_method: 'POST', _token: data_token, portal_id : portal_id, index : 'menu_url'},
            success: function (data) {
                if (data.status == 'success') {
                    $("select[name='default_page']").html('');
                    // looping add option value
                    $.each(data.list, function (i, value) {
                        $("select[name='default_page']").append($('<option>').text(value).attr('value', i));
                    });
                    // init select2
                    $('.select2').select2();
                } else {
                    swal({
                        title: data.status,
                        text: data.message,
                        confirmButtonColor: "#EF5350",
                        type: "error"
                    });
                }
            },
            error: function (data) {
                swal({
                    title: "Gagal !",
                    text: "Kesalahan pada server, mohon hubungi admin.",
                    confirmButtonColor: "#1e88e5 ",
                    type: "info"
                });
            }
        });
        // ajax get permission
        $.ajax({
            url: data_url_permission,
            type: 'POST',
            data: {_method: 'POST', _token: data_token, portal_id : portal_id},
            success: function (data) {
                if (data.status == 'success') {
                   if(data.list == ''){
                       var html =  '<div class="col-md-12"><div class="error-page empty-data">' +
                                   '<div class="error-content">' +
                                   '<div class="container text-center">' +
                                   '<h2 class="headline text-muted"><i class="mdi mdi-account-key"></i></h2>' +
                                   '<h3 class="margin-top-0">Permission Belum Tersedia !</h3>' +
                                   '</div></div></div></div>';
                       $('#list-permission').html('');
                       $('#list-permission').append(html);
                   }else{
                       var html = '<table class="table table-responsive">' +
                           '<tbody><tr><th width="5%" class="text-center"><div class="checkbox">' +
                           '<input type="checkbox" id="checked-all-menu" class="chk-col-green checked-all-menu">' +
                           '<label for="checked-all-menu"></label>' +
                           '</div></th><th width="20%" class="text-center">Menu</th>' +
                           '<th width="80%" class="text-center">Permission</th></tr></tbody></table>';
                       $('#list-permission').html('');
                       $('#list-permission').append(html);
                       $('#list-permission').find('tbody').append(data.list);
                       // check all permission
                       $(".checked-all-menu").click(function () {
                           var status = $(this).is(":checked");
                           if (status === true) {
                               $(".r-menu").prop('checked', true);
                           } else {
                               $(".r-menu").prop('checked', false);
                           }
                       });
                       // changed row permission
                       $(".checked-all").click(function () {
                           var status = $(this).is(":checked");
                           if (status === true) {
                               $(".r-" + $(this).val()).prop('checked', true);
                           } else {
                               $(".r-" + $(this).val()).prop('checked', false);
                           }
                       });
                   }
                } else {
                    swal({
                        title: data.status,
                        text: data.message,
                        confirmButtonColor: "#EF5350",
                        type: "error"
                    });
                }
            },
            error: function (data) {
                swal({
                    title: "Gagal !",
                    text: "Kesalahan pada server, mohon hubungi admin.",
                    confirmButtonColor: "#1e88e5 ",
                    type: "info"
                });
            }
        });
    });
    // initial select 2
    $(".select-2").select2();
    // check all permission
    $(".checked-all-menu").click(function () {
        var status = $(this).is(":checked");
        if (status === true) {
            $(".r-menu").prop('checked', true);
        } else {
            $(".r-menu").prop('checked', false);
        }
    });
    //check single
    $(".permission-role").click(function () {
        var status = $(this).is(":checked");
        if (status === true) {
            $(".multi-role-p-" + $(this).val()).prop('checked', true);
        } else {
            $(".multi-role-p-" + $(this).val()).prop('checked', false);
        }
    });
    // changed row permission
    $(".checked-all").click(function () {
        var status = $(this).is(":checked");
        if (status === true) {
            $(".r-" + $(this).val()).prop('checked', true);
        } else {
            $(".r-" + $(this).val()).prop('checked', false);
        }
    });
});
