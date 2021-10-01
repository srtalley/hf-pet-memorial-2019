<?php
/**
 * Theme functions and definitions
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! isset( $content_width ) ) {
	$content_width = 800; // pixels
}

/*
 * Set up theme support
 */
if ( ! function_exists( 'hf_pet_memorial_2019_setup' ) ) {
	function hf_pet_memorial_2019_setup() {
		if ( apply_filters( 'hf_pet_memorial_2019_load_textdomain', true ) ) {
			load_theme_textdomain( 'hf-pet-memorial-2019', get_template_directory() . '/languages' );
		}

		if ( apply_filters( 'hf_pet_memorial_2019_register_menus', true ) ) {
			register_nav_menus( array( 'menu-1' => __( 'Primary', 'hf-pet-memorial-2019' ) ) );
		}

		if ( apply_filters( 'hf_pet_memorial_2019_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'custom-logo' );
			add_theme_support( 'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			) );
			add_theme_support( 'custom-logo', array(
				'height' => 100,
				'width' => 350,
				'flex-height' => true,
				'flex-width' => true,
			) );

			/*
			 * Editor Style
			 */
			add_editor_style( 'editor-style.css' );

			/*
			 * WooCommerce
			 */
			if ( apply_filters( 'hf_pet_memorial_2019_add_woocommerce_support', true ) ) {
				// WooCommerce in general:
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0):
				// zoom:
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox:
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe:
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hf_pet_memorial_2019_setup' );

/*
 * Theme Scripts & Styles
 */
if ( ! function_exists( 'hf_pet_memorial_2019_scripts_styles' ) ) {
	function hf_pet_memorial_2019_scripts_styles() {
		if ( apply_filters( 'hf_pet_memorial_2019_enqueue_style', true ) ) {
			wp_enqueue_style( 'hf-pet-memorial-2019-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version') );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hf_pet_memorial_2019_scripts_styles' );

// Register Elementor Locations
if ( ! function_exists( 'hf_pet_memorial_2019_register_elementor_locations' ) ) {
	function hf_pet_memorial_2019_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hf_pet_memorial_2019_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hf_pet_memorial_2019_register_elementor_locations' );


/**
 * Register Additional Menu Locations
 */
function register_relics_2019_menu_locations() {

    register_nav_menus(
        array(
            'website-footer' => __( 'Website Footer' )
        )
    );
}
add_action( 'init', 'register_relics_2019_menu_locations' );

// Custom Shortcodes
function pwd_get_current_year_shortcode() {
    return date('Y');
}
add_shortcode('pwd_get_year', 'pwd_get_current_year_shortcode');


// Remove CSS and/or JS for Select2 used by WooCommerce, see https://gist.github.com/Willem-Siebe/c6d798ccba249d5bf080.
add_action( 'wp_enqueue_scripts', 'wsis_dequeue_stylesandscripts_select2', 100 );
function wsis_dequeue_stylesandscripts_select2() {
    if ( class_exists( 'woocommerce' ) ) {

        // Disabled these parts, due to somehow also removes Jquery UI Datepicker
        //wp_dequeue_style( 'select2' );
        //wp_deregister_style( 'select2' );

        //wp_dequeue_script( 'select2' );
        //wp_deregister_script( 'select2' );

        wp_dequeue_style( 'selectWoo' );
        wp_deregister_style( 'selectWoo' );

        wp_dequeue_script( 'selectWoo' );
        wp_deregister_script( 'selectWoo' );
    }
}

// WooCommerce - Remove
function pwd_hf_remove_woocommerce_actions() {

    // remove product images from product list -- Badge is linked to this
    //remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
}
add_action( 'after_setup_theme', 'pwd_hf_remove_woocommerce_actions' );

// Disable woocommerce order notes in checkout
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

/**
 * Add the white text color to the email header on The Pet Memorial 
 */
 
add_filter( 'woocommerce_email_styles', 'hf_change_email_header_clor', 9999, 2 );
 
function hf_change_email_header_clor( $css, $email ) { 
	$css .= '
		#header_wrapper h1 { color: #fff !important; }
	';
	return $css;
}

function wl ( $log ) {
    if ( is_array( $log ) || is_object( $log ) ) {
    error_log( print_r( $log, true ) );
    } else {
    error_log( $log );
    }
}

// GTM (Google Tag Manager) Tracking by whole whale
add_action('after_setup_theme', 'require_function_file');
function require_function_file () {
include get_stylesheet_directory() . '/PM_donation_to_dl.php';
};
