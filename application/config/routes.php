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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'Auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['about'] = 'Pages/about';
$route['gallery'] = 'Pages/gallery';
$route['contact'] = 'Pages/contact';
$route['reservation'] = 'Pages/reservation';
//$route['html_api/(:any)'] = 'Pages/calling_html_api/$1';
//$route['timing_api/(:any)'] = 'Pages/calling_timing_api/$1';
$route['get_html_timing/(:any)/(:any)'] = 'Pages/getHtmlForFooter/$1/$2';
$route['get_html_timing'] = 'Pages/validation1';
$route['get_html_timing/(:any)'] = 'Pages/validation2';
$route['get_our_deals_data/(:any)/(:any)'] = 'Pages/get_our_deals_data/$1/$2';
$route['get_our_deals_data'] = 'Pages/validation3';
$route['get_our_deals_data/(:any)'] = 'Pages/validation4';
$route['get_header_data/(:any)/(:any)'] = 'Pages/get_header_data/$1/$2';
$route['get_header_data'] = 'Pages/validation5';
$route['get_header_data/(:any)'] = 'Pages/validation6';
$route['Contact'] = 'Contact';
$route['about_us_contact/(:any)/(:any)'] = 'Pages/about_us_html_contact/$1/$2';
$route['about_us_contact'] = 'Pages/validation7';
$route['about_us_contact/(:any)'] = 'Pages/validation8';
$route['get_reservation_html/(:any)'] = 'Pages/get_reservation_html/$1';
//$route['get_gallery_details/(:any)/(:any)'] = 'Pages/get_gallery_html_image_url/$1/$2';
$route['get_gallery_details'] = 'Pages/validation9';
$route['get_gallery_details/(:any)'] = 'Pages/validation10';


















