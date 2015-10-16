<?php

class MY_Controller extends CI_Controller {
    function __construct(){
        parent::__construct();
        
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
        $this->load->library('session');

    }
    
}