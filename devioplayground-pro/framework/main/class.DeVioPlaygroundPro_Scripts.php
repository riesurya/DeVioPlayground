<?php
/**
  	@copyright Copyright (C) 2011-2014 Devio Multimedia. 
  	Made with 100% love and hopes for my beloved daughters Delfia Nur Anrianti Putri and Violina Melody Ramadhani, where ever you are, Papa Love U
  	Author : Muhammad Anrie Ibrahim
  	Author URI : http://deviolayground.com
  	SubPackage: Singular Loop
    Location : framework/main/class.DeVioPlayground_SingularLoop.php
**/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    die;
}

class DeVioPlaygroundPro_Scripts
{
	private static $_this;

	function __construct() 
	{
		self::$_this = $this;
	}

	static function this()
	{
		return self::$_this;
	}

  	//all scripts
  	function devio_register_theme_scripts()
  	{
	    if (is_singular() && comments_open() && get_option('thread_comments')) :
	    	wp_enqueue_script('comment-reply');
	    endif;

	    //bootstrap
	    if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/bootstrap/bootstrap.min.css' ) ):
	      wp_register_style( 'bootstrap', trailingslashit( DEVIO_THISTHEME_URL ) . 'assets/bootstrap/bootstrap.min.css', false, null );
	    else:
	      wp_register_style( 'bootstrap', 'https://cdn.jsdelivr.net/bootstrap/3.3.5/css/bootstrap.min.css', false, null );
	    endif;

	    if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/bootstrap/bootstrap.min.js' ) ):
	      wp_register_script( 'bootstrap', trailingslashit( DEVIO_THISTHEME_URL ) . 'assets/bootstrap/bootstrap.min.js', array('jquery'), null, true);
	    else:
	       wp_register_script( 'bootstrap', 'https://cdn.jsdelivr.net/bootstrap/3.3.5/js/bootstrap.min.js', array('jquery'), null, true);
	    endif;

	    //fontawesome
	    if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/fontawesome/css/font-awesome.min.css' ) ):
	      wp_register_style( 'fontawesome', trailingslashit( DEVIO_THISTHEME_URL )  . 'assets/fontawesome/css/font-awesome.min.css', false, null );
	    else:
	      wp_register_style( 'fontawesome', 'https://cdn.jsdelivr.net/fontawesome/4.4.0/css/font-awesome.min.css', false, null );
	    endif;

	    //modernizr
	    if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/modernizr/modernizr.min.js' ) ):
	      wp_register_script( 'modernizr', trailingslashit( DEVIO_THISTHEME_URL )  . 'assets/modernizr/modernizr.min.js', array('jquery'), null, false);
	    else:
	      wp_register_script( 'modernizr', 'https://cdn.jsdelivr.net/modernizr/2.8.3/modernizr.min.js', array('jquery'), null, false);
	    endif;
  	}

  	function devio_register_playground_scripts()
  	{
	    //playground
	    if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/devio/deviothemes.css' ) ):
	      wp_register_style( 'devio-playground-custom', trailingslashit( DEVIO_THISTHEME_URL ) . 'assets/devio/deviothemes.css', false, null ); 
	    endif;

	    if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/devio/deviothemes.js' ) ):
	      wp_register_script( 'devio-playground-custom', trailingslashit( DEVIO_THISTHEME_URL ) . 'assets/devio/deviothemes.js', array('jquery'), null, true );  
	    endif;

	    //child theme scripts 
	    if ( file_exists( trailingslashit( get_stylesheet_directory() ) . 'assets/devio/deviothemes_child.css' ) ):
	      wp_register_style( 'devio-playground-child', trailingslashit( DEVIO_THISTHEMECHILD_URL ) . 'assets/devio/deviothemes_child.css', false, null ); 
	    endif;

	    if ( file_exists( trailingslashit( get_stylesheet_directory() ) . 'assets/devio/deviothemes_child.js' ) ):
	      wp_register_script( 'devio-playground-child', trailingslashit( DEVIO_THISTHEMECHILD_URL ) . 'assets/devio/deviothemes_child.js', array('jquery'), null, true );  
	    endif;
  	}

	function devio_enqueue_theme_scripts()
	{
		wp_enqueue_script( array( 
			'jquery',
			'modernizr',
			'bootstrap',
			)
		);
		wp_enqueue_style( array( 
			'bootstrap',
			'fontawesome',
			)
		);
	}

	function devio_enqueue_playground_scripts()
	{
		//make sure that devio-themes always load in overriding mode
		wp_enqueue_script( array( 
			'devio-playground-custom' 
			)
		);

		wp_enqueue_style( array( 
			'devio-playground-custom' 
			)
		);

		if ( is_child_theme() )
		wp_enqueue_style( 'devio-playground-child' );
		wp_enqueue_script( 'devio-playground-child' );
	}

}

new DeVioPlaygroundPro_Scripts;
