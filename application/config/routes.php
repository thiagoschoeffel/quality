<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'web';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

$route['laudo/(:num)'] = 'web/laudo/$1';