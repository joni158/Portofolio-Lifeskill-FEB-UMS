<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <form id="form" method="post" action="<?=base_url('admin') . "/" . $this->uri->segment(2)?>/export">
                    <div class="pull-Left col-sm-12" style="margin-bottom: 5px;">
                        <div class="col-sm-3">
                            <select id="st_level" name="st_level" class="form-control input-sm">
                                <option value="">SEMUA USER</option>
                                <option value="kaprodi">Kepala Program Studi</option>
                                <option value="pembimbing">Dosen Pembimbing</option>
                                <option value="mahasiswa">Mahasiswa</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" name="st_username" id="st_username" class="form-control year input-sm" placeholder="Username">
                        </div>
                        <div class="col-sm-5">
                            <a class="btn btn-info btn-sm" onclick="cari()" ><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                </form>
                <table id="table-detail" cellpadding="0" cellspacing="0" border="1" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 3%">No</th>
                            <th style="width: 10%">Username</th>
                            <th style="width: 15%">Password (Encrypt)</th>
                            <th style="width: 10%">Level</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

<script type="text/javascript">
    
    function cari() {
        var table = $('#table-detail').DataTable({
            "paging": false,
            destroy: true,
            info: false,
            "searching": false,
            "processing": true,
            "serverSide": false,
            scrollY: '60vh',
            scrollCollapse: true,
            ajax: {
                url: "<?=base_url()?>admin/<?=$this->uri->segment(2)?>/get",
                type: "post",
                "data": function(d) {
                    d.st_level = $("#st_level").val();
                    d.st_username = $("#st_username").val();
                }
            }
        });

    }

</script>
