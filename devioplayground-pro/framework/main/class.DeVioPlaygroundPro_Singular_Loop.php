<?php
/**
  @copyright Copyright (C) 2011-2014 Devio Multimedia. 
  Made with 100% love for my beloved daughters Delfia and Violina, where ever you are, Papa Love U  
  Author : Anrie 'Riesurya'
  Author URI : http://riesurya.com
  SubPackage: Singular Loop
**/
//WP please process this filter only on archive mode
//override : filter hook

//ok thanks, now begin the loop ( this is main_query )
//developer, to override - please use pre_get_posts ( saving more dB Queries :D )

//inside class?
if ( !class_exists( 'DeVioPlayground_Singular_Loop' )):
class DeVioPlayground_Singular_Loop
{
	private static $_this;

	function __construct() 
	{
		self::$_this = $this;
	}

	static function this()
	{
	return self::$_this;
	}

	function devio_singular_loop()
	{

		if ( have_posts() ):

			$classes = get_body_class();
			
			devio_loop_while_before_do_action_pro();

			while ( have_posts() ) : the_post();

				//load article entry
				?>
				<article id="devioplayground-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php 
					devio_singular_article_top_do_action_pro();

					echo apply_filters( 'devio/frontend/article_entry_begin/do_filter', ''); 
					
					devio_singular_content_before_do_action_pro();
					
					if ( post_password_required() ) {
					 	echo get_the_password_form();
					 	return;
					}
					
					global $post;
					
    				$page_template = get_post_meta($post->ID, '_wp_page_template', true);
    				$pagetemplate_name = str_replace( array('page-templates/', '.php'), '', $page_template);

					if ( is_page() && $pagetemplate_name != 'default' ):
	    				if ( has_action ( 'devio/' . $pagetemplate_name . '/maincontent/do_action') ):
	    					do_action ( 'devio/' . $pagetemplate_name . '/maincontent/do_action' );
	    				else:
	    					do_action( 'devio/singular/maincontent/do_action' );
	    				endif;
					else: 
						do_action( 'devio/singular/maincontent/do_action' );
					endif;
					
					devio_singular_content_after_do_action_pro();

				  	echo apply_filters( 'devio/frontend/article_entry_close/do_filter', ''); 

					devio_singular_article_bottom_do_action_pro();
				 	?>
				</article><!-- #post-<?php the_ID(); ?> -->
				<?php

				// The comments section loaded when appropriate
			    if ( post_type_supports( 'post', 'comments' ) )
			      	comments_template( '/view/loop/comments.php' );

			endwhile;  //endwhile have_posts

			devio_loop_while_after_do_action_pro();

		// Else, if there are no Posts
		else :
			do_action( 'devio/error404/maincontent/do_action' ); //print notfound?
		endif; // endif have_posts()
	}
}

new DeVioPlayground_Singular_Loop();
endif;