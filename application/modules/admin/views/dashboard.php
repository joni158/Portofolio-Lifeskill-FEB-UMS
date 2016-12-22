<?php
    $ci = &get_instance();
    $level = $ci->session->userdata('level');
?>

<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Mahasiswa</span>
                <span class="info-box-number"><?=$mahasiswa?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <?php if ($level != 'pembimbing'): ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Dosen</span>
                    <span class="info-box-number"><?=$dosen?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-newspaper-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Kelas Bimbingan</span>
                    <span class="info-box-number"><?=$bimbingan?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    <?php endif ; ?>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-cubes"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Rubrik</span>
                <span class="info-box-number"><?=$rubrik?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-sm-12">
        <div class="card-box">
            <h2 class="m-t-0"><b>Selamat datang di aplikasi <?=$ci->site_name()?>!</b></h2>
            <p class="text-muted m-b-20 font-14">
                Aplikasi ini berfungsi untuk membantu penerapan mata kuliah lifeskill di Fakultas Ekonomi Dan Bisnis berbasis web dengan sistem terkomputerisasi.
            </p>
            <hr>
        </div>
    </div>
</div>