<?php
/**
  @copyright Copyright (C) 2011 - forever DeVio Multimedia 
  Made with love, wishes, and dry tears for my beloved daughters Delfia and Violina, where ever you are, Papa Love U
  Author : Anrie 'Riesurya'
  Author URI : http://riesurya.com
  Playground Main Control
**/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) 
{
    exit;
}

if ( !class_exists( 'DeVioPlaygroundPro' )):
class DeVioPlaygroundPro
{
    /**
     * @access      private
     * @since       1.0.0
     */
    private static $instance;

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.1
     * @return      self::$instance
     */
    public static function instance() 
    {
        if ( ! self::$instance ) {
            self::$instance = new self;
            self::$instance->includes();
            self::$instance->hooks();
        }

        return self::$instance;
    }

	public static $version = "2.0";

	private function __construct()
    {
        $this->plugin_path = plugin_dir_path( __FILE__ );
        $this->plugin_url  = plugin_dir_url( __FILE__ );
        
	}//eof construct

    /**
     * Include necessary files
     *
     * @access      public
     * @since       3.1.3
     * @return      void
     */
    public function includes() 
    {
  		//Auto Regenerate Thumbnails
  		require_once( $this->plugin_path . 'framework/lib/thirdparties/otf_regen_thumbs.php');
      // require $this->plugin_path . 'framework/main/class.DeVioPlaygroundPro_MainHooks.php';
    }
    
    /**
     * Run action and filter hooks
     *
     * @access      private
     * @since       3.1.3
     * @return      void
     */
    private function hooks()
    {
    	add_action( 'plugins_loaded',           array( $this, 'devio_load_textdomain' ) );
   		add_action( 'after_setup_theme', 		array( $this, 'devio_after_setup_theme' ) );
    	add_action( 'wp_head', 					array( $this, 'devio_meta_header' ), 5 );
    	add_action( 'wp_footer', 				array( $this, 'devio_footer_notice' ), 1000 );
		  add_action( 'redux/loaded', 			array( $this, 'devio_redux_removeDemoModeLink') );
    }

	/**
	 * load after theme setup
	 * @return [type] [description]
	 */
    function devio_after_setup_theme()
    {

    //Play the main hooks
    require $this->plugin_path . 'framework/main/class.DeVioPlaygroundPro_MainHooks.php';

		//Play with Main Panel - load if theme support devio_playground_panel		
		if ( current_theme_supports( 'devio_playground_panel' ) ):
			//load the config or welcome to blank page on Panel Options :D
    	require( $this->plugin_path . 'framework/panel/main_panel_config.php' );

			if ( file_exists( $this->plugin_path . 'framework/panel/DeVioPlaygroundPro_Panel.php' )):
		   		require( $this->plugin_path . 'framework/panel/DeVioPlaygroundPro_Panel.php' );
		  endif;
		  locate_template( array( 'lib/panel/DeVioPlayground_Theme_Panel.php' ), true, true );
		endif;

    //Playing the Layout
		if ( !class_exists( 'DeVioPlaygroundPro_Layout' ) ):
 			require $this->plugin_path . 'framework/main/class.DeVioPlaygroundPro_Layout.php';
 		endif;
 		locate_template( array( 'lib/main/class.ExtendDeVioPlaygroundPro_Layout.php' ), true, true );

		//Additional Functions Play
	  if ( file_exists( $this->plugin_path . 'framework/main/DeVioPlaygroundPro_Main_Functions.php' )):
	   	require $this->plugin_path . 'framework/main/DeVioPlaygroundPro_Main_Functions.php';
		endif;

    //Singular Loop
    if ( !class_exists( 'DeVioPlaygroundPro_SingularLoop' ) ):
      require $this->plugin_path . 'framework/main/class.DeVioPlaygroundPro_SingularLoop.php';
    endif;
    locate_template( array( 'lib/main/class.ExtendDeVioPlaygroundPro_SingularLoop.php' ), true, true );

    //Play with Footer Area
 		if ( !class_exists( 'DeVioPlaygroundPro_FooterArea' ) ):
 			require $this->plugin_path . 'framework/main/class.DeVioPlaygroundPro_FooterArea.php';
 		endif;
 		locate_template( array( 'lib/main/class.ExtendDeVioPlaygroundPro_FooterArea.php' ), true, true );

    //Modular hooks
    if ( !class_exists( 'DeVioPlaygroundPro_ModularHooks' ) ):
      require $this->plugin_path . 'framework/main/class.DeVioPlaygroundPro_ModularHooks.php';      
    endif;
    locate_template( array( 'lib/main/class.ExtendDeVioPlaygroundPro_ModularHooks.php' ), true, true );

		//thirdparties
	   	// require_once $this->plugin_path . 'framework/lib/thirdparties/template-modules.php';
		require_once $this->plugin_path . 'framework/lib/thirdparties/tha-theme-hooks.php';

		//Display CustomFrontEnd via Theme 
		locate_template( array( 'lib/main/DeVioPlayground_Theme_Functions.php' ), true, true );

		//Global Override ( include Hooks Filter and Action override ) - safely( not overriden on updates ) via theme ( parent and or child )
		locate_template( array( 'lib/override/DeVioPlayground_Theme_Override.php' ), true, true ); //for hooks

		//Register Menu - formality
		register_nav_menus( array(
		      'primary'   => __( 'themesupports primary menu', 'devio-playground' ),
		  ) );

		add_filter('the_content', 'do_shortcode', 11); // From shortcodes.php
		add_filter('widget_text', 'do_shortcode');

		//remove wp gallery style
		add_filter( 'use_default_gallery_style', '__return_false' );

    }

