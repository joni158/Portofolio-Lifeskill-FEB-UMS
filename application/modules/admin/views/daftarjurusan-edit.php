<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-file-text"></i> Form Data Jurusan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="#" id="form" class="form-horizontal">
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Kode Jurusan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Kode Jurusan" name="st_input1" readonly="" value="<?=$getdata->uid_jurusan?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Jurusan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Nama Jurusan" name="st_input2" value="<?=$getdata->nama_jurusan?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Fakultas</label>
                            <div class="col-sm-8">
                                <select class="form-control" required="required" name="st_input3">
                                    <?php foreach ($daftarfakultas as $key => $value) { ?>
                                        <option value="<?=$value->id_fakultas?>" <?php if ($getdata->uid_fakultas == "$value->id_fakultas"): echo "selected"; endif; ?>><?=$value->nama_fakultas?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">&nbsp;</label>
                          <div class="col-sm-8">
                            <a href="<?=base_url('admin')?>/<?=$this->uri->segment(2)?>">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            </a>
                            <button type="button" id="btnSave" onclick="save('<?=base_url()?>admin/<?=$this->uri->segment(2)?>/save?act=update')" class="btn btn-primary">Save</button>
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
                swal("Succes!", "Penambahan data berhasil!", "success")
                $("#btnSave").button('reset');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Terjadi kesalahan", "Terjadi kesalahan saat mennyimpan data:)", "error");
                $("#btnSave").button('reset');
            }

        });
    }
    
</script>