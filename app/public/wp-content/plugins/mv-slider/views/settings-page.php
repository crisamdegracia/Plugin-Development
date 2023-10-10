<div class="wrap">

    <!--  get_admin_page_titile() - This will get us the value we passed in the first parameter of the function that's adding our menu. 
          ung sa add_menu() meron don nakalagay MV SLIDER OPTIONS -->
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <?php 
        $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'main_options';
    ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=mv_slider_admin&tab=main_options" class="nav-tab <?php echo $active_tab == 'main_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Main Options', 'mv-slider' ); ?></a>
        <a href="?page=mv_slider_admin&tab=additional_options" class="nav-tab <?php echo $active_tab == 'additional_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Additional Options', 'mv-slider' ); ?></a>
    </h2>

    <!--ung form daw masa-submit sa options.php pwede makita ung page nayon by accessing wp-admin/options.php
        kapag nasubmit daw doon. ichechek kung my error or wala,
        kung wala irereturn sa page?? — hindi nadaw kaylangan gumawa ng file na options.php 
    the form - needs things - fields and submit button
    -->
    <form action="options.php" method="post">
        
    <?php
      settings_fields( 'mv_slider_group' );
      do_settings_sections( 'mv_slider_page1' );
    
    if( $active_tab == 'main_options' ){
            settings_fields( 'mv_slider_group' );
            do_settings_sections( 'mv_slider_page1' );
        }else{
            settings_fields( 'mv_slider_group' ); 
            do_settings_sections( 'mv_slider_page2' );
        }
        submit_button( esc_html__( 'Save Settings', 'mv-slider' ) );
    ?>
    </form>
</div>