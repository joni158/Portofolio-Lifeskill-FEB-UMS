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
                <h3 class="box-title"><i class="fa fa-file-text"></i> Form Data Dosen</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="#" id="form" class="form-horizontal">
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">NIDN Dosen</label>
                            <div class="col-sm-8">
                                <input type="text" maxlength="20" class="form-control" placeholder="NIDN Dosen" name="st_input1" id="st_input1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Dosen</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Nama Dosen" name="st_input2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email Dosen</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Email Dosen" name="st_input3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">No. Handphone</label>
                            <div class="col-sm-8">
                                <input type="text" maxlength="12" class="form-control" placeholder="No. Handphone" name="st_input4">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Username Dosen</label>
                            <div class="col-sm-8">
                                <input type="text" maxlength="20" class="form-control" placeholder="Username Dosen" name="st_input5" id="st_input5" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Password Dosen</label>
                            <div class="col-sm-8">
                                <input type="text" maxlength="20" class="form-control" placeholder="Password Dosen" name="st_input6" id="st_input6" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Level Dosen</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="st_level" id="st_level">
                                    <?php if($level == 'superadmin') : ?>
                                        <option value="kaprodi">Ketua Program Studi</option>
                                    <?php endif; ?>
                                    <option value="pembimbing">Dosen Pembiming</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Jurusan Dosen</label>
                            <div class="col-sm-8">
                                <select class="form-control" required="required" name="st_jurusan">
                                    <?php foreach ($daftarjurusan as $key=>$value) { ?>
                                        <option value="<?=$value->uid_jurusan?>"><?=$value->nama_jurusan?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="box-footer" style="text-align: right">
                    <a href="<?=base_url('admin')?>/<?=$this->uri->segment(2)?>">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </a>
                    <button type="button" id="btnSave" onclick="save('<?=base_url()?>admin/<?=$this->uri->segment(2)?>/save?act=save')" class="btn btn-primary">Save</button>
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
                    swal("Succes!", "Penambahan data berhasil!", "success");
                    $('#form')[0].reset();
                } else {
                    swal({
                      title: "Gagal !",
                      text: "Level Ketua Program Studi telah penuh, silahkan pilih level lain.",
                      timer: 3000,
                      showConfirmButton: false
                    });
                }
                $("#btnSave").button('reset');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Terjadi kesalahan", "Terjadi kesalahan saat mennyimpan data:)", "error");
                $("#btnSave").button('reset');
            }

        });
    }

    $("input#st_input1").keyup(function(e){
      var val = $(this).val();
      val = val.replace(/[^\w]+/g, "");
      $("input#st_input5").val(val);
      $("input#st_input6").val(val);
    });

</script>