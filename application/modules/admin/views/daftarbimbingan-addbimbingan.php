<?php
    $ci = &get_instance();
    $level = $ci->session->userdata('level');
?>

<?php $current_year = (int)substr($current_semester, 0, 4); ?>

<?php $three_previous_year = $current_year - 3; ?>
<?php $three_next_year = $current_year + 3; ?>

<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-file-text"></i> Form Data Bimbingan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="<?=base_url()?>admin/<?=$this->uri->segment(2)?>/save?act=save&st=bimbingan" id="form" class="form-horizontal" method="post">
                <div class="box-body">

                    <div id="loadingDiv"></div>

                    <div class="col-md-6">
                        <input type="hidden" name="step" value="bimbingan">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Kelas</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="st_kelas" id="st_kelas">
                                    <option disabled="">-- Pilih Kelas --</option>
                                    <?php foreach ($daftarkelas as $key => $value) { ?>
                                        <option value="<?=$value->uid_kelas?>"><?=$value->nama_kelas?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Jurusan</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="st_jurusan" id="st_jurusan">
                                    <option disabled="">-- Pilih Jurusan --</option>
                                    <?php foreach ($daftarjurusan as $key => $value) { ?>
                                        <option value="<?=$value->uid_jurusan?>"><?=$value->nama_jurusan?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Pembimbing</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="st_pembimbing" id="st_pembimbing">
                                    <option disabled="">-- Pilih Pembimbing --</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Semester</label>
                            <div class="col-sm-8">
                                <select class="pull-right form-control" id="st_semester" name="st_semester" title="Pilih Semester">
                                    <option value="" disabled>-- Pilih Semester --</option>
                                    
                                    <?php for ($year=$three_previous_year; $year<=$three_next_year; $year++) { ?>
                                        <?php $next_year = $year + 1; ?>
                                        <?php $smtval_1 = $year. '1' ?>
                                        <?php $smtval_2 = $year. '2' ?>
                                        <option value="<?=$smtval_1?>" <?php if ($current_semester == $smtval_1): echo "selected"; endif; ?>>Semester <?=$year?>/<?=$next_year?> Gasal</option>
                                        <option value="<?=$smtval_2?>" <?php if ($current_semester == $smtval_2): echo "selected"; endif; ?>>Semester <?=$year?>/<?=$next_year?> Genap</option>
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
                                <button type="submit" name="submit" class="btn btn-primary">Pilih Mahasiswa</button>
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

    $(document).ready(function(){
      var st_jurusan = $('#st_jurusan').val();
      get_dosen(st_jurusan);
    });

    $('#st_jurusan').change(function(){
      get_dosen(this.value);
    });

    function get_dosen(uid_jurusan) {
      $('#loadingDiv').attr('style', 'display: block');
      $.ajax({
            url: "<?=base_url()?><?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/get-dosen",
            type: "POST",
            dataType: "text",
            async:false,
            data: {
                "uid_jurusan":uid_jurusan,
            },
            success: function(data){
                $("#st_pembimbing").html(data);
                $('#loadingDiv').attr('style', 'display: none');
            }
        });
    }


</script>