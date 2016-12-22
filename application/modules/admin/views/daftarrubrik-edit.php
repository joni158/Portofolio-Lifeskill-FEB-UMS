<?php 

  $level_kegiatan = $this->input->get('p');

  if ($level_kegiatan == 'kategori' ){
    $level = 1;
    $level_name = 'Kategori';
  } elseif ($level_kegiatan == 'tingkatan') {
    $level = 2;
    $level_name = 'Tingkatan';
    $iden_kategori = 'st_parent';
    $uid_kategori = $getdata->parent;
  } else {
    $level = 3;
    $level_name = 'Posisi';
    $iden_kategori = 'st_kategori';
    $uid_kategori = $uid_rubrik_kategori;
  }

?>

<style>
  #atribute{
    display: none;
  }
</style>

<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-file-text"></i> Form Daftar Kategori</h3>
            </div>
            <!-- /.box-header -->
            
            <form action="#" id="form" class="form-horizontal">
                <div class="box-body">

                    <div id="loadingDiv"></div>

                    <div class="col-md-6">

                      <?php if ($level_kegiatan == 'kategori' ) : ?>
                        <input type="hidden" name="st_parent" value="0">
                      <?php endif; ?>
                      
                      <input type="hidden" name="st_level" value="<?=$level?>">
                      <input type="hidden" name="kode" value="<?=$getdata->uid_rubrik?>">

                      <?php if ($level_kegiatan == 'tingkatan' ) : ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Kategori</label>
                            <div class="col-sm-8">
                              <select class="form-control" required="required" name="<?=$iden_kategori?>" id="<?=$iden_kategori?>">
                                <option disabled="">-- Pilih Kategori --</option>
                                <?php foreach ($levelkategori as $kategori) { ?>
                                    <option value="<?=$kategori->uid_rubrik?>" <?php if ($kategori->uid_rubrik == $uid_kategori): echo "selected";endif;?>><?=$kategori->kegiatan?></option>
                                <?php } ?>
                              </select>
                            </div>
                        </div>
                      <?php endif; ?>

                      <?php if ($level_kegiatan == 'posisi' ) : ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Kategori</label>
                            <div class="col-sm-8">
                              <select class="form-control" required="required" name="<?=$iden_kategori?>" id="<?=$iden_kategori?>">
                                <option disabled="">-- Pilih Kategori --</option>
                                <?php foreach ($levelkategori as $kategori) : ?>
                                  <?php $cek_child = $this->admin->count_where('s_table6', array('parent'=>$kategori->uid_rubrik, 'child'=>1)); ?>
                                  <?php if ($cek_child > 0) : ?>
                                    <option value="<?=$kategori->uid_rubrik?>" <?php if ($kategori->uid_rubrik == $uid_kategori): echo "selected";endif;?>><?=$kategori->kegiatan?></option>
                                  <?php endif; ?>
                                <?php endforeach; ?>
                              </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Tingkatan</label>
                            <div class="col-sm-8">
                              <select class="form-control" name="st_parent" id="st_parent">
                                  <option disabled="">-- Pilih Tingkatan --</option>
                              </select>
                            </div>
                        </div>
                      <?php endif; ?>

                      <div class="form-group">
                          <label class="col-sm-4 control-label">Nama <?=$level_name?></label>
                          <div class="col-sm-8">
                              <input type="text" class="form-control" placeholder="Nama <?=$level_name?>" name="st_input1" value="<?=$getdata->kegiatan?>">
                          </div>
                      </div>

                      <?php if ($level_kegiatan != 'posisi' ) : ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Sublevel</label>
                            <div class="col-sm-8">
                              <select class="form-control" name="st_child" id="st_child" onchange="getAtributOne(this.value)">
                                <option value="1" <?php if ($getdata->child == "1"): echo "selected";endif;?>>Ya</option>
                                <option value="0" <?php if ($getdata->child == "0"): echo "selected";endif;?>>Tidak</option>
                              </select>
                            </div>
                        </div>
                      <?php else: ?>
                        <input type="hidden" name="st_child" id="st_child" value="0">
                      <?php endif; ?>

                    <?php if ($level_kegiatan != 'posisi' ) : ?>
                      <div id="atribute">
                    <?php endif; ?>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Poin Kategori</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" placeholder="Poin Kategori" name="st_input2" id="st_input2" value="<?=$getdata->poin?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Satuan Kategori</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Satuan Kategori" name="st_input3" id="st_input3" value="<?=$getdata->satuan?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Bukti Kategori</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Bukti Kategori" name="st_input4" id="st_input4" value="<?=$getdata->bukti?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Softskill</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Softskill" name="st_input5" id="st_input5" value="<?=$getdata->softskill?>">
                            </div>
                        </div>
                    <?php if ($level_kegiatan != 'posisi' ) : ?>
                      </div>
                    <?php endif; ?>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">&nbsp;</label>
                            <div class="col-sm-8">
                              <a href="<?=base_url('admin')?>/<?=$this->uri->segment(2)?>/view?p=<?=$level_kegiatan?>">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                              </a>
                                <button type="button" id="btnSave" onclick="save('<?=base_url()?>admin/<?=$this->uri->segment(2)?>/save?act=update')" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="box-footer" style="text-align: right">
                </div> -->
            </form>
            
        </div>
    </div>
