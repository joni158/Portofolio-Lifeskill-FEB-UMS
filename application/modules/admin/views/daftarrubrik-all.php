<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <!-- <a class="btn btn-default" href="<?=base_url('admin')?>/<?=$this->uri->segment(2)?>/add" role="button">Tambah Data</a> -->
                <!-- <a class="btn btn-default" data-toggle="modal" data-target="#import">Import</a>                 -->

                <table class="table table-bordered">
                    <tbody>
                        <?php $a = $this->db->query("SELECT * FROM s_table6 WHERE level = 1")->result();?>
                        <?php foreach ($a as $b): ?>
                            <?php if ($b->parent == 0 && $b->child == 0) : ?>
                                <tr>
                                    <td style="width: 3%">
                                        <button data-toggle="collapse" data-target="#kat<?=$b->uid_rubrik?>" aria-expanded="false" type="button" class="btn btn-xs"><i class="fa fa-plus"></i><i class="fa fa-minus pull-right"></i></button>
                                    </td>
                                    <td><?=$b->kegiatan?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <div class="accordian-body collapse" id="kat<?=$b->uid_rubrik?>">
                                            <table class="table table-bordered table-hovered">
                                                <thead>
                                                    <tr>
                                                        <th>Poin</th>
                                                        <th>Satuan</th>
                                                        <th>Bukti</th>
                                                        <th>Softskill</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?=$b->poin?></td>
                                                        <td><?=$b->satuan?></td>
                                                        <td><?=$b->bukti?></td>
                                                        <td><?=$b->softskill?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            <?php else : ?>
                                <tr>
                                    <td style="width: 3%">
                                        <button data-toggle="collapse" data-target="#kat<?=$b->uid_rubrik?>" aria-expanded="false" type="button" class="btn btn-xs"><i class="fa fa-plus"></i><i class="fa fa-minus pull-right"></i></button>
                                    </td>
                                    <td><?=$b->kegiatan?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <div class="accordian-body collapse" id="kat<?=$b->uid_rubrik?>">
                                            <table class="table table-bordered">
                                                <?php $par = $b->uid_rubrik ?>
                                                <?php $c = $this->db->query("SELECT * FROM s_table6 WHERE level = 2 AND parent = '$par' ")->result();?>
                                                <?php foreach ($c as $d): ?>
                                                    <?php if ($d->child == 0) : ?>
                                                        <tr>
                                                            <td style="width: 3%">
                                                                <button data-toggle="collapse" data-target="#grpone<?=$d->uid_rubrik?>" aria-expanded="false" type="button" class="btn btn-xs"><i class="fa fa-plus"></i><i class="fa fa-minus pull-right"></i></button>
                                                            </td>
                                                            <td><?=$d->kegiatan?></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                <div class="accordian-body collapse" id="grpone<?=$d->uid_rubrik?>">
                                                                    <table class="table table-bordered table-hovered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Poin</th>
                                                                                <th>Satuan</th>
                                                                                <th>Bukti</th>
                                                                                <th>Softskill</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><?=$d->poin?></td>
                                                                                <td><?=$d->satuan?></td>
                                                                                <td><?=$d->bukti?></td>
                                                                                <td><?=$d->softskill?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td style="width: 3%">
                                                                <button data-toggle="collapse" data-target="#grpone<?=$d->uid_rubrik?>" aria-expanded="false" type="button" class="btn btn-xs"><i class="fa fa-plus"></i><i class="fa fa-minus pull-right"></i></button>
                                                            </td>
                                                            <td><?=$d->kegiatan?></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                <div class="accordian-body collapse" id="grpone<?=$d->uid_rubrik?>">
                                                                    <table class="table table-bordered">
                                                                        <?php $par2 = $d->uid_rubrik ?>
                                                                        <?php $e = $this->db->query("SELECT * FROM s_table6 WHERE level = 3 AND parent = '$par2' ")->result();?>
                                                                        <?php foreach ($e as $f): ?>
                                                                            <?php if ($f->child == 0) : ?>
                                                                                <tr>
                                                                                    <td style="width: 3%">
                                                                                        <button data-toggle="collapse" data-target="#grptwo<?=$f->uid_rubrik?>" aria-expanded="false" type="button" class="btn btn-xs"><i class="fa fa-plus"></i><i class="fa fa-minus pull-right"></i></button>
                                                                                    </td>
                                                                                    <td><?=$f->kegiatan?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td></td>
                                                                                    <td>
                                                                                        <div class="accordian-body collapse" id="grptwo<?=$f->uid_rubrik?>">
                                                                                            <table class="table table-bordered table-hovered">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th>Poin</th>
                                                                                                        <th>Satuan</th>
                                                                                                        <th>Bukti</th>
                                                                                                        <th>Softskill</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td><?=$f->poin?></td>
                                                                                                        <td><?=$f->satuan?></td>
                                                                                                        <td><?=$f->bukti?></td>
                                                                                                        <td><?=$f->softskill?></td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php endif ?>
                                                                        <?php endforeach ?>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endif ?>

                                                <?php endforeach ?>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif ?>
                        <?php endforeach ?>
                    </tbody>
                </table>

            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
