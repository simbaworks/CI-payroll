<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$major                          = 1;               //NEW VERSION
$module_verion                  = 0;                //CHANGES OR ADD IN MODULES
$bug_fixing                     = 0;                //SMALL BUG FIXING
$version_status                 = 'Development';
// $version_status               = 'Production';

$config['version_status']       = $version_status;
$config['version']              = $major . '.' . $module_verion . '.' . $bug_fixing;
$config['title']                = 'JCI HRMS | V ' . $major;
$config['site_title']           = $config['title'] . ' (' . $config['version'] . ') &copy ' . date('Y') . ' | ' . $version_status;
$config['pegination_per_page']  = '50';
$config['report_interval_time'] = '30';
$config['admin_folder']         = 'admin';
$config['assets_folder']        = 'assets';
$config['css_folder']           = 'css';
$config['js_folder']            = 'js';
$config['upload_folder']        = 'uploads';
$config['vendor_folder']        = 'vendor';
$config['img_folder']           = 'img';
$config['asess_code']           = 'ADMIN_v' . $major . '_';
$config['footer_text']          = '2021 - ' . date('Y') . ' &copy; <a href="http://www.nodomain.com" target="_blank">JCI HRMS</a>. All rights reserved.';


