<?PHP
/*
Plugin Name: HostingXS API (v2) client for Wordpress
Plugin URI: http://api.hostingxs.nl
Description: Allows domain checks & ordering of products etc
Version: 1 (API 2)
Author: DHP Klabbers - HYN.me
Author URI: http://hyn.me
License: Commercial; for HostingXS resellers only
*/ 




// load the hxs client in lib dir
require_once( __DIR__ . "/lib/hxsclient.php" );

// options page etc 
require_once(__DIR__ . "/hxs-options.php");
// widget
require_once(__DIR__ . "/hxs-widget.php");
// page
require_once(__DIR__ . "/hxs-page.php" );