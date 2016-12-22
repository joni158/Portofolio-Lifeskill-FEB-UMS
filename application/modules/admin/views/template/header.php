<?php
    $ci = &get_instance();
    $level = $ci->session->userdata('level');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$ci->site_name();?><?php if ($this->uri->segment(1)): echo " | ". ucwords(str_replace("-", " ", $this->uri->segment(1))); endif; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="<?=base_url()?>favicon.ico">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin-part/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin-part/css/skin-blue.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin-part/plugins/dataTables/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin-part/plugins/datetimepicker/jquery.datetimepicker.css">
    <link rel="stylesheet" href="<?=base_url()?>plugins/sweetalert/sweetalert.css">
    <link rel="stylesheet" href="<?=base_url()?>plugins/icheck/all.css"/>
    <link href="http://code.google.com/apis/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?=base_url()?>assets/admin-part/plugins/selectize/selectize.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/jquery-ui-1.9.2.custom.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin-part/css/custom.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">

        .ui-menu{
            border-radius: 0px;
            padding: 0px;
        }
        .ui-menu .ui-menu-item a{
            border-radius: 0px;
            margin: 0px;
            font-size: 12px;
        }

        button[aria-expanded=true] .fa-plus {
           display: none;
        }
        button[aria-expanded=false] .fa-minus {
           display: none;
        }
        .image-upload > input{
            display: none;
        }

    </style>

    <script src="<?=base_url()?>assets/js/jquery-2.1.4.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>assets/admin-part/plugins/dataTables/js/jquery.dataTables.min.js"></script>
    <script src="<?=base_url()?>assets/admin-part/plugins/dataTables/js/dataTables.bootstrap.min.js"></script>
    <script src="<?=base_url('/assets/admin-part/plugins/selectize/selectize.min.js');?>"></script>
    <script src="<?=base_url('/assets/admin-part/plugins/datetimepicker/jquery.datetimepicker.min.js');?>"></script>
    <script src="<?=base_url('/plugins/sweetalert/sweetalert.min.js');?>"></script>
    <script src="<?=base_url()?>plugins/icheck/icheck.min.js"></script>
    <script src="<?=base_url()?>assets/admin-part/js/app.min.js"></script>
    <script src="<?=base_url()?>plugins/maskedinput/jquery.maskedinput.min.js"></script>

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="<?=base_url()?>admin" class="logo">
                <span class="logo-mini">UMS</span>
                <span class="logo-lg"><?=$ci->site_name();?></span>
                <!-- <span class="logo-mini"><img src="<?=base_url()?>assets/admin-part/img/sidesi-logo-small.png"></span> -->
                <!-- <span class="logo-lg"><img src="<?=base_url()?>assets/admin-part/img/sidesi-logo-1.png"></span> -->
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                      <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <!-- The user image in the navbar-->
                            <img src="<?=base_url()?>assets/images/user.png" class="user-image" alt="User Image">
                              <!-- hidden-xs hides the username on small devices so only the image appears. -->
                          <span class="hidden-xs"><?=$this->session->userdata('username')?></span>
                        </a>
                        <ul class="dropdown-menu">
                          <!-- The user image in the menu -->
                          <li class="user-header">
                            <img src="<?=base_url()?>assets/images/user.png" class="img-circle" alt="User Image">
                            <p>
                              <?=$this->session->userdata('username')?>                  <small><?=ucwords($this->session->userdata('level'))?></small>
                            </p>
                          </li>
              
                          <!-- Menu Footer-->
                          <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?=base_url()?>admin" class="btn btn-default btn-flat">Dashboard</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?=base_url('auth')?>/logout" class="btn btn-default btn-flat">Sign out</a>                  <!--<a href="#" class="btn btn-default btn-flat">Sign out</a>-->
                            </div>
                          </li>
                        </ul>
                      </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <ul class="sidebar-menu">
                    <li class="header" id="step-2">MAIN NAVIGATION</li>
                    <li class="treeview <?php if ($this->uri->segment(2) == ""): echo "active";endif;?>">
                        <a href="<?=base_url('admin')?>">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="treeview <?php if ($this->uri->segment(2) == "data-nilai"): echo "active";endif;?>">
                        <a href="#">
                            <i class="fa fa-arrow-circle-o-right"></i> <span>Data Nilai</span> <i class="fa fa-angle-left pull-right"></i>
                            <ul class="treeview-menu">
                                <li class="treeview <?php if (($this->uri->segment(2) == "data-nilai" && $this->uri->segment(3) == '') || ($this->uri->segment(2) == "data-nilai" && $this->uri->segment(3) == 'edit')): echo "active";endif;?>">
                                    <a href="<?=base_url('admin')?>/data-nilai">
                                        <i class="fa fa-circle-o"></i> <span>Lihat Semua</span>
                                    </a>
                                </li>
                            </ul>
                        </a>
                    </li>

                    <?php if($level != 'pembimbing'): ?>

                        <li class="treeview <?php if ($this->uri->segment(2) == "data-bimbingan"): echo "active";endif;?>">
                            <a href="#">
                                <i class="fa fa-arrow-circle-o-right"></i> <span>Data Bimbingan</span> <i class="fa fa-angle-left pull-right"></i>
                                <ul class="treeview-menu">
                                    <li class="treeview <?php if (($this->uri->segment(2) == "data-bimbingan" && $this->uri->segment(3) == '') || ($this->uri->segment(2) == "data-bimbingan" && $this->uri->segment(3) == 'edit')): echo "active";endif;?>">
                                        <a href="<?=base_url('admin')?>/data-bimbingan">
                                            <i class="fa fa-circle-o"></i> <span>Lihat Semua</span>
                                        </a>
                                    </li>
                                    <li class="treeview <?php if ($this->uri->segment(2) == "data-bimbingan" && $this->uri->segment(3) == 'add'): echo "active";endif;?>">
                                        <a href="<?=base_url('admin')?>/data-bimbingan/add?st=bimbingan">
                                            <i class="fa fa-circle-o"></i> <span>Tambah Data</span>
                                        </a>
                                    </li>
                                </ul>
                            </a>
                        </li>

                    <?php endif; ?>

                    <?php if($level == 'superadmin'): ?>
                    
                        <li class="treeview <?php if ($this->uri->segment(2) == "kaprodi"): echo "active";endif;?>">
                            <a href="#">
                                <i class="fa fa-arrow-circle-o-right"></i> <span>Kaprodi</span> <i class="fa fa-angle-left pull-right"></i>
                                <ul class="treeview-menu">
                                    <li class="treeview <?php if (($this->uri->segment(2) == "kaprodi" && $this->uri->segment(3) == '') || ($this->uri->segment(2) == "kaprodi" && $this->uri->segment(3) == 'edit')): echo "active";endif;?>">
                                        <a href="<?=base_url('admin')?>/kaprodi">
                                            <i class="fa fa-circle-o"></i> <span>Lihat Semua</span>
                                        </a>
                                    </li>
                                </ul>
                            </a>
                        </li>

                    <?php endif; ?>

                    <?php if($level != 'pembimbing'): ?>

                        <li class="header" id="step-2">DATA MASTER</li>

                        <li class="treeview <?php if ($this->uri->segment(2) == "data-dosen"): echo "active";endif;?>">
                            <a href="#">
                                <i class="fa fa-arrow-circle-o-right"></i> <span>Data Dosen</span> <i class="fa fa-angle-left pull-right"></i>
                                <ul class="treeview-menu">
                                    <li class="treeview <?php if (($this->uri->segment(2) == "data-dosen" && $this->uri->segment(3) == '') || ($this->uri->segment(2) == "data-dosen" && $this->uri->segment(3) == 'edit')): echo "active";endif;?>">
                                        <a href="<?=base_url('admin')?>/data-dosen">
                                            <i class="fa fa-circle-o"></i> <span>Lihat Semua</span>
                                        </a>
                                    </li>
                                    <li class="treeview <?php if ($this->uri->segment(2) == "data-dosen" && $this->uri->segment(3) == 'add'): echo "active";endif;?>">
                                        <a href="<?=base_url('admin')?>/data-dosen/add">
                                            <i class="fa fa-circle-o"></i> <span>Tambah Data</span>
                                        </a>
                                    </li>
                                </ul>
                            </a>
                        </li>

                        <li class="treeview <?php if ($this->uri->segment(2) == "data-mahasiswa"): echo "active";endif;?>">
                            <a href="#">
                                <i class="fa fa-arrow-circle-o-right"></i> <span>Data Mahasiswa</span> <i class="fa fa-angle-left pull-right"></i>
                                <ul class="treeview-menu">
                                    <li class="treeview <?php if (($this->uri->segment(2) == "data-mahasiswa" && $this->uri->segment(3) == '') || ($this->uri->segment(2) == "data-mahasiswa" && $this->uri->segment(3) == 'edit')): echo "active";endif;?>">
                                        <a href="<?=base_url('admin')?>/data-mahasiswa">
                                            <i class="fa fa-circle-o"></i> <span>Lihat Semua</span>
                                        </a>
                                    </li>
                                    <li class="treeview <?php if ($this->uri->segment(2) == "data-mahasiswa" && $this->uri->segment(3) == 'add'): echo "active";endif;?>">
                                        <a href="<?=base_url('admin')?>/data-mahasiswa/add">
                                            <i class="fa fa-circle-o"></i> <span>Tambah Data</span>
                                        </a>
                                    </li>
                                </ul>
                            </a>
                        </li>

                    <?php endif; ?>

                    <?php if($level == 'superadmin'): ?>

                        <li class="treeview <?php if ($this->uri->segment(2) == "data-jurusan"): echo "active";endif;?>">
                            <a href="#">
                                <i class="fa fa-arrow-circle-o-right"></i> <span>Data Jurusan</span> <i class="fa fa-angle-left pull-right"></i>
                                <ul class="treeview-menu">
                                    <li class="treeview <?php if (($this->uri->segment(2) == "data-jurusan" && $this->uri->segment(3) == '') || ($this->uri->segment(2) == "data-jurusan" && $this->uri->segment(3) == 'edit')): echo "active";endif;?>">
                                        <a href="<?=base_url('admin')?>/data-jurusan">
                                            <i class="fa fa-circle-o"></i> <span>Lihat Semua</span>
                                        </a>
                                    </li>
                                    <li class="treeview <?php if ($this->uri->segment(2) == "data-jurusan" && $this->uri->segment(3) == 'add'): echo "active";endif;?>">
                                        <a href="<?=base_url('admin')?>/data-jurusan/add">
                                            <i class="fa fa-circle-o"></i> <span>Tambah Data</span>
                                        </a>
                                    </li>
                                </ul>
                            </a>
                        </li>

                        <li class="treeview <?php if ($this->uri->segment(2) == "data-kelas"): echo "active";endif;?>">
                            <a href="#">
                                <i class="fa fa-arrow-circle-o-right"></i> <span>Data Kelas</span> <i class="fa fa-angle-left pull-right"></i>
                                <ul class="treeview-menu">
                                    <li class="treeview <?php if (($this->uri->segment(2) == "data-kelas" && $this->uri->segment(3) == '') || ($this->uri->segment(2) == "data-kelas" && $this->uri->segment(3) == 'edit')): echo "active";endif;?>">
                                        <a href="<?=base_url('admin')?>/data-kelas">
                                            <i class="fa fa-circle-o"></i> <span>Lihat Semua</span>
                                        </a>
                                    </li>
                                </ul>
                            </a>
                        </li>

                    <?php endif; ?>

                    <li class="treeview <?php if ($this->uri->segment(2) == "data-rubrik"): echo "active";endif;?>">
                        <a href="#">
                            <i class="fa fa-arrow-circle-o-right"></i> <span>Data Rubrik</span> <i class="fa fa-angle-left pull-right"></i>
                            <ul class="treeview-menu">
                                <li class="treeview <?php if ($this->uri->segment(2) == "data-rubrik" && $this->uri->segment(3) == "all"): echo "active";endif;?>">
                                    <a href="<?=base_url('admin')?>/data-rubrik/all">
                                        <i class="fa fa-circle-o"></i> <span>Lihat Semua</span>
                                    </a>
                                </li>

                                <?php if($level == 'superadmin'): ?>

                                    <li class="treeview <?php if (($this->uri->segment(2) == "data-rubrik" && $this->uri->segment(3) == "view") || ($this->uri->segment(2) == "data-rubrik" && $this->uri->segment(3) == "add") || ($this->uri->segment(2) == "data-rubrik" && $this->uri->segment(3) == "edit")): echo "active";endif;?>">
                                        <a href="#">
                                            <i class="fa fa-circle-o"></i> <span>Modifikasi</span> <i class="fa fa-angle-left pull-right"></i>
                                            <ul class="treeview-menu">
                                                <li class="treeview <?php if ($this->input->get('p') == "kategori"): echo "active";endif;?>">
                                                    <a href="#">
                                                        <i class="fa fa-circle-o"></i> <span>Level Kategori</span> <i class="fa fa-angle-left pull-right"></i>
                                                        <ul class="treeview-menu">
                                                            <li class="treeview <?php if ($this->uri->segment(3) == "add" && $this->input->get('p') == 'kategori'): echo "active";endif;?>">
                                                                <a href="<?=base_url('admin')?>/data-rubrik/add?p=kategori">
                                                                    <i class="fa fa-dot-circle-o"></i> <span>Tambah Data</span>
                                                                </a>
                                                            </li>
                                                            <li class="treeview <?php if (($this->uri->segment(3) == "view" && $this->input->get('p') == 'kategori') || ($this->uri->segment(3) == "edit" && $this->input->get('p') == 'kategori')): echo "active";endif;?>">
                                                                <a href="<?=base_url('admin')?>/data-rubrik/view?p=kategori">
                                                                    <i class="fa fa-dot-circle-o"></i> <span>Lihat Semua</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </a>
                                                </li>
                                                <li class="treeview <?php if ($this->input->get('p') == 'tingkatan'): echo "active";endif;?>">
                                                    <a href="#">
                                                        <i class="fa fa-circle-o"></i> <span>Level Tingkatan</span> <i class="fa fa-angle-left pull-right"></i>
                                                        <ul class="treeview-menu">
                                                            <li class="treeview <?php if ($this->uri->segment(3) == "add" && $this->input->get('p') == 'tingkatan'): echo "active";endif;?>">
                                                                <a href="<?=base_url('admin')?>/data-rubrik/add?p=tingkatan">
                                                                    <i class="fa fa-dot-circle-o"></i> <span>Tambah Data</span>
                                                                </a>
                                                            </li>
                                                            <li class="treeview <?php if (($this->uri->segment(3) == "view" && $this->input->get('p') == 'tingkatan') || ($this->uri->segment(3) == "edit" && $this->input->get('p') == 'tingkatan')): echo "active";endif;?>">
                                                                <a href="<?=base_url('admin')?>/data-rubrik/view?p=tingkatan">
                                                                    <i class="fa fa-dot-circle-o"></i> <span>Lihat Semua</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </a>
                                                </li>
                                                <li class="treeview <?php if ($this->input->get('p') == 'posisi'): echo "active";endif;?>">
                                                    <a href="#">
                                                        <i class="fa fa-circle-o"></i> <span>Level Posisi</span> <i class="fa fa-angle-left pull-right"></i>
                                                        <ul class="treeview-menu">
                                                            <li class="treeview <?php if ($this->uri->segment(3) == "add" && $this->input->get('p') == 'posisi'): echo "active";endif;?>">
                                                                <a href="<?=base_url('admin')?>/data-rubrik/add?p=posisi">
                                                                    <i class="fa fa-dot-circle-o"></i> <span>Tambah Data</span>
                                                                </a>
                                                            </li>
                                                            <li class="treeview <?php if (($this->uri->segment(3) == "view" && $this->input->get('p') == 'posisi') || ($this->uri->segment(3) == "edit" && $this->input->get('p') == 'posisi')): echo "active";endif;?>">
                                                                <a href="<?=base_url('admin')?>/data-rubrik/view?p=posisi">
                                                                    <i class="fa fa-dot-circle-o"></i> <span>Lihat Semua</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </a>
                                                </li>
                                            </ul>
                                        </a>
                                    </li>    

                                <?php endif; ?>

                            </ul>
                        </a>
                    </li>

                    <li class="header">PENGATURAN</li>

                    <li class="treeview <?php if ($this->uri->segment(2) == "profil"): echo "active";endif;?>">
                        <a href="#"><i class="fa fa-sliders"></i> <span>User Privilege</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">

                            <?php if($level == 'superadmin'): ?>

                                <li <?php if ($this->uri->segment(2) == "profil" && $this->uri->segment(3) == 'all'): echo "class='active'";endif;?>><a href="<?=base_url('admin')?>/profil/all"><i class="fa fa-circle-o"></i> Lihat Semua</a></li>

                            <?php endif; ?>

                            <?php if($level != 'superadmin'): ?>
                                <li <?php if ($this->uri->segment(2) == "profil" && $this->uri->segment(3) == "me"): echo "class='active'";endif;?>><a href="<?=base_url('admin')?>/profil/me"><i class="fa fa-circle-o"></i> Profil Saya</a></li>
                            <?php endif; ?>

                            <li <?php if ($this->uri->segment(2) == "profil" && $this->uri->segment(3) == ""): echo "class='active'";endif;?>><a href="<?=base_url('admin')?>/profil"><i class="fa fa-circle-o"></i> Akun</a></li>
                        </ul>
                    </li>

                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1><?=($this->uri->segment(2) != "") ? ucwords(str_replace("-", " ", $this->uri->segment(2))) : "Dashboard";?> <small>Control panel</small></h1>
            </section>
