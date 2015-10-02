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
global $deviocantik, $opt_name;
$deviocantik = get_option( $opt_name);

/*
  BackEnd
*/

/**
* Load custom admin scripts ( & styles )
* @return [type] [description]
*/
  function devio_admin_scripts_styles_pro()
  {
    global $pagenow;

    // if ( is_admin() && $pagenow == 'widgets.php') {
    if ( is_admin() ) 
    {
      wp_enqueue_script( 'devio_admin-script', DEVIO_PLUGIN_URL . 'assets/admin/js/devio-admin.js');
      // wp_enqueue_style( 'devio_admin-styles',  DEVIO_PLUGIN_URL . 'assets/admin/css/devio-admin.css');
      wp_enqueue_style( 'fontawesome' );
    }
  }

//Admin Thumb
  function devio_addthumb_column($cols) {
      $cols['thumbnail'] = __('Thumbnail');
      return $cols;
  }

/**
   * Display Post Thumbnail on admin editor
   * @param [type] $column_name [description]
   * @param [type] $post_id     [description]
*/
  function devio_addthumb_value($column_name, $post_id) {
    $width = (int) 35;
    $height = (int) 35;

    if ( 'thumbnail' == $column_name ) {
        // thumbnail of WP 2.9
        $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
        // image from gallery
        $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
        if ( $thumbnail_id )
            $thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
        elseif ($attachments) 
        {
            foreach ( $attachments as $attachment_id => $attachment ) {
                $thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
            }
        }
        if ( isset($thumb) && $thumb ) 
        {
            echo $thumb;
        } 
        else 
        {
            echo __('None');
        }
    }
    }

/*
  FrontEnd
*/

