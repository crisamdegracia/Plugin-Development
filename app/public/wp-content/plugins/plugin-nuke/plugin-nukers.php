<?php 
/*
 * Plugin Name: Masdev Slider
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
 */
if (!defined('ABSPATH')) {
    die('A message if somebody directly execute the file');
    exit;
}

if( ! class_exists('Masdev_Slider') ){

	class Masdev_Slider {

		function __construct() {


		}

	}

}



if (class_exists('Masdev_Slider')) {
    //1st is the name of the file that will be used to name the hook that performs the plugin and activation
    // ung 2nd parameter daw must be s static function or method - activate,deactivae,uninstall
    //the idea daw is you dont have to be forced to instantiate an object to have access to this method
    // inside array we pass the php Class name and method name
    // it wiill create daw an action hook active_mv-slider/mv-slider.php
    register_activation_hook(__FILE__, array('Masdev_Slider', 'activate'));

    // it wiill create daw an action hook active_mv-slider/mv-slider.php
    register_deactivation_hook(__FILE__, array('Masdev_Slider', 'deactivate'));

    // it wiill create daw an action hook active_mv-slider/mv-slider.php
    register_uninstall_hook(__FILE__, array('Masdev_Slider', 'uninstall'));

    $masdev_slider = new Masdev_Slider();
}


?>
