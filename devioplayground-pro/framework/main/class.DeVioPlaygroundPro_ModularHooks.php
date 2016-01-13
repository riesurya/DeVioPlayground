<?php
/**
  @copyright Copyright (C) 2011 - forever DeVio Multimedia 
  Made with 100% love for my beloved daughters Delfia and Violina, where ever you are, Papa Love U
  Author : Anrie 'Riesurya'
  Author URI : http://riesurya.com
  SubPackage: Modular hooks
  Location : framework/main/class.DeVioPlayground_ModularHooks.php
  Extend this Class as you wish into : theme_name/lib/main/class.ExtendDeVioPlayground_ModularHooks.php
 */
//THA Supports
class DeVioPlaygroundPro_ModularHooks
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

	//TopBar Area - fix
	function devio_topbararea_do_action()
	{
		if ( has_action ( 'devio/topbararea/do_action' ) )
		do_action( 'devio/topbararea/do_action' );
	}

	// Header Area - fix
	function devio_headerarea_do_action()
	{
		if ( has_action ( 'devio/headerarea/do_action' ) )
			do_action( 'devio/headerarea/do_action' );
	}

	//Main Area - fix
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

	//Footer Area - fix
	function devio_footerarea_do_action()
	{
		if ( has_action ( 'devio/footerarea/do_action' ) )
			do_action( 'devio/footerarea/do_action' );
	}

	//Bottom Area - fix
	function devio_bottomarea_do_action()
	{
		if ( has_action ( 'devio/bottomarea/do_action' ) )
			do_action( 'devio/bottomarea/do_action' );
	}

	//MainContent
	
	//article entry
	//right after <article> ( between <article> and <div class="article-entry">)
	/**
	Extra Hooks right after <article devioplayground-<?php the_ID>
	* location : loop/article-entry.php
	**/
	function devio_singular_article_top_do_action()
	{
		if ( has_action ( 'devio/singular/article/top/do_action' ) )
			do_action( 'devio/singular/article/top/do_action' );
	}

	function devio_singular_article_bottom_do_action()
	{
		if ( has_action ( 'devio/singular/article/bottom/do_action' ) )
			do_action( 'devio/singular/article/bottom/do_action' );
	}

	//Comments - need check !
	function devio_post_comments_before_do_action()
	{
		if ( has_action ( 'devio/post_comments/before/do_action' ) ) :
			do_action('devio/post_comments/before/do_action' ) ;
			tha_comments_before();
		endif;
	}

	function devio_post_comments_after_do_action()
	{
		if ( has_action ( 'devio/post_comments/after/do_action' ) ):
			do_action('devio/post_comments/after/do_action' ) ;
			tha_comments_after();
		endif;
	}

}

global $modular_hoooks;
$modular_hoooks = new DeVioPlaygroundPro_ModularHooks;