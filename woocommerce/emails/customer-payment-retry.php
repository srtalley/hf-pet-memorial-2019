<?php
/**
 * Customer payment retry email
 *
 * @author  Prospress
 * @package WooCommerce_Subscriptions/Templates/Emails
 * @version 2.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p>
	<?php
	// translators: %1$s: name of the blog, %2$s: lowercase human time diff in the form returned by wcs_get_human_time_diff(), e.g. 'in 12 hours'
	echo wp_kses( sprintf( _x( 'The automatic payment to renew your life-saving donation with %1$s has failed. We will retry the payment %2$s.', 'In customer renewal invoice email', 'woocommerce-subscriptions' ), esc_html( get_bloginfo( 'name' ) ), wcs_get_human_time_diff( $retry->get_time() ) ), array( 'a' => array( 'href' => true ) ) );
	?>
</p>
<p>
	<?php
	// translators: %1$s %2$s: link markup to checkout payment url, note: no full stop due to url at the end
	echo wp_kses( sprintf( _x( 'To reactivate the donation now, you can also login and pay for the renewal from your account page: %1$sPay Now &raquo;%2$s', 'In customer renewal invoice email', 'woocommerce-subscriptions' ), '<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">', '</a>' ), array( 'a' => array( 'href' => true ) ) );
	?>
</p>

<?php
do_action( 'woocommerce_subscriptions_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

do_action( 'woocommerce_email_footer', $email );
