<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contacts extends Loggedin_Controller
{
	function __construct() {
		parent::__construct();

	}

	function index() {
		$this->_load_view('contacts');
	}
	
}
