<?

class Developer_Code_Editor_Admin extends Developer_Code_Editor {
	/**
	 * Error messages to diplay
	 *
	 * @var array
	 */
	private $_messages = array();
	
	
	
	/**
	 * Class constructor
	 *
	 */
	public function __construct() {
		$this->_plugin_dir   = DIRECTORY_SEPARATOR . str_replace(basename(__FILE__), null, plugin_basename(__FILE__));
		$this->_settings_url = 'options-general.php?page=' . plugin_basename(__FILE__);;
	
      
		add_action('admin_print_scripts-theme-editor.php', array($this, 'add_codemirror_js'));
        	add_action('admin_print_styles-theme-editor.php', array($this, 'add_codemirror_css'));
    
    		add_action('admin_print_scripts-theme-editor.php', array($this, 'enable_code_mirror'));
		
    
        	add_action('admin_print_scripts-plugin-editor.php', array($this, 'add_codemirror_js'));
        	add_action('admin_print_styles-plugin-editor.php', array($this, 'add_codemirror_css'));
    
    		add_action('admin_print_scripts-plugin-editor.php', array($this, 'enable_code_mirror'));
		
        	//add_action('admin_footer', array($this, 'enable_code_mirror'));


		$allowed_options = array();
		
		
		if(array_key_exists('option_name', $_GET) && array_key_exists('option_value', $_GET)
			&& in_array($_GET['option_name'], $allowed_options)) {
			update_option($_GET['option_name'], $_GET['option_value']);
			
			header("Location: " . $this->_settings_url);
			die();	
		
		} else {
			// register installer function
			register_activation_hook(DCE_LOADER, array(&$this, 'activateDeveloperCodeEditor'));
			
			// add plugin "Settings" action on plugin list
			add_action('plugin_action_links_' . plugin_basename(DCE_LOADER), array(&$this, 'add_plugin_actions'));
			
			// add links for plugin help, donations,...
			add_filter('plugin_row_meta', array(&$this, 'add_plugin_links'), 10, 2);
			
			// push options page link, when generating admin menu
			//add_action('admin_menu', array(&$this, 'adminMenu'));
	
		}
	}
	
	/**
	 * Add "Settings" action on installed plugin list
	 */
	public function add_plugin_actions($links) {
		array_unshift($links, '<a href="options-general.php?page=' . plugin_basename(__FILE__) . '">' . __('Settings') . '</a>');
		
		return $links;
	}
	
	/**
	 * Add links on installed plugin list
	 */
	public function add_plugin_links($links, $file) {
		if($file == plugin_basename(TW_LOADER)) {
			$links[] = '<a href="http://MyWebsiteAdvisor.com">Premium Plugins</a>';
		}
		
		return $links;
	}
	
	/**
	 * Add menu entry 
	 */
	public function adminMenu() {		
		// add option in admin menu, for setting options
		//$plugin_page = add_options_page('Developer Options', 'Developer Options', 8, __FILE__, array(&$this, 'optionsPage'));

	}
	

	
  	
  
	


	function add_codemirror_css(){ ?>
		<!-- Codemirror CSS Start -->
		<link type="text/css" rel="stylesheet" href="<?php echo WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); ?>codemirror/codemirror.css"></link>
		<link type="text/css" rel="stylesheet" href="<?php echo WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); ?>codemirror/default.css"></link>
		<!-- Codemirror CSS End -->	
	
	<?
	}
  
	
	function add_codemirror_js(){ ?>
		<!-- Codemirror JS Start -->
		<script language="javascript" src="<?php echo WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); ?>codemirror/codemirror.js"></script>
      		<script language="javascript" src="<?php echo WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); ?>codemirror/javascript/javascript.js"></script>
		<script language="javascript" src="<?php echo WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); ?>codemirror/css/css.js"></script>
		<script language="javascript" src="<?php echo WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); ?>codemirror/php/php.js"></script>
      		<script language="javascript" src="<?php echo WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); ?>codemirror/xml/xml.js"></script>
	      <!-- Codemirror JS End -->	
	
	<?
	}
	
	
  
  	function enable_code_mirror(){
    		add_action('admin_footer', array($this, 'print_code_mirror'));
    	
  	}
  
  
	function print_code_mirror(){ ?>
	<script language="javascript">
      		var editor = CodeMirror.fromTextArea(document.getElementById("newcontent"), { 
      			lineWrapping: 'true',
      			lineNumbers: 'true',
 			mode: "application/x-httpd-php"   	
    	});
    	</script>
	<?
      
	}




}

$developer_code_editor = new Developer_Code_Editor_Admin();
?>