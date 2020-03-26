<?php 
global $product; 
$cat = ''; $link_attr = '';
if (class_exists("FlaTep_Woocommerce")){
	$cat = FlaTep_Woocommerce::get_related_product_cat($product);
	$link_attr = FlaTep_Woocommerce::get_the_product_link_title_seo($product->get_name(), $cat);
}

?>
<li>
	<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"  <?php echo $link_attr; ?>>
		<?php echo $product->get_image( 'woocommerce_gallery_thumbnail' ); ?>
		<span class="product-title"><?php echo $product->get_title(); ?></span>
	</a>
	<?php if ( ! empty( $show_rating ) ) echo $product->get_rating_html(); ?>
	<?php echo $product->get_price_html(); ?>
</li>
