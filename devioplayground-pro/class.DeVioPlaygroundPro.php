<?php
/**
  @copyright Copyright (C) 2011 - forever DeVio Multimedia 
  Made with love, wishes, and dry tears for my beloved daughters Delfia and Violina, where ever you are, Papa Love U
  Author : Anrie 'Riesurya'
  Author URI : http://riesurya.com
  Any questions? Do not hesitate to contact me : http://riesurya.com/contact/
  Main Playground Class
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

		// private static $_this;
	public static $version = "2.0";
		
		// static function this()
		// {
		// return self::$_this;
		// }


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
		//Widget BackUp
		// if ( file_exists( $this->plugin_path . 'framework/lib/thirdparties/Widget_Data.php' ))
			// require_once( $this->plugin_path . 'framework/lib/thirdparties/Widget_Data.php' );
    	
		//thirdparties
		//Auto Regenerate Thumbnails
		require_once( $this->plugin_path . 'framework/lib/thirdparties/otf_regen_thumbs.php');
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
   		add_action( 'admin_head', 				array( $this, 'admin_head' ) );
   		add_filter( 'ot_show_pages', 			'__return_false' );
   		add_action( 'after_setup_theme', 		array( $this, 'devio_after_setup_theme' ) );
    	add_action( 'wp_head', 					array( $this, 'devio_meta_header' ), 5 );
		add_action( 'redux/loaded', 			array( $this, 'devio_redux_removeDemoModeLink') );
    }

	/**
	 * load after theme setup
	 * @return [type] [description]
	 */
    function devio_after_setup_theme()
    {
		//Main Panel - load if theme support devio_playground_panel		
		if ( current_theme_supports( 'devio_playground_panel' ) ):
			//load the config or welcome to blank page :D
    		require( $this->plugin_path . 'framework/panel/main_panel_config.php' );

			if ( file_exists( $this->plugin_path . 'framework/panel/DeVioPlaygroundPro_Panel.php' )):
		   		require( $this->plugin_path . 'framework/panel/DeVioPlaygroundPro_Panel.php' );
		   	endif;
		endif;

		//to override
		locate_template( array( 'lib/panel/DeVioPlayground_Theme_Panel.php' ), true, true );

		if ( !class_exists( 'DeVioPlaygroundPro_Layout' ) ):
			if ( file_exists( $this->plugin_path . 'framework/main/class.DeVioPlaygroundPro_Layout.php' ))
   			require( $this->plugin_path . 'framework/main/class.DeVioPlaygroundPro_Layout.php' );
   		endif;

		//Core Functions - merged
	   	if ( file_exists( $this->plugin_path . 'framework/main/DeVioPlaygroundPro_Main_Functions.php' ))
	   		require( $this->plugin_path . 'framework/main/DeVioPlaygroundPro_Main_Functions.php' );
		
		//Modular hooks
		if ( locate_template( array( 'lib/main/DeVioPlayground_Theme_Modular_Hooks.php' ) ) ):
			locate_template( array( 'lib/main/DeVioPlayground_Theme_Modular_Hooks.php' ), true, true );
	   	elseif ( file_exists( $this->plugin_path . 'framework/main/DeVioPlaygroundPro_Modular_Hooks.php' ) ) :
   			require( $this->plugin_path . 'framework/main/DeVioPlaygroundPro_Modular_Hooks.php' );
   		endif;

   		if ( !class_exists( 'DeVioPlaygroundPro_Layout' ) ):
   			require( $this->plugin_path . 'framework/main/class.DeVioPlaygroundPro_Singular_Loop.php' );
   		endif;

		//Core Hooks - merged
	   	if ( file_exists( $this->plugin_path . 'framework/main/DeVioPlaygroundPro_Main_Hooks.php' ))
	   		require( $this->plugin_path . 'framework/main/DeVioPlaygroundPro_Main_Hooks.php' );

   		//ot loader - themes ( plugin required via tgm )
  
		//thirdparties
	   	require_once( $this->plugin_path . 'framework/lib/thirdparties/template-modules.php' );
		require_once( $this->plugin_path . 'framework/lib/thirdparties/tha-theme-hooks.php' );

		//Themes Playing Area - TODO ?
		// locate_template( array( 'lib/classes/thirdparties/widget-shortcode.php' ), true, true );
		// locate_template( array( 'lib/classes/thirdparties/sidebargen.php' ), true, true );

		//Load custom PostMeta Box via theme
		locate_template( array( 'lib/DeVioPlayground_Theme_Metaboxes.php' ), true, true );

		//display widget output ( custom widget via themes )
		locate_template( array( 'lib/DeVioPlayground_Theme_Widgets.php' ), true, true );
			
		//Display CustomFrontEnd via Theme 
		locate_template( array( 'lib/main/DeVioPlayground_Theme_Functions.php' ), true, true );

		//Global Override ( include Hooks Filter and Action override ) - safely( not overriden on updates ) via theme ( parent and or child )
		locate_template( array( 'lib/override/DeVioPlayground_Theme_Override.php' ), true, true ); //for hooks

		locate_template( array( 'lib/override/DeVioPlayground_Theme_Functions_Override.php' ), true, true ); //for hook functions - separated functions from hooks

		//Register Menu - formality
		//can be different each child theme
		register_nav_menus( array(
		      'primary'   => __( 'themesupports primary menu', 'devio-playground' ),
		  ) );

		add_filter('the_content', 'do_shortcode', 11); // From shortcodes.php
		add_filter('widget_text', 'do_shortcode');

		//remove wp gallery style
		add_filter( 'use_default_gallery_style', '__return_false' );

    }

	//sorry Redux,OT but i think its overshow
	function admin_head()
	{
		// remove_submenu_page( 'tools.php','redux-about' );
		remove_submenu_page( 'themes.php','ot-cleanup' );
		remove_submenu_page( 'themes.php','ot-theme-options' );
	}

	/**
	* DeVioPlayground identity
	* Please do not remove this
	* @return [type] [description]
	*/
    function devio_meta_header()
    {   
        // global $version;
        $ct = wp_get_theme();
        $meta = "\t".'<meta name="generator" content="DeVio Playground - Fun Theme Framework for Delfia and Violina" />' . "\n";
        $meta .= "\t".'<meta name="plugin-author" content="Riesurya" />' . "\n";
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

	//Main
	/**
	 * WordPress localization
	 *
	 * @return void
	 */
    function devio_load_textdomain()
    {
		$textdomain = 'devioplayground';

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