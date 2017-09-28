<?php

function output_json( $json_obj ) {
	
	$CI =& get_instance();

	$CI->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($json_obj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			->_display();
	exit;
}

function check_access($access) {
		
	if ($_SESSION['is_super'] == 1) return true;
	
	if (!isset($_SESSION['access']) 
		|| !is_array($_SESSION['access'])
		|| !in_array($access, $_SESSION['access'])) {
		return false;
	}
	return true;
}

function is_super(){
	return ($_SESSION['is_super'] == 1);
}

function check_group($group) {
	if (!isset($_SESSION['groups']) 
		|| !is_array($_SESSION['groups'])
		|| !in_array($group, $_SESSION['groups'])) {
		return false;
	}
	return true;
}
