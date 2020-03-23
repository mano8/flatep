<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $product_attributes ) {
	return;
}
$i=0;

?>
    <?php foreach ( $product_attributes as $product_attribute_key => $product_attribute ) : ?>
        
        <?php if(!$selected_items || (is_array($selected_items) && in_array($product_attribute['label'], $selected_items))): ?>
            <?php if($i>0): ?>
                <span class="sep"> - - - </span>
            <?php endif; ?>
            <span class="ocotimn-product-attributes-item ocotimn-product-attributes-item--<?php echo esc_attr( $product_attribute_key ); ?>">
                <?php if(!get_theme_mod( 'ocean_customzer_child_styling', true )): ?>
                    <span class="ocotimn-product-attributes-item__label"><?php echo wp_kses_post( $product_attribute['label'] ); ?> :</span>
                <?php endif; ?>
                <span class="ocotimn-product-attributes-item__value"><?php echo wp_kses_post( $product_attribute['value'] ); ?></span>
            </span>
        <?php 
            $i++;
        endif; 
        
        ?>
	<?php endforeach; ?>

