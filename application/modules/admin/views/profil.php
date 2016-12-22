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
                <h3 class="box-title"><i class="fa fa-file-text"></i> Edit Profil</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" role="form" id="form">
                <div class="box-body">
                    <div class="col-md-6">
                        <div id="msg-user"></div>

                        <?php if ($this->uri->segment(3) == "me"): ?>
                            <?php if($level != 'superadmin'): ?>
                                <?php $page = 'profil'; ?>
                                <input type="hidden" class="form-control" value="<?=$getdata->uid_dosen?>" name="kode" id="kode">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">NIDN <?=ucwords($level)?></label>
                                    <div class="col-sm-8">
                                        <input type="text" maxlength="20" value="<?=$getdata->nidn?>" class="form-control" placeholder="NIDN <?=ucwords($level)?>" name="nidn" id="nidn">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Nama <?=ucwords($level)?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?=$getdata->nama_dosen?>" placeholder="Nama <?=ucwords($level)?>" name="nama_dosen" id="nama_dosen">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Email <?=ucwords($level)?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?=$getdata->email?>" placeholder="Email <?=ucwords($level)?>" name="email" id="email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">No. Handphone</label>
                                    <div class="col-sm-8">
                                        <input type="text" maxlength="12" class="form-control" value="<?=$getdata->no_hp?>" placeholder="No. Handphone" name="no_hp" id="no_hp">
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php $page = 'akun'; ?>
                            <?php if($level == 'superadmin'): ?>
                                <input type="hidden" class="form-control" value="<?=$getdata->uid?>" name="kode" id="kode">
                            <?php else: ?>
                                <input type="hidden" class="form-control" value="<?=$getdata->uid_dosen?>" name="kode" id="kode">
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" maxlength="20" required="required" value="<?=$getdata->username?>" class="form-control" placeholder="Username" name="st_input1" id="st_input1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Password Lama</label>
                                <div class="col-sm-8">
                                    <input type="password" required="required" class="form-control" placeholder="Password Lama" name="st_input2" id="st_input2">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Password Baru</label>
                                <div class="col-sm-8">
                                    <input type="password" required="required" class="form-control" placeholder="Password Baru" name="st_input3" id="st_input3">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Ulangi Password Baru</label>
                                <div class="col-sm-8">
                                    <input type="password" required="required" class="form-control" placeholder="Ulangi Password Baru" name="st_input4" id="st_input4">
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">&nbsp;</label>
                            <div class="col-sm-8">
                              <a href="<?=base_url('admin')?>">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                              </a>
                              <button type="button" id="btnUser" onclick="save('<?=base_url()?>admin/<?=$this->uri->segment(2)?>/update?page=<?=$page?>')" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="box-footer" style="text-align: right">
                </div> -->
            </form>
        </div>
        <!-- /.box -->
        <!-- Form Element sizes -->
    </div>
</div>
<!-- /.row -->

<script type="text/javascript">
  
    function save(url) {
        var formData = new FormData( $("#form")[0] );
        $.ajax({ 
            url: url,
            data: formData,
            type: "POST",
            async : false,
            cache : false,
            contentType : false,
            processData : false,
            dataType: "JSON",
            success: function(data) {
              $('#msg-user').html(data['msg']);
              $('#msg-user').show();
            }
        });
    }

</script>
