<?php
/**
  @copyright Copyright (C) 2011 - forever DeVio Multimedia
  Made with 100% love for my beloved daughters Delfia and Violina, where ever you are, Papa Love U
  Theme_Author : Anrie 'Riesurya' - http://riesurya.com
  Location : class.DeVioPlayground_Layout.php
  SubPackage: Layout Control - Pro
**/
if ( !class_exists( 'DeVioPlayground_LayoutPro' )):
class DeVioPlayground_LayoutPro
{
	private static $_this;

	private $layoutcontext;
	private $rightwidth;
	private $leftwidth;
	private $rightsidebar;
	private $leftsidebar;

	function __construct() 
	{
		self::$_this = $this;
	}

	static function this()
	{
	return self::$_this;
	}


	/**
	 * [devio_template_controls description]
	 * @return [type] [description]
	 */

	function devio_template_controls()
	{
		$classes = get_body_class();

		global $deviocantik;

    	$layoutcontext 		= 	apply_filters( 'devio/' . $classes[0] . '/layout/do_filter', $deviocantik['devio-general-layout'] );

        $rightsidebar 		= 	apply_filters( 'devio/' . $classes[0] . '/rightside/do_filter', $deviocantik['devio-general-rightside'] );
        
        $leftsidebar 		= 	apply_filters( 'devio/' . $classes[0] . '/leftside/do_filter', $deviocantik['devio-general-leftside'] );

        $rightwidth 		=   apply_filters( 'devio/' . $classes[0] . '/rightwidth/do_filter', $deviocantik['devio-general-rightwidth'] );

        $leftwidth 			=  	apply_filters( 'devio/' . $classes[0] . '/leftwidth/do_filter', $deviocantik['devio-general-leftwidth'] );

	    //grab all properties in list ( such an array )
	    return array( $layoutcontext, $rightsidebar, $leftsidebar, $rightwidth, $leftwidth );
	    //http://stackoverflow.com/questions/3451906/multiple-returns-from-function
	}

	function devio_mainlayout()
	{
		list( $layoutcontext, $rightsidebar, $leftsidebar, $rightwidth, $leftwidth ) = $this->devio_template_controls();

		  switch ( $layoutcontext ) :
		    case 'right' :
		        $this->devio_mainarea_layout();
		        $this->devio_rightarea_layout();  
		    break;

		    case 'left' :
		        $this->devio_mainarea_layout();
		        $this->devio_leftarea_layout();
		    break;

		    case 'full' :
		        $this->devio_mainarea_layout();
		    break;

		    default :
		        $this->devio_mainarea_layout();
		    break;

		  endswitch;
	}

	//the content
	function devio_mainarea_layout()
	{
		$this->devio_mainarea_layout_columns(); //<section class="mainarea">

		    echo apply_filters( 'devio/maincontent/open/do_filter','' );

	      	devio_maincontent_top_do_action_pro();

	        echo apply_filters( 'devio/contentloop/open/do_filter','' );

	        switch ( true ):

				case is_home():
					if ( file_exists( locate_template( 'view/loop/home.php' ) ) ):
						get_template_module( 'view/loop/home' );
					// else:
						// do_action( 'devio/home/maincontent/do_action');
					endif;
				break;
				
				case is_front_page(): //make it special with modular or just use is_singular() below ?
				    global $post;
    				$page_template = get_post_meta($post->ID, '_wp_page_template', true);
					
					if ( file_exists( locate_template( 'view/loop/frontpage.php' ) ) ):
						get_template_module( 'view/loop/frontpage' );
					elseif ( $page_template == 'page-templates/pg-template-homepage.php' ):
						do_action( 'devio/homepage_template/maincontent/do_action' );
					else:
						do_action( 'devio/frontpage/maincontent/do_action');
					endif;
				break;

				case is_archive() :
				case is_search() :
					if ( has_action( 'devio/archive/maincontent/do_action' ) ):
		        		do_action ( 'devio/archive/maincontent/do_action' );
		        	endif;
	        	break;

	        	case is_singular():
					devio_singular_article_before_do_action_pro();
					DeVioPlayground_Singular_Loop::this()->devio_singular_loop();
					devio_singular_article_after_do_action_pro();
				break;

				case is_404():
					do_action ( 'devio/error404/maincontent/do_action' );
				break;

	        	default:
        			do_action ( 'devio/maincontent/do_action' );
	        	break;

	        endswitch;
	        
	        echo apply_filters( 'devio/contentloop/close/do_filter','' );

	     	echo apply_filters( 'devio/maincontent/close/do_filter','' );	

	    	devio_maincontent_bottom_do_action_pro();
	    	?>
	    	
	    </section><!--.mainarea -->
	<?php    
	}

