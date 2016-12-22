<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>PORTOFOLIO LIFESKILL MAHASISWA </title>

    <!-- CUSTOM STYLE CSS -->
    <style type="text/css">
    body {
        font-size: 12px;
        background-color: #ffffff;
    }
    h2 {
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
        text-align: justify;
    }

    table {
        border-collapse:collapse;  
        margin-bottom:10px;
        width: 100%;
    }

    .tborder, .tborder th, .tborder td {
        border: 1px solid #000;
    }

    table, th, td {
        padding: 5px;
    }

    table thead tr th {
        text-align: center;
    }

    </style>
</head>

<body>
    <div class="container">

        <table>
          <tr>
            <td style="margin:0px; padding:0px; text-align:center;">
              <img src="assets/images/logo-hd.png" height="75" width="75">
            </td>
            <td style="text-align:center;margin:0px; padding:0px;">
              <h2 class="kop">UNIVERSITAS MUHAMMADIYAH SURAKARTA</h2>
              <h2 class="kop3">FAKULTAS EKONOMI DAN BISNIS</h2>
              <h2 class="kop2">Jl. A. Yani Tromol Pos I Pabelan Kartasura Sukoharjo, Telp. 0271 717417 ex 210, 229 Surakarta 57102</h2>
            </td>
          </tr>
        </table>

        <hr style="margin-bottom:1px; margin-top:5px">

        <h2 class="kop4">Penilaian Portofolio</h2>
        <h2 class="kop4">Kecakapan Berkehidupan</h2>

        <div class="row" style="margin-top:20px">
            <div class="col-sm-12">
                <table class="tborder">
                    <tbody>
                        <tr>
                            <td>Nama Mahasiswa</td>
                            <td style="text-align:center">:</td>
                            <td><b><?=$getdata->nama_mhs?></b></td>
                        </tr>
                        <tr>
                            <td>Nomor Induk Mahasiswa</td>
                            <td style="text-align:center">:</td>
                            <td><?=$getdata->nim?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan Tanggal Lahir</td>
                            <td style="text-align:center">:</td>
                            <td><?=$getdata->tempat_lahir?>, <?php echo date("d F Y", strtotime($getdata->tgl_lahir)); ?></td>
                        </tr>
                        <tr>
                            <td>Program Studi</td>
                            <td style="text-align:center">:</td>
                            <td><?=$getdata->nama_jurusan?></td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-bottom:20px;"></div>
                
                <table class="tborder">
                    <thead>
                      <tr>
                          <th>No.</th>
                          <th>Kegiatan</th>
                          <th>Bukti</th>
                          <th>Kredit Poin</th>
                          <th>Softskill</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no=1; ?>
                      <?php foreach ($kegiatan as $key => $value) { ?>
                      <tr>
                          <td><?php echo $no ?></td>
                          <td><?php echo $value->keterangan ?></td>
                          <td><?php echo $value->bukti ?></td>
                          <td style="text-align:center"><?php echo $value->poin ?></td>
                          <td><?php echo $value->softskill ?></td>
                      </tr>
                      <?php $no++; ?>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                          <th colspan="3">Total Kredit Poin</th>
                          <th><?php echo $total; ?></th>
                          <th></th>
                      </tr>
                      <tr>
                          <th colspan="3">Konversi Nilai</th>
                          <th><?php echo $nilaikonversi; ?></th>
                          <th></th>
                      </tr>
                    </tfoot>
                </table>
                
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

                <table>
                    <tbody>
                        <tr>
                            <td style="padding-left: 100px;"></td>
                            <td style="text-align: center; padding-left:200px;">Surakarta, <?php echo date("d F Y"); ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding-left:50px;">Dosen Pembimbing</td>
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
                            <td style="text-align: center; padding-left:50px;"><u><b><?=$getdata->nama_dosen?></b></u></td>
                            <td style="text-align: center; padding-left:200px;"><u><b><?=$getdata->nama_mhs?></b></u></td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding-left:50px;"><b>NIDN : <?=$getdata->nidn?></b></td>
                            <td style="text-align: center; padding-left:200px;"><b>NIM : <?=$getdata->nim?></b></td>
                        </tr>
                    </tbody>
                </table>

                <table>
                    <tbody>
                        <tr>
                            <td style="text-align: center;">Mengetahui Kaprodi <?=$getdata->nama_jurusan?></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><u><b><?=$getkaprodi->nama_dosen?></b></u></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><b>NIDN : <?=$getkaprodi->nidn?></b></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</body>

</html>
