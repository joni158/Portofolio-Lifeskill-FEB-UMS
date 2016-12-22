<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>LAPORAN SOFTSKILL MAHASISWA </title>

    <!-- CUSTOM STYLE CSS -->
    <style type="text/css">
    body {
        /*font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;*/
        font-family: Times New Roman;
        font-size: 13px;
        background-color: #ffffff;
    }
    th{
        text-align: center;
    }
    th,td{
         padding: 5px;
    }
    h2{
        text-align: center;
        font-size: 13px;
    }
    .kop{
        margin: 5px;
        padding: 0;
        font-size: 20px;
        font-weight: bold;
    }
    .kop2{
        margin: 5px;
        padding: 0;
        font-size: 11px;
    }
    .kop3{
        margin: 3px;
        padding: 0;
        font-size: 16px;
        font-weight: bold;
    }
    .kop4{
        margin: 3px;
        padding: 0;
        font-size: 15px;
    }
    .container{
        letter-spacing: 1px;
        font-family: Times New Roman;
        text-align: justify;
    }
    th, td, tr{
      padding: 1px 4px;
    }
    </style>
</head>

<body>
    <table class="table" style="margin-bottom:0px">
      <tr>
        <td style="margin:0px; padding:0px;">
          <img src="<?=base_url()?>assets/images/logo-hd.png" class="img-responsive" height="75" width="75">
        </td>
        <td style="text-align:center;margin:0px; padding:0px;">
          <h2 class="kop">UNIVERSITAS MUHAMMADIYAH SURAKARTA</h2>
          <h2 class="kop3">FAKULTAS EKONOMI DAN BISNIS</h2>
          <h2 class="kop2">Jl. A. Yani Tromol Pos I Pabelan Kartasura Sukoharjo, Telp. 0271 717417 ex 210, 229 Surakarta 57102</h2>
        </td>
      </tr>
    </table>
    <hr style="margin-bottom:1px; margin-top:5px">
    <hr style="margin-top:1px">

    <h2 class="kop4">Penilaian Portofolio</h2>
    <h2 class="kop4">Kecakapan Berkehidupan</h2>

    <div class="container">
        <div class="row" style="margin-top:20px">
            <div class="col-sm-12">
              <?php if ($this->input->get('s') == 'all') { ?>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Nama Mahasiswa</td>
                            <td style="text-align:center">:</td>
                            <td><b><?=$mahasiswa->nama_mahasiswa?></b></td>
                        </tr>
                        <tr>
                            <td>Nomor Induk Mahasiswa</td>
                            <td style="text-align:center">:</td>
                            <td><?=$mahasiswa->nim?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan Tanggal Lahir</td>
                            <td style="text-align:center">:</td>
                            <td><?=$mahasiswa->tempat_lahir?>, <?php echo date("d F Y", strtotime($mahasiswa->tgl_lahir)); ?></td>
                        </tr>
                        <tr>
                            <td>Program Studi</td>
                            <td style="text-align:center">:</td>
                            <td><?=$mahasiswa->nama_jurusan?></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered">
                    <thead>
                      <tr>
                          <th style="text-align:center"><b>No.</b></th>
                          <th style="text-align:center"><b>Kegiatan</b></th>
                          <th style="text-align:center"><b>Bukti</b></th>
                          <th style="text-align:center"><b>Kredit Poin</b></th>
                          <th style="text-align:center"><b>Softskill</b></th>
                          <th style="text-align:center"><b>Ya</b></th>
                          <th style="text-align:center"><b>Poin</b></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no=1; ?>
                      <?php foreach ($kegiatan as $keg) { ?>
                      <tr>
                          <td><b><?php echo $no ?></b></td>
                          <td><b><?php echo $keg->nama_kegiatan ?></b></td>
                          <td><b><?php echo $keg->bukti ?></b></td>
                          <td style="text-align:center"><b><?php echo $keg->poin ?></b></td>
                          <td><b><?php echo $keg->softskill ?></b></td>
                          <td><b></b></td>
                          <td><b></b></td>
                      </tr>
                      <?php $no++; ?>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="2"><b>Total Kredit Poin</b><th>
                          <th><b></b><th>
                        <th><b></b><th>
                      </tr>
                      <tr>
                        <th colspan="2"><b>Konversi Nilai</b><th>
                          <th><b></b><th>
                        <th><b></b><th>
                      </tr>
                    </tfoot>
                </table>

              <?php } else { ?>

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Nama Mahasiswa</td>
                            <td style="text-align:center">:</td>
                            <td><b><?=$mahasiswa->nama_mahasiswa?></b></td>
                        </tr>
                        <tr>
                            <td>Nomor Induk Mahasiswa</td>
                            <td style="text-align:center">:</td>
                            <td><?=$mahasiswa->nim?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan Tanggal Lahir</td>
                            <td style="text-align:center">:</td>
                            <td><?=$mahasiswa->tempat_lahir?>, <?php echo date("d F Y", strtotime($mahasiswa->tgl_lahir)); ?></td>
                        </tr>
                        <tr>
                            <td>Program Studi</td>
                            <td style="text-align:center">:</td>
                            <td><?=$mahasiswa->nama_jurusan?></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered">
                    <thead>
                      <tr>
                          <th style="text-align:center"><b>No.</b></th>
                          <th style="text-align:center"><b>Kegiatan</b></th>
                          <th style="text-align:center"><b>Bukti</b></th>
                          <th style="text-align:center"><b>Kredit Poin</b></th>
                          <th style="text-align:center"><b>Softskill</b></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no=1; ?>
                      <?php foreach ($kegiatan as $keg) { ?>
                      <tr>
                          <td><b><?php echo $no ?></b></td>
                          <td><b><?php echo $keg->nama_kegiatan ?></b></td>
                          <td><b><?php echo $keg->bukti ?></b></td>
                          <td style="text-align:center"><b><?php echo $keg->poin ?></b></td>
                          <td><b><?php echo $keg->softskill ?></b></td>
                      </tr>
                      <?php $no++; ?>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="2"><b>Total Kredit Poin</b><th>
                        <th><b><?=$jumlah?></b><th>
                      </tr>
                      <tr>
                        <th colspan="2"><b>Konversi Nilai</b><th>
                        <th><b><?=$nilaikonversi?></b><th>
                      </tr>
                    </tfoot>
                </table>

              <?php } ?>

            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <div class="col-sm-12">
                Dengan ini saya menyatakan bahwa data tersebut di atas telah saya isi dengan benar sesuai dengan bukti-bukti yang ada
                dan sesuai dengan kenyataan yang susungguhnya selama saya menjadi mahasiswa FEB UMS.
            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <div class="col-sm-12">
                <table class="table" style="width:100%;">
                    <tbody>
                        <tr>
                            <td style="padding-left: 100px;"></td>
                            <td style="text-align: center; padding-left:200px;">Surakarta, <?php echo date("d F Y"); ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Dosen Pembimbing</td>
                            <td style="text-align:center; padding-left:200px;">Mahasiswa</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><u><b><?=$pengampu->nama_dosen?></b></u></td>
                            <td style="text-align: center; padding-left:200px;"><u><b><?=$mahasiswa->nama_mahasiswa?></b></u></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><b>NIDN : <?=$pengampu->nidn?></b></td>
                            <td style="text-align: center; padding-left:200px;"><b>NIM : <?=$mahasiswa->nim?></b></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table" style="width:100%;">
                  <tr>
                    <td style="text-align: center;">
                      Mengetahui Kaprodi Manajemen
                    </td>
                  </tr>
                  <tr><td><td></tr>
                    <tr><td><td></tr>
                    <tr><td><td></tr>
                    <tr><td><td></tr>
                    <tr><td><td></tr>
                    <tr><td><td></tr>
                    <tr><td><td></tr>
                    <tr><td><td></tr>
                    <tr><td><td></tr>
                  <tr><td><td></tr>
                  <tr>
                    <td style="text-align: center;">
                      <u><b><?=$dekan->nama_dekan?></b></u>
                    </td>
                  </tr>
                  <tr>
                    <td style="text-align: center;">
                      <b>NIDN : <?=$dekan->nidn?></b>
                    </td>
                  </tr>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
