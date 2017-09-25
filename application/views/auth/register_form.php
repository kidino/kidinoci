
<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
		'placeholder' => 'Username',
    	'class' => 'form-control input-lg'
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
    'placeholder' => 'Email',
	'class' => 'form-control input-lg'
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
    'placeholder' => 'Password',
	'class' => 'form-control input-lg'
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
    'placeholder' => 'Confirm Password',
	'class' => 'form-control input-lg'
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>

<div class="row" style="margin-top:20px">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        
        <?php echo form_open($this->uri->uri_string()); ?>
			<fieldset>
				<h2>Register</h2>
				
				<?php if (is_array($errors) && (count($errors) > 0)) { ?>
				<p class="alert alert-danger"><?php echo array_shift($errors); ?></p>
				<?php } ?>
				
				<hr class="colorgraph">
                
                <?php if ($use_username) { ?>
                <?php echo form_template(form_input($username), form_error($username['name'])) ; ?>              
                <?php } ?>
                 				
                <?php echo form_template(form_input($email), form_error($email['name'])) ; ?>
                <?php echo form_template(form_input($password), form_error($password['name'])) ; ?>
                <?php echo form_template(form_input($confirm_password), form_error($confirm_password['name'])) ; ?>
                
<?php if ($captcha_registration) { ?>
		<div class="form-group">
		<table class="table">
		<?php if ($use_recaptcha) { ?>
	<tr>
		<td colspan="2">
			<div id="recaptcha_image"></div>
		</td>
		<td>
			<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
			<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
			<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="recaptcha_only_if_image">Enter the words above</div>
			<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
		</td>
		<td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
		<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
		<?php echo $recaptcha_html; ?>
	</tr>
	<?php } else { ?>
	<tr>
		<td colspan="3">
			<p>Enter the code exactly as it appears:</p>
			<?php echo $captcha_html; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
		<td><?php echo form_input($captcha); ?></td>
		<td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
	</tr>
	<?php } ?>
                </table>
                </div>
	<?php } ?>				
				
				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
                        <input type="submit" class="btn btn-lg btn-success btn-block" value="Register">
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
					</div>
				</div>
			</fieldset>
        <?php echo form_close(); ?>
	</div>
</div>

<div>&nbsp;</div>