//default scripts for playground
  function devio_register_playground_scripts()
  {
    global $deviocantik;

    if (is_singular() && comments_open() && get_option('thread_comments')) :
    wp_enqueue_script('comment-reply');
    endif;

    //playground
    if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/devio/deviothemes.css' ) ):
    wp_register_style( 'devio-playground-custom', trailingslashit( get_template_directory_uri() ) . 'assets/devio/deviothemes.css', false, null ); 
    endif;

    if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/devio/deviothemes.js' ) ):
    wp_register_script( 'devio-playground-custom', trailingslashit( get_template_directory_uri() ) . 'assets/devio/deviothemes.js', array('jquery'), null, true );  
    endif;

    //child theme scripts 
    if ( file_exists( trailingslashit( get_stylesheet_directory() ) . 'assets/devio/deviothemes_child.css' ) ):
    wp_register_style( 'devio-playground-child', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/devio/deviothemes_child.css', false, null ); 
    endif;

    if ( file_exists( trailingslashit( get_stylesheet_directory() ) . 'assets/devio/deviothemes_child.js' ) ):
    wp_register_script( 'devio-playground-child', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/devio/deviothemes_child.js', array('jquery'), null, true );  
    endif;

    //bootstrap
    wp_register_style( 'bootstrap', trailingslashit( get_template_directory_uri() ) . 'assets/bootstrap/bootstrap.min.css', false, null );
    wp_register_script( 'bootstrap', trailingslashit( get_template_directory_uri() ) . 'assets/bootstrap/bootstrap.min.js', array('jquery'), null, true);

    //fontawesome
    wp_register_style( 'fontawesome', trailingslashit( get_template_directory_uri() )  . 'assets/fontawesome/css/font-awesome.min.css', false, null );

    //modernizr
    wp_register_script( 'modernizr', trailingslashit( get_template_directory_uri() )  . 'assets/modernizr/modernizr-2.7.0.min.js', array('jquery'), null, false);

    //animate
    wp_register_style( 'animate', trailingslashit( get_template_directory_uri() )  . 'assets/css/animate.min.css', false, null); 

  }

//devio postclass
  function deviocantik_postclass_pro($classes) 
  {
    $classes[] = 'deviocantik_on ' . get_post_type();
    return $classes;
  }

//Custom CSS
  function devio_custom_csscode_pro()
  {
    global $deviocantik;

    if ( !empty( $deviocantik['css_custom'] ) ):
      echo '<style>' . $deviocantik['css_custom'] . '</style>';
    endif;
  }

//Custom JS
  function devio_custom_jscode_pro()
  {
    global $deviocantik;

    if ( !empty( $deviocantik['js_custom'] ) ):
      echo '<script>' . $deviocantik['js_custom'] . '</script>';
    endif;
  }

//Bottom bar
  function devio_bottombar_text_pro()
  {
    global $deviocantik;
    if ( $deviocantik['bottext'] )
     echo apply_filters( 'devio/bottombar/text/do_filter', esc_textarea( $deviocantik['bottext'] ) );
  }

//entry Article Entry
  function devio_singular_entry_title_pro()
  {
    $classes = get_body_class();

    if ( !is_archive() ) :
      $entry_title = '';
    
      if ( is_front_page() )
        return;

      //no display title for aside
      if ( is_singular() && has_post_format( array( 'aside', 'quote' ) ) ) :
        // not display post title, no link
        $entry_title .= ''; 
      elseif ( is_singular() && has_post_format( array( 'gallery', 'image' ,'link' ) ) ) :
      // display post title, no link
        $entry_title = '<header><h1>' . get_the_title() . '</h1></header>';
      else :
      // link Post Headline (H1) to post permalink
        $entry_title = '<header><h1><a href="' . get_permalink() . '">' . get_the_title() . '</a></h1></header>';    
      endif;

      echo apply_filters( 'devio/singular/entry-title/do_filter', $entry_title );

    endif;
  }

//No Title
  /**
   * Output default Post Title if none is provided
   * Filter Hook: the_title 
   * Filter 'the_title' to output '(Untitled)' if 
   * no Post Title is provided
   */
  function devio_untitled_post_pro( $title ) 
  {
    if ( '' == $title ) :
      return apply_filters( 'devio/singular/title/untitled/do_filter', '<em>( ' . __( 'Untitled', 'devio-playground' ) . ' )</em>' );
    else :
      return $title;
    endif;
  }

//Archive Title
  function devio_archive_title_pro() 
  {   
    if ( !is_singular() ) :
      $archives_title = '';
    
    // If this is an archive index
    if( is_archive() ) :
      switch ( true ) :
        // If this is a taxonomy archive
        case is_category() :
        case is_tag() :
                // If this is a category or tag archive
          $tax = ( is_category() ? 'category' : 'tag' );
          $archives_title = ( is_category() ? single_cat_title( '', false ) : single_tag_title( '', false ) );

          $catdescription = ( ( is_category() && category_description() ) ? category_description() : false );
          $tagdescription = ( ( is_tag() && tag_description() ) ? tag_description() : false );
          $taxdesc = ( is_category() ? $catdescription : $tagdescription );
          $taxdescdefault = __( 'Posts filed under ', 'devio-playground' ) . $archives_title;

          $taxdescription = ( $taxdesc ? $taxdesc : $taxdescdefault );
        break;  

        case is_tax( 'post_format', 'post-format-' . get_post_format() ) :
                // If this is a Post Format archive
                // elseif ( is_tax( 'post_format', 'post-format-' . get_post_format() ) ) {
          $tax = get_post_format();
          $archives_title = get_post_format_string( $tax );

          $taxdescription = false;
          $formats = devio_get_post_formats();

          foreach ( $formats as $format ) {
            if ( $format['slug'] == $tax ) {
              $taxdescription = '<em>' . $format['description'] . '</em>';
            }
          }
        break;

        case is_tax() :                
              // If this is a Custom Taxonoomy archive
          global $wp_query;
          $tax = $wp_query->query_vars['taxonomy'];
          $term = $wp_query->query_vars['term'];
          $taxobject = get_taxonomy( $tax );
          $termobject = get_term_by( 'slug', $term, $tax );

          $archives_title = single_term_title( '', false );
          $taxdescription = $termobject->description;
        break;

        case is_year() :
          // printf( __( 'Yearly Archives : %s', 'devio-playground' ), get_the_date( _x( 'Y', 'yearly archives date format', 'devio-playground' ) ) );
          $archives_title .= __( 'Yearly Archives : ', 'devio-playground' ) . get_the_date( 'Y' );
        break;

        case is_month() :
          $archives_title .= __( 'Monthly Archives: ', 'devio-playground' ) . get_the_date( 'F Y' );
        break;

        case is_day() :
          // printf( __( 'Daily Archives : %s', 'devio-playground' ), get_the_date( 'F d, Y' ) );
          $archives_title .= __( 'Daily Archives : ', 'devio-playground' ) . get_the_date( 'F d, Y' );
        break;

        case is_author() :
          $archives_title .= '<a class="authorlink url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a>';
        break;

        case is_post_type_archive() :
          $archives_title .= post_type_archive_title();
        break;

      endswitch;  
      
    endif;

    return apply_filters( 'devio/archive_title/do_filter', $archives_title );

    endif; //eof !is_singular
  }


// Get post meta
  if ( !function_exists('devio_post_meta')):
  function devio_post_meta( $key, $args = array(), $post_id = null )
  {
    $post_id = empty( $post_id ) ? get_the_ID() : $post_id;

    $args = wp_parse_args( $args, array(
      'type' => 'text',
    ) );

    $meta = get_post_meta( $post_id, $key, $args );

    return apply_filters( 'devio_post_meta', $meta, $key, $args, $post_id );
  }
  endif;

//Entry meta date
  function devio_entrymeta_date_pro()
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
  function devio_entrymeta_postcategory_pro()
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
  function devio_entrymeta_postauthors_pro()
  {
    if ( is_singular() || is_multi_author() ) :
      printf( '<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s </span><a class="url fn n" href="%2$s">%3$s</a></span></span>',
        _x( 'Author', 'Used before post author name.', 'devio-playground' ),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        get_the_author()
      );
    endif;
  }

//single post tags
  function devio_entrymeta_posttags_pro()
  {
    // the_tags( '<footer class="entry-meta"><i class="fa fa-tags"></i><span class="tag-links">', '', '</span></footer>' );

    $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'devio-playground' ) );

      if ( $tags_list )
      printf( '<p class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</p>',
        _x( 'Tags', 'Used before tag names.', 'devio-playground' ),
        $tags_list  ); 
  }

