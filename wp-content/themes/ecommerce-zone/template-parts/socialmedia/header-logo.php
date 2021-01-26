<?php
/**
 * Displays top navigation
 *
 * @package Ecommerce Zone
 */
?>

<div class="container">
	<div class="row">
	  	<div class="col-lg-3 col-md-4">
		    <div class="navbar-brand">
		        <?php if ( has_custom_logo() ) : ?>
            		<div class="site-logo"><?php the_custom_logo(); ?></div>
          		<?php endif; ?>
          		<?php $blog_info = get_bloginfo( 'name' ); ?>
            		<?php if ( ! empty( $blog_info ) ) : ?>
              			<?php if ( is_front_page() && is_home() ) : ?>
                			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
              			<?php else : ?>
            				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
              			<?php endif; ?>
            		<?php endif; ?>
		            <?php
						$description = get_bloginfo( 'description', 'display' );
						if ( $description || is_customize_preview() ) :
		            ?>
            		<p class="site-description"><?php echo esc_html($description); ?></p>
          		<?php endif; ?>
		    </div>
	  	</div>
	  	<div class="col-lg-7 col-md-6">
	  		<?php if(class_exists('woocommerce')){ ?>
	   			<?php get_product_search_form(); ?>
	   		<?php }?>
	  	</div>
	 	<div class="col-lg-2 col-md-2">
	    	<div class="cart_no">
	  			<?php if(class_exists('woocommerce')){ ?>
		        	<?php global $woocommerce; ?>
		        	<a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e( 'shopping cart','ecommerce-zone' ); ?>"><i class="fas fa-shopping-bag"></i><span class="cart-value"><?php echo sprintf ( esc_attr( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></span><span class="cart-total"><?php echo wp_kses_data( WC()->cart->get_cart_total() ); ?></span></a>
		        <?php }?>
	      	</div>
	  	</div>
	</div>
</div>