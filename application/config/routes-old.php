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

$route['default_controller']['GET'] = "home";

$route['cron/index']['GET'] = 'cron/index';


$route['email']['GET'] = 'home/email';

$route['api/v1/states']['GET'] = 'api/v1/presets/states';

$route['api/v1/upload_image']['POST'] = 'api/v1/upload/upload_image';

$route['api/v1/me/push_token']['POST'] = 'api/v1/me/push_token';
$route['api/v1/register_device_token']['POST'] = 'api/v1/push_notification/register_device_token';
$route['cron/pushNotification']['GET'] = 'cron/pushNotification';
$route['cron/push_notifications_datewise']['GET'] = 'cron/push_notifications_datewise';


$route['api/v1/signup']['POST'] = 'api/v1/auth/register';
$route['api/v1/resend_code_email']['GET'] = 'api/v1/auth/resend_code_email';
$route['api/v1/activate_user']['POST'] = 'api/v1/auth/activate_user';
$route['api/v1/authenticate']['POST'] = 'api/v1/auth/authenticate';
$route['api/v1/forgot_password']['POST'] = 'api/v1/auth/forgot_password';
$route['api/v1/verify_user']['POST'] = 'api/v1/auth/verify_user';
$route['api/v1/change_password']['POST'] = 'api/v1/auth/change_password';
$route['api/v1/user_update_password']['POST'] = 'api/v1/me/user_update_password';
$route['api/v1/profile']['GET'] = 'api/v1/me/profile';
$route['api/v1/profile']['POST'] = 'api/v1/me/profile';
$route['api/v1/ads_list']['GET'] = 'api/v1/ads/ads_list';
$route['api/v1/featured_ads']['GET'] = 'api/v1/ads/featured_ads';
$route['api/v1/spoted_ads']['GET'] = 'api/v1/ads/spoted_ads';
$route['api/v1/ads_detail/(:num)']['GET'] = 'api/v1/ads/ads_detail/$1';
$route['api/v1/respond_ads']['POST'] = 'api/v1/ads/respond_ads';
$route['api/v1/my_ads']['GET'] = 'api/v1/me/my_ads';
$route['api/v1/offermessages']['GET'] = 'api/v1/me/offermessages';
$route['api/v1/delete_offerlist']['POST'] = 'api/v1/me/delete_offerlist';
$route['api/v1/offerlists']['GET'] = 'api/v1/me/offerlists';
$route['api/v1/offers_detail']['GET'] = 'api/v1/me/offers_detail';
$route['api/v1/delete_offer_chat']['POST'] = 'api/v1/me/delete_offer_chat';
$route['api/v1/block_user']['POST'] = 'api/v1/me/block_user';
$route['api/v1/upload_comment_file']['POST'] = 'api/v1/upload/upload_comment_file';
$route['api/v1/add_comment']['POST'] = 'api/v1/me/add_comment';
$route['api/v1/payment_history']['GET'] = 'api/v1/me/payment_history';
$route['api/v1/wishlists']['GET'] = 'api/v1/me/wishlists';
$route['api/v1/check_wishlist']['GET'] = 'api/v1/me/check_wishlist';
$route['api/v1/add_wishlist']['POST'] = 'api/v1/me/add_wishlist';
$route['api/v1/delete_wishlist']['POST'] = 'api/v1/me/delete_wishlist';
$route['api/v1/delete_wishlist_withpostid']['POST'] = 'api/v1/me/delete_wishlist_withpostid';
$route['api/v1/privacy_setting']['GET'] = 'api/v1/me/privacy_setting';
$route['api/v1/privacy_setting']['POST'] = 'api/v1/me/privacy_setting';
$route['api/v1/account_deactivate_reason']['GET'] = 'api/v1/presets/account_deactivate_reason';
$route['api/v1/deactivate_account']['POST'] = 'api/v1/me/deactivate_account';
$route['api/v1/invite_link']['GET'] = 'api/v1/me/invite_link';
$route['api/v1/total_postads']['GET'] = 'api/v1/me/total_postads';
$route['api/v1/myactivity']['GET'] = 'api/v1/me/myactivity';
$route['api/v1/approve_ads']['GET'] = 'api/v1/me/approve_ads';
$route['api/v1/chart']['GET'] = 'api/v1/me/chart';
$route['api/v1/send_invite_request']['POST'] = 'api/v1/me/send_invite_request';
$route['api/v1/todos']['GET'] = 'api/v1/me/todos';
$route['api/v1/todos/add']['POST'] = 'api/v1/me/todos_add';
$route['api/v1/todos/status']['POST'] = 'api/v1/me/todos_status';
$route['api/v1/todos/delete']['POST'] = 'api/v1/me/todos_delete';
$route['api/v1/coupon']['POST'] = 'api/v1/me/coupon';
$route['api/v1/referal_login_friends']['GET'] = 'api/v1/me/referal_login_friends';
$route['api/v1/classi_credits']['GET'] = 'api/v1/me/classi_credits';
$route['api/v1/popular_category']['GET']  = 'api/v1/presets/popular_category';
$route['api/v1/category']['GET']  = 'api/v1/presets/category';
$route['api/v1/bike_types']['GET'] = 'api/v1/presets/bike_types';
$route['api/v1/job_category']['GET'] = 'api/v1/presets/job_category';