//entry item maincontent - themes ?
  function devio_entry_item_maincontent_pro()
  {
    has_filter( 'devio/singular/entry_item/maincontent/columns/do_filter' ) ? print '<div class="maincontent ' . apply_filters( 'devio/singular/entry_item/maincontent/columns/do_filter','') . '">' : print '<div class="maincontent">';

    the_content();
    
    wp_link_pages( array(
      'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'devio-playground' ) . '</span>',
      'after'       => '</div>',
      'link_before' => '<span>',
      'link_after'  => '</span>',
      'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'devio-playground' ) . ' </span>%',
      'separator'   => '<span class="screen-reader-text">, </span>',
    ) );

    echo '</div>';

    //add manually simple author box plugin - hooks?
    // if ( function_exists( 'wpsabox_author_box' ) ) echo wpsabox_author_box();//manually
  }  

//Singular Post Navi Prev-Next / Older Newer
    function devio_postnavi_post_oldnew_pro()
    {
      // Don't print empty markup if there's nowhere to navigate.
      $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
      $next     = get_adjacent_post( false, '', false );

      if ( ! $next && ! $previous )
      {
        return;
      }
      ?>
        <nav class="navigation post-navigation" role="navigation">
        <h3 class="sr-only">Post navigation</h3>
        <ul class="pager">
        <?php
            //set argument true : only on same category
        if ( is_attachment() ) :
          // previous_post_link( '%link', __( '<li class="previous-link">Published In</li>%title', 'devio-playground' ), true );
          previous_post_link( '%link', '<li class="previous-link">' . __('Published In', 'devio-playground' ) . '</li>%title', true );
        else :
          previous_post_link( '<li class="previous-link">%link</li>', apply_filters( 'devio/single-post/previous-postlink/do_filter', '<i class="fa fa-angle-double-left"></i>' . __( 'Older', 'devio-playground' ) ), true );
          next_post_link( '<li class="next-link">%link</li>', apply_filters( 'devio/single-post/next-postlink/do_filter', __( 'Newer', 'devio-playground' ) .' <i class="fa fa-angle-double-right"></i>'), true );
        endif;
        ?>
      </ul><!-- .nav-links -->
      </nav><!-- .navigation -->
    <?php
    }

