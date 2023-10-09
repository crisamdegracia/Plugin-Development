<?php 

if( ! class_exists( 'MV_Slider_Settings' )){
    class MV_Slider_Settings{

		//Pubtlic static dadw - so we can access it outside this class, but without having to create an object for it
		// the goal is to store an array with the values of all settings
        public static $options;

        public function __construct(){

			//ung selt::$options eto ung way na pag call ng php object ata nung nasa Netflix clone ako natatandaan ko
			//get_option() - eto API nadaw to
			//
            self::$options = get_option( 'mv_slider_options' );
            add_action( 'admin_init', array( $this, 'admin_init') );
        }


		//we will create 2 section and 4 fields
        public function admin_init(){

            register_setting( 'mv_slider_group', 'mv_slider_options', array( $this, 'mv_slider_validate' ) );


			//4 parameters,
			// 1st - ID this ID daw will link between section daw. dko pa gets
			// 2nd - is the Sections title
			// 3rd - is a callback function so we can add text with explaination below title
			//4th - the page on which the section will appear
			// pwede daw makita ung page kung gagamitin tong mga values sa 4th parameter
			// general - writing - reading - discussion - media - privacy - permalink
			// in our case daw we will define a new page name called mv_slider_page1
			// we need this value daw [mv_slider_page1] to bind to other section
            add_settings_section(
                'mv_slider_main_section',
                esc_html__( 'How does it work?', 'mv-slider' ),
                null,
                'mv_slider_page1'
            );

            add_settings_section(
                'mv_slider_second_section',
                esc_html__( 'Other Plugin Options', 'mv-slider' ),
                null,
                'mv_slider_page2'
            );



			// 1st param is an ID - this is going to be an ID for the field inside the database table
			// 2nd is the title of the field
			// 3rd param is call back the creates the fields content
			// 4th is the ID of the page wher this field has to appear - ung kreate natin sa taas
			// 5th is the ID of the section it has to appear
            add_settings_field(
                'mv_slider_shortcode',
                esc_html__( 'Shortcode', 'mv-slider' ),
                array( $this, 'mv_slider_shortcode_callback' ),
                'mv_slider_page1',
                'mv_slider_main_section'
            );

            add_settings_field(
                'mv_slider_title',
                esc_html__( 'Slider Title', 'mv-slider' ),
                array( $this, 'mv_slider_title_callback' ),
                'mv_slider_page2',
                'mv_slider_second_section',
                array(
                    'label_for' => 'mv_slider_title'
                )
            );

			
            add_settings_field(
                'mv_slider_bullets',
                esc_html__( 'Display Bullets', 'mv-slider' ),
                array( $this, 'mv_slider_bullets_callback' ),
                'mv_slider_page2',
                'mv_slider_second_section',
                array(
                    'label_for' => 'mv_slider_bullets'
                )
            );

            add_settings_field(
                'mv_slider_style',
                esc_html__( 'Slider Style', 'mv-slider' ),
                array( $this, 'mv_slider_style_callback' ),
                'mv_slider_page2',
                'mv_slider_second_section',
                array(
                    'items' => array(
                        'style-1',
                        'style-2'
                    ),
                    'label_for' => 'mv_slider_style'
                )
                
            );
        }

        public function mv_slider_shortcode_callback(){
            ?>
            <span><?php esc_html_e( 'Use the shortcode [mv_slider] to display the slider in any page/post/widget', 'mv-slider' ); ?></span>
            <?php
        }

        public function mv_slider_title_callback( $args ){
            ?>
                <input 
                type="text" 
                name="mv_slider_options[mv_slider_title]" 
                id="mv_slider_title"
                value="<?php echo isset( self::$options['mv_slider_title'] ) ? esc_attr( self::$options['mv_slider_title'] ) : ''; ?>"
                >
            <?php
        }
        
        public function mv_slider_bullets_callback( $args ){
            ?>
                <input 
                    type="checkbox"
                    name="mv_slider_options[mv_slider_bullets]"
                    id="mv_slider_bullets"
                    value="1"
                    <?php 
                        if( isset( self::$options['mv_slider_bullets'] ) ){
                            checked( "1", self::$options['mv_slider_bullets'], true );
                        }    
                    ?>
                />
                <label for="mv_slider_bullets"><?php esc_html_e( 'Whether to display bullets or not', 'mv-slider' ); ?></label>
                
            <?php
        }

        public function mv_slider_style_callback( $args ){
            ?>
            <select 
                id="mv_slider_style" 
                name="mv_slider_options[mv_slider_style]">
                <?php 
                foreach( $args['items'] as $item ):
                ?>
                    <option value="<?php echo esc_attr( $item ); ?>" 
                        <?php 
                        isset( self::$options['mv_slider_style'] ) ? selected( $item, self::$options['mv_slider_style'], true ) : ''; 
                        ?>
                    >
                        <?php echo esc_html( ucfirst( $item ) ); ?>
                    </option>                
                <?php endforeach; ?>
            </select>
            <?php
        }

        public function mv_slider_validate( $input ){
            $new_input = array();
            foreach( $input as $key => $value ){
                switch ($key){
                    case 'mv_slider_title':
                        if( empty( $value )){
                            add_settings_error( 'mv_slider_options', 'mv_slider_message', esc_html__( 'The title field can not be left empty', 'mv-slider' ), 'error' );
                            $value = esc_html__( 'Please, type some text', 'mv-slider' );
                        }
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                    default:
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                }
            }
            return $new_input;
        }

    }
}

