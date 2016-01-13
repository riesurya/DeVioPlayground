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

class DeVioPlaygroundPro_MainHooks
{	
	function __construct() 
	{
		add_action( 'widgets_init',                             array( $this, 'devio_register_sidebars' ));
		
		add_action( 'wp_head', 									array( $this, 'devio_custom_favicon' ), 20 );

		add_action( 'wp_enqueue_scripts',                      	array( $this, 'devio_register_theme_scripts'), 9 );
		add_action( 'wp_enqueue_scripts',                      	array( $this, 'devio_register_playground_scripts'), 9 );
		add_action( 'wp_enqueue_scripts',             			array( $this, 'devio_enqueue_theme_scripts' ),11 );
		add_action( 'wp_enqueue_scripts',             			array( $this, 'devio_enqueue_playground_scripts' ),20 );

		//frontpage
		add_action( 'devio/frontpage/maincontent/do_action',  	array( $this, 'devio_frontpage_display' ), 2 );
		add_action( 'devio/home/maincontent/do_action',  		array( $this, 'devio_home_display' ), 2 );
		add_action( 'devio/home/maincontent/do_action', 		array( $this, 'devio_archive_links' ));

		//singular maincontent default
		add_action( 'devio/singular/maincontent/do_action',   	array( $this, 'devio_singular_entry_maincontent'), 10 );
		
		//Title
		add_action( 'devio/singular/article/top/do_action',   	array( $this, 'devio_singular_entry_title' ));

		//Comments for singular
		add_action( 'devio/singular/comments/do_action',   		array( $this, 'devio_singular_comments' ));

		//EditLink
		add_action( 'devio/singular/article/bottom/do_action', 	array( $this, 'devio_entry_item_editlink' ));
		
		//Post Navigation
		add_action( 'devio/singular/article/bottom/do_action',  array( $this, 'devio_postnavi_post_oldnew' ), 12 );
		
		//Search Result 
		add_action( 'devio/search/maincontent/do_action', 		array( $this, 'devio_archive_entry' ));

		//Archive entry - Post
		add_action( 'devio/archive/maincontent/do_action',    	array( $this, 'devio_archive_entry' ));
		add_action( 'devio/navigation/archive/links/do_action', array( $this, 'devio_archive_links'));

		//BottomBar
		add_action( 'devio/bottombar-text/do_action',       	array( $this, 'devio_bottombar_text' ));

		//custom CSS/JS
		add_action( 'wp_head',                                	array( $this, 'devio_custom_csscode' ), 25 );
		add_action( 'wp_footer',                              	array( $this, 'devio_custom_jscode' ), 25 );

		//404
		add_action( 'devio/error404/maincontent/do_action',     array( $this, 'devio_pagenotfound' ) );
	}

	//custom favicon
	function devio_custom_favicon()
	{
		global $deviocantik;
		if ( !empty( $deviocantik['favicon-url'] ) ): 
			echo'<link rel="icon" type="image/x-icon" href="'. esc_url ( $deviocantik['favicon-url']['url'] ).'">';
		endif;
	}

	//Register Default Sidebar
	function devio_register_sidebars()
	{
	  //register sidebar - apply filters ...
	  $allsidebars = array( 
	    'devio-sidebar-right',
	    'devio-sidebar-left', 

	    'devio-footer-1', 
	    'devio-footer-2',

	    'devio-footer-3', 
	    'devio-footer-4',
	  );

	  foreach( $allsidebars as $sidesupport )
	  {
	    register_sidebar(
	      array(
	        'name'          => ucwords( ( str_replace ( array( '-', '_' ), ' ', $sidesupport ) ) ),
	        'id'            => sanitize_title ($sidesupport),    
	        'before_widget' => '<div id="%1$s" class="devio-widget %2$s">',       
	        'after_widget'  => '</div><!--#widget id-->', 
	        'before_title'  => '<h3 class="widget-title">',
	        'after_title'   => '</h3>',       
	      )
	    ); 
	  }
	}//eof function
  	
  	//all scripts
  	function devio_register_theme_scripts()
  	{
	    if (is_singular() && comments_open() && get_option('thread_comments')) :
	    	wp_enqueue_script('comment-reply');
	    endif;

	    //bootstrap
	    if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/bootstrap/bootstrap.min.css' ) ):
	      wp_register_style( 'bootstrap', trailingslashit( get_template_directory_uri() ) . 'assets/bootstrap/bootstrap.min.css', false, null );
	    else:
	      wp_register_style( 'bootstrap', 'https://cdn.jsdelivr.net/bootstrap/3.3.5/css/bootstrap.min.css', false, null );
	    endif;

	    if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/bootstrap/bootstrap.min.js' ) ):
	      wp_register_script( 'bootstrap', trailingslashit( get_template_directory_uri() ) . 'assets/bootstrap/bootstrap.min.js', array('jquery'), null, true);
	    else:
	       wp_register_script( 'bootstrap', 'https://cdn.jsdelivr.net/bootstrap/3.3.5/js/bootstrap.min.js', array('jquery'), null, true);
	    endif;

	    //fontawesome
	    if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/fontawesome/css/font-awesome.min.css' ) ):
	      wp_register_style( 'fontawesome', trailingslashit( get_template_directory_uri() )  . 'assets/fontawesome/css/font-awesome.min.css', false, null );
	    else:
	      wp_register_style( 'fontawesome', 'https://cdn.jsdelivr.net/fontawesome/4.4.0/css/font-awesome.min.css', false, null );
	    endif;

	    //modernizr
	    if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/modernizr/modernizr.min.js' ) ):
	      wp_register_script( 'modernizr', trailingslashit( get_template_directory_uri() )  . 'assets/modernizr/modernizr.min.js', array('jquery'), null, true);
	    else:
	      wp_register_script( 'modernizr', 'https://cdn.jsdelivr.net/modernizr/2.8.3/modernizr.min.js', array('jquery'), null, true);
	    endif;
  	}

