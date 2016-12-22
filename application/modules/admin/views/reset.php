    <div class="row">
        <div class="col-sm-6">

            <blockquote>Reset Data</blockquote>
            <div class="form-group">
                <label class="col-sm-5 control-label">Histori Kartu Stok</label>
                <div class="col-sm-7">
                    <a href="javascript:void()" class="btn btn-sm btn-default" onclick="format('<?=base_url()?>admin/daftar-barang/reset-history')"><i class="fa fa-trash"></i> Reset Now</a>
                </div>
            </div><br><br><Br>
            <div class="form-group">
                <label class="col-sm-5 control-label">Daftar Stok Barang</label>
                <div class="col-sm-7">
                    <a href="javascript:void()" class="btn btn-sm btn-default" onclick="format('<?=base_url()?>admin/daftar-barang/reset-stok')"><i class="fa fa-trash"></i> Reset Now</a>
                </div>
            </div>

        </div>
    </div>

<script type="text/javascript">
    function format(url) {
        swal({
                title: "Kamu yakin?",
                text: "Kamu tidak akan bisa mengembalikan data ini!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, reset it!',
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data) {
                            swal("Berhasil!", "Data berhasil di reset!", "success");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            swal("Terjadi kesalahan", "Terjadi kesalahan saat mereset data:)", "error");
                        }
                    });
                } else {
                    swal("Kembali", "Reset dibatalkan:)", "error");
                }
            });
        }
</script>