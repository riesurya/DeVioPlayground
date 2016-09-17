<?php
/**
  @copyright Copyright (C) 2011 - forever DeVio Multimedia
  Made with 100% love and hopes for my beloved daughters Delfia Nur Anrianti Putri and Violina Melody Ramadhani, where ever you are, Papa Love U
  Theme_Author : Muhammad Anrie Ibrahim - http://devioplayground.com
  Location : framework/main/class.DeVioPlayground_Layout.php
**/
class DeVioPlaygroundPro_Footer
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

	function devio_footerarea_settings()
	{
		$footer1sidebar  = 'devio-footer-1';
		$footer2sidebar  = 'devio-footer-2';
		$footer3sidebar  = 'devio-footer-3';
		$footer4sidebar  = 'devio-footer-4';
		return array( $footer1sidebar, $footer2sidebar, $footer3sidebar, $footer4sidebar );
	}

	function devio_footerarea()
	{
		// print 'parentClass FooterArea devio_footerarea()';
		//reserved
	}

	function devio_footerarea_one_column()
	{
		list( $footer1sidebar, $footer2sidebar, $footer3sidebar, $footer4sidebar ) = $this->devio_footerarea_settings();
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
		list( $footer1sidebar, $footer2sidebar, $footer3sidebar, $footer4sidebar ) = $this->devio_footerarea_settings();
		?>  
		<footer id="footerarea" class="footer">
		  	<div class="container">
		  		<div class="row">
		      <?php if ( is_active_sidebar( $footer1sidebar ) ) : ?>
		      <div class="<?php echo apply_filters( 'devio/footer21_columns/do_filter', 'col-md-6' );?>">
		        <div class="footer-sidebar">
		          <?php dynamic_sidebar( $footer1sidebar ); ?>
		        </div>
		      </div>
		      <?php endif; ?>

		      <?php if ( is_active_sidebar( $footer2sidebar ) ) : ?>
		      <div class="<?php echo apply_filters( 'devio/footer22_columns/do_filter', 'col-md-6' );?>">
		        <div class="footer-sidebar">
		          <?php dynamic_sidebar( $footer2sidebar ); ?>
		        </div>
		      </div>
		      <?php endif; ?>

			  	</div>
			</div>
		</footer>
		<?php
	}
	
	function devio_footerarea_three_columns()
	{
		list( $footer1sidebar, $footer2sidebar, $footer3sidebar, $footer4sidebar ) = $this->devio_footerarea_settings();
		?>  
		<footer id="footerarea" class="footer">
		  	<div class="container">
		  		<div class="row">
		      <?php if ( is_active_sidebar( $footer1sidebar ) ) : ?>
		      <div class="<?php echo apply_filters( 'devio/footer31_columns/do_filter', 'col-md-4' );?>">
		        <div class="footer-sidebar">
		          <?php dynamic_sidebar( $footer1sidebar ); ?>
		        </div>
		      </div>
		      <?php endif; ?>

		      <?php if ( is_active_sidebar( $footer2sidebar ) ) : ?>
		      <div class="<?php echo apply_filters( 'devio/footer32_columns/do_filter', 'col-md-4' );?>">
		        <div class="footer-sidebar">
		          <?php dynamic_sidebar( $footer2sidebar ); ?>
		        </div>
		      </div>
		      <?php endif; ?>

		      <?php if ( is_active_sidebar( $footer3sidebar ) ) : ?> 
		      <div class="<?php echo apply_filters( 'devio/footer33_columns/do_filter', 'col-md-4' );?>">
		        <div class="footer-sidebar">
		          <?php dynamic_sidebar( $footer3sidebar ); ?>
		        </div>
		      </div>
		      <?php endif; ?>
			  	</div>
			</div>
		</footer>
		<?php
	}

	function devio_footerarea_four_columns()
	{
		list( $footer1sidebar, $footer2sidebar, $footer3sidebar, $footer4sidebar ) = $this->devio_footerarea_settings();
		?>  
		<footer id="footerarea" class="footer">
		  	<div class="container">
		  		<div class="row">
			      	<?php if ( is_active_sidebar( $footer1sidebar ) ) : ?>
			      	<div class="<?php echo apply_filters( 'devio/footer41_columns/do_filter', 'col-md-3' );?>">
				        <div class="footer-sidebar footer1">
				          	<?php dynamic_sidebar( $footer1sidebar ); ?>
				        </div>
			      	</div>
		      		<?php endif; ?>

		      		<?php if ( is_active_sidebar( $footer2sidebar ) ) : ?>
					<div class="<?php echo apply_filters( 'devio/footer42_columns/do_filter', 'col-md-3' );?>">
						<div class="footer-sidebar footer2">
							<?php dynamic_sidebar( $footer2sidebar ); ?>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( $footer3sidebar ) ) : ?> 
					<div class="<?php echo apply_filters( 'devio/footer43_columns/do_filter', 'col-md-3' );?>">
						<div class="footer-sidebar footer3">
							<?php dynamic_sidebar( $footer3sidebar ); ?>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( $footer4sidebar ) ) : ?>
					<div class="<?php echo apply_filters( 'devio/footer44_columns/do_filter', 'col-md-3' );?>">
						<div class="footer-sidebar footer4">
							<?php dynamic_sidebar( $footer4sidebar ); ?>
						</div>
					</div>
					<?php endif; ?>

			  	</div>
			</div>
		</footer>
		<?php
	}

} //eof class

new DeVioPlaygroundPro_Footer;