//Paginate Archive Index Page Links
  function devio_get_paginate_archive_page_links_pro( $type = 'plain', $endsize = 1, $midsize = 1 ) 
  {
    global $wp_query, $wp_rewrite, $pagination;  
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    
    // Sanitize input argument values
    if ( ! in_array( $type, array( 'plain', 'list', 'array' ) ) ) $type = 'plain';
    $endsize = (int) $endsize;
    $midsize = (int) $midsize;
    
    // Setup argument array for paginate_links()
    $pagination = array(
      'base' => @add_query_arg( 'paged','%#%' ),
      'format' => '',
      'total' => $wp_query->max_num_pages,
      'current' => $current,
      'show_all' => false,
      'end_size' => $endsize,
      'mid_size' => $midsize,
      'type' => $type,
      // 'prev_text' => '&lt;&lt;',
      // 'next_text' => '&gt;&gt;'
      'prev_text' => apply_filters( 'devio/navigation/archive/previous_link/arrow/do_filter', '<i class="fa fa-chevron-left"></i>'),
      'next_text' => apply_filters( 'devio/navigation/archive/previous_link/arrow/do_filter', '<i class="fa fa-chevron-right"></i>'),
    );

    if( $wp_rewrite->using_permalinks() )
      $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

    if( !empty($wp_query->query_vars['s']) ):
      $pagination['add_args'] = array( 's' => urlencode( get_query_var( 's' ) ) );
    endif;
    
    do_action('devio/navigation/archive/links/do_action'); 
  }

//Page 404
  /**
  * Display Custom Page 404 from Panel
  * Heading Title and Content
  */
  function devio_page404_pro()
  {
    global $deviocantik;

    if ( !empty( $deviocantik['page404_title'] ) ):
      echo apply_filters( 'devio/page404/title/do_filter','<h2>' . esc_html( $deviocantik['page404_title'] ). '</h2>' );
    endif;

    if ( !empty( $deviocantik['page404_content'] ) ):
      echo applyfilters( 'devio/page404/content/do_filter', esc_textarea( $deviocantik['page404_content']) );
      // wp_kses_post( $deviocantik['page404_content'] );
    endif;
  }

//Archive mode
  function devio_archive_entry_pro()
  {  
    if ( have_posts() ) :
  
      if ( has_action( 'devio/archive/header/do_action' )):
        do_action('devio/archive/header/do_action' ); //add title inside mainarea block

      else:

        if ( is_search() ):
            echo apply_filters( 'devio/archive/search-title/do_filter', '<header><h2>'. __( 'Search Result for','devio-playground' ) . ' <span>' . ' ' . get_search_query() . '</span></h2></header>' );
        else:
          echo apply_filters( 'devio/archive/title/do_filter', '<header><h2>' . devio_archive_title_pro() . '</h2></header>' );
        endif;

      endif; 
    ?>
    <div class="row">
      <div class="archive mode <?php echo apply_filters( 'devio/archive/mode/do_filter', '' );?>"> 
        <!--filterable-isotope is optional-->
        <?php 
        while ( have_posts() ) : the_post();
        $thumb = has_post_thumbnail() ? 'thumb ' : '';
        echo '<div class="' . apply_filters( 'devio/archive/columns/do_filter', $thumb . 'col-md-4 col-sm-6') . '">';
        //inject filterItems here

        if ( has_action( 'devio/archive/entry-content/do_action' ) ) :
          do_action( 'devio/archive/entry-content/do_action' );
        else:
          devio_entrycontent_loop_pro();
        endif;
        ?>
        
        </div><!--.entry-columns-->
        <?php endwhile; ?>
      </div><!--.archive-mode-->

    <?php endif; ?>

    <?php //run pagination if needed
      devio_get_paginate_archive_page_links_pro(); 
    ?>
    </div><!--.row-->
    <?php
  }

//Archive Main Loop
  function devio_entrycontent_loop_pro()
  {
    ?>
    <div class="entry-content <?php echo apply_filters( 'devio/archive/entry-content/columns/do_filter', '' );?>">
      <?php
      apply_filters( 'devio/archive/entry-content/featimage-loop/do_filter','' );
      if ( has_action( 'devio/archive/entry-content/featimage-loop/do_action' ) ) :
        do_action( 'devio/archive/entry-content/featimage-loop/do_action' );
      else:
        devio_featimage_loop_pro();
      endif;
      ?>

      <div class="entry-item nopadding <?php echo apply_filters( 'devio/archive/entry-content/item-columns/do_filter', '' );?>">
      <?php
        //additional content if needed
        if ( has_action( 'devio/archive/entry-content/entry-item/do_action' ) ) :
          do_action( 'devio/archive/entry-content/entry-item/do_action' );

        else: //default mode
          //title
          echo apply_filters( 'devio/archive/entry-content/item-title/do_filter', '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>');

          //date
          echo apply_filters( 'devio/archive/entry-content/item-date/do_filter', '<span class="date">' . get_the_date() . '</span>');
          //excerpt
          echo apply_filters( 'devio/archive/entry-content/item-excerpt/do_filter', '<span class="intro">' . strip_shortcodes ( wp_trim_words( get_the_content() , 10 ) ) .'</span>');

          //readmore
          echo apply_filters( 'devio/archive/entry-content/item-readmore/do_filter', '<span class="readmore"><a href="' . get_permalink() . '">' . __( 'Read More', 'devio-playground') .'</a></span>');

        endif;
      ?>
      </div><!--.entry-item-->
    </div><!--.entry-content-->
    <?php  
  }

