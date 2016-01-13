<?php
/**
  	@copyright Copyright (C) 2011-2014 Devio Multimedia. 
  	Made with 100% love for my beloved daughters Delfia and Violina, where ever you are, Papa Love U  
  	Author : Anrie 'Riesurya'
  	Author URI : http://riesurya.com
  	SubPackage: Footer Layout
    Location : framework/main/class.DeVioPlaygroundPro_FooterArea.php
  	Extend this Class as you wish into : theme_name/lib/main/class.ExtendDeVioPlayground_FooterArea.php
**/
//ok thanks, now begin the loop ( this is main_query )
//developer, to override - please use pre_get_posts ( saving more dB Queries :D )

//inside class?
if ( !class_exists( 'DeVioPlaygroundPro_FooterArea' )):
class DeVioPlaygroundPro_FooterArea
{
	private static $_this;

	function devio_footerarea_settings()
	{
		$footer1sidebar  = 'devio-footer-1';
		$footer2sidebar  = 'devio-footer-2';
		$footer3sidebar  = 'devio-footer-3';
		$footer4sidebar  = 'devio-footer-4';
	}

	function devio_footerarea()
	{
		//reserved
	}

	function devio_footerarea_one_column()
	{
		?>
	  	<footer id="footerarea" class="footerarea">
		    <div class="container">
		        <div class="col-md-12">

		        <?php if ( is_active_sidebar( $footer1sidebar ) ) : ?>
		        <div class="<?php echo apply_filters( 'devio/footer1/columns/do_filter', '' );?>">
		          <?php dynamic_sidebar( $footer1sidebar ); ?>
		        </div>
		        <?php endif; ?>

		        </div>
		    </div>
	  	</footer>
	  <?php
	}

	function devio_footerarea_two_columns()
	{
		?>  
		<footer id="footerarea" class="footer">
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

		  </div>
		</footer>
		<?php
	}
	
	function devio_footerarea_three_columns()
	{
		?>  
		<footer id="footerarea" class="footer">
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

		  </div>
		</footer>
		<?php
	}

	function devio_footerarea_four_columns()
	{
		?>  
		<footer id="footerarea" class="footer">
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
	}
}

global $footerarea;
new DeVioPlaygroundPro_FooterArea();
endif;