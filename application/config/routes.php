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
$route['404_override'] = 'error/error404';
$route['panitia/pos/inputpos/(:any)'] = 'panitia/inputpos/$1';
$route['panitia/pos/ubahstatus/(:any)'] = 'panitia/ubahstatus/$1';
$route['panitia/pos/tambah'] = 'panitia/tambahPos';
$route['panitia/customer/edit/(:any)'] = 'panitia/editCustomer/$1';
$route['panitia/customer/tambah'] = 'panitia/addCustomer';
$route['panitia/lelang/lihat/(:any)'] = 'panitia/seeLelang/$1';
$route['panitia/lelang/peserta/(:any)'] = 'panitia/pesertaLelang/$1';
$route['panitia/lelang/edit/(:any)'] = 'panitia/editLelang/$1';
$route['panitia/lelang/tambah'] = 'panitia/addLelang';
$route['panitia/username/reset/(:any)'] = 'panitia/resetUsername/$1';
$route['panitia/username/edit/(:any)'] = 'panitia/editUsername/$1';
$route['panitia/username/tambah'] = 'panitia/addUsername';
$route['panitia/jenis_pos/edit/(:any)'] = 'panitia/editJenisPos/$1';
$route['panitia/jenis_pos/tambah'] = 'panitia/addJenisPos';
$route['panitia/wewenang/edit/(:any)'] = 'panitia/editWewenang/$1';
$route['panitia/barang/tambah'] = 'panitia/tambahBarang';
$route['panitia/barang/edit/(:any)'] = 'panitia/editBarang/$1';
$route['create/buat'] = 'create/buat';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
