<?php
/**
  @copyright Copyright (C) 2011 - forever DeVio Multimedia
  Made with 100% love for my beloved daughters Delfia and Violina, where ever you are, Papa Love U
  Theme_Author : Anrie 'Riesurya' - http://riesurya.com
  Any questions? Do not hesitate to contact me : http://riesurya.com/contact/
  Web Service version
  SubPackage: Panel Functions
**/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
    die;
}

global $opt_name;

add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_customicons', 10 );
add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_layout_general', 20 );
add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_bottom', 51 );
add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_customcss', 61 );
add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_customjs', 61 );

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

//Prior 70 - Custom css
function devio_panel_customcss( $sections ) 
{
  $section = array(
    'title'     => __( 'Custom CSS', 'devio-playground' ),
    'icon'      => 'fa fa-code',
  );

  $fields[] = array(
    'id'    => 'css_custom_info',
    'type'  => 'info',
    'title' => __( 'Customized CSS.', 'devio-playground' ),
    'desc'  => __( 'May this playground have no meet all styling you want, so freely do add custom CSS to adjust any elements to suit your need', 'devio-playground' ),
  );

  $fields[] = array(
    'id'        => 'css_custom',
    'type'      => 'ace_editor',
    'title'     => __( 'CSS Code', 'devio-playground'),
    'subtitle'  => __( 'Paste your CSS code here.', 'devio-playground'),
    'mode'      => 'css',
    'theme'     => 'monokai',
    'compiler'  => true,
    'default'   => "#header{\nmargin: 0 auto;\n}"
  );

  $section['fields'] = $fields;

  $sections[] = $section;
  
  return $sections;
}

//custom js - 71
function devio_panel_customjs( $sections ) 
{
  $section = array(
    'title'   => __( 'Custom Javascript', 'devio-playground' ),
    'icon'    => 'fa fa-bug',
    'id'      => 'customjs_el',
  );

  $fields[] = array(
    'id'    => 'js_custom_info',
    'type'  => 'info',
    'style' => 'success',
    'icon'  => 'el el-info-circle',
    'title' => __( 'Custom Javascript', 'devio-playground' ),
    'desc'  => __( 'Some little javascript code line may more efficient if written directly.', 'devio-playground' )
  );

  $fields[] = array(
    'id'        => 'js_custom',
    'type'      => 'ace_editor',
    'title'     => __( 'Javascript Code', 'devio-playground' ),
    'mode'      => 'javascript',
    'theme'     => 'chrome',
    'default'   => "jQuery(document).ready(function(){\n\n});",
    'hint'        => array(
        'title'     => 'Javascript Code',
        'content'   => __( 'Type Javascript code like Google analytics, advertisement code etc','devio-playground' ),
              )
  );

  $section['fields'] = $fields;

  $sections[] = $section;
  
  return $sections;
}