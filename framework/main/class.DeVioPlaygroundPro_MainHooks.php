<?php
/**
  @copyright Copyright (C) 2011 - forever DeVio Multimedia
  Made with 100% love and hopes for my beloved daughters Delfia Nur Anrianti Putri and Violina Melody Ramadhani, where ever you are, Papa Love U
  Author : Muhammad Anrie Ibrahim
  Author URI : http://deviolayground.com
  Any questions? Do not hesitate to contact me : http://riesurya.com/contact/
  Easy hooks override
  SubPackage: Main Hooks Control
**/
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    die;
}

//Default hooks loaded 
//Only Hooks here
class DeVioPlaygroundPro_MainHooks
{	
	private static $_this;

	static function this()
	{
		return self::$_this;
	}

	function __construct() 
	{
		self::$_this = $this;

		add_action( 'widgets_init',                             array( DeVioPlaygroundPro_MainHooks::this(), 'devio_register_sidebars' ) );
		
		//load scripts
		add_action( 'wp_enqueue_scripts',                      	array( DeVioPlaygroundPro_Scripts::this(), 'devio_register_theme_scripts' ),9 );
		
		add_action( 'wp_enqueue_scripts',                      	array( DeVioPlaygroundPro_Scripts::this(), 'devio_register_playground_scripts'),9 );
		
		add_action( 'wp_enqueue_scripts',             			array( DeVioPlaygroundPro_Scripts::this(), 'devio_enqueue_theme_scripts' ),10 ); //bootstrap, fontawesome, modernizr
		
		add_action( 'wp_enqueue_scripts',             			array( DeVioPlaygroundPro_Scripts::this(), 'devio_enqueue_playground_scripts' ),20 ); //deviothemes.css/js

		//BottomBar
		add_action( 'devio/bottombar-text/do_action',       	array( DeVioPlaygroundPro_MainHooks::this(), 'devio_bottombar_text' ) );
		add_action( 'devio/bottomarea/do_action',       		array( DeVioPlaygroundPro_MainHooks::this(), 'devio_bottombar_info' ),101);

		add_action( 'wp_head',                                	array( DeVioPlaygroundPro_MainHooks::this(), 'devio_custom_csscode' ),25 );
	}

	//custom favicon - theme area
	//by default theme options have custom favicon panel
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

	//Homepage default_content ( blog mode )
	function devio_home_display()
	{
	  while ( have_posts() ) : the_post();
	    // DeVioPlaygroundPro_ArchiveLoop::this()->devio_archive_entrycontent_loop();
	  endwhile;
	  wp_reset_query();
	}

	//No Title ???
	function devio_untitled_post( $title ) 
	{
	  if ( '' == $title ) :
	    return apply_filters( 'devio/singular/title/untitled/do_filter', '<em>( ' . __( 'Untitled', 'devio-playground' ) . ' )</em>' );
	  else :
	    return $title;
	  endif;
	}

	//Bottom bar
	function devio_bottombar_text()
	{
	  	global $deviocantik;
	  	$themes_notice = wp_get_theme()->name . ' '.'<br>Theme developed with <a target="_blank" href="http://devioplayground.com">DeVioPlaygroundPro</a>';
	  	if ( isset( $deviocantik['bottext'] ) && !empty( $deviocantik['bottext'] ) ):
	  		echo apply_filters( 'devio/bottombar/text/do_filter', wp_kses_post( $deviocantik['bottext'] ). $themes_notice );
	  	else:
	  		echo $themes_notice;
	  	endif;
	}

	//Bottom bar
	function devio_bottombar_info()
	{
		?>
		<div class="bottombar text-right">
			<div class="container">
				<div class="col-md-12">
		  		Theme developed with <a href="mailto:hello@riesurya.com">DeVioPlaygroundPro</a>
		  		</div>
		  	</div>
		</div>
	  	<?php	
	}

	//Pagination
	//archive paginate links hook - custom theme
	function devio_archive_pagination()
	{
		global $pagination;
		?>
		<div class="row clearfix">
		  	<div class="col-md-12">
		    	<nav class="posts-pagination"><?php echo paginate_links( $pagination );?></nav>
		  	</div><!--.col-md-12-->
		</div><!--.row-->
		<?php
	}

}//eof Class
new DeVioPlaygroundPro_MainHooks;
