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

add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_layout_general', 20 );
add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_singlelayout', 21 );
add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_archivelayout', 23 );
add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_footer', 50 );
add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_bottom', 51 );
add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_customcss', 61 );
add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_customjs', 61 );
add_filter( 'redux/options/'. $opt_name .'/sections', 'devio_panel_socmed', 40 );

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
    'desc'  => __( '<em>Get more features such as more layouts, sidebar selection and sidebar width variant on paid version</em>', 'devio-playground' ),
  );

  $fields[] = array( 
    'title'     => __( 'General Layout', 'devio-playground' ),
    'id'        => 'devio-general-layout',
    'default'   => 'full',
    'type'      => 'image_select',
    'options'   => array( 
      'full'            => ReduxFramework::$_url . '/assets/img/1c.png',
      'left'            => ReduxFramework::$_url . '/assets/img/2cl.png',
      'right'           => ReduxFramework::$_url . '/assets/img/2cr.png',
      ),
    );

  $section['fields'] = $fields;

  $sections[] = $section;

  return $sections;
}

function devio_panel_singlelayout( $sections ) 
{
  $section = array(
    'icon'      => 'fa fa-columns',
    'title'     => __( 'Any Singular Layout', 'devio-playground' ),
    'desc'     => __( 'Choose your own layout, as you wish', 'devio-playground' ),
    'subsection'=> true
  );    

  //single
  $fields[] = array(
    'id'    => 'single_layout_info',
    'type'  => 'info',
    'style' => 'attention',
    'icon'  => 'el el-info-circle',
    'desc'  => apply_filters( 'devio/panel/single-layout/info/do_filter', __( 'Attention! <strong>Demo Only</strong> <br>Get this feature by purchasing the commercial version. Your purchase also support this Playground development', 'devio-playground' ) ),
    );

  
  $fields[] = array(
      'id'       => 'singlelayout-demo',
      'type'     => 'raw',
      'title'    => __( 'Any Single Layout', 'devio-playground' ),
      'desc'     => __( 'Choose your own layout, as you wish', 'devio-playground' ),
      'content'  => '<img src="' . DEVIO_PLUGIN_URL . 'assets/admin/images/paneldemo-layout.png">',
  );
  $section['fields'] = $fields;

  $sections[] = $section;

  return $sections;
}

function devio_panel_archivelayout( $sections ) 
{
  $section = array(
    'icon'      => 'fa fa-columns',
    'title'     => __( 'Any Archive Layout', 'devio-playground' ),
    'desc'  => apply_filters( 'devio/panel/single-layout/info/do_filter', __( 'Attention! <strong>Demo Only</strong> <br>Get this feature by purchasing the commercial version. Your purchase also support this Playground development', 'devio-playground' ) ),
    'subsection'=> true
  );    
  
  $fields[] = array(
      'id'       => 'archivelayout-demo',
      'type'     => 'raw',
      'title'    => __( 'Any Archive Layout', 'devio-playground' ),
      'content'  => '<img src="' . DEVIO_PLUGIN_URL . 'assets/admin/images/paneldemo-layout.png">',
  );

  $section['fields'] = $fields;

  $sections[] = $section;

  return $sections;
}

//priority 35 - Page 404
function devio_panel_page404( $sections ) 
{
  $section = array(
    'title'   => __( 'Page 404', 'devio-playground' ),
    'icon'    => 'fa fa-bug',
    'heading'   => __('Custom Page 404','devio-playground'),
    );

  $fields[] = array(
    'id'      => 'page404_info',
    'type'    => 'info',
    'desc'    => '<p class="description">' . __( 'Make your own custom Page 404 ( Page Not Found mode )', 'devio-playground' ) .'<br><em>Get more flexible options on paid version</em></p>',
    );

  $fields[] = array(
    'title'   => __( 'Page 404 Content', 'devio-playground' ),
    'id'      => 'page404',
    'default' => 'Oops page not found',
    'type'    => 'textarea',
    );

  $section['fields'] = $fields;

  $sections[] = $section;

  return $sections;
}

