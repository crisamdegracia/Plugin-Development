<?php

if (!class_exists('MV_Slider_Post_Type')) {

    class MV_Slider_Post_Type {
        function __construct() {

            add_action('init', array($this, 'create_post_type'));

        }

        public function create_post_type() {
            register_post_type(
                'mv-slider',
                array(
                    'label' => 'Slider',
                    'description' => 'Sliders',
                    'labels' => array(
                        'name' => 'Sliders',
                        'singular_name' => 'Slider',
                    ),
                    'public' => true,
                    'supports' => array('title', 'editor', 'thumbnail'),
                    'hierarchical' => true, // eto dapat kasama nakalagay sa supports ung page-attributes —
                    // ang usage neto pwede gumawa ng parent-child relationship sa post
                    // so false sya kasi hndi need
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'menu_position' => 5,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true, // pwede makita sa Menu nav bar
                    'can_export' => true, // pwede makita dun sa Tools export
                    'has_archive' => false, // kapag true pwede mong gawan sa archive-post-type, tapos makikita rin sa Menu navbar pwedeng iadd.
                    'exclude_from_search' => false,
                    'publicly_queryable' => false, // querries can be performed on the front-end using post_type or not
                    //public_queryable - pero kung, ung has_archive daw naka true, okay daw gamitin kung ung individual post are for viewing
                    'show_in_rest' => true, // aha! true para makita rin sa Editor block. for Guttenburg ?
                    // so ayon nga, hindi na ung lumang editor once naka show_in_rest = true
                    'menu_icon' => 'dashicons-images-alt2',
                ));
        }
    }
}