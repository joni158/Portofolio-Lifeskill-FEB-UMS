<?php $this->load->view('template/header');?>
<section class="content">
	<?php $this->load->view('template/error');?>
    <?php $this->load->view($main_content);?>
</section>
<?php $this->load->view('template/footer');?>