$route['api/v1/verify_mobile']['POST']  = 'api/v1/post/verify_mobile';
$route['api/v1/resend_code']['GET']  = 'api/v1/post/resend_code';
$route['api/v1/add_code']['POST']  = 'api/v1/post/add_code';
$route['api/v1/post_categories']['GET']  = 'api/v1/presets/post_categories';
$route['api/v1/search_categories']['GET']  = 'api/v1/presets/search_categories';
$route['api/v1/makes']['GET']  = 'api/v1/presets/makes';
$route['api/v1/models']['GET']  = 'api/v1/presets/models';
$route['api/v1/conditions']['GET']  = 'api/v1/presets/conditions';
$route['api/v1/transmissions']['GET']  = 'api/v1/presets/transmissions';
$route['api/v1/colors']['GET']  = 'api/v1/presets/colors';
$route['api/v1/body_types']['GET']  = 'api/v1/presets/body_types';
$route['api/v1/register_type']['GET']  = 'api/v1/presets/register_type';
$route['api/v1/years']['GET']  = 'api/v1/presets/years';

$route['api/v1/salary_type']['GET']  = 'api/v1/presets/salary_type';
$route['api/v1/job_type']['GET']  = 'api/v1/presets/job_type';
$route['api/v1/sale_by']['GET']  = 'api/v1/presets/sale_by';
$route['api/v1/realstate_sale_by']['GET']  = 'api/v1/presets/realstate_sale_by';
$route['api/v1/offer_type']['GET']  = 'api/v1/presets/offer_type';
$route['api/v1/location']['GET']  = 'api/v1/presets/location';
$route['api/v1/property_type']['GET']  = 'api/v1/presets/property_type';
$route['api/v1/property_category']['GET']  = 'api/v1/presets/property_category';

$route['api/v1/ads_form']['GET']  = 'api/v1/post/ads_form';
$route['api/v1/ads_edit_form/(:num)']['GET']  = 'api/v1/post/edit_form/$1';
$route['api/v1/upload_post_images']['POST']  = 'api/v1/upload/upload_post_images';
$route['api/v1/upload_post_image']['POST']  = 'api/v1/upload/upload_post_image';
$route['api/v1/address']['GET']  = 'api/v1/presets/address';
$route['api/v1/ads_form']['POST']  = 'api/v1/post/ads_form';
$route['api/v1/ads_edit_form/(:num)']['POST']  = 'api/v1/post/edit_form/$1';
$route['api/v1/payment_duration']['GET'] = "api/v1/presets/payemnt_duration";
$route['api/v1/calculate_price']['POST'] = "api/v1/presets/calculate_price";
$route['api/v1/upload_logo']['POST'] = 'api/v1/upload/upload_logo';
$route['api/v1/payment']['POST'] = 'api/v1/post/payment';
$route['api/v1/report_ad']['POST'] = 'api/v1/post/report_ad';
$route['api/v1/social_authenticate']['POST'] = 'api/v1/auth/social_authenticate';

