<?php
    $ci = &get_instance();
    $level = $ci->session->userdata('level');
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="table-detail" cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 3%">No</th>
                            <th style="width: 10%">NIDN</th>
                            <th style="width: 10%">Nama Kaprodi</th>
                            <th style="width: 15%">Jurusan</th>
                            <th style="width: 7%;text-align: center;">Aksi</th>
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
                url: "<?=base_url()?>admin/<?=$this->uri->segment(2)?>/get",
                type: "get",
            }
        });

    }
    
</script>
