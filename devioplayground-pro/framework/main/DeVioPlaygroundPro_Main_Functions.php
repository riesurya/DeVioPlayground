<?php
/**
  @copyright Copyright (C) 2011 - forever DeVio Multimedia
  Made with 100% love for my beloved daughters Delfia and Violina, where ever you are, Papa Love U
  Theme_Author : Anrie 'Riesurya' - http://riesurya.com
  Contains Libraries
  SubPackage: FrontEnd Control
  Location : framework/main/DeVioPlayground_Main_Functions.php
**/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
    die;
}

/**
 * Use Bootstrap's media object for listing comments
 *
 * @link http://getbootstrap.com/components/#media
 */
if ( !class_exists( 'Roots_Walker_Comment')):
class Roots_Walker_Comment extends Walker_Comment {
  function start_lvl(&$output, $depth = 0, $args = array()) {
    $GLOBALS['comment_depth'] = $depth + 1; ?>
    <ul <?php comment_class('media list-unstyled comment-' . get_comment_ID()); ?>>
    <?php
  }

  function end_lvl(&$output, $depth = 0, $args = array()) {
    $GLOBALS['comment_depth'] = $depth + 1;
    echo '</ul>';
  }

  function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0) {
    $depth++;
    $GLOBALS['comment_depth'] = $depth;
    $GLOBALS['comment'] = $comment;

    if (!empty($args['callback'])) {
      call_user_func($args['callback'], $comment, $args, $depth);
      return;
    }

    extract($args, EXTR_SKIP); ?>

  <li id="comment-<?php comment_ID(); ?>" <?php comment_class('media comment-' . get_comment_ID()); ?>>
    <?php //include(locate_template('view/loop/comment.php')); ?>
    <?php include(locate_template('comment.php')); ?>
  <?php
  }

  function end_el(&$output, $comment, $depth = 0, $args = array()) {
    if (!empty($args['end-callback'])) {
      call_user_func($args['end-callback'], $comment, $args, $depth);
      return;
    }
    echo "</div></li>\n";
  }
}
endif;

//single post tags
function devio_entrymeta_posttags()
{
  $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'devio-playground' ) );

    if ( $tags_list )
    printf( '<p class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</p>',
      _x( 'Tags', 'Used before tag names.', 'devio-playground' ),
      $tags_list  ); 
}

//Entry meta date
function devio_entrymeta_date()
{
  if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) :
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

    $time_string = sprintf( $time_string,
      esc_attr( get_the_date( 'c' ) ),
      get_the_date(),
      esc_attr( get_the_modified_date( 'c' ) ),
      get_the_modified_date()
    );

    printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
      _x( 'Posted on', 'Used before publish date.', 'devio-playground' ),
      esc_url( get_permalink() ),
      $time_string
    );
  endif;
}

//Post Category
function devio_entrymeta_postcategory()
{
  $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'devio-playground' ) );

  if ( $categories_list ) {
  // if ( $categories_list && devio-playground_categorized_blog() ) {
    printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
      _x( 'Categories', 'Used before category names.', 'devio-playground' ),
      $categories_list
    );
  }
}

//Post author(s)
function devio_entrymeta_postauthors()
{
  if ( is_singular() || is_multi_author() ) :
    printf( '<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s </span><a class="url fn n" href="%2$s">%3$s</a></span></span>',
      _x( 'Author', 'Used before post author name.', 'devio-playground' ),
      esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
      get_the_author()
    );
  endif;
}

//Retrieve attachment ID from URL
//https://philipnewcomer.net/2012/11/get-the-attachment-id-from-an-image-url-in-wordpress/
function devio_get_attachment_id_from_url( $attachment_url = '' ) 
{
 
  global $wpdb;
  $attachment_id = false;
 
  // If there is no url, return.
  if ( '' == $attachment_url )
    return;
 
  // Get the upload directory paths
  $upload_dir_paths = wp_upload_dir();
 
  // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
  if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) :
 
    // If this is the URL of an auto-generated thumbnail, get the URL of the original image
    $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
    // Remove the upload path base directory from the attachment URL
    $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
    // Finally, run a custom database query to get the attachment ID from the modified attachment URL
    $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
  endif;
 
  return $attachment_id;
}