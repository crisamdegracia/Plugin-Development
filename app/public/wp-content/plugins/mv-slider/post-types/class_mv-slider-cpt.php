<?php
echo __FILE__;

if ( ! class_exists( 'MV_Slider_Post_Type' ) ){

	class MV_Slider_Post_Type {
		function __construct() { 

			add_action('init', array( $this, 'create_post_type') );

		 }	
		 
		 public function create_post_type(){
			register_post_type(
				'mv-slider',
				array(
					'label' => 'Slider',
					'description' => 'Sliders',
					'labels' => array(
						'name' => 'Sliders',
						'singular_name' => 'Slider'
					),
					'public' => true,
					'show_ui' => true
				));
		 }
	}
}