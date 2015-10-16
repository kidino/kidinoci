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