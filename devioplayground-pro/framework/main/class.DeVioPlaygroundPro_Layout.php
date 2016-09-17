<?php
/**
  @copyright Copyright (C) 2011 - forever DeVio Multimedia
  Made with 100% love for my beloved daughters Delfia Nur Anrianti Putri and Violina Melody Ramadhani, where ever you are, Papa Love U
  Theme_Author : Muhammad Anrie Ibrahim - http://devioplayground.com
  Location : class.DeVioPlayground_Layout.php
  SubPackage: Layout Control - Pro
**/
if ( !class_exists( 'DeVioPlaygroundPro_Layout' )):
class DeVioPlaygroundPro_Layout
{
	private static $_this;

	private $layoutcontext;
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

	//layout bodyclass
	function devio_bodyclass()
	{
		switch ( true ):
		
			case is_front_page() :
			case is_home() :
				$level[0] = 'home';
			break;

			case is_singular():
				$level[0] = 'singular';
			break;

			default:
				$level = get_body_class();
			break;

		endswitch;

		return array( $level[0] );
	}

	//extendedable
	function devio_template_controls()
	{
		global $deviocantik;

    	$layoutcontext 		= 	apply_filters( 'devio/layout/context/do_filter', $deviocantik['devio-general-layout'] );

        $rightsidebar 		= 	apply_filters( 'devio/rightarea/sidebar/do_filter', 'devio-sidebar-right' );

        $leftsidebar 		= 	apply_filters( 'devio/leftarea/sidebar/do_filter', 'devio-sidebar-left' );

	    //grab all properties in list ( such an array )
	    return array( $layoutcontext, $rightsidebar, $leftsidebar );
	    //http://stackoverflow.com/questions/3451906/multiple-returns-from-function
	}

	//extendedable
	function devio_mainlayout()
	{
		list( $layoutcontext, $rightsidebar, $leftsidebar ) = $this->devio_template_controls();

		  switch ( $layoutcontext ) :
		    case 'right-side' :
		        $this->devio_maincontent();
		        $this->devio_rightarea_layout();  
		    break;

		    case 'left-side' :
		        $this->devio_maincontent();
		        $this->devio_leftarea_layout();
		    break;

		    case 'full-side' :
		        $this->devio_maincontent();
		    break;

		  endswitch;
	}

	//the content
	//extendedable
	function devio_maincontent() //devio_maincontent
	{
		list( $level[0] ) = $this->devio_bodyclass();

		// var_dump($level[0]);

		echo $this->devio_maincontent_columns(); //devio_maincontent_column <section class="main-content">

	        switch ( true ):

	        	case is_singular():
					DeVioPlaygroundPro_SingularLoop::this()->devio_singular_loop();
				break;

	        	case has_action( 'devio/' . $level[0] . '/maincontent/do_action' ):
	        		do_action ( 'devio/' . $level[0] . '/maincontent/do_action' );	
	        	break;

	        	default:
        			do_action ( 'devio/maincontent/do_action' );
	        	break;

	        endswitch;
	    	?>
	    	
	    </section><!--.mainarea -->
		<?php 
	}

	//extended version
	/**
	 * [devio_rightarea_layout description]
	 * @return [type] [description]
	 */
	function devio_rightarea_layout()
	{	
		list( $layoutcontext, $rightsidebar, $leftsidebar ) = $this->devio_template_controls();

		if ( is_active_sidebar( $rightsidebar ) ):
		?>
		<aside class="rightarea <?php echo apply_filters( 'devio/' . $layoutcontext . '/rightarea/column/do_filter', 'col-md-3');?>">
			
			<div class="wrapper sideright">

				<?php dynamic_sidebar ( $rightsidebar ); ?>

			</div><!--.wrapper sideright-->

		</aside><!--.rightarea-->

		<?php 
		endif; //eof active sidebar
	}

	//extended version
	function devio_leftarea_layout()
	{
		list( $layoutcontext, $rightsidebar, $leftsidebar ) = $this->devio_template_controls();

		if ( is_active_sidebar( $leftsidebar ) ) :
		?>
		<aside class="leftarea <?php echo apply_filters( 'devio/' . $layoutcontext . '/leftarea/column/do_filter', 'col-md-3 col-md-pull-9');?>">
						
			<div class="wrapper sideleft"><!--usefull for block styling -->

				<?php dynamic_sidebar ( $leftsidebar ); ?>

			</div><!--.wrapper sideleft-->

		</aside><!--.leftarea-->

		<?php	
		endif;
	}

	//extendedable
	//Main Layout Hook filter//since 2.0.1 - 15.07.2014 - 17.31
	function devio_maincontent_columns() //devio_maincontent_column
	{
		list($layoutcontext, $rightsidebar, $leftsidebar) = $this->devio_template_controls();

		$devio_mainarea = ''; //$maincontent_column

		switch ( $layoutcontext ) :
		    case 'full-side' :
		    	$devio_mainarea = '<section class="main-content fullcol col-md-12">';
		    break;

		    case 'right-side' :
		    	$devio_mainarea = '<section class="main-content rightcol col-md-9">';
		    break;

		    case 'left-side' :
		    	$devio_mainarea = '<section class="main-content leftcol col-md-9 col-md-push-3">';
		    break; 
		endswitch;

		return apply_filters( 'devio/' . $layoutcontext . '/mainarea/do_filter', $devio_mainarea );
	}

} //eof class

global $mainlayout;
$mainlayout = new DeVioPlaygroundPro_Layout;
endif;
