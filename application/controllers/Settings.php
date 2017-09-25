<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Loggedin_Controller
{
	function __construct() {
		parent::__construct();
		if (!check_access('admin_app_settings')) {
			redirect('dashboard/invalid');
		}
		
		$this->load->helper('form');
		
	}

	function index() {
		
		$this->data['get_key'] = array('application_name','timezone','email_from_email','email_from_name',
									   'email_useragent','email_method','smtp_port','smtp_host','smtp_username',
									   'smtp_password','smtp_connection');
		
		$tz = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
		$this->data['timezone_list'] = array();
		foreach($tz as $t) {
			$this->data['timezone_list'][$t] = $t;
		}
		
		foreach( $this->data['get_key'] as $key) {
			$this->data['input'][$key] = $this->appsettings->get($key);
		}

		$this->data['page_title'] = 'Settings';
		$this->_load_view('settings');
	}
	
	function saver() {		
		$save_key = $this->input->post('save_key');
		$return_uri = $this->input->post('return_uri');
		$keys = explode(',', $save_key);
		
		$settings = array();
		foreach ($keys as $key) {
			$settings[$key] = $this->input->post($key);
		}
		$this->appsettings->save( $settings );
		$_SESSION['success'] = true;
		$this->session->mark_as_flash('success');
		
		redirect($return_uri);
	}
	

}
