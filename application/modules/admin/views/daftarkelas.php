<div class="row">
    <div class="col-sm-5">
        <form class="form-horizontal" method="post" id="form">
            <div class="form-group">
                <label class="col-sm-4 control-label">Nama Kelas</label>
                <div class="col-sm-8">
                    <input type="hidden" name="uid_kelas" id="uid_kelas">
                    <input type="text" class="form-control" placeholder="Masukkan nama Kelas" name="kelas" id="kelas">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-10">
                    <button type="button" onclick="save('<?=base_url()?>admin/<?=$this->uri->segment(2)?>/save?act=save')" class="btn btn-primary">Save</button>
                    <button type="button" onclick="save('<?=base_url()?>admin/<?=$this->uri->segment(2)?>/save?act=update')" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-7">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> <?=ucwords($this->uri->segment(2))?> List</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form id="form-search" method="post">
                    <div class="pull-Left col-sm-12" style="margin-bottom: 5px;">
                        <div class="col-sm-4">
                            <input type="text" name="st_nama" id="st_nama" placeholder="Ketikkan Nama..." class="form-control input-sm">
                        </div>
                        <div class="col-sm-5">
                            <a class="btn btn-info btn-sm" onclick="cari('filter')" ><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                </form>
                <table id="table-detail" cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 3%">No.</th>
                            <th style="width: 40%">Nama Kelas</th>
                            <th style="width: 15%"><center>Aksi</center></th>
                        </tr>
                    </thead>
                    <tbody>
                </table>
            </div>
            <!-- ./box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<script type="text/javascript">

    $(window).load(function(e) {
        cari('all');
    });

    function cari(display) {
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
                    d.st_nama = $("#st_nama").val();
                    d.st_display = display;
                }
            }
        });

    }
    
    function save(url) {

        if ( $('#kategori').val() == '') {
            swal("Terjadi kesalahan", "Terjadi kesalahan saat menyimpan data:)", "error");

        } else {
            var formData = new FormData( $("#form")[0] );
            $.ajax({
                url: url,
                type: "POST",
                data : formData,
                async : false,
                cache : false,
                contentType : false,
                processData : false,
                dataType: "JSON",
                success: function(data) {
                    swal("Succes!", "Penambahan data berhasil!", "success")
                    $('#form')[0].reset();
                    cari('filter');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal("Terjadi kesalahan", "Terjadi kesalahan saat menyimpan data:)", "error");
                }

            });
        }
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
                        cari('filter');
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

    function getdata(uid) {
        $.ajax({
            url: "<?=base_url()?>admin/<?=$this->uri->segment(2)?>/getdata",
            type: "POST",
            dataType: "JSON",
            data: {
                "uid_kelas":uid
            },
            success: function(data) {
                $('#uid_kelas').val(data['uid_kelas']);
                $('#kelas').val(data['nama_kelas']);
            }
        });
    }

</script>