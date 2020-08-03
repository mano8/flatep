<?php
/**
 * The template for displaying lookbook product style content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     1.6.4
 */

global $product, $woocommerce_loop, $flatsome_opt;

/* PRODUCT QUICK VIEW HOOKS */
add_action( 'woocommerce_single_product_flipbook_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_flipbook_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_flipbook_summary', 'woocommerce_template_single_meta', 40 );

$cat = ''; $link_attr = '';
if (class_exists("FlaTep_Woocommerce")){
	$cat = FlaTep_Woocommerce::get_related_product_cat($product);
	$link_attr = FlaTep_Woocommerce::get_the_product_link_title_seo($product, $cat);
}
?>
  <div class="row row-collapse align-middle flip-slide" style="width:100%">
        <div class="large-6 col flip-page-one">
        <div class="featured-product col-inner">
          <a href="<?php the_permalink(); ?>" <?php echo $link_attr; ?>>
                <div class="product-image relative">
                   <div class="front-image">
                    <?php echo get_the_post_thumbnail( $post->ID,  apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' )) ?>
                  </div>
                  <?php wc_get_template( 'loop/sale-flash.php' ); ?>
                </div><!-- end product-image -->
          </a>
        </div><!-- end product -->
        </div><!-- large-6 -->
       <div class="large-6 col flip-page-two">
        <div class="product-info col-inner inner-padding">
              <h1 class="entry-title"><a href="<?php the_permalink(); ?>" <?php echo get_the_product_link_title_seo($product); ?>><?php the_title(); ?></a></h1>
              <div class="is-divider medium"></div>
              <?php do_action( 'woocommerce_single_product_flipbook_summary' ); ?>
              <a href="<?php the_permalink(); ?>" class="button"  <?php echo get_the_product_link_title_seo($product, _e( 'Read more', 'woocommerce' )); ?>><?php _e( 'Read more', 'woocommerce' ); ?></a>
         </div>
        </div><!-- large-6 -->
</div><!-- row -->
