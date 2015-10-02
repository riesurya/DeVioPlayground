<?php
/**
  @copyright Copyright (C) 2011 - forever DeVio Multimedia
  Made with 100% love for my beloved daughters Delfia and Violina, where ever you are, Papa Love U
  Theme_Author : Anrie 'Riesurya' - http://riesurya.com
  Any questions? Do not hesitate to contact me : http://riesurya.com/contact/
  Easy hooks override
  SubPackage: Main Hooks Control
**/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    die;
}

add_action( 'plugins_loaded',                         'devio_load_textdomain' );

// Admin
add_action( 'admin_enqueue_scripts',                  'devio_admin_scripts_styles_pro' );

// FrontEnd
add_action('wp_enqueue_scripts',                      'devio_register_playground_scripts', 9);

//custom CSS/JS
add_action( 'wp_head',                                'devio_custom_csscode_pro', 25 );
add_action( 'wp_footer',                              'devio_custom_jscode_pro', 25 );

//BodyClass Filter for layoutmode
  // add_filter( 'body_class', 'devio_bannermode_body_classes', 12 );

//BodyClass Filter for colorscheme - next todo with own color
  add_filter( 'body_class', 'devio_color_body_classes', 15 );

// Home
add_action( 'devio/frontpage/maincontent/do_action',  'devio_frontpage_display_pro', 2 ); //static page
add_action( 'devio/home/maincontent/do_action',       'devio_home_display_pro', 2 ); //home blog mode

//Page 404 - themes loaded
add_action( 'devio/error404/maincontent/do_action',   'devio_page404_pro' );
//Search Result 
// add_action( 'devio/search/maincontent/do_action', 'devio_archive_entry_front' );

//Archive entry - Post
add_action( 'devio/archive/maincontent/do_action',    'devio_archive_entry_pro' );

//singular maincontent default
add_action( 'devio/singular/maincontent/do_action',   'devio_entry_item_maincontent_pro', 20 ); //themes?