$route['push_notifications'] = 'cron/push_notifications';

$route['home/send_couponemail'] = "home/send_couponemail";
$route['home/send_couponsms'] = "home/send_couponsms";
$route['home/set_make'] = "home/set_make";
$route['users/migrate'] = "users/migrate";
$route['terms-of-use.html'] = "home/terms";
$route['reviews/(:num)'] = "home/reviews/$1";
$route['pd-privacy-policy.html'] = "home/privacy";
$route['pd-cookie-policy.html'] = "home/cookie";
$route['success/(:any)'] = "home/campaign_success/$1";
$route['home/page_not_found'] = 'home/page_not_found';
$route['coupon-offers'] = "adpost/coupon_offers";

$route['db_backup'] = "cron/db_backup";
$route['location/(:num)/(:any)'] = "home/add_location/$1/$2";
$route['campaign'] = "home/campaign";
$route['car'] = "home/car";
$route['job'] = "home/job";
$route['bike'] = "home/bike";
$route['realstate'] = "home/realstate";
$route['news/(:num)'] = "home/news_detail/$1";
$route['news-list'] = "home/news";
$route['adpost/upload_file'] = "adpost/upload_file";
$route['adpost/remove_image'] = "adpost/remove_image";
$route['adpost/myad_payment'] = "adpost/myad_payment";
$route['adpost/find_model'] = "adpost/find_model";
$route['adpost/find_region'] = "adpost/find_region";
$route['adpost/select_category1'] = "adpost/select_category1";
$route['adpost/select_category2'] = "adpost/select_category2";
$route['adpost/select_category3'] = "adpost/select_category3";
$route['adpost/select_category4'] = "adpost/select_category4";
$route['adpost/adddata'] = "adpost/adddata";
$route['adpost/success'] = "adpost/success";
$route['adpost/cancel'] = "adpost/cancel";
$route['adpost/getPrice123'] = "adpost/getPrice123";
$route['adpost/getPrice'] = "adpost/getPrice";
$route['adpost/payment/(:num)'] = "adpost/payment/$1";
$route['adpost/upload_images'] = "adpost/upload_images";
$route['adpost/upload_images/(:num)'] = "adpost/upload_images/$1";
$route['adpost/deletepost/(:num)']['POST'] =  "adpost/deletepost/$1";
$route['adpost/update_image/(:num)/(:num)'] = "adpost/update_image/$1/$2";
$route['adpost/delete_image/(:num)']['POST'] = "adpost/delete_image/$1";
$route['ads/(:num)/change_status/(:num)'] = "adpost/change_status/$1/$2";
$route['users/logout'] = "users/logout";
$route['home/facebook_login'] = "home/facebook_login";
$route['home/reply'] = "home/reply";
$route['home/checkcron'] = "home/checkcron";
$route['fbcallback'] = "home/fbcallback";
$route['users/gmailcallback'] = "users/gmailcallback";
$route['verify_mobile.html'] = "adpost/verify_mobile";
$route['add-pincode.html'] = "adpost/add_pincode";
$route['post-ad.html'] = "adpost";
$route['dashboard.html'] = "users/dashboard";
$route['users/getoffers'] = "users/getoffers";
$route['users/getoffer_messages'] = "users/getoffer_messages";
$route['adpost/addcomment'] = "adpost/addcomment";
$route['profile-setting.html']="users/profile";
$route['login.html'] = "users/login";
$route['sign-up.html'] = "users/signup";
$route['sign-up.html/(:any)'] = "users/signup/$1";
$route['forgot.html'] = "users/forgot";
$route['users/get_address/(:any)'] = "users/get_address/$1";
$route['users/get_address_region/(:any)'] = "users/get_address_region/$1";
$route['home/getpost/(:any)'] = "home/getpost/$1";
$route['users/get_address_post'] = "users/get_address_post";
$route['users/update_password/(:any)'] = "users/update_password/$1";
$route['users/upload_file'] = "users/upload_file";
$route['users/addtask'] = "users/addtask";
$route['users/taskstatus'] = "users/taskstatus";
$route['users/deletetask'] = "users/deletetask";
$route['users/remove_image'] = "users/remove_image";
$route['users/forgot'] = "users/forgot";
$route['activate_account/(:any)'] = "users/activate_account/$1";
$route['search.html'] = "home/search";
$route['pd-contact.html'] = "home/contact";
$route['pd-about-us.html'] = "home/about";
$route['pd-terms-of-use.html'] = "home/terms";
$route['search.html/(:num)'] = "home/search";
$route['my-ad.html'] = "adpost/myad_post";
$route['privacy-setting.html'] = "users/privacy";
$route['invite-friend.html'] = "users/invite_friends";
$route['referral_dashboard'] = "users/referral_dashboard";
$route['send_invite_request'] = "users/send_invite_request";
$route['cron/send_inviteFriendEmail'] = 'cron/send_inviteFriendEmail';
$route['cron/inviteEmail'] = 'cron/inviteEmail';
$route['cron/sendDealNewsletter'] = 'cron/sendDealNewsletter';
$route['myfavourites.html'] = "adpost/myfavourites";
$route['adpost/delete_wishlist/(:num)']['POST'] = "adpost/delete_wishlist/$1";
$route['offers/(:any)'] = "adpost/offers/$1";
$route['offerlists.html'] = "adpost/offerlists";
$route['offermessages.html'] = "adpost/offermessages";
$route['offers_detail.html'] = "adpost/offers_detail";
$route['my-ad.html/images/(:num)'] = "adpost/postimages/$1";
$route['post-edit.html'] = "adpost/edit_adpost";
$route['users/signup'] = "users/signup";
$route['users/login'] = "users/login";
$route['test.html'] = "users/signup";
$route['users/profile/(:any)'] = "users/profile";
$route['users/changepassword/(:any)'] = "users/changepassword";
$route['forgot-password'] = "users/forgot";
$route['adpost/send_email'] = "adpost/send_email";
$route['adpost/share_post'] = "adpost/share_post";
$route['home/reportAd'] = "home/reportAd";
$route['home/mailgun'] = "home/mailgun";
$route['home/newsletter'] = "home/newsletter";
$route['home/favourite'] = "home/favourite";
$route['home/note_seen'] = "home/note_seen";
$route['pd-(:any)'] = "home/page_detail/$1";
$route['post/print_post/(:num)'] = "home/print_post/$1";
$route['post/photo_gallery/(:num)'] = "home/photo_gallery/$1";
$route['xx-(:any)/p-(:num)'] = "home/post_detail/$1/$2";
$route['preview-ad.html'] = "adpost/preview_ad";
$route['adpost/publish'] = "adpost/publish";
$route['xx-(:any)'] = "home/list_posts_category/$1";
$route['xx-(:any)/(:num)'] = "home/list_posts_category/$1";
$route['(:any)/(:any)/(:any)/p-(:num)'] = "home/post_detail/$1/$2/$3/$4";
$route['(:any)/(:any)/p-(:num)'] = "home/post_detail/$1/$2/$3";
$route['(:any)/p-(:num)'] = "home/post_detail/$1/$2";
$route['(:any)/(suburb)/(:any)'] = "home/postbylocation";
//$route['location/(:num)/(:any)'] = "home/postbylocation";
$route['make/(:num)/(:any)'] = "home/filterbyMake";
$route['price_type/(:num)/(:any)'] = "home/price_type";
$route['(:any)/(:any)/(:any)'] = "home/search_post";
$route['(:any)/(:any)/(:any)/(:num)'] = "home/search_post";
$route['(:any)/(:any)'] = "home/search_post";
$route['(:any)/(:any)/(:num)'] = "home/search_post";
$route['(:any)'] = "home/search_post";
$route['(:any)/(:num)'] = "home/search_post";

$route['404_override'] = 'home/page_not_found';


/* End of file routes.php */
/* Location: ./application/config/routes.php */