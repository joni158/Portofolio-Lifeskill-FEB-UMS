</div>

<?php
    $ci = &get_instance();
?>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; <?="2016" . (("2016" != (int) date('Y')) ? '-' . (int) date('Y') : '');?> <a href="http://rsk.co.id" target="blank"><?=$ci->site_name();?></a>.</strong> All rights reserved.
</footer>
</div>

<script type="text/javascript">

	function add() {
	    save_method = 'add';
	    $('#form')[0].reset();
	    $('#modal_form').modal('show');
	}

	jQuery('.date').datetimepicker({
	    timepicker: false,
	    format: 'Y-m-d'
	});

</script>
</body>

</html>