//Feat Image for Loop
function devio_featimage_loop_pro()
{
  if ( has_post_thumbnail() ):
    $thumb_imgalt = get_post_meta( get_post_thumbnail_id() ); // Get post meta by ID
    $imgalt = isset( $thumb_imgalt['_wp_attachment_image_alt'] ) ? $thumb_imgalt['_wp_attachment_image_alt']['0'] : get_the_title();

    $image_thumb    = wp_get_attachment_image_src( get_post_thumbnail_id(), apply_filters( 'devio/featimage/size/do_filter','large') );
    ?>

    <div class="entry-image nopadding <?php echo apply_filters( 'devio/featimage/columns/do_filter', '' );?>">
    <?php
    //load the image
      echo apply_filters( 'devio/featimage/figure/do_filter', '<img class="img-responsive"  src="'. esc_url( $image_thumb[0] ) .'" alt="' . esc_attr( $imgalt ) . '">' );
    ?>
    </div><!-- //entry-image-->

    <?php 
  endif;//eof has post thumbnnail
}    

//entry item editlink
function devio_entry_item_editlink_pro()
{
  if ( is_user_logged_in() ) :
      echo apply_filters ( 'devio/editlink/do_filter','<div class="editlink col-md-12 nopadding"><a href="' . get_edit_post_link() . '">' . __( 'Edit', 'devio-playground' ) . '</a></div>' );
  endif;
}

//start view -
function devio_section_startview_pro()
{
  global $deviocantik;
  ?>
  <section id="start" class="start appear featured" <?php echo apply_filters( 'devio/section/startview/appear/do_filter','');?>>
    <div class="container"> 
      <div class="row heading">
        <div class="<?php echo apply_filters( 'devio/section/startview/data/do_filter', 'col-md-6 col-md-offset-3 text-center' );?>">
          <?php do_action( 'devio/section/startview/data/do_action' ); ?>
        </div>
      </div>
    </div>
  </section>
  <?php
}

//Slogan -
function devio_section_slogan_pro()
{
  global $deviocantik;
  ?>
  <section id="section-slogan" class="section slogan" <?php echo apply_filters( 'devio/section/slogan/appear/do_filter','' );?>>
      <div class="container">
          <div class="slogandata <?php echo apply_filters( 'devio/section/slogan/data/do_filter','text-center pad-top40 pad-bot40');?>">
            <?php do_action( 'devio/section/slogan/data/do_action' ); ?>
          </div>
      </div>  
  </section>
  <?php
}

// CTA -
function devio_section_callaction_pro()
{
  ?>
  <section id="section-callaction" class="section callaction" <?php echo apply_filters( 'devio/section/callaction/appear/do_filter','' );?>>
      <div class="text-center <?php echo apply_filters( 'devio/section/callaction/container/do_filter','pad-top40 pad-bot40');?>">
        <?php do_action( 'devio/section/callaction/data/do_action' ); ?> 
      </div>
  </section>
  <?php
}

//Cform -
function devio_section_cform_pro()
{
  global $deviocantik;
  ?>
  <div class="<?php echo apply_filters( 'devio/section/cform/top/code/columns/do_filter', 'col-md-offset-3 col-md-6 col-xs-offset-1 col-xs-10' ); ?><?php echo apply_filters( 'devio/section/cform/data/do_filter','' );?>">
      <?php do_action( 'devio/section/cform/data/do_action' ); ?>
    </div>
  <?php
}

//address -
function devio_section_address_pro()
{
  ?>
  <div class="addressdata <?php echo apply_filters( 'devio/section/address/data/do_filter', 'pad-top20 pad-bot20');?>">
    <?php 
    if ( has_action( 'devio/section/address/data/do_action' ) ):
      do_action( 'devio/section/address/data/do_action' );

    else:

      if ( !empty( $deviocantik['address'] ) ):
        echo '<div class="address-data">' . esc_textarea( $deviocantik['address'] ) . '</div>';
      endif;

    endif;
    ?> 
  </div>
  <?php
}

