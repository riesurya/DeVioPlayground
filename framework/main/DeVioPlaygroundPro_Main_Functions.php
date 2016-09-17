<?php
/**
  @copyright Copyright (C) 2011 - forever DeVio Multimedia
  Made with 100% love and hopes for my beloved daughters Delfia Nur Anrianti Putri and Violina Melody Ramadhani, where ever you are, Papa Love U
  Author : Muhammad Anrie Ibrahim
  Author URI : http://deviolayground.com
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
