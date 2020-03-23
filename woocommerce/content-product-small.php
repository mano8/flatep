<?php global $product; ?>
<li>
	<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"  <?php if(is_object($flatepWoo)) {echo $flatepWoo->get_the_product_link_title_seo($product);} ?>>
		<?php echo $product->get_image( 'woocommerce_gallery_thumbnail' ); ?>
		<span class="product-title"><?php echo $product->get_title(); ?></span>
	</a>
	<?php if ( ! empty( $show_rating ) ) echo $product->get_rating_html(); ?>
	<?php echo $product->get_price_html(); ?>
</li>