	/**
	 * [devio_rightarea_layout description]
	 * @return [type] [description]
	 */
	function devio_rightarea_layout()
	{	
		list( $layoutcontext, $rightsidebar, $leftsidebar, $rightwidth, $leftwidth ) = $this->devio_template_controls();

		if ( is_active_sidebar( $rightsidebar ) ):

		$this->devio_rightarea_layout_columns(); //filter hook for layout ( prepare for CSS Framework variant )
		?>
			
			<?php devio_rightsidebar_before_do_action_pro();//extra area for rightsidebar before ?>

				<div class="wrapper sideright">

					<?php dynamic_sidebar ( $rightsidebar ); ?>

				</div><!--.wrapper sideright-->

			<?php devio_rightsidebar_after_do_action_pro(); //extra area for rightsidebar after ?>

		</aside><!--.rightarea-->

		<?php 
		endif; //eof active sidebar
	}

	function devio_leftarea_layout()
	{
		list( $layoutcontext, $rightsidebar, $leftsidebar, $rightwidth, $leftwidth ) = $this->devio_template_controls();

		if ( is_active_sidebar( $leftsidebar ) ) :

		$this->devio_leftarea_layout_columns(); //filter hook leftarea
		?>
			
			<?php devio_leftsidebar_before_do_action_pro(); ?>
			
				<div class="wrapper sideleft"><!--rightsidebar usefull for block styling -->

					<?php dynamic_sidebar ( $leftsidebar ); ?>

				</div><!--.wrapper sideleft-->

			<?php devio_leftsidebar_after_do_action_pro(); ?>

		</aside><!--.leftarea-->

		<?php	
		endif;
	}

	//Main Layout Hook filter//since 2.0.1 - 15.07.2014 - 17.31
	function devio_mainarea_layout_columns()
	{
		list($layoutcontext, $rightsidebar, $leftsidebar, $rightwidth, $leftwidth) = $this->devio_template_controls();

		$devio_mainarea = '';

		switch ( $layoutcontext ) :
		    case 'full' :
		    	$devio_mainarea = '<section class="mainarea full col-md-12">';
		    break;

		    case 'right' :
		    	$devio_mainarea = '<section class="mainarea right col-md-8">';
		    break;

		    case 'left' :
		    	$devio_mainarea = '<section class="mainarea pluginleft col-md-8 col-md-push-4">';
		    break; 

		endswitch;

		echo apply_filters( 'devio/mainarea/' . $layoutcontext . '/do_filter', $devio_mainarea );
	}

	//hook filter for rightarea
	function devio_rightarea_layout_columns()
	{
		list($layoutcontext, $rightsidebar, $leftsidebar, $rightwidth, $leftwidth) = $this->devio_template_controls();
	
		$devio_rightarea = '<aside class="rightarea col-md-4">';
		echo apply_filters( 'devio/rightarea/' . $layoutcontext . '/do_filter', $devio_rightarea );
	}

	//hook filter for leftarea
	function devio_leftarea_layout_columns()
	{
		list($layoutcontext, $rightsidebar, $leftsidebar, $rightwidth, $leftwidth) = $this->devio_template_controls();

		$devio_leftarea = '<aside class="leftarea col-md-4 col-md-pull-8">';

		echo apply_filters( 'devio/leftarea/' . $layoutcontext . '/do_filter', $devio_leftarea );
	}

} //eof class

new DeVioPlayground_LayoutPro;
endif;