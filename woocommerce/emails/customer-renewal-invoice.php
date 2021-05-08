<?php
/**
 * Customer renewal invoice email
 *
 * @author  Brent Shepherd
 * @package WooCommerce_Subscriptions/Templates/Emails
 * @version 2.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( 'failed' == $order->get_status() ) {
    $email_heading = 'Sorry, Your Donations Have Stopped';
}

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php if ( 'pending' == $order->get_status() ) : ?>
	<p>
		<?php
		// translators: %1$s: name of the blog, %2$s: link to checkout payment url, note: no full stop due to url at the end
		echo wp_kses( sprintf( _x( 'An invoice has been created for you to renew your life-saving donation with %1$s. Simply login to your account on our website and enter your payment details: %2$s', 'In customer renewal invoice email', 'woocommerce-subscriptions' ), esc_html( get_bloginfo( 'name' ) ), '<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay Now &raquo;', 'woocommerce-subscriptions' ) . '</a>' ), array( 'a' => array( 'href' => true ) ) );
		?>
	</p>
<?php elseif ( 'failed' == $order->get_status() ) : ?>
    <p>Your most recent automatic monthly payment to <strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong> has failed. This happens for many reasons, but is frequently the result of an expiring credit card.</p>
    <h3 style="font-weight:bold">WHAT TO DO</h3>
	<p>
		<?php
		// translators: %1$s: name of the blog, %2$s: link to checkout payment url, note: no full stop due to url at the end
		echo wp_kses( sprintf( _x( 'It&apos;s quick and easy to reactivate your life-saving donations to rescue animals across the planet through <strong>%1$s</strong>. Simply login to your account on our website and enter new payment details: %2$s', 'In customer renewal invoice email', 'woocommerce-subscriptions' ), esc_html( get_bloginfo( 'name' ) ), '<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay Now &raquo;', 'woocommerce-subscriptions' ) . '</a>' ), array( 'a' => array( 'href' => true ) ) ); ?>
    </p>
<?php endif; ?>

<?php
do_action( 'woocommerce_subscriptions_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

do_action( 'woocommerce_email_footer', $email );
