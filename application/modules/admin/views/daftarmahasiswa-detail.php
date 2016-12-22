<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-file-text"></i> Detail Data Mahasiswa</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- <div class="col-md-8"> -->
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>No. Induk Mahasiswa</td>
                                <td>:</td>
                                <td><?=$mahasiswa->nim?></td>
                            </tr>
                            <tr>
                                <td>Username Mahasiswa</td>
                                <td>:</td>
                                <td><?=$mahasiswa->username?></td>
                            </tr>
                            <tr>
                                <td>Nama Mahasiswa</td>
                                <td>:</td>
                                <td><?=$mahasiswa->nama_mhs?></td>
                            </tr>
                            <tr>
                                <td>Email Mahasiswa</td>
                                <td>:</td>
                                <td><?=$mahasiswa->email?></td>
                            </tr>
                            <tr>
                                <td>No. Handphone</td>
                                <td>:</td>
                                <td><?=$mahasiswa->no_hp?></td>
                            </tr>
                            <tr>
                                <td>Alamat Lengkap</td>
                                <td>:</td>
                                <td><?=$mahasiswa->alamat?></td>
                            </tr>
                            <tr>
                                <td>Tempat Lahir</td>
                                <td>:</td>
                                <td><?=$mahasiswa->tempat_lahir?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>:</td>
                                <td><?=$mahasiswa->tgl_lahir?></td>
                            </tr>
                            <tr>
                                <td>Tahun Angkatan</td>
                                <td>:</td>
                                <td><?=$mahasiswa->angkatan?></td>
                            </tr>
                            <tr>
                                <td>Jurusan Mahasiswa</td>
                                <td>:</td>
                                <td><?=$mahasiswa->nama_jurusan?></td>
                            </tr>
                            <tr>
                                <td>Image</td>
                                <td>:</td>
                                <td>
                                    <img class="img-responsive img-thumbnail" src="<?=base_url()?>uploads/<?=$mahasiswa->img?>" width="200" onerror="this.onerror=null; this.src='<?=base_url()?>uploads/barang/header/empty.png';" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <!-- </div> -->
            </div>
            <div class="box-footer" style="text-align: right">
                <a href="<?=base_url('admin')?>/<?=$this->uri->segment(2)?>">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </a>
            </div>
        </div>
        <!-- /.box -->
        <!-- Form Element sizes -->
    </div>
</div>
<!-- /.row -->
