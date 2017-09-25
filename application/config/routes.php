<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'dashboard';
$route['users'] = 'usersp';
$route['users/index'] = 'usersp/index';
$route['users/index/(:any)'] = 'usersp/index/$1';
$route['users/index/(:any)/(:any)'] = 'usersp/index/$1/$2';
$route['users/index/(:any)/(:any)/(:any)'] = 'usersp/index/$1/$2/$3';
$route['users/index/(:any)/(:any)/(:any)/(:any)'] = 'usersp/index/$1/$2/$3/$4';

$route['users/groups'] = 'usersp/groups';
$route['users/groups/(:any)'] = 'usersp/groups/$1';
$route['users/groups/(:any)/(:any)'] = 'usersp/groups/$1/$2';
$route['users/groups/(:any)/(:any)/(:any)'] = 'usersp/groups/$1/$2/$3';
$route['users/groups/(:any)/(:any)/(:any)/(:any)'] = 'usersp/groups/$1/$2/$3/$4';

$route['users/user_profile'] = 'usersp/user_profile';
$route['users/user_profile/(:any)'] = 'usersp/user_profile/$1';
$route['users/user_profile/(:any)/(:any)'] = 'usersp/user_profile/$1/$2';
$route['users/user_profile/(:any)/(:any)/(:any)'] = 'usersp/user_profile/$1/$2/$3';
$route['users/user_profile/(:any)/(:any)/(:any)/(:any)'] = 'usersp/user_profile/$1/$2/$3/$4';

$route['users/access_types'] = 'usersp/access_types';
$route['users/access_types/(:any)'] = 'usersp/access_types/$1';
$route['users/access_types/(:any)/(:any)'] = 'usersp/access_types/$1/$2';
$route['users/access_types/(:any)/(:any)/(:any)'] = 'usersp/access_types/$1/$2/$3';
$route['users/access_types/(:any)/(:any)/(:any)/(:any)'] = 'usersp/access_types/$1/$2/$3/$4';

$route['users/group_access'] = 'usersp/group_access';
$route['users/group_access/(:any)'] = 'usersp/group_access/$1';
$route['users/group_access/(:any)/(:any)'] = 'usersp/group_access/$1/$2';
$route['users/group_access/(:any)/(:any)/(:any)'] = 'usersp/group_access/$1/$2/$3';
$route['users/group_access/(:any)/(:any)/(:any)/(:any)'] = 'usersp/group_access/$1/$2/$3/$4';

$route['404_override'] = '';
$route['template/(:any)'] = 'template/t/$1';
$route['translate_uri_dashes'] = FALSE;
