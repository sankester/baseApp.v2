/**
 * Created by achva on 20/08/2017.
 */
$(document).ready(function () {
    $("input[name='is_assign_menu']").change(function () {
        // get value
        var valueCheck = $(this).val();
        if(valueCheck == 'iya'){
            var data_url = $(this).attr('data-url');
            var data_token = $(this).attr('data-token');
            var portal_id =  $( "#portal_id option:selected" ).val();
            $.ajax({
                url: data_url,
                type: 'POST',
                data: {_method: 'POST', _token: data_token, portal_id : portal_id},
                success: function (data) {
                    if (data.status == 'success') {
                        $('#form-select-menu').html('');
                        var formSelect = '<div class="form-group row">'+
                                         '<label class="col-sm-3 control-label">Pilih Menu</label>'+
                                         '<div class="col-sm-9">' +
                                         '<select multiple name="menu_id[]" id="menu_id" class="form-control select2 select2-hidden-accessible pr-0" style="width: 100%"></select>'+
                                         '</div>'+
                                         '</div>';
                        $('#form-select-menu').append(formSelect);
                        $("select[name='menu_id']").html('');
                        // looping add option value
                        $.each(data.list, function (i, value) {
                            $("#menu_id").append($('<option>').text(value).attr('value', i));
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
        }else{
            $('#form-select-menu').html('');
        }
    });
});
