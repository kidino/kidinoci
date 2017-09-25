<?php

class MY_Controller extends CI_Controller {
	var $data = array();
    function __construct(){
        parent::__construct();
        
		$this->lang->load('tank_auth');
		$this->load->helper('general');
		$this->load->library('AppSettings','appsettings');
				
		$appname = $this->appsettings->get('application_name');
		$this->data['appname'] = ($appname == '') ? 'Kidino CI' : $appname;
		
		$timezone = $this->appsettings->get('timezone');
		$this->data['timezone'] = ($timezone == '') ? 'UTC' : $timezone;
		date_default_timezone_set($this->data['timezone']);

    }
    
}