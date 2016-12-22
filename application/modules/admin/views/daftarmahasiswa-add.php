<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-file-text"></i> Form Data Mahasiswa</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">No. Induk Mahasiswa</label>
                            <div class="col-sm-8">
                                <input type="text" maxlength="20" class="form-control" placeholder="No. Induk Mahasiswa" name="st_input1" id="st_input1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Mahasiswa</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Nama Mahasiswa" name="st_input2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email Mahasiswa</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Email Mahasiswa" name="st_input3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">No. Handphone</label>
                            <div class="col-sm-8">
                                <input type="text" maxlength="12" class="form-control" placeholder="No. Handphone" name="st_input4">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Alamat Lengkap</label>
                            <div class="col-sm-8">
                                <textarea cols="3" class="form-control" name="st_alamat" id="st_alamat" placeholder="Alamat Lengkap"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tempat Lahir</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Tempat Lahir" name="st_input5">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tanggal Lahir</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control date" placeholder="Tanggal Lahir" name="st_input6">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tahun Angkatan</label>
                            <div class="col-sm-8">
                                <input type="text" maxlength="4" class="form-control only-year" placeholder="Tahun Angkatan" name="st_input7">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Username Mahasiswa</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Username Mahasiswa" name="st_input8" id="st_input8" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Password Mahasiswa</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Password Mahasiswa" name="st_input9" id="st_input9" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Jurusan Mahasiswa</label>
                            <div class="col-sm-8">
                                <select class="form-control" required="required" name="st_input10">
                                    <?php foreach ($daftarjurusan as $key=>$value) { ?>
                                        <option value="<?=$value->uid_jurusan?>"><?=$value->nama_jurusan?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Foto Gambar</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" placeholder="Foto" name="userfile" id="userfile">
                                <br>
                                <i>*jpg, *jpeg, *png, *gif</i>
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
                swal("Succes!", "Penambahan data berhasil!", "success")
                $('#form')[0].reset();
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
      $("input#st_input8").val(val);
      $("input#st_input9").val(val);
    });

</script>