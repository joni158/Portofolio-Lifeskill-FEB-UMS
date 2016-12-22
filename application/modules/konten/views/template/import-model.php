<div class="modal fade" id="import">
    <form id="siswa" enctype='multipart/form-data' method="post" action="<?=base_url('web-admin') . "/" . $this->uri->segment(2)?>/import">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Import Data</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Data Format excel <a style="color:blue;" href="<?=base_url('web-admin') . "/" . $this->uri->segment(2)?>/export">Download Format</a></label>
                        <input name="file" type="file" id="file" size="50" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </form>
    <!-- /.modal-dialog -->
</div>
<!--<label>Data Format excel <a style="color:blue;" href="<?=base_url() . "uploads/excel/" . $this->uri->segment(2)?>.xlsx">Download Format</a></label>-->