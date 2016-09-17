<?php
/*
Plugin Name: DeVio Playground Pro
Made with 100% love and hopes for my beloved daughters Delfia Nur Anrianti Putri and Violina Melody Ramadhani, where ever you are, Papa Love U
Author : Muhammad Anrie Ibrahim
Author URI : http://deviolayground.com
Version: 1.1.0
*/
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
    die;
}

if ( ! defined( 'DEVIO_PLUGIN_DIR' ) )
	define( 'DEVIO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

if ( ! defined( 'DEVIO_PLUGIN_URL' ) ){
    $playground_assets_url = str_replace( 'http:', '', plugin_dir_url( __FILE__ ) );
    $playground_assets_url = str_replace( 'https:', '', $playground_assets_url );
    define( 'DEVIO_PLUGIN_URL', $playground_assets_url );
}
    
if ( ! defined( 'DEVIO_THISTHEME_URL' ) ){
    $theme_assets_url = str_replace( 'http:', '', get_template_directory_uri() );
    $theme_assets_url = str_replace( 'https:', '', $theme_assets_url );
    define( 'DEVIO_THISTHEME_URL', $theme_assets_url );
}
	
if ( ! defined( 'DEVIO_THISTHEMECHILD_URL' ) ){
    $themechild_assets_url = str_replace( 'http:', '', get_stylesheet_directory_uri() );
    $themechild_assets_url = str_replace( 'https:', '', $themechild_assets_url );
    define( 'DEVIO_THISTHEMECHILD_URL', $themechild_assets_url );
}

//Load dependency plugin first or fatal error!
	require_once plugin_dir_path( __FILE__ ) . 'tgm/class-tgm-plugin-activation.php'; 
	// TGM_Plugin_Activation
	require_once plugin_dir_path( __FILE__ ) . 'tgm/dependencies.php';                
	// load our dependencies

// Require the main plugin class
require_once plugin_dir_path( __FILE__ ) . 'class.DeVioPlaygroundPro.php';

//run main class
DeVioPlaygroundPro::instance();
