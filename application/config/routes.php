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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['stocks-create'] = 'products/stocks_create';
$route['warehouse-stocks-create/(:any)'] = 'products/warehouse_stocks_create/$1';
$route['stocks-summary/(:any)'] = 'products/stock_summary/$1';
$route['stocks-edit/(:any)'] = 'products/stocks_edit/$1';
$route['warehouse/edit/(:any)'] = 'warehouses/edit/$1';
$route['warehouse/view/(:any)'] = 'warehouses/view/$1';
$route['warehouse/create'] = 'warehouses/create';
$route['lists-of-products/(:any)/(:any)'] = 'warehouses/viewWarehouseProductsByStores/$1/$2';
$route['warehouse-product-view/(:any)/(:any)/(:any)'] = 'products/viewstoreproduct/$1/$2/$3';

//deliveries
$route['deliveries/(:any)/(:any)']              = 'warehouses/deliveries/$1/$2';
$route['deliveries-create/(:any)/(:any)']       = 'warehouses/deliveries_create/$1/$2';
$route['deliveries-edit/(:any)/(:any)/(:any)']  = 'warehouses/deliveries_edit/$1/$2/$3';
$route['deliveries-view/(:any)/(:any)/(:any)']  = 'warehouses/deliveries_view/$1/$2/$3'; //storename,$tid,$store_id
$route['deliveries-confirm/(:any)/(:any)']      = 'warehouses/deliveries_confirm/$1/$2'; //storeid,$tid

//pickups
$route['pickups/(:any)/(:any)'] = 'warehouses/pickups/$1/$2';
$route['pickups-create/(:any)/(:any)'] = 'warehouses/pickups_create/$1/$2';
$route['pickups-edit/(:any)/(:any)/(:any)'] = 'warehouses/pickups_edit/$1/$2/$3';
$route['pickups-view/(:any)/(:any)/(:any)'] = 'warehouses/pickups_view/$1/$2/$3';
$route['pickups-confirm/(:any)/(:any)']      = 'warehouses/pickups_confirm/$1/$2'; //storeid,$tid
//transfers
$route['transfers/(:any)/(:any)'] = 'warehouses/transfers/$1/$2';
$route['transfers-create/(:any)/(:any)'] = 'warehouses/transfers_create/$1/$2';
$route['transfers-edit/(:any)/(:any)/(:any)'] = 'warehouses/transfers_edit/$1/$2/$3';
$route['transfers-view/(:any)/(:any)/(:any)'] = 'warehouses/transfers_view/$1/$2/$3';
$route['transfers-confirm/(:any)/(:any)']      = 'warehouses/transfers_confirm/$1/$2'; //storeid,$tid

//withdrawals
$route['withdrawals/(:any)/(:any)'] = 'warehouses/withdrawals/$1/$2';
$route['withdrawals-create/(:any)/(:any)'] = 'warehouses/withdrawals_create/$1/$2';
$route['withdrawals-edit/(:any)/(:any)/(:any)'] = 'warehouses/withdrawals_edit/$1/$2/$3';
$route['withdrawals-view/(:any)/(:any)/(:any)'] = 'warehouses/withdrawals_view/$1/$2/$3';
$route['withdrawals-confirm/(:any)/(:any)']      = 'warehouses/withdrawals_confirm/$1/$2'; //storeid,$tid












