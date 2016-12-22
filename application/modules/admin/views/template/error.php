<?php if ($this->input->get('error') == "1"): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Gagal!</strong>karena kesalahan file atau file tidak ditemukan
    </div>
<?php endif?>
 <?php if ($this->input->get('error') == "2"): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Gagal!</strong> File belum dipilih
    </div>
<?php endif?>
