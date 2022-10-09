<?php

if (!class_exists('MV_Slider_Post_Type')) {

    class MV_Slider_Post_Type {
        function __construct() {

            add_action('init', array($this, 'create_post_type'));
            add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
            add_action('save_post', array($this, 'save_post'), 10, 2);

            //to add filtering in the list of the posts
            // starts with manaege_[CPT KEY] then [_posts_columns]
            add_filter('manage_mv-slider_posts_columns', array($this, 'mv_slider_cpt_columns'));

            //to add value to the columns
            // 10 - the priority -- 2 -number of args
            add_action('manage_mv-slider_posts_custom_column', array($this, 'mv_slider_custom_columns'), 10, 2);

            //it will sort the table in the column using the Name column
            //since we didnt spcify the number of parameters - that means this methos will only accept one parameter
            add_filter('manage_edit-mv-silder_sortable_columns', array($this, 'mv_silder_sortable_columns'));
            add_filter('manage_edit-mv-slider_sortable_columns', array($this, 'mv_slider_sortable_columns'));

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
                    'show_in_rest' => false, // aha! true para makita rin sa Editor block. for Guttenburg ?
                    // so ayon nga, hindi na ung lumang editor once naka show_in_rest = true
                    'menu_icon' => 'dashicons-images-alt2',

                    //same daw dun sa add_action( 'add_meta_boxed' )
                    //it can recieves a function or cb merhod that can be used to register a metabox
                    // 'register_meta_box_cb' => array($this, 'add_meta_boxes')
                ));

        } //create post type

        //Vid 24
        // the parameter here is an array that contains all the columns that my post type
        // table will display
        //$columns['column-id'] = 'Column text'
        public function mv_slider_cpt_columns($columns) {

            // $column[ METADATA KEY ]
            $columns['mv_slider_link_text'] = esc_html__('Link Text', 'mv-slider');
            $columns['mv_slider_link_url'] = esc_html__('Link URL', 'mv-slider');

            return $columns;
        }

        //to put value dun sa column fields
        public function mv_slider_custom_columns($column, $post_id) {
            switch ($column) {
            case 'mv_slider_link_text';
                //last args [true] - coz we dont want an array here - we only need a single string wtih the fields value
                echo esc_html(get_post_meta($post_id, 'mv_slider_link_text', true));
                break;

            case 'mv_slider_link_url';
                echo esc_url(get_post_meta($post_id, 'mv_slider_link_url', true));
                break;
            }
        }

        public function mv_slider_sortable_columns($columns) {

            //we can choose what column can be sortable
            $columns['mv_slider_link_text'] = 'mv_slider_link_text';
            return $columns;
        }


        public function add_meta_boxes() {
            //1st param this value daw will be use as CSS ID of the metabox
            //2nd -  // then a title
            //4th parameter - is the screen which metabox will show up. its a key
            //5th parameter - is context - define the position of the box within the editing area.
            // we can choose between placing the metabox in before or after the post title, before post link or after the editor or inside the editing area etc etc
            //6th param - is priority, this will define the order in which the metabox is displayed, relative to another metabox position
            //7th Param - is an optional array args - that we can use to pass data to you CB function.
            // if we choose to pass the array,  you must reference it here as the 2nd param of the CB func the add_inner_meta_boxes
            // then you can get the value by calling $test (2nd param)  $test['args']['foo'] — so inundo nya kaya wala ung 7th param

            //this is WP function
            add_meta_box(
                'mv_slider_meta_box',
                'Link Options',
                array($this, 'add_inner_meta_boxes'), //CB function that will help us build the content inside the metabox, so gagawa ng panibagopng funtion
                'mv-slider',
                'normal',
                'high',
            );
        }

        //Parameter $post is - $post object -very important coz WP has to know which post will reciv the data from our metabox

        public function add_inner_meta_boxes($post) {
            require_once MV_SLIDER_PATH . 'views/mv-slider_metabox.php';
        }

        //Create 2 variable for for each field in metabox
        public function save_post($post_id) {

// ----------- GUARD CLAUSE  ------------------------------------------------- //
            // Guard clause use to exit functions early if the condition is not met
            if (isset($_POST['mv_slider_nonce'])) {
                //check value if not expected value 1st arg: the value 2nd arg: name of nonce
                if (!wp_verify_nonce($_POST['mv_slider_nonce'], 'mv_slider_nonce')) {
                    // if false return nothing
                    return;
                }
            }
            //avoid auto save
            if (defined(' DOIN_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }
            //verify if the user can access page and make use the post type editing screen
            if (isset($_POST['post_type']) && $_POST['post_type'] === 'mv-slider') {
                //then check user if they can edit page
                if (!current_user_can('edit_page', $post_id)) {
                    return;
                }
                //then check user if they can edit post
                elseif (!current_user_can('edit_post', $post_id)) {
                    return;
                }
            }

// ----------- GUARD CLASE END ------------------------------------------------- //

            if (isset($_POST['action']) & isset($_POST['action']) == 'editpost') {
                //get old value — if already exists in the table
                //2nd args is the name of the key from the table field in the table ( from view/)
                // for now no value - but when somethings saved the key will have the same name as the name attribute in my input elements
                //3rd args = if we want to retrieve the key value as string or as an array — for single value
                $old_link_text = get_post_meta($post_id, 'mv_slider_link_text', true);
                $old_link_url = get_post_meta($post_id, 'mv_slider_link_url', true);

                //get the new value field, which will be passed by the user in the admin
                // to get daw the value  sent by the user in the form
                $new_link_text = $_POST['mv_slider_link_text'];
                $new_link_url = $_POST['mv_slider_link_url'];

                if (empty($new_link_text)) {
                    //1st ID, 2md Metakey, 3rd new value, 4th old value
                    update_post_meta($post_id, 'mv_slider_link_text', esc_html__('Add some text', 'mv-slider'));
                } else {
                    update_post_meta($post_id, 'mv_slider_link_text', sanitize_text_field($new_link_text), $old_link_text);
                }

                if (empty($new_link_url)) {
                    update_post_meta($post_id, 'mv_slider_link_url', '#');
                } else {
                    update_post_meta($post_id, 'mv_slider_link_url', sanitize_text_field($new_link_url), $old_link_url);
                }

            }
        }
    }
}