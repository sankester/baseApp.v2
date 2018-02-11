/**
 * Created by achva on 20/08/2017.
 */
$(document).ready(function () {
    $('.delete-menu').on('click', function () {
        var data_url = $(this).attr('delete-url');
        var data_token = $(this).attr('delete-token');
        var data_id= $(this).attr('delete-id');
        var dataElement = $(this);
        swal({
                title: "Apa anda yakin ?",
                text: "Menghapus menu ini juga akan menghapus data yang berhubungan",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#FF7043",
                cancelButtonColor: "#ddd",
                confirmButtonText: "Iya, hapus menu.",
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
});
