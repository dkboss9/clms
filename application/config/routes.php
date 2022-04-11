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

$route['api/v1/signup']['POST'] = 'api/v1/auth/signup';
$route['api/v1/resend_activation_code']['POST'] = 'api/v1/auth/resend_activation_code';
$route['api/v1/activate_user']['POST'] = 'api/v1/auth/activate_user';
$route['api/v1/authenticate']['POST'] = 'api/v1/auth/authenticate';
$route['api/v1/social_authenticate']['POST'] = 'api/v1/auth/social_authenticate';
$route['api/v1/forgot_password']['POST'] = 'api/v1/auth/forgot_password';
$route['api/v1/verify_user']['POST'] = 'api/v1/auth/verify_user';
$route['api/v1/change_password']['POST'] = 'api/v1/auth/change_password';
$route['api/v1/update_password']['POST'] = 'api/v1/me/user_update_password';
$route['api/v1/profile']['GET'] = 'api/v1/me/profile';
$route['api/v1/profile']['POST'] = 'api/v1/me/profile';
$route['api/v1/upload_photo']['POST'] = 'api/v1/presets/upload_photo';
$route['api/v1/my_documents']['GET'] = 'api/v1/me/my_documents';
$route['api/v1/my_documents_upload']['POST'] = 'api/v1/presets/upload_documents';
$route['api/v1/document_categories']['GET'] = 'api/v1/presets/document_categories';
$route['api/v1/add_my_document']['POST'] = 'api/v1/me/add_my_document';
$route['api/v1/delete_my_document/(:num)']['POST'] = 'api/v1/me/delete_my_document/$1';
$route['api/v1/ielts']['POST'] = 'api/v1/me/ielts';
$route['api/v1/qualification']['POST'] = 'api/v1/me/qualification';




$route['invite-student/(:any)/(:any)'] 	= "login/signup/$1/$2";
$route['approve-invitation'] = "student/approve_invitaion";
$route['activate-account/(:any)'] = "login/activate_user/$1";
$route['guest-checkin/(:any)'] = "login/guest_checkin/$1";
$route['invite-user'] 	= "login/user_signup";
$route['invite-user/(:any)/(:any)'] 	= "login/user_signup/$1/$2";
$route['logout'] 			 = "login/logout";
$route['forgot-password'] = "login/forgot_password";
$route['change-password/(:any)'] = "login/change_password/$1";
$route['school/grouppermission'] = 'grouppermission';
$route['profile'] = 'student/profile';
$route['404_override'] 		 = 'login/page_not_found';


/* End of file routes.php */
/* Location: ./application/config/routes.php */