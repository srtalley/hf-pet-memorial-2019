<?php
/**
 * Customer renewal invoice email (plain text)
 *
 * @author  Brent Shepherd
 * @package WooCommerce_Subscriptions/Templates/Emails/Plain
 * @version 2.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( 'failed' == $order->get_status() ) {
    $email_heading = 'Sorry, Your Donations Have Stopped';
}

echo $email_heading . "\n\n";

if ( 'pending' == $order->get_status() ) {
	// translators: %1$s: name of the blog, %2$s: link to checkout payment url, note: no full stop due to url at the end
	printf( esc_html_x( 'An invoice has been created for you to renew your life-saving donation with %1$s. Simply login to your account on our website and enter your payment details: %2$s', 'In customer renewal invoice email', 'woocommerce-subscriptions' ), esc_html( get_bloginfo( 'name' ) ), esc_attr( $order->get_checkout_payment_url() ) ) . "\n\n";
} elseif ( 'failed' == $order->get_status() ) {
    echo 'Your most recent automatic monthly payment to ' . esc_html( get_bloginfo( 'name' ) ) . ' has failed. This happens for many reasons, but is frequently the result of an expiring credit card.' . "\n\n";
    echo 'WHAT TO DO' . "\n\n";
	// translators: %1$s: name of the blog, %2$s: link to checkout payment url, note: no full stop due to url at the end
	printf( esc_html_x( 'It is quick and easy to reactivate your life-saving donations to rescue animals across the planet through %1$s. Simply login to your account on our website and enter new payment details: %2$s', 'In customer renewal invoice email', 'woocommerce-subscriptions' ), esc_html( get_bloginfo( 'name' ) ), esc_attr( $order->get_checkout_payment_url() ) );
}

echo "\n\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";

do_action( 'woocommerce_subscriptions_email_order_details', $order, $sent_to_admin, $plain_text, $email );

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
