/**
 * Created by achva on 20/08/2017.
 */
$(document).ready(function () {
    $('.delete-user').on('click', function () {
        var data_url = $(this).attr('data-url');
        var data_token = $(this).attr('data-token');
        var data_id= $(this).attr('data-id');
        console.log(data_token);
        swal({
                title: "Apa anda yakin ?",
                text: "Menghapus user ini mungkin akan menghapus data yang berhubungan",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#FF7043",
                cancelButtonColor: "#ddd",
                confirmButtonText: "Iya, hapus user.",
                cancelButtonText: "Cancel ",
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        url: data_url,
                        type: 'POST',
                        data: {_method: 'DELETE', _token: data_token},
                        success: function (data) {
                            if(data.status == 'success'){
                                console.log($(data_id));
                                $('#'+data_id).remove();
                                swal({
                                        title: data.status,
                                        text: data.message,
                                        confirmButtonColor: "#66BB6A",
                                        type: "success",
                                        closeOnConfirm: false
                                    }
                                );
                            }else{
                                swal({
                                    title: data.status,
                                    text: data.message,
                                    confirmButtonColor: "#EF5350",
                                    type: "error"
                                });
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
                }
                else {
                    swal({
                        title: "Cancelled",
                        text: "Batal menghapus data:)",
                        confirmButtonColor: "#EF5350",
                        type: "error"
                    });
                }
            });
    });

    $('.detail-user').on('click', function () {
        var data_url = $(this).attr('data-url');
        var data_token = $(this).attr('data-token');
        $.ajax({
            url: data_url,
            type: 'POST',
            data: {_method: 'GET', _token: data_token},
            success: function (response) {
                if(response.status == 'success'){
                    $('#myModal').on('show.bs.modal', function (event) {
                        var button = $(event.relatedTarget) // Button that triggered the modal
                        var recipient = button.data('whatever') // Extract info from data-* attributes
                        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                        var modal = $(this)
                        modal.find('.modal-title').text(response.data.title);
                        modal.find('.modal-body ').html(response.data.html);
                    })
                    $('#myModal').modal('show');
                }else{
                    swal({
                        title: response.status,
                        text: response.message,
                        confirmButtonColor: "#EF5350",
                        type: "error"
                    });
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
