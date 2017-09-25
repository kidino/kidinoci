<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'class' => 'form-control input-lg'	
);

if ($this->config->item('use_username', 'tank_auth')) {
	$login['placeholder'] = 'Email or login';
} else {
	$login['placeholder'] = 'Email';
}

?>

<div class="row" style="margin-top:20px">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        
        <?php echo form_open($this->uri->uri_string()); ?>
			<fieldset>
				<h2>Forget Password</h2>
				
				<?php if (is_array($errors) && (count($errors) > 0)) { ?>
				<p class="alert alert-danger"><?php echo array_shift($errors); ?></p>
				<?php } ?>
				
				<hr class="colorgraph">
				
                <?php echo form_template(form_input($login), form_error($login['name'])) ; ?>
                				
				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-8 col-sm-6 col-md-6">
                        <input type="submit" class="btn btn-lg btn-success btn-block" value="Reset Password">
					</div>
				</div>
			</fieldset>
        <?php echo form_close(); ?>
	</div>
</div>


<!--
<?php echo form_open($this->uri->uri_string()); ?>
<table>
	<tr>
		<td><?php echo form_label($login_label, $login['id']); ?></td>
		<td><?php echo form_input($login); ?></td>
		<td style="color: red;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></td>
	</tr>
</table>
<?php echo form_submit('reset', 'Get a new password'); ?>
<?php echo form_close(); ?>
-->
