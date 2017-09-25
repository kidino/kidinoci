<div class="row">
	<div class="col-md-12">
		<h1>Settings</h1>
	</div>
</div>

<?php if (isset($_SESSION['success']) && $_SESSION['success']) { ?>
	<div class="row">
		<div class="col-md-12">
			<p class="alert alert-success">Data has been saved!</p>
		</div>
	</div>
	<?php } ?>

		<form action="<?php echo site_url('settings/saver')?>" method="post">
			<input type="hidden" name="return_uri" value="settings">
			<input type="hidden" name="save_key" value="<?php echo implode(',', $get_key)?>">
			<div class="row">

				<div class="col-md-6">
					<h2>General Settings</h2>

					<div class="form-group row">
						<label class="col-md-3 form-control-label" for="text-input">Application Name</label>
						<div class="col-md-9">
							<input type="text" id="application_name" name="application_name" class="form-control" value="<?php echo $input['application_name']?>">
							<!--<span class="help-block">This is a help text</span>-->
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-3 form-control-label" for="text-input">Timezone</label>
						<div class="col-md-9">
							<?php echo form_dropdown('timezone', $timezone_list, $input['timezone'], array('class' => 'form-control'))?>
						</div>
					</div>					

				</div>
				<div class="col-md-6">
					<h2>Email Settings</h2>

					<div class="form-group row">
						<label class="col-md-3 form-control-label" for="text-input">From Name</label>
						<div class="col-md-9">
							<input type="text" id="email_from_name" name="email_from_name" class="form-control" value="<?php echo $input['email_from_name']?>">
							<!--<span class="help-block">This is a help text</span>-->
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-3 form-control-label" for="text-input">From Email</label>
						<div class="col-md-9">
							<input type="text" id="email_from_email" name="email_from_email" class="form-control" value="<?php echo $input['email_from_email']?>">
							<!--<span class="help-block">This is a help text</span>-->
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-3 form-control-label">Email Method</label>
						<div class="col-md-9">
							<label class="checkbox-inline" for="inline-checkbox1">
								<input type="radio" id="email_method_mail" name="email_method" value="mail" <?php echo ( $input[ 'email_method']=='mail' ) ? ' checked="checked"': ''; ?>>PHP mail() function &nbsp;
							</label>
							<label class="checkbox-inline" for="inline-checkbox2">
								<input type="radio" id="email_method_smtp" name="email_method" value="smtp" <?php echo ( $input[ 'email_method']=='smtp' ) ? ' checked="checked"': ''; ?>>SMTP
							</label>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-3 form-control-label">User Agent</label>
						<div class="col-md-9">
							<label class="checkbox-inline" for="inline-checkbox1">
								<input type="radio" id="email_useragent_phpmailer" name="email_useragent" value="phpmailer" <?php echo ( $input[ 'email_useragent']=='phpmailer' ) ? ' checked="checked"': ''; ?>>PHPMailer &nbsp;
							</label>
							<label class="checkbox-inline" for="inline-checkbox2">
								<input type="radio" id="email_useragent_codeigniter" name="email_useragent" value="codeigniter" <?php echo ( $input[ 'email_useragent']=='codeigniter' ) ? ' checked="checked"': ''; ?>>Codeigniter
							</label>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-3 form-control-label" for="text-input">SMTP Host</label>
						<div class="col-md-9">
							<input type="text" id="smtp_host" name="smtp_host" class="form-control" value="<?php echo $input['smtp_host']?>">
							<!--<span class="help-block">This is a help text</span>-->
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-3 form-control-label" for="text-input">SMTP Port</label>
						<div class="col-md-9">
							<input type="text" id="smtp_port" name="smtp_port" class="form-control" value="<?php echo $input['smtp_port']?>">
							<!--<span class="help-block">This is a help text</span>-->
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-3 form-control-label" for="text-input">SMTP Username</label>
						<div class="col-md-9">
							<input type="text" id="smtp_username" name="smtp_username" class="form-control" value="<?php echo $input['smtp_username']?>">
							<!--<span class="help-block">This is a help text</span>-->
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-3 form-control-label" for="text-input">SMTP Password</label>
						<div class="col-md-9">
							<input type="text" id="email_smtp_password" name="smtp_password" class="form-control" value="<?php echo $input['smtp_password']?>">
							<!--<span class="help-block">This is a help text</span>-->
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-3 form-control-label">Connection Type</label>
						<div class="col-md-9">
							<label class="checkbox-inline" for="inline-checkbox1">
								<input type="radio" id="email_connection_standard" name="smtp_connection" value="" <?php echo ( $input[ 'smtp_connection']=='' ) ? ' checked="checked"': ''; ?>>Standard &nbsp;
							</label>
							<label class="checkbox-inline" for="inline-checkbox1">
								<input type="radio" id="email_connection_ssl" name="smtp_connection" value="ssl" <?php echo ( $input[ 'smtp_connection']=='ssl' ) ? ' checked="checked"': ''; ?>>SSL &nbsp;
							</label>
							<label class="checkbox-inline" for="inline-checkbox1">
								<input type="radio" id="email_connection_ssl" name="smtp_connection" value="sslv2" <?php echo ( $input[ 'smtp_connection']=='sslv2' ) ? ' checked="checked"': ''; ?>>SSL v2 &nbsp;
							</label>
							<label class="checkbox-inline" for="inline-checkbox2">
								<input type="radio" id="email_connection_tls" name="smtp_connection" value="tls" <?php echo ( $input[ 'smtp_connection']=='tls' ) ? ' checked="checked"': ''; ?>>TLS
							</label>
						</div>
					</div>

				</div>
			</div>


			<div class="row">
				<div class="col-md-12 text-center">
					<hr>
					<button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i> Reset</button>
					<button type="submit" class="btn btn-primary"><i class="fa fa-dot-circle-o"></i> Save</button>

				</div>
			</div>
			<p>&nbsp;</p>


		</form>