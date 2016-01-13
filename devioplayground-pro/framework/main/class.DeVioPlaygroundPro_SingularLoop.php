<?php
/**
  	@copyright Copyright (C) 2011-2014 Devio Multimedia. 
  	Made with 100% love for my beloved daughters Delfia and Violina, where ever you are, Papa Love U  
  	Author : Anrie 'Riesurya'
  	Author URI : http://riesurya.com
  	SubPackage: Singular Loop
    Location : framework/main/class.DeVioPlayground_SingularLoop.php
    Extend this Class as you wish into : theme_name/lib/main/class.ExtendDeVioPlayground_SingularLoop.php
**/
//ok thanks, now begin the loop ( this is main_query )
//developer, to override - please use pre_get_posts ( saving more dB Queries :D )

//inside class?
if ( !class_exists( 'DeVioPlaygroundPro_SingularLoop' )):
class DeVioPlaygroundPro_SingularLoop
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

		while ( have_posts() ) : the_post();
		?>
			<article id="devioplayground-<?php the_ID(); ?>" <?php post_class(); ?>>
				
				<?php
				//by default will load Title
				DeVioPlaygroundPro_ModularHooks::this()->devio_singular_article_top_do_action();

				if ( post_password_required() ) {
				 	echo get_the_password_form();
				 	return;
				}

				//run default maincontent for singular
				do_action( 'devio/singular/maincontent/do_action' );

				//by default will load EditLink
				DeVioPlaygroundPro_ModularHooks::this()->devio_singular_article_bottom_do_action();
			 	?>
			</article><!-- #post-<?php the_ID(); ?> -->
		<?php
		// The comments section loaded when appropriate
		do_action( 'devio/singular/comments/do_action' );

		endwhile;  //endwhile have_posts
	}
}

new DeVioPlaygroundPro_SingularLoop();
endif;