  	function devio_register_playground_scripts()
  	{
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
			'devio-playground-custom' )
		);

		wp_enqueue_style( array( 
			'devio-playground-custom' )
		);

		if ( is_child_theme() )
		wp_enqueue_style( 'devio-playground-child' );
		wp_enqueue_script( 'devio-playground-child' );
	}

	//frontpage
	function devio_frontpage_display()
	{
	    while ( have_posts() ) : the_post();
	      the_content();
	    endwhile;
	    wp_reset_query();
	}

	//Homepage default_content ( blog mode )
	function devio_home_display()
	{
	  while ( have_posts() ) : the_post();
	    $this->devio_archive_entrycontent_loop();
	  endwhile;
	  wp_reset_query();
	}

	//singular mode
	function devio_singular_entry_maincontent()
	{
	    ?>
	    <div class="article-content">
	    <?php
	    the_content();
	    
	    wp_link_pages( array(
	      'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'devio-playground' ) . '</span>',
	      'after'       => '</div>',
	      'link_before' => '<span>',
	      'link_after'  => '</span>',
	      'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'devio-playground' ) . ' </span>%',
	      'separator'   => '<span class="screen-reader-text">, </span>',
	    ) );
	    ?>
	    </div>
	    <?php
	}

  	//entry Article Entry
	function devio_singular_entry_title()
	{
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
	}

	//No Title
	  /**
	   * Output default Post Title if none is provided
	   * Filter Hook: the_title 
	   * Filter 'the_title' to output '(Untitled)' if 
	   * no Post Title is provided
	   */
	function devio_untitled_post( $title ) 
	{
	  if ( '' == $title ) :
	    return apply_filters( 'devio/singular/title/untitled/do_filter', '<em>( ' . __( 'Untitled', 'devio-playground' ) . ' )</em>' );
	  else :
	    return $title;
	  endif;
	}

	//Comments loaded
	function devio_singular_comments()
	{
		if ( post_type_supports( 'post', 'comments' ) )
	    comments_template(); //see comments.php on theme
	}

	//entry item editlink
	function devio_entry_item_editlink()
	{
	    if ( is_user_logged_in() ) :
	    ?>
	    <div class="editlink"><a href="<?php echo get_edit_post_link();?>"><?php echo __( 'Edit', 'devio-playground' );?></a></div>
	    <?php
	    endif;
	 }

	 //default scripts

  	//Archive mode
	function devio_archive_entry()
	{  
	  if ( have_posts() ) :

		if ( is_search() ):	?>
		<header><h2><?php echo __( 'Search Result for','devio-playground' );?><span><?php echo get_search_query();?></span></h2></header>
		<?php else: ?>
		<header><h2><?php echo $this->devio_archive_title();?></h2></header>
		<?php endif; ?>

		  	<div class="row">
			    <div class="archive-mode<?php echo apply_filters( 'devio/archive/mode/do_filter', '' );?>">
			      	<!--filterable-isotope is optional-->
			      	<?php 
			        while ( have_posts() ) : the_post();
			        $thumb = has_post_thumbnail() ? 'thumb ' : '';
			      	?>
			      
			      	<div class="<?php echo apply_filters( 'devio/archive/columns/do_filter', $thumb . 'col-md-4 col-sm-6');?>">
			        <?php $this->devio_archive_entrycontent_loop(); ?>
			      	</div><!--.entry-columns-->

			      	<?php endwhile; ?>
			    </div><!--.archive-mode-->
		  	</div>

		  	<?php $this->devio_get_paginate_archive_page_links();  //run pagination if needed ?>
		  
		  	<?php else: //if have no posts or any custom conditions ?>

		  	<?php 
		  	if ( has_action('devio/loop/have_no_posts/do_action') ):
		  		do_action( 'devio/loop/have_no_posts/do_action' );
		  	else:
		  		echo '<p class="notfound">'. __('the article(s) you are looking for not found', 'devio-playground').'</p>';
		  	endif;
		  	?>

		  	<?php endif; //eof have_posts ?>
	  
	  <?php
	}

	//Archive Title
	function devio_archive_title()
	{   

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

	  	return apply_filters( 'devio/archive/title/do_filter', $archives_title );

	  	// endif; //eof !is_singular
	}

	//archive entry loop
	function devio_archive_entrycontent_loop()
	{
		global $post;
	  	?>
	  	<div class="entry-content">
		    <?php 
		    //featured image ( may or not display via hooks )
		    if ( has_action( 'devio/archive/entrycontent/featimage-loop/do_action' ) ) :
	          do_action( 'devio/archive/entrycontent/featimage-loop/do_action' );
	        else:
	        	$this->devio_featimage_loop();
	        endif;

	        //additional content if needed
	        if ( has_action( 'devio/archive/entrycontent/item/do_action' ) ) :
	          do_action( 'devio/archive/entrycontent/item/do_action' );
	        else: //default mode
	        ?>
		    <div class="entry-item">
		      	<!-- //default mode -->
		        <!-- // title -->
		        <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>

		        <!-- //date -->
		        <span class="date"><?php echo get_the_date() ;?></span>

		        <!-- //excerpt -->
		        <span class="intro"><?php echo strip_shortcodes ( wp_trim_words( get_the_content() , 10 ) );?></span>

		        <!-- //readmore -->
		        <span class="readmore"><a href="<?php the_permalink();?>"><?php echo __( 'Read More', 'devio-playground');?></a></span>
		        
		        <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( __( 'View all posts by %s', 'twentyfifteen' ), get_the_author() ); ?>
			</a>
		    </div><!--.entry-item-->
			<?php endif;?>

	  	</div><!--.entry-content-->
	  	<?php  
	}

	//Archive Pagination
	function devio_get_paginate_archive_page_links( $type = 'plain', $endsize = 1, $midsize = 1 ) 
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
	      'prev_text' => apply_filters( 'devio/navigation/archive/previous_link/arrow/do_filter', '<i class="fa fa-chevron-left"></i> Previous'),
	      'next_text' => apply_filters( 'devio/navigation/archive/next_link/arrow/do_filter', 'Next <i class="fa fa-chevron-right"></i>'),
	    );

	    if( $wp_rewrite->using_permalinks() )
	      $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

	    if( !empty($wp_query->query_vars['s']) ):
	      $pagination['add_args'] = array( 's' => urlencode( get_query_var( 's' ) ) );
	    endif;
	    
	    do_action('devio/navigation/archive/links/do_action'); 
  	}

	//archive paginate links hook
	function devio_archive_links()
	{
		global $pagination;
		?>
		<div class="row clearfix">
		  <div class="col-md-12">
		    <nav class="posts-pagination"><?php echo paginate_links( $pagination );?></nav>
		  </div>
		</div>
		<?php
	}

	//Singular Post Navi Prev-Next / Older Newer
	function devio_postnavi_post_oldnew()
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

  	//FeatImage
  	function devio_featimage_loop()
	{
		if ( has_post_thumbnail() ):

			$thumb_imgalt = get_post_meta( get_post_thumbnail_id() ); // Get post meta by ID
			$image_alt = isset( $thumb_image_alt['_wp_attachment_image_alt'] ) ? $thumb_image_alt['_wp_attachment_image_alt']['0'] : get_the_title();

			$image_thumb    = wp_get_attachment_image_src( get_post_thumbnail_id(), apply_filters( 'devio/featimage/size/do_filter', 'large' ) );
			?>
			<div class="entry-image nopadding <?php echo apply_filters( 'devio/featimage/columns/do_filter', '' );?>">
				<img class="img-responsive"  src="<?php echo esc_url( $image_thumb[0] );?>" alt="<?php echo esc_attr( $image_alt );?>">
			</div><!-- //entry-image-->

		<?php 
		endif;//eof has post thumbnnail
	}

	//Custom CSS
	function devio_custom_csscode()
	{
		global $deviocantik;

		if ( !empty( $deviocantik['css_custom'] ) ):
		echo '<style>' . $deviocantik['css_custom'] . '</style>';
		endif;
	}

	//Custom JS
	function devio_custom_jscode()
	{
		global $deviocantik;

		if ( !empty( $deviocantik['js_custom'] ) ):
		echo '<script>' . $deviocantik['js_custom'] . '</script>';
		endif;
	}

	//Bottom bar - extendable
	function devio_bottombar_text()
	{
	  	global $deviocantik;
	  	$themes_notice = wp_get_theme()->name . ' '.'Theme created with <i class="fa fa-heart red"></i> by <a href="http://riesurya.com/">Riesurya</a><br>for beloved angels Delfia and Violina';
	  	if ( isset( $deviocantik['bottext'] ) && !empty( $deviocantik['bottext'] ) ):
	  		echo apply_filters( 'devio/bottombar/text/do_filter', wp_kses_post( $deviocantik['bottext'] ). $themes_notice );
	  	else:
	  		echo $themes_notice;
	  	endif;
	}

	//page404
	function devio_pagenotfound()
	{
		echo '<h3>' . __( 'Page you are looking for is not exist anymore', 'devio-playground' ) .'</h3>';
	}

}//eof Class
global $mainhooks;
$mainhooks = new DeVioPlaygroundPro_MainHooks();