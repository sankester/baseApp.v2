/**
 * Created by achva on 20/08/2017.
 */
$(document).ready(function () {

    // config jquery validator
    $.extend($.validator.messages, {
        required: "tidak boleh kosong.",
        equalTo: 'harus sama.',
        minlength: 'tidak boleh melebihi panjang maksimal.',
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
    });
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
});