//prior 50 - Footer
function devio_panel_footer( $sections ) 
{
  $section = array(
    'title' => __( 'Footer', 'devio-playground' ),
    'icon' => 'fa fa-th',
    'desc'  => apply_filters( 'devio/panel/single-layout/info/do_filter', __( 'Attention! <strong>Demo Only</strong> <br>Get this feature by purchasing the commercial version. Your purchase also support this Playground development', 'devio-playground' ) ),
    );

  $fields[] = array(
      'id'       => 'footerlayout-demo',
      'type'     => 'raw',
      'title'    => __( 'Footer Layout', 'devio-playground' ),
      'content'  => '<img src="' . DEVIO_PLUGIN_URL . 'assets/admin/images/paneldemo-layout.png">',
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
    'default'     => wp_get_theme()->name . ' Theme - created with <i class="fa fa-heart red"></i> by ' . wp_get_theme()->Author . '<br>for beloved angels Delfia and Violina',
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
    'title' => __( 'Customized Javascript.', 'devio-playground' ),
    'desc'  => __( 'Some little javascript code line may more efficient if written directly.', 'devio-playground' )
  );

  $fields[] = array(
    'id'        => 'js_custom',
    'type'      => 'ace_editor',
    'title'     => __( 'JS Code', 'devio-playground' ),
    // 'subtitle'  => __( 'Paste your JS code here.', 'devio-playground' ),
    'mode'      => 'javascript',
    'theme'     => 'chrome',
    'default'   => "jQuery(document).ready(function(){\n\n});",
    'hint'        => array(
        'title'     => 'Custom JS',
        'content'   => __( 'Type JS code like Google analytics, advertisement code etc. Will displayed as inline script right before </body>, alternative, you can use custom js file on child theme - devio-playground.js','devio-playground' ),
              )
  );

  $section['fields'] = $fields;

  $sections[] = $section;
  
  return $sections;
};

//socmed - 40
function devio_panel_socmed( $sections ) 
{

  $section = array(
    'title'     => __( 'Social Media', 'devio-playground' ),
    'icon'      => 'fa fa-users',
  );

  $fields[] = array(
    'id'    => 'socmed_info',
    'type'  => 'info',
    'desc'  => __( '<em>Get more flexible options such as sortable, animation effects selection on paid version</em>', 'devio-playground' ),
  );

    $fields[] = array(
      'id'        => 'socmed_sort',
      'type'      => 'checkbox',
      'title'     => __( 'Sort and Order', 'devio-playground' ),
      'desc'      => __( 'Drag and drop to order display social media icons', 'devio-playground'),
      'options'   => array(
        'soc-gplus'         => 'Google+',
        'soc-twitter'       => 'Twitter',
        'soc-facebook'      => 'Facebook',
        'soc-linkedin'      => 'LinkedIn',
        'soc-feed'          => 'Feed',
        ),
      'default'   => array(
        'soc-gplus'         => '1', 
        'soc-twitter'       => '1', 
        'soc-fb'            => '1',
        'soc-linkedin'      => '1',
        'soc-feed'      => '1',
        ),
      'label'     => true,
      );

  $fields[] = array(
    'id'                => 'soc-gplus',
    'type'              => 'text',
    'title'             => __( 'Google+ ( full URL )', 'devio-playground' ),
    'default'           => 'http://google.com',
    'validate'          => 'url',
    );

  $fields[] = array(
    'id'                => 'soc-twitter',
    'type'              => 'text',
    'title'             => __( 'Twitter', 'devio-playground' ),
    'default'           => 'https://twitter.com',
    'validate'          => 'url',
  );

  $fields[] = array(
    'id'                => 'soc-facebook',
    'type'              => 'text',
    'title'             => __( 'Facebook', 'devio-playground' ),
    'default'           => 'http://facebook.com',
    'validate'          => 'url',
  );

  $fields[] = array(
    'id'                => 'soc-linkedin',
    'type'              => 'text',
    'title'             => __( 'LinkedIn', 'devio-playground' ),
    'default'           => 'http://linkedin.com',
    'validate'          => 'url',
  );

  $fields[] = array(
    'id'                => 'soc-feed',
    'type'              => 'text',
    'title'             => __( 'RSS Feed', 'devio-playground' ),
    'default'           => 'http://mydomain.rld/feed',
    'validate'          => 'url',
  );
      
  $section['fields'] = $fields;

  $sections[] = $section;

  return $sections;
}