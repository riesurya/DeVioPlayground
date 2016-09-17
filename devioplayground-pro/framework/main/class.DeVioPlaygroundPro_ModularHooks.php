<?php
/**
  @copyright Copyright (C) 2011 - forever DeVio Multimedia 
  Made with 100% love and hopes for my beloved daughters Delfia Nur Anrianti Putri and Violina Melody Ramadhani, where ever you are, Papa Love U
  Author : Muhammad Anrie Ibrahim
  Author URI : http://deviolayground.com
  SubPackage: Modular hooks
  Location : framework/main/class.DeVioPlayground_ModularHooks.php
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    die;
}

class DeVioPlaygroundPro_ModularHooks
{
	//important thing !
	private static $_this;
	
	function __construct() 
	{
		self::$_this = $this;
	}

	static function this()
	{
		return self::$_this;
	}

	//TopBar Area
	function devio_topbararea_do_action()
	{
		if ( has_action ( 'devio/topbararea/do_action' ) )
		do_action( 'devio/topbararea/do_action' );
	}

	// Header Area
	function devio_headerarea_do_action()
	{
		if ( has_action ( 'devio/headerarea/do_action' ) )
			do_action( 'devio/headerarea/do_action' );
	}

	//Main Area
  	function devio_mainarea_top_do_action()
  	{
		if ( has_action ( 'devio/mainarea/top/do_action' ) )
			do_action( 'devio/mainarea/top/do_action' );
  	}

	function devio_mainarea_bottom_do_action()
	{
		if ( has_action ( 'devio/mainarea/bottom/do_action' ) )
			do_action( 'devio/mainarea/bottom/do_action' );
	}

	//Footer Area
	function devio_footerarea_do_action()
	{
		if ( has_action ( 'devio/footerarea/do_action' ) )
			do_action( 'devio/footerarea/do_action' );
	}

	//Bottom Area
	function devio_bottomarea_do_action()
	{
		if ( has_action ( 'devio/bottomarea/do_action' ) )
			do_action( 'devio/bottomarea/do_action' );
	}

	//Modular singular - begin
	function devio_singular_entry_do_action()
	{
		//this hook will create singular entry from scratch
		if( has_action ( 'devio/singular/entry/do_action' ) ):
			do_action( 'devio/singular/entry/do_action' );
		else:
			DeVioPlaygroundPro_ModularHooks::this()->devio_singular_title_do_action();
			?>
			<article id="devioplayground-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php 
				//while have_posts here
				while ( have_posts() ) : the_post();

					if ( post_password_required() ) :
					 	echo get_the_password_form();
					 	return;
					endif;

					//do more override here
					DeVioPlaygroundPro_ModularHooks::this()->devio_singular_entrycontent_do_action();

				endwhile;
				?>
			</article><!-- #post-<?php the_ID(); ?> -->
			<?php
			
			//by default will load EditLink
			DeVioPlaygroundPro_ModularHooks::this()->devio_singular_editlink_do_action();			
			
			DeVioPlaygroundPro_ModularHooks::this()->devio_singular_pagination_do_action();
						
			// The comments section loaded when appropriate
			DeVioPlaygroundPro_ModularHooks::this()->devio_singular_comments_do_action();
		endif;
	}

	function devio_singular_title_do_action()
	{
		if ( has_action ( 'devio/singular/title/do_action' ) ):
			do_action( 'devio/singular/title/do_action' );
		else:
			//do check
			if ( is_front_page() )
			  return;

			$entry_title = '<header><h1><a href="' . get_permalink() . '">' . get_the_title() . '</a></h1></header>';    
			echo apply_filters( 'devio/singular/title/do_filter', $entry_title );	
		endif;
	}	

	//entrycontent
	function devio_singular_entrycontent_do_action()
	{
		global $post;

		$page_template = get_post_meta( $post->ID, '_wp_page_template', true );
		$pagetemplate_name = str_replace( array('page-templates/', '.php'), '', $page_template);
		?>
		<div class="article-maincontent">

		<?php
		if( is_page() && $pagetemplate_name != 'default' ):
			do_action ( 'devio/' . $pagetemplate_name . '/maincontent/do_action' );
		endif;

		if ( has_action( 'devio/singular/entrycontent/do_action' ) ):
			do_action( 'devio/singular/entrycontent/do_action' );
		else:
			//load maincontent
			do_action( 'devio/singular/entrycontent/meta/top/do_action' ); 
			?>

		    <div class="thecontent"><?php the_content(); ?></div>
		    <?php
		    wp_link_pages( array(
		      'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'devio-playground' ) . '</span>',
		      'after'       => '</div>',
		      'link_before' => '<span>',
		      'link_after'  => '</span>',
		      'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'devio-playground' ) . ' </span>%',
		      'separator'   => '<span class="screen-reader-text">, </span>',
		    ) );

		    do_action( 'devio/singular/entrycontent/meta/bottom/do_action' );
			
		endif;
		?>
		</div>
		<?php
	}

	function devio_singular_editlink_do_action()
	{
		if ( is_user_logged_in() ) :
	    ?>
	    <div class="editlink"><a href="<?php echo get_edit_post_link();?>"><?php echo __( 'Edit', 'devio-playground' );?></a></div>
	    <?php
	    endif;	
	}

	//post navigation
	function devio_singular_pagination_do_action()
	{
		if ( has_action( 'devio/singular/pagination/do_action' ) ) :
			do_action( 'devio/singular/pagination/do_action');
		else :
		// Don't print empty markup if there's nowhere to navigate.
	    $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	    $next     = get_adjacent_post( false, '', false );

	    if ( ! $next && ! $previous ):
	      	return;
	    endif;
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
			previous_post_link( '<li class="previous-link">%link</li>', apply_filters( 'devio/singular/pagination/previous/do_filter', '<i class="fa fa-angle-double-left"></i>' . __( 'Older', 'devio-playground' ) ), true );
			next_post_link( '<li class="next-link">%link</li>', apply_filters( 'devio/singular/pagination/next/do_filter', __( 'Newer', 'devio-playground' ) .' <i class="fa fa-angle-double-right"></i>'), true );
			endif;
			?>
	    </ul><!-- .nav-links -->
	    </nav><!-- .navigation -->
	  	<?php
	  	endif;
	}

	function devio_singular_comments_do_action()
	{
		if ( post_type_supports( 'post', 'comments' ) ):
			if ( has_action( 'devio/singular/comments/do_action' ) ):
				do_action( 'devio/singular/comments/do_action' );
			else:
				DeVioPlaygroundPro_ModularHooks::this()->devio_singular_comments_before_do_action();
				comments_template();
				DeVioPlaygroundPro_ModularHooks::this()->devio_singular_comments_after_do_action();
			endif;
		endif;
	}

	//Comments - need check !
	function devio_singular_comments_before_do_action()
	{
		if ( has_action ( 'devio/singular/comments/before/do_action' ) ) :
			do_action('devio/singular/comments/before/do_action' ) ;
			tha_comments_before();
		endif;
	}

	function devio_singular_comments_after_do_action()
	{
		if ( has_action ( 'devio/singular/comments/after/do_action' ) ):
			do_action('devio/singular/comments/after/do_action' ) ;
			tha_comments_after();
		endif;
	}
	//eof singular modular
	
	//Modular Archive
	function devio_archive_entry_do_action()
	{
		//this hook will create archive entry from scratch
		if( has_action ( 'devio/archive/entry/do_action' ) ):
			do_action( 'devio/archive/entry/do_action' );
		else:
			//archive title heading //check for override? return empty? 
			DeVioPlaygroundPro_ModularHooks::this()->devio_archive_title_do_action();
			?>

		  	<div class="row">
			    <div class="archive-mode col-md-12x <?php //echo DeVioPlaygroundPro_ModularHooks::this()->devio_archive_mode_do_filter();  //ext ?>">
			    	
			      	<?php 
					//02 Mei 2016 - 1923
					//make it modular hook for archive entrycontent loop
					while ( have_posts() ) : the_post();
						//do more override here
						DeVioPlaygroundPro_ModularHooks::this()->devio_archive_entrycontent_do_action();
	  				endwhile;
					?>
			    </div><!--.archive-mode-->
		  	</div>

		  	<?php 
		  	//check default pagination;
		  	DeVioPlaygroundPro_ModularHooks::this()->devio_archive_pagination_do_action();
	  	endif;
	}

	//new - since 14 Juli 2016 - 18.11
	//modular for archive heading title override
	function devio_archive_title_do_action()
	{
		if ( has_action( 'devio/archive/title/do_action' )):
      		do_action( 'devio/archive/title/do_action' );
      	else:
      	?>
      	<header>
      		<?php if ( is_search() ):	?>
			<h2><?php echo __( 'Search result(s) for ','devio-playground' );?><span><?php echo get_search_query();?></span></h2>
			<?php else: ?>
			<h2><?php echo DeVioPlaygroundPro_ModularHooks::this()->devio_archive_title_do_filter();?></h2>
			<?php endif;?>
		</header>
      	<?php
       	endif;
	}

	//Archive Title
	//credit to chipbennet - oenology themes
	function devio_archive_title_do_filter()
	{   
		//alternate to extend !!
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
		            // If this is a Custom Taxonomy archive
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
		        	$archives_title .= 'All Article(s) by <a class="authorlink url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="author">' . get_the_author() . '</a>';
		      	break;

		      	case is_post_type_archive() :
		        	$archives_title .= post_type_archive_title();
		      	break;

		    endswitch;  
	    
	  	endif;

	  	//extended here!
	  	return apply_filters( 'devio/archive/title/do_filter', $archives_title );
	}
	
	//added 02Mei2016 : 0600
	function devio_archive_mode_do_filter()
	{
		echo apply_filters( 'devio/archive/mode/do_filter', '' );
	}


	//02 Mei 2016 - 1924 - rev 03Mei2016 - 0800
	//modular for archive mode entrycontent loop
	function devio_archive_entrycontent_do_action()
	{
      	?>
      	<div class="<?php DeVioPlaygroundPro_ModularHooks::this()->devio_archive_columns_do_filter();?>">
      	<?php	
		if ( has_action( 'devio/archive/entrycontent/do_action' )):
      		do_action( 'devio/archive/entrycontent/do_action' );
      	else:			
      		?>
		  	<div class="entry-content <?php //DeVioPlaygroundPro_ModularHooks::$this->devio_archive_entrycontent_mode_do_filter();?>">
				<?php 
			    DeVioPlaygroundPro_ModularHooks::this()->devio_archive_entrycontent_item_do_action();
				?>
		  	</div><!--.entry-content-->
			<?php
       	endif;
       	?>
       	</div>
       	<?php
	}

	function devio_archive_columns_do_filter()
	{
		echo apply_filters( 'devio/archive/columns/do_filter', 'col-md-6' );
	}

	//added 02 Mei 2016 - 1500 - extended
	function devio_archive_entrycontent_mode_do_filter()
	{
		echo apply_filters( 'devio/archive/entrycontent/mode/do_filter', '' );
	}

	function devio_archive_entrycontent_item_do_action()
	{
		if ( has_action( 'devio/archive/entrycontent/item/do_action' ) ) :
	        do_action( 'devio/archive/entrycontent/item/do_action' );
	    else: //default mode
	    ?>
		    <div class="entry-item">
		    	<?php 
		        //since 21 Juli 2016 - HB DY
		        //by default is entry title
		    	DeVioPlaygroundPro_ModularHooks::this()->devio_archive_entrycontent_item_top_do_action();
		    	?>

		        <div class="intro">
		        	<?php 
		        	//show introtext by trimming words from content or just displayed the excerpt 
		        	echo DeVioPlaygroundPro_ModularHooks::this()->devio_archive_entrycontent_item_introtext_do_filter(); 
		        	?>
		    	</div>
		    	 
		    	<?php 
		    	//by default is readmore
		    	DeVioPlaygroundPro_ModularHooks::this()->devio_archive_entrycontent_item_bottom_do_action();
		    	?>
		    </div><!--.entry-item-->
		<?php endif;
	}

	function devio_archive_entrycontent_item_top_do_action()
	{
		if ( has_action( 'devio/archive/entrycontent/item/top/do_action' ) ) :
	        do_action( 'devio/archive/entrycontent/item/top/do_action' );
	    else:
	    ?>	
        	<h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
    	<?php 
    	endif;
	}
	
	function devio_archive_entrycontent_item_introtext_do_filter()
	{	
		if ( has_filter( 'devio/archive/entrycontent/item/introtext/do_filter' )):
			echo strip_shortcodes ( wp_trim_words( get_the_content(), apply_filters( 'devio/archive/entrycontent/item/introtext/do_filter', '' ) ));
		else:
			the_excerpt();
		endif;
	}

	function devio_archive_entrycontent_item_bottom_do_action()
	{
		if ( has_action( 'devio/archive/entrycontent/item/bottom/do_action' ) ):
	        do_action( 'devio/archive/entrycontent/item/bottom/do_action' );
	    else:
	    ?>	
        <span class="readmore"><a href="<?php the_permalink();?>"><?php echo __( 'Read More', 'devio-playground');?></a></span>
        
        <!-- <a class="author-link" href="<?php //echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php //printf( __( 'View all posts by %s', 'devio-playground' ), get_the_author() ); ?></a> -->
    	<?php 
    	endif; 
	}

	function devio_archive_pagination_do_action()
	{
		if ( has_action( 'devio/archive/pagination/do_action' ) ):
		  	do_action( 'devio/archive/pagination/do_action' );
		else:
		?>
			<div class="row oldnew-pagination">
				<div class="nav-previous <?php echo apply_filters( 'devio/archive/pagination/previous/do_filter', 'text-left col-md-3 col-md-offset-0 col-sm-4 col-sm-offset-2 col-xs-5 col-xs-offset-1' );?>"><?php next_posts_link( '<i class="fa fa-chevron-left"></i>'. ' ' . __( 'Older','devio-playground') ); ?></div>
				<div class="nav-next <?php echo apply_filters( 'devio/archive/pagination/next/do_filter', 'text-right col-md-3 col-md-offset-3 col-sm-4 col-sm-offset-0 col-xs-5 col-xs-offset-1');?>"><?php previous_posts_link( __('Newer','devio-playground' ) . ' ' . '<i class="fa fa-chevron-right"></i>' ); ?></div>
			</div>
		<?php
		endif;
	}

	//extended
	function devio_archive_entrycontent_item_after_do_action()
	{
		if ( has_action( 'devio/archive/entrycontent/item/after/do_action' ) )
	        do_action( 'devio/archive/entrycontent/item/after/do_action' );
	}


	// - main archive entry bottom & right after endwhile loop
	function devio_archive_bottom_do_action()
	{
		if ( has_action( 'devio/archive/bottom/do_action' ))
		do_action( 'devio/archive/bottom/do_action' );
	}

	//eof Modular archive
	//new since 14 Juli 2016
	function devio_socmed_mode_do_filter()
	{
		if ( has_filter( 'devio/socmed/mode/do_filter' ) ):
			apply_filters( 'devio/socmed/mode/do_filter','' );
		endif;
	}

	// Page 404
	function devio_pagenotfound_do_action()
	{
		if ( has_action( 'devio/pagenotfound/do_action' ) ):
			do_action( 'devio/pagenotfound/do_action' );
		else:
			echo '<h3>' . __( 'Page you are looking for is not exist anymore', 'devio-playground' ) .'</h3>';
		endif;
	}
}
 
new DeVioPlaygroundPro_ModularHooks;
