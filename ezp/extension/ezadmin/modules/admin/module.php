<?php
/**
 * File module.php
 *
 * @package ezadmin
 * @version //autogentag//
 * @copyright Copyright (C) 2007 xrow. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.txt GPL License
 */
$Module = array( "name" => "Admin",
                 "variable_params" => true,
                 "function" => array(
                     "script" => "changeuser.php",
                     "params" => array( ) ) );

$ViewList = array();
$ViewList["setowner"] = array(
    'functions' => array( 'setowner' ),
    'default_navigation_part' => 'ezadmin',
    "script" => "setowner.php",
    'params' => array( 'ObjectID' ) );
$ViewList["changeuser"] = array(
    'functions' => array( 'userchange' ),
    'default_navigation_part' => 'ezadmin',
    "script" => "changeuser.php",
    'params' => array( 'ObjectID' ) );
$ViewList["changeuserview"] = array(
    'default_navigation_part' => 'ezadmin',
    "script" => "changeuserview.php",
    'params' => array( ) );
$ViewList["recalluser"] = array(
    'default_navigation_part' => 'ezadmin',
    "script" => "recalluser.php",
    'params' => array( ) );
$ViewList["backup"] = array(
    'default_navigation_part' => 'ezadmin',
    'functions' => array( 'backup' ),
    "script" => "backup.php",
    'params' => array(  ) );
$ViewList["phpinfo"] = array(
    'default_navigation_part' => 'ezadmin',
    'functions' => array( 'phpinfo' ),
    "script" => "phpinfo.php",
    'params' => array(  ) );
$ViewList["menu"] = array(
    'default_navigation_part' => 'ezadmin',
    "script" => "menu.php",
    'params' => array(  ) );
$ViewList["sqlquery"] = array(
    'functions' => array( 'sqlquery' ),
    'default_navigation_part' => 'ezadmin',
    "script" => "sqlquery.php",
    'params' => array( 'sql' ) );
$ViewList["phpmyadmin"] = array(
    'functions' => array( 'phpmyadmin' ),
    'default_navigation_part' => 'ezadmin',
    "script" => "phpmyadmin.php",
    'params' => array( ) );
$ViewList["frame"] = array(
    "script" => "frame.php",
    'default_navigation_part' => 'ezadmin',
    'ui_context' => 'edit',
    'ui_component' => 'content',
    'single_post_actions' => array( 'Exit' => 'Exit' ),
    'params' => array( "modulename", "view" ) );
$ViewList["apc"] = array(
    'default_navigation_part' => 'ezadmin',
    'functions' => array( 'accelerator' ),
    'script' => 'apc.php',
    'params' => array( ) );
$ViewList["eaccelerator"] = array(
    'default_navigation_part' => 'ezadmin',
    'functions' => array( 'accelerator' ),
    'script' => 'eaccelerator.php',
    'params' => array( ) );
$ViewList["maintance"] = array(
    "script" => "maintance.php",
    'params' => array( 'date', 'time' ) );
$ViewList['client'] = array(
	'script' => 'client.php',
	'default_navigation_part' => 'ezadmin',
	'functions' => array( 'systemtesting' ),
	'single_post_actions' => array( 'Cancel' => 'Cancel' ),
	'post_action_parameters' => array( 'Cancel' => array(  ) ),
	"params" => array( ),
	"unordered_params" => array(  ) );
$ViewList['mailtest'] = array(
	'script' => 'mailtest.php',
	'default_navigation_part' => 'ezadmin',
	'functions' => array( 'systemtesting' ),
	'single_post_actions' => array( 'Cancel' => 'Cancel' ),
	'post_action_parameters' => array( 'Cancel' => array(  ) ),
	"params" => array( ),
	"unordered_params" => array(  ) );

$FunctionList['setowner'] = array( );
$FunctionList['systemtesting'] = array( );
$FunctionList['userchange'] = array( );
$FunctionList['backup'] = array( );
$FunctionList['phpinfo'] = array( );
$FunctionList['menu'] = array( );
$FunctionList['sqlquery'] = array( );
$FunctionList['phpmyadmin'] = array( );
$FunctionList['accelerator'] = array( );
?>
