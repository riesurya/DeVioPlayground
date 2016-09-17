<?php
/**
  @copyright Copyright (C) 2011 - forever DeVio Multimedia
  Made with 100% love and hopes for my beloved daughters Delfia Nur Anrianti Putri and Violina Melody Ramadhani, where ever you are, Papa Love U
  Author : Muhammad Anrie Ibrahim
  Author URI : http://deviolayground.com
  SubPackage: Singular Loop
   Location : framework/panel/DeVioPlaygroundro_Panel.php
  SubPackage: Panel Functions - sample
**/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
    die;
}

global $opt_name;

add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_customicons', 10 );
add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_layout_general', 20 );
add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_bottom', 51 );

//Prior 70 - Custom css
function devio_panel_customicons( $sections ) 
{
  $section = array(
    'title'     => __( 'Custom Favicon', 'devio-playground' ),
    'icon'      => 'fa fa-code',
  );

  $fields[] = array(
      'id'            => 'favicon-url',
      'type'          => 'media',
      'url'           => true,
      'title'         => __( 'Image', 'devio-playground' ),
      'deesc'         => __( 'Leave it empty if not used', 'devio-playground' ),
  );

  $section['fields'] = $fields;

  $sections[] = $section;
  
  return $sections;
}


//Prior 20 - General Layout
function devio_panel_layout_general( $sections ) 
{
  $section = array(
    'title'     => __( 'Layout', 'devio-playground' ),
    'icon'      => 'fa fa-dashboard icon-large',
    'id'        => 'layout_el',
    );

  $fields[] = array(
    'id'    => 'layout_info',
    'type'  => 'info',
    'desc'  => '',
  );

  $fields[] = array( 
    'title'     => __( 'General Layout', 'devio-playground' ),
    'id'        => 'devio-general-layout',
    'default'   => 'full-side',
    'type'      => 'image_select',
    'options'   => array( 
      'full-side'            => ReduxFramework::$_url . '/assets/img/1c.png',
      'left-side'            => ReduxFramework::$_url . '/assets/img/2cl.png',
      'right-side'           => ReduxFramework::$_url . '/assets/img/2cr.png',
      ),
    );

  $section['fields'] = $fields;

  $sections[] = $section;

  return $sections;
}

//Prior 51 - Bottom
function devio_panel_bottom( $sections ) 
{
  $section = array(
    'title'       => __( 'Bottom', 'devio-playground' ),
    'icon'        => 'fa fa-th',
    );

  $fields[] = array(
    'id'    => 'bottom_text_info',
    'type'  => 'info',
    'desc'  => __( 'Feel free to show such as Copyright, Company name', 'devio-playground' ),
    );
  
  $fields[] = array( 
    'title'       => __( 'Bottom Text', 'devio-playground' ),
    'desc'        => __( 'The text that will be displayed on bottom.', 'devio-playground' ),
    'id'          => 'bottext',
    'default'     => '',
    'type'        => 'textarea',
    );

  $section['fields'] = $fields;

  $sections[] = $section;

  return $sections;
}
