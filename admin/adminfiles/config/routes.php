<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login";
$route['logout'] 			 = "login/logout";
$route['register'] = "login/register";
$route['myadmin'] = "login/admin_login";
$route['get-demo'] = "login/demo";
$route['checkuser/(:any)'] = "login/checkuser/$1";
$route['upgrade/(:num)'] = "dashboard/upgrade/$1";
$route['recover-password'] = "login/forgot_password";
$route['payment/(:num)'] = "login/payment/$1";
$route['forgot-password'] = "login/forgot_password";
$route['forgot-username'] = "login/forgot_username";
$route['school/grouppermission'] = 'grouppermission';
$route['download/tasks'] = "dashboard/download_todotasks";
$route['download/tasks/(:any)'] = "dashboard/download_todotasks/$1";
$route['change-password/(:any)'] = "login/change_password/$1";
$route['activate-account/(:any)'] = "login/activate_user/$1";
$route['c-(:any)'] = "login/checkslug/$1";
$route['404_override'] 		 = 'login/page_not_found';


/* End of file routes.php */
/* Location: ./application/config/routes.php */