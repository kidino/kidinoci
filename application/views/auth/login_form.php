<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'class' => 'form-control input-lg'
);
if ($login_by_username AND $login_by_email) {
	$login['placeholder'] = 'Email or login';
} else if ($login_by_username) {
	$login['placeholder'] = 'Login';
} else {
	$login['placeholder'] = 'Email';
}
$password = array(
	'name'	=> 'password',
	'type'	=> 'password',
	'id'	=> 'password',
	'class' => 'form-control input-lg',
	'placeholder' => 'Password'
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember_me',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
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
				<h2>Please Sign In</h2>
				
				<?php if (is_array($errors) && (count($errors) > 0)) { ?>
				<p class="alert alert-danger"><?php echo array_shift($errors); ?></p>
				<?php } ?>
				
				<hr class="colorgraph">
                
                <?php echo form_template(form_input($login), form_error($login['name'])) ; ?>               				
                <?php echo form_template(form_input($password), form_error($password['name'])) ; ?>               								
	<?php if ($show_captcha) { ?>
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
				<span class="button-checkbox">
					<!--<button type="button" class="btn" data-color="info">Remember Me</button>-->
                    <!-- <input type="checkbox" name="remember_me" id="remember_me" checked="checked" class="hidden"> -->
                    
  <div class="checkbox">
    <label><?php echo form_checkbox($remember); ?> Remember Me</label>
	<a href="<?php echo site_url('auth/forgot_password'); ?>" class="btn btn-link pull-right">Forgot Password?</a>
</div>         
                    

				</span>
				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
                        <input type="submit" class="btn btn-lg btn-success btn-block" value="Sign In">
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<?php if ($this->config->item('allow_registration', 'tank_auth')) { ?>
						<a href="<?php echo site_url('auth/register');?>" class="btn btn-lg btn-primary btn-block">Register</a>    <?php } ?>
					</div>
				</div>
			</fieldset>
        <?php echo form_close(); ?>
	</div>
</div>

<?php $this->load->view('footer'); ?>
<script>
    $(function(){
    $('.button-checkbox').each(function(){
		var $widget = $(this),
			$button = $widget.find('button'),
			$checkbox = $widget.find('input:checkbox'),
			color = $button.data('color'),
			settings = {
					on: {
						icon: 'glyphicon glyphicon-check'
					},
					off: {
						icon: 'glyphicon glyphicon-unchecked'
					}
			};

		$button.on('click', function () {
			$checkbox.prop('checked', !$checkbox.is(':checked'));
			$checkbox.triggerHandler('change');
			updateDisplay();
		});

		$checkbox.on('change', function () {
			updateDisplay();
		});

		function updateDisplay() {
			var isChecked = $checkbox.is(':checked');
			// Set the button's state
			$button.data('state', (isChecked) ? "on" : "off");

			// Set the button's icon
			$button.find('.state-icon')
				.removeClass()
				.addClass('state-icon ' + settings[$button.data('state')].icon);

			// Update the button's color
			if (isChecked) {
				$button
					.removeClass('btn-default')
					.addClass('btn-' + color + ' active');
			}
			else
			{
				$button
					.removeClass('btn-' + color + ' active')
					.addClass('btn-default');
			}
		}
		function init() {
			updateDisplay();
			// Inject the icon if applicable
			if ($button.find('.state-icon').length == 0) {
				$button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
			}
		}
		init();
	});
});
</script>