	/**
	* DeVioPlayground identity
	* Please do not remove this 
	*/
    function devio_meta_header()
    {   
        // global $version;
        $ct = wp_get_theme();
        $meta = "\t".'<meta name="generator" content="DeVio Playground - Fun Theme Framework for Delfia and Violina" />' . "\n";
        $meta .= "\t".'<meta name="playground-author" content="Riesurya - hello at riesurya dot com " />' . "\n";
        $meta .= "\t".'<meta name="theme-version" content="' . $ct->get( 'Name' ) . ' ::v' . $ct->get( 'Version' ). '" />' . "\n";
        echo $meta;
    }

    //just anticipation if Redux Plugin is activated ( after installed )
  	function devio_redux_removeDemoModeLink() 
  	{ // Be sure to rename this function to something more unique
  	    if ( class_exists('ReduxFrameworkPlugin') )
  	        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
  	    if ( class_exists('ReduxFrameworkPlugin') ) 
  	        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
  	}

    //just a notice
    function devio_footer_notice()
    {
    	echo '<!-- This website is powered by DeVioPlayground - Fun Theme Framework for Delfia and Violina - more fun at http://devioplayground.com -->';
    }

	//Main
	/**
	 * WordPress localization
	 *
	 * @return void
	 */
    function devio_load_textdomain()
    {
		$textdomain = 'devio-playground';

		// Look for WP_LANG_DIR/{$domain}-{$locale}.mo
		if ( file_exists( WP_LANG_DIR . '/' . $textdomain . '-' . get_locale() . '.mo' ) ) {
			$file = WP_LANG_DIR . '/' . $textdomain . '-' . get_locale() . '.mo';
		}
		// Look for $this->plugin_path/languages/{$domain}-{$locale}.mo
		if ( ! isset( $file ) && file_exists( $this->plugin_path . '/languages/' . $textdomain . '-' . get_locale() . '.mo' ) ) {
			$file = $this->plugin_path . '/languages/' . $textdomain . '-' . get_locale() . '.mo';
		}

		if ( isset( $file ) ) {
			load_textdomain( $textdomain, $file );
		}

		load_plugin_textdomain( $textdomain, false, $this->plugin_path . '/languages' );
	}

}//eof class

endif;

// Get post meta
// modification from MetaBox plugins by Rilwis
function devio_post_meta( $key, $args = array(), $post_id = null )
{
  $post_id = empty( $post_id ) ? get_the_ID() : $post_id;

  $args = wp_parse_args( $args, array(
    'type' => 'text',
  ) );

  $meta = get_post_meta( $post_id, $key, $args );

  return apply_filters( 'devio_post_meta', $meta, $key, $args, $post_id );
}