<div class="col-md-9">
    <div class="well well-content">
        <div class="profile-content">

          <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-file-text"></i> Daftar Kegiatan</h3>
          </div>
          <br>

            <table id="table-detail" cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-striped" width="100%">
                <thead>
                    <tr>
                        <th style="width: 3%">No.</th>
                        <th style="width: 10%">Nama Kegiatan</th>
                        <th style="width: 4%">Poin</th>
                        <th style="width: 7%">Softskill</th>
                        <th style="width: 4%">Bukti</th>
                        <th style="width: 3%">Verifikasi</th>
                        <th style="width: 10%"><center>Aksi</center></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END col-md-9 -->

<script type="text/javascript">

    cari();
    
    function cari() {
        var table = $('#table-detail').DataTable({
            "paging": false,
            destroy: true,
            info: false,
            "searching": false,
            "processing": true,
            "serverSide": false,
            scrollY: '60vh',
            scrollCollapse: true,
            ajax: {
                url: "<?=base_url()?><?=$this->uri->segment(1)?>/get",
                type: "get",
            }
        });

    }

    function hapus(url) {
        swal({
            title: "Kamu yakin?",
            text: "Kamu tidak akan bisa mengembalikan data ini!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, delete it!',
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
                        swal("Deleted!", "Data berhasil di hapus!", "success");
                        cari();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swal("Terjadi kesalahan", "Terjadi kesalahan saat menghapus data:)", "error");
                    }
                });
            } else {
                swal("Cancelled", "Penghapusan dibatalkan:)", "error");
            }
        });
    }
    
</script>
