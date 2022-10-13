<?php
/**
 * FlaTep Function Setup.
 *
 * Setup theme function.
 *
 * @package FlaTep\Functions
 */
function flatep_setup() {

	/* add woocommerce support */
	add_theme_support( 'events-manager' );

	
}

add_action( 'after_setup_theme', 'flatep_setup' );