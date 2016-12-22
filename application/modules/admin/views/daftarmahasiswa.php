<?php
    $ci = &get_instance();
    $level = $ci->session->userdata('level');
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                
                <form id="form" method="post" action="<?=base_url('admin') . "/" . $this->uri->segment(2)?>/export">
                    <div class="pull-Left col-sm-12" style="margin-bottom: 5px;">
                        <?php if($level == 'superadmin') : ?>
                            <div class="col-sm-2">
                                <select id="st_jurusan" name="st_jurusan" class="form-control input-sm">
                                    <option value="">Semua Jurusan</option>
                                    <?php foreach ($daftarjurusan as $key => $value) { ?>
                                        <option value="<?=$value->uid_jurusan?>"><?=$value->nama_jurusan?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        <div class="col-sm-2">
                            <input type="text" name="st_angkatan" id="st_angkatan" class="form-control year input-sm" placeholder="Tahun Angkatan">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" name="st_nim" id="st_nim" class="form-control year input-sm" placeholder="NIM Mahasiswa">
                        </div>
                        <div class="col-sm-5">
                            <a class="btn btn-info btn-sm" onclick="cari()" ><i class="fa fa-search"></i></a>
                            <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#import"><i class="fa fa-file-excel-o"></i> Import</a>
                            <button class="btn btn-info btn-sm" type="submit" name="submit"><i class="fa fa-file-excel-o"></i> Export</button>
                        </div>
                    </div>
                </form>
                <table id="table-detail" cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 3%">No</th>
                            <th style="width: 10%">NIM</th>
                            <th style="width: 10%">Username</th>
                            <th style="width: 15%">Nama Lengkap</th>
                            <th style="width: 5%">Angkatan</th>
                            <th style="width: 15%;">Jurusan</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 15%;text-align: center;">Aksi</th>
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

<div class="modal fade" id="import">
    <form id="siswa" enctype='multipart/form-data' method="post" action="<?=base_url('admin') . "/" . $this->uri->segment(2)?>/import">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Import Data</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Data Format excel 
                            <a style="color:blue;" href="<?=base_url()?>assets/importmahasiswa.xlsx">Download Format</a>
                        </label>
                        <input name="file" type="file" id="file" size="50" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </form>
    <!-- /.modal-dialog -->
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
                    <?php if ($level == 'superadmin'): ?>
                        d.st_jurusan = $("#st_jurusan").val();
                    <?php endif; ?>
                    
                    d.st_angkatan = $("#st_angkatan").val();
                    d.st_nim = $("#st_nim").val();
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
