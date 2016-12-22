<div class="col-md-9">
  <div class="well well-content">
    <div class="profile-content">
      <h4 class="box-title"><i class="fa fa-edit"></i> Form Kegiatan</h4>
      <hr>
      <div style="margin-bottom: 40px">
      </div>
    	<form action="#" id="form" class="form-horizontal">
    		<div class="form-group" id="kategori">
          <label class="col-sm-2 control-label">Nama Kategori</label>
          <div class="col-sm-10">
              <select class="form-control" id="levelkategori" name="st_input1">
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($daftarkategori as $key => $value) { ?>
                  <option value="<?=$value->uid_rubrik?>"><?=$value->kegiatan?></option>
                <?php } ?>
              </select>
          </div>
        </div>
        <div class="form-group" id="tingkatan">
          <label class="col-sm-2 control-label">Nama Tingkatan</label>
          <div class="col-sm-10">
              <select class="form-control" id="leveltingkatan" name="st_input2">
                <option value="">-- Pilih Tingkatan --</option>
              </select>
          </div>
        </div>
        <div class="form-group" id="posisi">
          <label class="col-sm-2 control-label">Nama Posisi</label>
          <div class="col-sm-10">
              <select class="form-control" id="levelposisi" name="st_input3">
                <option value="">-- Posisi Kosong --</option>
              </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nama Kegiatan</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Nama Kegiatan" name="st_input4" id="kegiatan">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <a href="<?=base_url()?><?=$this->uri->segment(1)?>">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </a>
            <button type="button" id="btnSave" onclick="save('<?=base_url()?><?=$this->uri->segment(1)?>/save?act=save')" class="btn btn-primary">Save</button>
          </div>
        </div>
    	</form>
    </div>
  </div>
</div>
<!-- END col-md-9 -->

<script type="text/javascript">

  $('#levelkategori').change(function(){
    get_tingkatan(this.value);
    $('#levelposisi').val('');
  });

  $('#leveltingkatan').change(function(){
    get_posisi(this.value);
  });
  
  function get_tingkatan(uid) {
    $.ajax({
        url: "<?=base_url()?><?=$this->uri->segment(1)?>/get-tingkatan",
        type: "POST",
        dataType: "text",
        async:false,
        data: {
            "uid_kategori":uid
        },
        success: function(data){
            $("#leveltingkatan").html(data);
        }
    });
  }

  function get_posisi(uid) {
    $.ajax({
        url: "<?=base_url()?><?=$this->uri->segment(1)?>/get-posisi",
        type: "POST",
        dataType: "text",
        async:false,
        data: {
            "uid_tingkatan":uid
        },
        success: function(data){
            $("#levelposisi").html(data);
        }
    });
  }

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
              swal("Succes!", "Penambahan data berhasil!", "success");
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