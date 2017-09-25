<?php
function load_app_controllers()
{
  spl_autoload_register('my_own_controllers');
}
function my_own_controllers($class)
{
  if (strpos($class, 'CI_') !== 0)
  {
    if (is_readable(APPPATH . 'core/' . $class . '.php'))
    {
      require_once(APPPATH . 'core/' . $class . '.php');
    }
  }
}


function redirect_ssl() {
	if (!is_secure()){
		redirect( current_url(), 'location', 301 ); // current_url will create based on $config['base_url'] which has https://
	}
}

function is_secure() {
  return
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || $_SERVER['SERVER_PORT'] == 443;
}
