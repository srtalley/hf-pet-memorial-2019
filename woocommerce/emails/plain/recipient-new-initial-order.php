<?php
/**
 * Recipient customer new account email
 *
 * @author James Allan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
echo '= ' . $email_heading . " =\n\n";
echo sprintf( __( 'Hello,', 'woocommerce-subscriptions-gifting' ) ) . "\n";

echo 'A gift membership to ' . esc_html( $blogname ) . ' has been given to you by ' . wp_kses( $subscription_purchaser, wp_kses_allowed_html( 'user_description' ) ) . '. ' . esc_html( $blogname ) . '  was created to honor pets who have passed on. Membership sponsors the work of underdog animal rescue squads who are providing food, shelter and protection-from-cruelty for thousands of animals across the planet.' . "\n\n";

echo 'How to Add Your Pet to The Memorial' . "\n";

echo 'Your pet’s name will be added to our physical memorial when it is created in 2026.' . "\n\n";

echo 'Today, we invite you to create your own online tribute page for your pet on our virtual memorial. This page can include a few favorite photos and special words about your pet.' . "\n\n";

echo 'It’s easy to get started. We created an account for you, and naturally there is no cost at all as this is a gift for you.' . "\n\n";

echo '---------------------------------------------' . "\n\n";

echo '---------------------------------------------' . "\n\n";

echo '= HOW TO ADD YOUR PET TO THE MEMORIAL =' . "\n\n";
echo 'You may add your pet to our online memorial by uploading favorite photos and a words of tribute to your beloved pet.' . "\n\n";

$new_recipient = get_user_meta( $recipient_user->ID, 'wcsg_update_account', true );

if ( 'true' == $new_recipient ) {

	// get the login token
	$login_token = get_user_meta( $recipient_user->ID, 'one-time-login-token', true );

	echo esc_html__( 'Please use this link to get started: ' . site_url() . '/my-account/?token=' . $login_token, 'woocommerce-subscriptions-gifting' ) . "\n\n";
} else {
	echo sprintf( __( 'Please use this link to get started and log into your account: %2$s.', 'woocommerce-subscriptions-gifting' ), _n( 'subscription', 'subscriptions', count( $subscriptions ), 'woocommerce-subscriptions-gifting' ), untrailingslashit( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) . '/pet-profiles/?gift_create=1' ) . "\n\n";
}

echo '---------------------------------------------' . "\n\n";

echo __( ' Details of the membership are shown below.', 'woocommerce-subscriptions-gifting' ) . "\n\n";

foreach ( $subscriptions as $subscription_id ) {
	$subscription = wcs_get_subscription( $subscription_id );

	do_action( 'wcs_gifting_email_order_details', $subscription, $sent_to_admin, $plain_text, $email );

	if ( is_callable( array( 'WC_Subscriptions_Email', 'order_download_details' ) ) ) {
		WC_Subscriptions_Email::order_download_details( $subscription, $sent_to_admin, $plain_text, $email );
	}
}

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
