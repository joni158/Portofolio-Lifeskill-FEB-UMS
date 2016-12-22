<?php
  $ci = &get_instance();
  $level = $ci->session->userdata('level');
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-sm-9">
                  <h4><i class="fa fa-user"></i> Data Mahasiswa</h4>
                  <table class="table table-bordered table-hover" id="identity">
                      <tbody>
                          <tr>
                              <td>Nama Mahasiswa</td>
                              <td>:</td>
                              <td><?=$getdata->nama_mhs?></td>
                          </tr>
                          <tr>
                              <td>Nomor Induk Mahasiswa</td>
                              <td>:</td>
                              <td><?=$getdata->nim?></td>
                          </tr>
                          <tr>
                              <td>Tempat dan Tanggal Lahir</td>
                              <td>:</td>
                              <td><?=$getdata->tempat_lahir?>, <?=$getdata->tgl_lahir?></td>
                          </tr>
                          <tr>
                              <td>Program Studi</td>
                              <td>:</td>
                              <td><?=$getdata->nama_jurusan?></td>
                          </tr>
                      </tbody>
                  </table>
                </div>
                
                <div class="col-sm-12" style="margin-top: 10px;">
                  <h4><i class="fa fa-file"></i> Daftar Kegiatan</h4>
                  <table id="table-detail" cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-striped" width="100%">
                      <thead>
                          <tr>
                              <th style="width: 3%">No.</th>
                              <th style="width: 10%">Nama Kegiatan</th>
                              <th style="width: 4%">Poin</th>
                              <th style="width: 5%">Bukti</th>
                              <th style="width: 10%">Softskill</th>
                              <th style="width: 4%">Status</th>
                              <?php if ($level == 'pembimbing'): ?>
                                <th style="width: 7%"><center>Aksi</center></th>
                              <?php endif; ?>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                          <tr>
                              <th colspan="2" style="text-align: center">Total</th>
                              <th></th>
                              <?php if ($level == 'pembimbing'): ?>
                                <th colspan="4"></th>
                              <?php else: ?>
                                <th colspan="3"></th>
                              <?php endif; ?>
                          </tr>
                      </tfoot>
                  </table>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer" style="text-align: right">
                <a href="<?=base_url('admin')?>/<?=$this->uri->segment(2)?>">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                </a>
                <a href="<?=base_url('admin')?>/<?=$this->uri->segment(2)?>/pdf?id=<?=$getdata->uid_kelasajar?>" target="_blank">
                  <button type="button" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Print</button>
                </a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    cari();
    
    function cari() {
        var table = $('#table-detail').DataTable({
            "paging": false,
            destroy: true,
            info: false,
            "searching": false,
            "processing": true,
            "serverSide": false,
            scrollY: '60vh',
            scrollCollapse: true,
            ajax: {
                url: "<?=base_url()?>admin/<?=$this->uri->segment(2)?>/get-kegiatan",
                type: "post",
                "data": function(d) {
                    d.uid_kelasajar = <?=$getdata->uid_kelasajar?>
                }
            },
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
    
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                for(i=2; i<3; i++) {
                    total_col = api.column(i).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                    $( api.column(i).footer() ).html(total_col);  
                }
            }
        });

    }

    function verification(url) {
  	    $.ajax({
  	        url: url,
  	        type: "POST",
  	        dataType: "JSON",
  	        success: function(data) {
                if (data['action'] == 'verify') {
                  swal("Succes!", "Verifikasi data kegiatan berhasil !", "success"); 
                } else {
                  swal("Succes!", "Verifikasi data kegiatan dibatalkan !", "success");
                }
                cari();
  	        },
  	        error: function(jqXHR, textStatus, errorThrown) {
  	            swal("Terjadi kesalahan", "Terjadi kesalahan saat memverifikasi data kegiatan:)", "error");
  	        }
  	    });
  	}


</script>
