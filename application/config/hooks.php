<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/


$hook['pre_system'][] = array(
  'class' => '',
  'function' => 'load_app_controllers',
  'filename' => 'App_controllers.php',
  'filepath' => 'hooks'
);

if ($_SERVER['SERVER_NAME'] == 'armada-timesheet.coders.my') {
	$hook['post_controller_constructor'][] = array(
	  'class' => '',
	  'function' => 'redirect_ssl',
	  'filename' => 'App_controllers.php',
	  'filepath' => 'hooks'
	);	
}

