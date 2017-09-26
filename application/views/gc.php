<?php $this->load->view('loggedin_header');?>

<div class="row">
	<div class="col-md-12">
	<h1><?php echo str_replace($appname.' - ','',$page_title);?></h1>
	
	<?php if(isset($gc_tab)) { ?>
	<?php $this->load->view($gc_tab);?>
	<?php }?>
	
	<?php echo $output; ?>
	</div>
</div>

<?php $this->load->view('footer');?>
