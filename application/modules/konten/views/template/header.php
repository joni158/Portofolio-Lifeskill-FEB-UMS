<?php 
    $ci = &get_instance();
?>

<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin-part/plugins/dataTables/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>plugins/sweetalert/sweetalert.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin-part/plugins/datetimepicker/jquery.datetimepicker.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/style-front.css">
    <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- script references -->
    <script src="<?=base_url()?>assets/js/jquery-2.1.4.min.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>assets/admin-part/plugins/dataTables/js/jquery.dataTables.min.js"></script>
    <script src="<?=base_url()?>assets/admin-part/plugins/dataTables/js/dataTables.bootstrap.min.js"></script>
    <script src="<?=base_url('assets/admin-part/plugins/datetimepicker/jquery.datetimepicker.min.js');?>"></script>
    <script src="<?=base_url('plugins/sweetalert/sweetalert.min.js');?>"></script>

    <title><?php if ($this->uri->segment(1)): echo ucwords(str_replace("-", " ", $this->uri->segment(1))) . " - " ; else: echo "Beranda" . " - "; endif; ?><?=$ci->site_name();?></title>

    <style type="text/css">
        body{
            font-size: 12px;
        }
        th{
            text-align: center;
        }

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

    </head>

    <body class="hold-transition skin-blue sidebar-mini">

        <div class="navbar navbar-fixed-top navbar-inverse">
            <div class="container">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">
                <table>
                  <tr>
                    <td>
                      <a href="<?=base_url()?>">
                        <img src="<?=base_url()?>assets/images/logo-hd.png" class="img-responsive" width="50" height="auto">
                      </a>
                    </td>
                    <td style="padding: 5px;">
                      <a href="<?=base_url()?>" style="color:#fff; text-decoration:none">
                        LIFESKILL FEB
                      </a>
                    </td>
                  </tr>
                </table>
              </a>

              <ul class="nav navbar-nav navbar-right">
                  <li class="animate"><a href="#"><i class="fa fa-user"></i> <?=$ci->session->userdata('username')?></a></li>
                  <li class="animate"><a href="<?=base_url('auth/logout')?>"><i class="fa fa-sign-out"></i> Logout</a></li>
              </ul>

            </div><!-- /.container -->
        </div><!-- /.navbar -->

        <!-- HEADER
        =================================-->

        <div class="jumbotron text-center">
            <div class="container">
              <div class="row">
                <div class="col col-lg-12 col-sm-12">
                  <p>PORTOFOLIO LIFESKILL FAKULTAS EKONOMI DAN BISNIS</p>
                  <P>UNIVERSITAS MUHAMMADIYAH SURAKARTA</P>
                </div>
              </div>
            </div>
        </div>
        <!-- /header container-->

        <div class="container">

            <div class="row content">
                <div class="col-lg-12">

                    <ol class="breadcrumb" style="margin-top:20px">
                        <li <?php if ($this->uri->segment(1) == ''): echo "class='active'"; endif; ?>><i class="fa fa-home"></i> Home</li>
                        <?php if ($this->uri->segment(1)): ?>
                            <li <?php if ($this->uri->segment(2) == ''): echo "class='active'"; endif; ?>><?=ucwords($this->uri->segment(1))?></li>
                        <?php endif; ?>
                        <?php if ($this->uri->segment(2)): ?>
                            <li <?php if ($this->uri->segment(3) == ''): echo "class='active'"; endif; ?>><?=ucwords($this->uri->segment(2))?></li>
                        <?php endif; ?>
                    </ol>

                    <div class="row">
                        <div class="col-md-3 sidebar">
                            <div class="well well-sidebar">
                                <div class="profile-sidebar">
                                    <!-- SIDEBAR MENU -->
                                    <div class="profile-usermenu">
                                        <ul class="nav">
                                            <li class="treeview <?php if ($this->uri->segment(1) == ""): echo "active";endif;?>">
                                                <a href="<?=base_url()?>">
                                                    <i class="fa fa-home"></i> Home
                                                </a>
                                            </li>
                                            <li class="treeview <?php if ($this->uri->segment(1) == "kegiatan" && $this->uri->segment(2) == "add"): echo "active";endif;?>">
                                                <a href="<?=base_url()?>kegiatan/add">
                                                    <i class="fa fa-edit"></i> Isi Kegiatan
                                                </a>
                                            </li>
                                            <li class="treeview <?php if (($this->uri->segment(1) == "kegiatan" && $this->uri->segment(2) == "") || ($this->uri->segment(1) == "kegiatan" && $this->uri->segment(2) == "edit") ): echo "active";endif;?>">
                                                <a href="<?=base_url()?>kegiatan">
                                                    <i class="fa fa-calendar"></i></i> Lihat Kegiatan
                                                </a>
                                            </li>
                                            <li class="treeview <?php if ($this->uri->segment(1) == "profil" && $this->uri->segment(2) == "me"): echo "active";endif;?>">
                                                <a href="<?=base_url()?>profil/me">
                                                    <i class="fa fa-user"></i> Profil Saya
                                                </a>
                                            </li>
                                            <li class="treeview <?php if ($this->uri->segment(1) == "profil" && $this->uri->segment(2) == ""): echo "active";endif;?>">
                                                <a href="<?=base_url()?>profil">
                                                    <i class="fa fa-wrench"></i> <span>Akun</span>
                                                </a>
                                            </li>
                                        </ul>

                                    </div>
                                    <!-- END MENU -->
                                </div>
                            </div>
                        </div>
                        <!-- END col-md-3 -->
