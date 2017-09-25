<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Loggedin_Controller
{
	function __construct() {
		parent::__construct();

	}

	function index() {
		$this->_load_view('dashboard');
	}
	
	function invalid(){
		$this->_load_view('invalid');		
	}
}
