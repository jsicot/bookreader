<?php
define('BOOKREADER_PLUGIN_DIR', dirname(__FILE__));
define('BOOKREADER_PLUGIN_VERSION', get_plugin_ini('bookreader', 'version'));
define('BOOKREADER_MODE_PAGE', get_option('bookreader_mode_page'));
define('BOOKREADER_DEFAULT_WIDTH', get_option('bookreader_default_width'));
define('BOOKREADER_DEFAULT_HEIGHT', get_option('bookreader_default_height'));
add_plugin_hook('install', 'bookreader_install');
add_plugin_hook('uninstall', 'bookreader_uninstall');
add_plugin_hook('config_form', 'bookreader_config_form');
add_plugin_hook('config', 'bookreader_config');
add_plugin_hook('define_routes', 'bookreader_define_routes');
add_plugin_hook('public_append_to_items_show', 'br_append_to_item');

require_once HELPERS;
require_once BOOKREADER_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'bookreaderFunctions.php';

//installation du plugin dans omeka
function bookreader_install()
{
	set_option('bookreader_plugin_version', BOOKREADER_PLUGIN_VERSION);	
	set_option('bookreader_mode_page', '1');
	set_option('bookreader_default_width', '620'); 
	set_option('bookreader_default_height', '500');   
	                                                                                                                  
}

//désinstallation du plugin
function bookreader_uninstall()
{
	delete_option('bookreader_mode_page');
	delete_option('bookreader_default_width');
	delete_option('bookreader_default_height');
}

/**
* Shows the configuration form.
*/
function bookreader_config_form()
{
	$bookreader_mode_page = get_option('bookreader_mode_page');
	$bookreader_default_width = get_option('bookreader_default_width');
	$bookreader_default_height = get_option('bookreader_default_height');

	include 'config_form.php';
}

/**
* Processes the configuration form.
*/
function bookreader_config()
{
	set_option('bookreader_mode_page', $_POST['bookreader_mode_page']);
	set_option('bookreader_default_width', $_POST['bookreader_default_width']);
	set_option('bookreader_default_height', $_POST['bookreader_default_height']);
}


function bookreader_define_routes($router)
{

	$router->addRoute(
	    'bookreader_action',
	    new Zend_Controller_Router_Route(
	        'viewer/:action/:id', 
	        array(
	            'controller'   => 'viewer',
		    'module'       => 'book-reader',	              
	            'id'           => '/d+'
	        )
	    )
	);

}

function br_append_to_item() {
	
	if ($item == null) 
	{
		$item = get_current_item();//si null, récupère l'item actuellement consulté
	}
	
	$iditem = $item->id;
	$html = "<div><iframe src='". WEB_ROOT ."/viewer/show/". $iditem ."?ui=embed#mode/". BOOKREADER_MODE_PAGE ."up' width='". BOOKREADER_DEFAULT_WIDTH ."' height='". BOOKREADER_DEFAULT_HEIGHT ."' frameborder='0' ></iframe></div>";
	
	echo $html;
	}
	

