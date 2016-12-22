<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <form id="form" method="post" action="<?=base_url('admin') . "/" . $this->uri->segment(2)?>/export">
                    <div class="pull-Left col-sm-12" style="margin-bottom: 5px;">
                        <div class="col-sm-2">
                            <select id="st_fakultas" name="st_fakultas" class="form-control input-sm">
                                <option value="">Semua Fakultas</option>
                                <?php foreach ($daftarfakultas as $key => $value) { ?>
                                    <option value="<?=$value->id_fakultas?>"><?=$value->nama_fakultas?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" name="st_kode" id="st_kode" class="form-control year input-sm" placeholder="Kode Jurusan">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" name="st_nama" id="st_nama" class="form-control year input-sm" placeholder="Nama Jurusan">
                        </div>
                        <div class="col-sm-5">
                            <a class="btn btn-info btn-sm" onclick="cari()" ><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                </form>
                <table id="table-detail" cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 3%">No</th>
                            <th style="width: 10%">Kode</th>
                            <th style="width: 20%">Nama Jurusan</th>
                            <th style="width: 20%">Fakultas</th>
                            <th style="width: 10%;text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

<script type="text/javascript">
    
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
                url: "<?=base_url()?>admin/<?=$this->uri->segment(2)?>/get",
                type: "post",
                "data": function(d) {
                    d.st_fakultas = $("#st_fakultas").val();
                    d.st_kode = $("#st_kode").val();
                    d.st_nama = $("#st_nama").val();
                }
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
