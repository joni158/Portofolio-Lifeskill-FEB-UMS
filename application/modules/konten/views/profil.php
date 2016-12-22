<?php
    $ci = &get_instance();
    $level = $ci->session->userdata('level');
?>

<div class="col-md-9">
  <div class="well well-content">
    <div class="profile-content">
      <h4 class="box-title"><i class="fa fa-user"></i> Profil Mahasiswa</h4>
      <hr>
      <div style="margin-bottom: 40px">
      </div>
      <!-- form start -->
      <form class="form-horizontal" role="form" id="form">
        <div class="col-md-12">   
          <div id="msg-user">
          </div>
          <?php if ($this->uri->segment(2) == "me"): ?>
            <?php if($level != 'superadmin'): ?>
              <?php $page = 'profil'; ?>
              <input type="hidden" class="form-control" value="<?=$getdata->uid_mhs?>" name="kode" id="kode">
              <div class="form-group">
                <label class="col-sm-2 control-label">NIM <?=ucwords($level)?></label>
                <div class="col-sm-10">
                    <input type="text" maxlength="20" value="<?=$getdata->nim?>" class="form-control" placeholder="NIM <?=ucwords($level)?>" name="nim" id="nim">
                </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-2 control-label">Nama <?=ucwords($level)?></label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?=$getdata->nama_mhs?>" placeholder="Nama <?=ucwords($level)?>" name="nama_mhs" id="nama_mhs">
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-2 control-label">Email <?=ucwords($level)?></label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?=$getdata->email?>" placeholder="Email <?=ucwords($level)?>" name="email" id="email">
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-2 control-label">No. Handphone</label>
                  <div class="col-sm-10">
                      <input type="text" maxlength="12" class="form-control" value="<?=$getdata->no_hp?>" placeholder="No. Handphone" name="no_hp" id="no_hp">
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-2 control-label">Tempat Lahir</label>
                  <div class="col-sm-10">
                      <input type="text" maxlength="12" class="form-control" value="<?=$getdata->tempat_lahir?>" placeholder="Tempat Lahir" name="tempat_lahir" id="tempat_lahir">
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-2 control-label">Tanggal Lahir</label>
                  <div class="col-sm-10">
                      <input type="text" maxlength="12" class="form-control datetime" value="<?=$getdata->tgl_lahir?>" placeholder="Tanggal Lahir" name="tgl_lahir" id="tgl_lahir">
                  </div>
              </div>
            <?php endif; ?>
          <?php else: ?>
            <?php $page = 'akun'; ?>
            <input type="hidden" class="form-control" value="<?=$getdata->uid_mhs?>" name="kode" id="kode">
            <div class="form-group">
                <label class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" maxlength="20" required="required" value="<?=$getdata->username?>" class="form-control" placeholder="Username" name="st_input1" id="st_input1">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Password Lama</label>
                <div class="col-sm-10">
                    <input type="password" required="required" class="form-control" placeholder="Password Lama" name="st_input2" id="st_input2">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Password Baru</label>
                <div class="col-sm-10">
                    <input type="password" required="required" class="form-control" placeholder="Password Baru" name="st_input3" id="st_input3">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Ulangi Password Baru</label>
                <div class="col-sm-10">
                    <input type="password" required="required" class="form-control" placeholder="Ulangi Password Baru" name="st_input4" id="st_input4">
                </div>
            </div>
          <?php endif; ?>
          <div class="form-group">
              <label class="col-sm-2 control-label">&nbsp;</label>
              <div class="col-sm-10">
                <a href="<?=base_url()?>">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </a>
                <button type="button" id="btnUser" onclick="save('<?=base_url()?><?=$this->uri->segment(1)?>/update?page=<?=$page?>')" class="btn btn-primary">Update</button>
              </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- END col-md-9 -->


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