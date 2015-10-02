<?php
/*
Plugin Name: DeVio Playground Pro
Description: More than just Theme Framework, this is Playground. Made with love and dry tears for my beloved daughters, Delfia and Violina ( whereever you are, Papa still love u, miss u my little angels )
Author: Riesurya
Author URI: http://riesurya.com/
Plugin URI: http://devioplayground.com/plugins/devio-playground
Version: 1.0.1
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

//Load dependency plugin first or fatal error!
	require_once plugin_dir_path( __FILE__ ) . 'tgm/class-tgm-plugin-activation.php'; 
	// TGM_Plugin_Activation
	require_once plugin_dir_path( __FILE__ ) . 'tgm/dependencies.php';                
	// load our dependencies

// Require the main plugin class
require_once plugin_dir_path( __FILE__ ) . 'class.DeVioPlaygroundPro.php';

//run main class
DeVioPlaygroundPro::instance();