</div>

<?php if ($level_kegiatan == 'posisi'): ?>

  <script type="text/javascript">
    
    $(document).ready(function(){
      var st_kategori = $('#st_kategori').val();
      get_tingkatan(st_kategori);
      $('#st_parent').val(<?=$getdata->parent?>);
    });

    $('#st_kategori').change(function(){
      get_tingkatan(this.value);
    });

    function get_tingkatan(uid) {
      $('#loadingDiv').attr('style', 'display: block');
      $.ajax({
            url: "<?=base_url()?><?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/get-tingkatan",
            type: "POST",
            dataType: "text",
            async:false,
            data: {
                "kode_kategori":uid,
                "page":"<?=$this->uri->segment(3)?>"
            },
            success: function(data){
                $("#st_parent").html(data);
                $('#loadingDiv').attr('style', 'display: none');
            }
        });
    }

  </script>

<?php endif; ?>

<script type="text/javascript">

  getAtributOne(<?=$getdata->child?>);

  function getAtributOne(elem){
     if(elem == 0){
       var uid_rubrik = <?=$getdata->uid_rubrik?>;
       $.ajax({
            url: "<?=base_url()?><?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/is-child",
            data:{id:uid_rubrik},
            dataType:"JSON",
            type: "POST",
            success: function(data) {
              if(data["child"] == 1) {
                  swal({
                      title: "Gagal !",
                      text: "Kategori ini mempunyai sublevel, silahkan hapus terlebih dahulu sublevel kategori ini.",
                      timer: 3000,
                      showConfirmButton: false
                    });
                  
                  $("#st_child").val('1');

               }else{
                document.getElementById('atribute').style.display = "block";
               }
            },
        });
     } else {
       document.getElementById('atribute').style.display = "none";
       $('input#st_input2').val('');
       $('input#st_input3').val('');
       $('input#st_input4').val('');
       $('input#st_input5').val('');
     }
  }

  function getauto(uid, column) {
    $('#'+uid).autocomplete({
        source: function(request, response){
            $.ajax({
                url:"<?=base_url()?><?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/get-data-auto",
                dataType:"json",
                data:{
                  q:request.term,
                  column:column
                },
                success: function(data){
                    response(data);
                }
            });
        },
        minLength:1,
    });
  }

  getauto('st_input3', 'satuan');
  getauto('st_input4', 'bukti');
  getauto('st_input5', 'softskill');

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
            swal("Succes!", "Pengubahan data berhasil!", "success");
            $("#btnSave").button('reset');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal("Terjadi kesalahan", "Terjadi kesalahan saat mengubah data:)", "error");
            $("#btnSave").button('reset');
        }

    });
  }
  

</script>