//Social media ( panel )
function devio_socmed_sort()
{
  global $deviocantik;

    if ( isset( $deviocantik['socmed_sort'] ) ):
    foreach( $deviocantik['socmed_sort'] as $k => $v ):

      switch ( $k ):

        case 'soc-twitter' :
          if ( !empty( $deviocantik['soc-twitter'] ) ) :
            $url  = $deviocantik['soc-twitter'];
            $icon = 'twitter';
          endif;
        break;

        case 'soc-gplus' :
          if ( !empty( $deviocantik['soc-gplus'] ) ) :
            $url  = $deviocantik['soc-gplus'];
            $icon = 'google-plus';
          endif;
        break;

        case 'soc-facebook' :
          if ( !empty( $deviocantik['soc-facebook'] ) ) :
            $url  = $deviocantik['soc-facebook'];
            $icon = 'facebook'; 
          endif;
        break;

        case 'soc-linkedin' :
          if ( !empty( $deviocantik['soc-linkedin'] ) ) : 
            $url  = $deviocantik['soc-linkedin'];
            $icon = 'linkedin';
          endif;
        break;

        case 'soc-feed' :
          if ( !empty( $deviocantik['soc-feed'] ) ) : 
            $url  = $deviocantik['soc-feed'];
            $icon = 'rss';
          endif;
        break;

      endswitch;

      if ( $v == '1' ):
      ?>
      <li class="socmedicons"><a href="<?php echo esc_url( $url );?>" class="iconborder ico-<?php echo $icon;?>"><i class="fa fa-<?php echo $icon;?>"></i></a></li>
      <?php
      endif;

    endforeach;
    endif;
}

//footer area
function devio_footerarea_pro()
{
  global $deviocantik, $footerlayout, $footer1sidebar, $footer2sidebar, $footer3sidebar, $footer4sidebar;

  $footer1sidebar  = $deviocantik['footer-1-sidebar'];
  $footer2sidebar  = $deviocantik['footer-2-sidebar'];
  $footer3sidebar  = $deviocantik['footer-3-sidebar'];
  $footer4sidebar  = $deviocantik['footer-4-sidebar'];
  $footerlayout    = $deviocantik['footer_layout'];

  switch ( $footerlayout ) :
    case 'full' :
      do_action( 'devio/footerarea_one_column/do_action' );
    break;

    case '2cols' :
      do_action( 'devio/footerarea_one_column/do_action' );
    break;

    case '3cols' :
      do_action( 'devio/footerarea_one_column/do_action' );
    break;
    
    case '4cols' :
      do_action( 'devio/footerarea_one_column/do_action' );
    break;
  endswitch;
}

function devio_footerarea_two_columns()
{
  global $deviocantik, $footer1sidebar, $footer2sidebar;
  
  if ( is_active_sidebar( $footer1sidebar ) || is_active_sidebar( $footer2sidebar ) ) : 
  ?> 
  <footer id="footerarea" class="footer2 footerarea">
    <div class="container">

        <?php if ( is_active_sidebar( $footer1sidebar ) ) : ?> 
        <div class="<?php echo apply_filters( 'devio/footer21_columns/do_filter', 'col-md-6' );?>">
          <?php dynamic_sidebar( $footer1sidebar ); ?>
        </div>
        <?php endif; ?>

        <?php if ( is_active_sidebar( $footer2sidebar ) ) : ?>
        <div class="<?php echo apply_filters( 'devio/footer22_columns/do_filter', 'col-md-6' );?>">
          <?php dynamic_sidebar( $footer2sidebar ); ?>
        </div>
        <?php endif; ?>

    </div>
  </footer>
  <?php
  endif; 
}

