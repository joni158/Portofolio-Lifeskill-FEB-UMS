<?php
    $ci = &get_instance();
    $level = $ci->session->userdata('level');
    $bimbingan_id_kelas = $ci->input->get('id_kelas');
    $bimbingan_id_jurusan = $ci->input->get('id_jurusan');
    $bimbingan_id_dosen = $ci->input->get('id_dosen');
    $bimbingan_semester = $ci->input->get('semester');
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <form action="<?=base_url()?>admin/<?=$this->uri->segment(2)?>/save?act=save&st=tambahkan" id="form" class="form-horizontal" method="post">
                <input type="hidden" name="id_kelas" value="<?=$bimbingan_id_kelas?>">
                <input type="hidden" name="id_jurusan" value="<?=$bimbingan_id_jurusan?>">
                <input type="hidden" name="id_dosen" value="<?=$bimbingan_id_dosen?>">
                <input type="hidden" name="semester" value="<?=$bimbingan_semester?>">
                <div class="box-body">
                    <div class="pull-Left col-sm-12" style="margin-bottom: 5px;">                    
                        <div class="col-sm-6">
                            <a class="btn btn-info btn-sm checkbox-toggle"><i class="fa fa-square-o"></i> Select All</a>
                            <div class="btn-group">
                                <button class="btn btn-info btn-sm" type="submit" name="delete" value="delete"><i class="fa fa-check"></i> Selesai</button>
                            </div>
                        </div>
                    </div>
                    <div class="bimbingan-mahasiswa">
                        <table id="table-detail" cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-striped bimbingan-mhs" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 3%">*</th>
                                    <th style="width: 3%">No</th>
                                    <th style="width: 10%">NIM</th>
                                    <th style="width: 10%">Username</th>
                                    <th style="width: 15%">Nama Lengkap</th>
                                    <th style="width: 5%">Angkatan</th>
                                    <th style="width: 15%;">Jurusan</th>
                                    <th style="width: 10%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('.bimbingan-mhs').DataTable({
        responsive: true,
        "ordering": false,
        "lengthChange": false,
        "searching": true,
        "pageLength": 25,
        ajax: {
            url: "<?=base_url()?>admin/<?=$this->uri->segment(2)?>/get-mahasiswa",
            type: "post",
            "data": function(d) {
                d.st_jurusan = "<?=$bimbingan_id_jurusan?>";
                d.page = "addmahasiswa";
            }
        },
    });

    $(function() {
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('.bimbingan-mahasiswa input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function() {
            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $(".bimbingan-mahasiswa input[type='checkbox']").iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                //Check all checkboxes
                $(".bimbingan-mahasiswa input[type='checkbox']").iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });
    });

</script>
