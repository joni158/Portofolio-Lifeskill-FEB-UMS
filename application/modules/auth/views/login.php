<?php 
    $ci = &get_instance();
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php if ($this->uri->segment(1)): echo ucwords(str_replace("-", " ", $this->uri->segment(1))) . " - " ; else: echo "Beranda" . " - "; endif; ?><?=$ci->site_name();?></title>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=base_url()?>assets/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>plugins/dataTables/css/dataTables.bootstrap.min.css">

        <style>
            .wrap { -webkit-box-shadow: #999999 0 0 10px 0; background: #FFFFFF url('/views/images/twh.jpg')  scroll no-repeat 20px 20px; border-radius: 8px 8px 8px 8px; box-shadow: #999999 0 0 10px 0; position: absolute; top: 50%; left: 50%; margin: -200px 0 0 -200px; width: 400px; z-index: 1000; color: #333333; }
            .wrap h2 { font-size: 26px; line-height: 36px; margin: 25px 20px 0 0px; font-weight: bold; }
            .wrap h4 { font-size: 14px; color: #999999; line-height: 18px; margin: -3px 0 30px 0px; }
            .wrap .alert { margin: 20px; text-align: center; }
            .wrap .login { background-color: #EEEEEE; border-radius: 6px 6px 6px 6px; padding: 10px; margin: 5px 20px 20px; overflow: hidden; }
            .wrap .login .email { margin-top: 5px; }
            .wrap .login .pw { margin-top: 55px; }
            .wrap .login .remember { margin: 15px 0 0 155px }
            .wrap .login label { float: left; font-weight: bold; font-size: 13px; margin: 10px 5px; width: 80px; }
            .wrap .login label.checkbox { font-size: 13px; font-weight: normal; width: 100%; }
            .wrap .login .field-input { background-color: #DDDDDD; border-radius: 3px 3px 3px 3px; float: right; padding: 5px; }
            .wrap .login .field-input .control-group { margin: 0; }
            .wrap .login .field-input .control-group .input-prepend { margin-bottom: 0 !important; }
            .wrap .login .field-input input { margin: 0; width: 190px !important; }
            .wrap .submit { margin-bottom: 15px; }
            .wrap .submit .forget { float: left; font-size: 13px; text-decoration: none; margin-left: 20px; }
            .wrap .submit .btn { margin-left: 300px; }
            #alerror{
                display: none;
            }
        </style>

        <!-- Javascript  -->
        <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
    </head>
    <body>
    <div class="wrap">
        <table>
            <tr>
                <td style="width: 25%; text-align: center;">
                    <img src="<?=base_url()?>assets/images/logo-hd.png" alt="" style="max-width: 75%">
                </td>
                <td style="width: 75%">
                    <h2>Lifeskill FEB</h2>
                    <h4>Silahkan masuk untuk memulai sesi anda</h4>
                </td>
            </tr>
        </table>
        <form method="post" action="<?=base_url('auth/cek_login')?>" id="frmLogin">
            <?php $msg = $this->session->flashdata('msg') ?>
            <?php if ($msg): ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>
            <div class="login">
                <div class="email">
                    <label for="username">Username</label>
                    <div class="field-input">
                        <div class="control-group">
                            <div class="input-prepend">
                                <span class="add-on"><i class="icon-envelope"></i></span>
                                <input type="text" id="username" name="username" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pw">
                    <label for="password">Password</label>
                    <div class="field-input">
                        <div class="control-group">
                            <div class="input-prepend">
                                <span class="add-on"><i class="icon-lock"></i></span>
                                <input type="password" id="password" name="password" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="remember">
                    <label class="checkbox">
                        <input type="checkbox" value="1" name="remember">
                        Ingatkan saya dikomputer ini
                    </label>
                </div>
            </div>
            <div class="submit">
                <!-- <a class="forget" href="/acc/passwd">Lupa password</a> -->
                <button class="btn btn-primary" type="submit"><i class="fa fa-sign-in"></i> Login</button>
            </div>
        </form>
    </div>
    </body>
</html>
