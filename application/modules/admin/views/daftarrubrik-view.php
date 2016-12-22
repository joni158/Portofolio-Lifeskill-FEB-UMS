<?php 

  $level = $this->input->get('p');
  if ($level == 'kategori') {
    $placeholder_nama = 'Nama Kategori..';
  } elseif ($level == 'tingkatan') {
    $placeholder_nama = 'Nama Tingkatan..';
  } else {
    $placeholder_nama = 'Nama Posisi..';
  }

?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-file-text"></i> Level <?=ucwords($level)?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                
                <form id="form" method="post">
                    <div class="pull-Left col-sm-12" style="margin-bottom: 5px;">
                        <div class="col-sm-2">
                            <select id="st_softskill" name="st_softskill" class="form-control input-sm">
                                <option value="">Semua Softskill</option>
                                <?php foreach ($daftarsoftskill as $key => $value) { ?>
                                  <?php if($value->softskill == ''): ?>
                                    <option value="empty"><i>-</i></option>
                                  <?php else: ?>  
                                    <option value="<?=$value->softskill?>"><?=$value->softskill?></option>
                                  <?php endif;?>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <select id="st_satuan" name="st_satuan" class="form-control input-sm">
                                <option value="">Semua Satuan</option>
                                <?php foreach ($daftarsatuan as $key => $value) { ?>
                                  <?php if($value->satuan == ''): ?>
                                    <option value="empty"><i>-</i></option>
                                  <?php else: ?>  
                                    <option value="<?=$value->satuan?>"><?=$value->satuan?></option>
                                  <?php endif;?>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <?php if($level != 'kategori'): ?>
                          <div class="col-sm-2">
                            <select id="st_kategori" name="st_kategori" class="form-control input-sm" onchange="get_tingkatan(this.value)">
                                <option value="">Semua Kategori</option>
                                <?php foreach ($daftarkategori as $key => $value) { ?>
                                  <?php if($level == 'posisi'): ?>
                                    <?php $cek = $this->admin->count_where('s_table6', array('parent'=>$value->uid_rubrik, 'child'=>1)); ?>
                                    <?php if($cek > 0): ?>
                                      <option value="<?=$value->uid_rubrik?>"><?=$value->kegiatan?></option>
                                    <?php endif; ?>
                                  <?php else : ?>
                                    <option value="<?=$value->uid_rubrik?>"><?=$value->kegiatan?></option>
                                  <?php endif; ?>
                                <?php } ?>
                            </select>
                          </div>
                        <?php endif; ?>

                        <?php if($level == 'posisi'): ?>
                          <div class="col-sm-2">
                            <select id="st_tingkatan" name="st_tingkatan" class="form-control input-sm">
                                <option value="">Semua Tingkatan</option>
                            </select>
                          </div>
                        <?php endif; ?>

                        <div class="col-sm-2">
                            <input type="text" name="st_nama" id="st_nama" class="form-control year input-sm" placeholder="<?=$placeholder_nama?>">
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-info btn-sm" onclick="cari()" ><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                </form>
                <table id="table-detail" cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 3%">No</th>
                            <th style="width: 15%">Kategori</th>
                            <?php if ($level != 'kategori'): ?>
                              <th style="width: 15%">Tingkatan</th>
                            <?php endif; ?>
                            <?php if ($level == 'posisi'): ?>
                              <th style="width: 15%">Posisi</th>
                            <?php endif; ?>
                            <th style="width: 3%">Poin</th>
                            <th style="width: 7%">Satuan</th>
                            <th style="width: 7%">Bukti</th>
                            <th style="width: 10%;">Softskill</th>
                            <th style="width: 10%;text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

<script type="text/javascript">
    
    function cari() {
        var table = $('#table-detail').DataTable({
            "paging": false,
            destroy: true,
            info: false,
            "searching": false,
            "processing": true,
            "serverSide": false,
            scrollY: '60vh',
            "scrollX": true,
            scrollCollapse: true,
            ajax: {
                url: "<?=base_url()?>admin/<?=$this->uri->segment(2)?>/get",
                type: "post",
                "data": function(d) {
                    d.st_softskill = $("#st_softskill").val();
                    d.st_satuan = $("#st_satuan").val();
                    d.st_nama = $("#st_nama").val();
                    d.st_level = "<?=$level?>";
                    <?php if ($level != 'kategori'): ?>
                      d.st_kategori = $("#st_kategori").val();
                    <?php endif; ?>
                    <?php if ($level == 'posisi'): ?>
                      d.st_tingkatan = $("#st_tingkatan").val();
                    <?php endif; ?>
                }
            }
        });

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
                        cari();
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

    function get_tingkatan(uid) {
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
                $("#st_tingkatan").html(data);
            }
        });
    }

</script>
