<?php
/*
Plugin Name: Developer Code Editor
Plugin URI: http://MyWebsiteAdvisor.com
Description: Plugin for developers to enhance default wordpress code editor.
Version: 1.0
Author: MyWebsiteAdvisor
Author URI: http://MyWebsiteAdvisor.com
*/

register_activation_hook(__FILE__, 'developer_code_editor');

// display error message to users
if ($_GET['action'] == 'error_scrape') {                                                                                                   
    die("Sorry,  Plugin requires PHP 5.0 or higher. Please deactivate Plugin.");                                 
}

function developer_code_editor() {
	if ( version_compare( phpversion(), '5.0', '<' ) ) {
		trigger_error('', E_USER_ERROR);
	}
}

// require  Plugin if PHP 5 installed
if ( version_compare( phpversion(), '5.0', '>=') ) {
	define('DCE_LOADER', __FILE__);

	require_once(dirname(__FILE__) . '/developer-code-editor.php');
	require_once(dirname(__FILE__) . '/plugin-admin.php');

}
?>