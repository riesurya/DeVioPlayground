<?php
/**
  @copyright Copyright (C) 2011 - forever DeVio Multimedia 
  Made with 100% love for my beloved daughters Delfia and Violina, where ever you are, Papa Love U
  Author : Anrie 'Riesurya'
  Author URI : http://riesurya.com
  SubPackage: Theme - hooks_content
  Location : framework/main/DeVioPlayground_Modular_Hooks.php
 */
//THA Supports

//TopBar Area - fix
	function devio_topbararea_do_action_pro()
	{
		if ( has_action ( 'devio/topbararea/do_action' ) )
		do_action( 'devio/topbararea/do_action' );
	}

// Header Area - fix
	function devio_headerarea_do_action_pro()
	{
		if ( has_action ( 'devio/headerarea/do_action' ) )
			do_action( 'devio/headerarea/do_action' );
	}

//Main Area - fix
  	function devio_mainarea_top_do_action_pro()
  	{
		if ( has_action ( 'devio/mainarea-top/do_action' ) )
			do_action( 'devio/mainarea-top/do_action' );
  	}

	function devio_mainarea_bottom_do_action_pro()
	{
		if ( has_action ( 'devio/mainarea-bottom/do_action' ) )
			do_action( 'devio/mainarea-bottom/do_action' );
	}

//Footer Area - fix
	function devio_footerarea_do_action_pro()
	{
		if ( has_action ( 'devio/footerarea/do_action' ) )
			do_action( 'devio/footerarea/do_action' );
	}

//Bottom Area - fix
	function devio_bottomarea_do_action_pro()
	{
		if ( has_action ( 'devio/bottomarea/do_action' ) )
			do_action( 'devio/bottomarea/do_action' );
	}

//MainContent
	
// Loop Hooks - need test
	function devio_loop_while_before_do_action_pro()
	{
		if ( has_action( 'devio/loop_while/before/do_action' ) ):
			do_action( 'devio/loop_while/before/do_action' );
		endif;
	}

	function devio_loop_while_after_do_action_pro()
	{
		if ( has_action( 'devio/loop_while/after/do_action' ) ):
			do_action( 'devio/loop_while/after/do_action' );
		endif;
	}

	/**
	Right after <section id="maincontent">;
	Location : Class Layout
	**/
	function devio_maincontent_top_do_action_pro() 
	{
		if ( has_action ( 'devio/maincontent/top/do_action' ) )
			do_action( 'devio/maincontent/top/do_action' );
	}
			
	/**
	right before </section #maincontent>
	Location : Class Layout
	**/
	function devio_maincontent_bottom_do_action_pro()
	{
		if ( has_action ( 'devio/maincontent/bottom/do_action' ) )
			do_action( 'devio/maincontent/bottom/do_action' );
	}

	/**
	Extra Hooks right before <article id="devioplayground-the_ID">
	@return  mixed any output hooked into 'devio_content_do_before'
	location: loop/index.php
	singular mode
	**/
	function devio_singular_article_before_do_action_pro()
	{
		if ( has_action ( 'devio/singular/article/before/do_action' ) )
			do_action( 'devio/singular/article/before/do_action' );
	}
	/**
	Extra Hooks right after <article id="devioplayground-the_ID">
	@return  mixed any output hooked into 'devio_content_do_before'
	location: loop/index.php
	singular mode
	**/
	function devio_singular_article_after_do_action_pro()
	{
		if ( has_action ( 'devio/singular/article/after/do_action' ) )
			do_action( 'devio/singular/article/after/do_action' );
	}

//article entry
	//right after <article> ( between <article> and <div class="article-entry">)
	/**
	Extra Hooks right after <article devioplayground-<?php the_ID>
	* location : loop/article-entry.php
	**/
	function devio_singular_article_top_do_action_pro()
	{
		if ( has_action ( 'devio/singular/article/top/do_action' ) )
			do_action( 'devio/singular/article/top/do_action' );
	}

	function devio_singular_article_bottom_do_action_pro()
	{
		if ( has_action ( 'devio/singular/article/bottom/do_action' ) )
			do_action( 'devio/singular/article/bottom/do_action' );
	}

	function devio_singular_content_before_do_action_pro()
	{
		if ( has_action ( 'devio/singular/content/before/do_action' ) )
			do_action( 'devio/singular/content/before/do_action' );
	}

	function devio_singular_content_after_do_action_pro()
	{
		if ( has_action ( 'devio/singular/content/after/do_action' ) )
			do_action( 'devio/singular/content/after/do_action' );
	}

//Comments - need check !
	function devio_post_comments_before_do_action_pro()
	{
		if ( has_action ( 'devio/post_comments/before/do_action' ) ) :
			do_action('devio/post_comments/before/do_action' ) ;
			tha_comments_before();
		endif;
	}

	function devio_post_comments_after_do_action_pro()
	{
		if ( has_action ( 'devio/post_comments/after/do_action' ) ):
			do_action('devio/post_comments/after/do_action' ) ;
			tha_comments_after();
		endif;
	}

//Sidebars
	//Right Sidebar
	function devio_rightsidebar_before_do_action_pro()
	{
		if ( has_action ( 'devio/rightsidebar/before/do_action' ) )
			do_action( 'devio/rightsidebar/before/do_action' );
	}

	function devio_rightsidebar_after_do_action_pro()
	{
		if ( has_action ( 'devio/rightsidebar/after/do_action' ) )
			do_action( 'devio/rightsidebar/after/do_action' );
	}

	//Left Sidebar
	function devio_leftsidebar_before_do_action_pro()
	{
		if ( has_action ( 'devio/leftsidebar/before/do_action' ) )
			do_action( 'devio/leftsidebar/before/do_action' );
	}

	function devio_leftsidebar_after_do_action_pro()
	{
		if( has_action ( 'devio/leftsidebar/after/do_action' ) )
			do_action( 'devio/leftsidebar/after/do_action' );
	}