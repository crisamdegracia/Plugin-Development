<?php
/* 
* Plugin Name: MV Slider
* Plugin URI: sample.uri.com
* Description: Test Description Lorem ipsum
* Version: 1.0
* Requires at least: 5.6
* Author: Crisam Pogee
* Author URI: https://crisamdegracia.github.io
* License: GPL v2 or later
* license URI: https://www.gnu.org/licenses/gpl-2.0
* Text Domain: my-slider
* Domain Path: /languages



ung license important kung isubmit natin sa wordpress.org
text domain - to identify translatable strings in your planning
whenever you have a string that has  to be translated, 
 -you will pass it through a translation function and use this term here as the second parameter
 - so in this case our name will be mv-slide

 domain path - this is the path where WP will look for translation files
*/
/* kaya my script na to for security
if the file access directly - it stop the execution of the script with the exit method

*/
if (! defined( 'ABSPATH' ) ){
	die('A message if somebody directly execute the file');
	exit;
}

if( ! class_exists( 'MV_Slider') ){
	class MV_slider {
		//Constructor - the first method to be executed;
		function __construct(){

			//calling define_constants function
			$this->define_constants();
		}

		public function define_constants(){
			//home/www/my_site/wp-content/plugin/your-plugin
			define( 'MV_SLIDER_PATH', plugin_dir_path( __FILE__ ) );
			// http://example.com/wp-content/plugins/mv-slider
			define( 'MV_SLIDER_URL', plugin_dir_url( __FILE__ ) );
			//Plugin version
			define( 'MV_SLIDER_VERSION', '1.0.0' );
		}

		public static function activate(){
			//ginamit nya ung update_option( 'rewrite_rules' )
			//kasidaw in his experience deleting the values from the table on activation works better than calling this function
			//eto daw ung - pag mag resave tayo ng link sa permalink - para maforce refresh ung mga links
			// flush_rewrite_rule();

			// Vid 14 to
			//direct erasing the values in the table record
			update_option( 'rewrite_rules', '' );

		}
		public static  function deactivate(){
			//ginamit nya daw dito eto kasi daw wala naman daw idedelete unlike sa activate method()
				flush_rewrite_rule();
		}


		// before public function uninstall(){}
		// my static daw para dun samga hooks na register_uninstall_hook
		// required ata na static or for this purpose lang
		public static function uninstall(){}


	}
}


if( class_exists( 'MV_Slider') ){

	// ung 2nd parameter daw must be s static function or method - activate,deactivae,uninstall
	//the idea daw is you dont have to be forced to instantiate an object to have access to this method
	// inside array we pass the php Class name and method name
	// it wiill create daw an action hook active_mv-slider/mv-slider.php
	register_activation_hook( __FILE, array( 'MV_Slider', 'activate') );

	// it wiill create daw an action hook active_mv-slider/mv-slider.php
	register_deactivation_hook( __FILE, array( 'MV_Slider', 'deactivate') );

	// it wiill create daw an action hook active_mv-slider/mv-slider.php
	register_uninstall_hook( __FILE, array( 'MV_Slider', 'uninstall') );

	$mv_slider = new MV_slider();
}

