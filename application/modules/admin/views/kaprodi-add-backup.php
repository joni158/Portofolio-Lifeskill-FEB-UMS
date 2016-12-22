<?php
    $ci = &get_instance();
    $level = $ci->session->userdata('level');
?>

<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-file-text"></i> Form Kaprodi</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" id="form" class="form-horizontal">
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Kaprodi</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="id_dosen" id="id_dosen">
                                    <option disabled="">-- Pilih Kaprodi --</option>
                                    <?php foreach ($daftardosen as $key => $value) { ?>
                                        <option value="<?=$value->uid_dosen?>"><?=$value->nama_dosen?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Jurusan</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="id_jurusan" id="id_jurusan">
                                    <option disabled="">-- Pilih Jurusan --</option>
                                    <?php foreach ($daftarjurusan as $key => $value) { ?>
                                        <option value="<?=$value->uid_jurusan?>"><?=$value->nama_jurusan?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-8">
                                <a href="<?=base_url('admin')?>/<?=$this->uri->segment(2)?>">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </a>
                                <button type="button" id="btnSave" onclick="save('<?=base_url()?>admin/<?=$this->uri->segment(2)?>/save?act=save')" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->
        <!-- Form Element sizes -->
    </div>
</div>
<!-- /.row -->

<script type="text/javascript">
    
    function save(url) {
        $("#btnSave").button('loading');

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
                if (data['msg'] == 1) {
                    swal("Succes!", "Penambahan data berhasil!", "success")
                } else {
                    swal({
                      title: "Gagal !",
                      text: "Jurusan yang dipilih sudah terdaftar, silahkan pilih jurusan lain.",
                      timer: 3000,
                      showConfirmButton: false
                    });
                }
                $('#form')[0].reset();
                $("#btnSave").button('reset');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Terjadi kesalahan", "Terjadi kesalahan saat mennyimpan data:)", "error");
                $("#btnSave").button('reset');
            }

        });
    }


</script>