function devio_footerarea_three_columns()
{
  global $deviocantik, $footer1sidebar, $footer2sidebar, $footer3sidebar;

  if ( is_active_sidebar( $footer1sidebar ) || is_active_sidebar( $footer2sidebar ) || is_active_sidebar( $footer3sidebar ) ) : 
  ?>
  <footer id="footerarea" class="footer3 footerarea">
    <div class="container">

        <?php if ( is_active_sidebar( $footer1sidebar ) ) : ?>
        <div class="<?php echo apply_filters( 'devio/footer31_columns/do_filter', 'col-md-4' );?>">
          <div class="footer-sidebar">
            <?php dynamic_sidebar( $footer1sidebar ); ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if ( is_active_sidebar( $footer2sidebar ) ) : ?>
        <div class="<?php echo apply_filters( 'devio/footer32_columns/do_filter', 'col-md-4' );?>">
          <div class="footer-sidebar">
            <?php dynamic_sidebar( $footer2sidebar ); ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if ( is_active_sidebar( $footer3sidebar ) ) : ?>
        <div class="<?php echo apply_filters( 'devio/footer33_columns/do_filter', 'col-md-4' );?>">
          <div class="footer-sidebar">
            <?php dynamic_sidebar( $footer3sidebar ); ?>
          </div>
        </div>
        <?php endif; ?>

    </div>
  </footer>
  <?php 
  endif;
}

function devio_footerarea_four_columns()
{
  global $deviocantik, $footer1sidebar, $footer2sidebar, $footer3sidebar, $footer4sidebar;

  if ( is_active_sidebar( $footer1sidebar ) || is_active_sidebar( $footer2sidebar ) || is_active_sidebar( $footer3sidebar ) || is_active_sidebar( $footer4sidebar ) ) : 
  ?>  
  <footer id="footerarea" class="footer4 footerarea">
    <div class="container">
        <?php if ( is_active_sidebar( $footer1sidebar ) ) : ?>
        <div class="<?php echo apply_filters( 'devio/footer41_columns/do_filter', 'col-md-3' );?>">
          <div class="footer-sidebar">
            <?php dynamic_sidebar( $footer1sidebar ); ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if ( is_active_sidebar( $footer2sidebar ) ) : ?>
        <div class="<?php echo apply_filters( 'devio/footer42_columns/do_filter', 'col-md-3' );?>">
          <div class="footer-sidebar">
            <?php dynamic_sidebar( $footer2sidebar ); ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if ( is_active_sidebar( $footer3sidebar ) ) : ?> 
        <div class="<?php echo apply_filters( 'devio/footer43_columns/do_filter', 'col-md-3' );?>">
          <div class="footer-sidebar">
            <?php dynamic_sidebar( $footer3sidebar ); ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if ( is_active_sidebar( $footer4sidebar ) ) : ?>
        <div class="<?php echo apply_filters( 'devio/footer44_columns/do_filter', 'col-md-3' );?>">
          <div class="footer-sidebar">
            <?php dynamic_sidebar( $footer4sidebar ); ?>
          </div>
        </div>
        <?php endif; ?>

    </div>
  </footer>
  <?php
  endif;
}

//Frontpage
function devio_frontpage_display_pro()
{
    while ( have_posts() ) : the_post();
      the_content();
    endwhile;
    wp_reset_query();
}

//Homepage default_content ( blog mode )
function devio_home_display_pro()
{
  while ( have_posts() ) : the_post();
    devio_entrycontent_loop_pro();
  endwhile;
  wp_reset_query();
}

//OT Upload Media Text Filter
function devio_upload_media_text_do_filter_pro()
{
  return 'Upload Media';
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
      <?php include(locate_template('view/loop/comment.php')); ?>
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

//Retrieve attachment ID from URL
  //https://philipnewcomer.net/2012/11/get-the-attachment-id-from-an-image-url-in-wordpress/
  function devio_get_attachment_id_from_url_pro( $attachment_url = '' ) 
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

//preload - themes loaded
  function devio_css_preload_pro()
  {
    global $deviocantik;
    ?>
    <div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <?php
  }   

//Body Class
function devio_color_body_classes($classes)
{
  global $deviocantik;
  if ( isset($deviocantik['colorscheme'] )):
    $classes[] = $deviocantik['colorscheme'];
  endif;
  return $classes;
}

//for page templates
function devio_clean_pagetemplate_body_class_pro($classes) 
{
  global $wp_query;

  $arr = array();

  if ( is_page_template()):
    foreach ( $classes as $k =>  $v ) {
      $temp = get_page_template();
      if ( $temp != null ) {
        $path = pathinfo($temp);
        $tmp = $path['filename'] . "." . $path['extension'];
        $tn= str_replace(".php", "", 'page ' . $tmp);
        $arr[] = "".$tn;
      }
    }
    $classes = $arr;
    endif;
    return $classes;
}