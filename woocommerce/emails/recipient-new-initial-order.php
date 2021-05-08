<?php
/**
 * Recipient new subscription(s) notification email
 *
 * @author James Allan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php printf( esc_html__( 'Hello,', 'woocommerce-subscriptions-gifting' ) ); ?></p>

<p>A gift membership to <?php echo esc_html( $blogname ); ?> has been given to you by <?php echo wp_kses( $subscription_purchaser, wp_kses_allowed_html( 'user_description' ) ); ?>. <?php echo esc_html( $blogname ); ?> was created to honor pets who have passed on. Membership sponsors the work of underdog animal rescue squads who are providing food, shelter and protection-from-cruelty for thousands of animals across the planet.</p>

<h2>How to Add Your Pet to The Memorial</h2>

<p>Your pet’s name will be added to our physical memorial when it is created in 2026. </p>

<p>Today, we invite you to create your own online tribute page for your pet on our virtual memorial. This page can include a few favorite photos and special words about your pet.</p>

<p>It’s easy to get started. We created an account for you, and naturally there is no cost at all as this is a gift for you.</p>

<?php /*
<p><strong>Message:</strong></p>
<p><?php // Message field not available for gifted subscriptions ?></p>
*/ ?>

<p><strong><?php
$new_recipient = get_user_meta( $recipient_user->ID, 'wcsg_update_account', true );

if ( 'true' == $new_recipient ) : 

	// get the login token
	$login_token = get_user_meta( $recipient_user->ID, 'one-time-login-token', true );

?>
	<h2>Please use this link to get started: <a href="<?php echo site_url(); ?>/?token=<?php echo $login_token;?>" target="_blank"><?php echo site_url(); ?>/my-account</a><h2>

	
<?php //printf( esc_html_e( 'We noticed you didn\'t have an account with %1$s, so we created one for you. Your account login details will have been sent to you in a separate email.', 'woocommerce-subscriptions-gifting' ), esc_html( $blogname ) ); ?>

<?php else : ?>

	<h2>Please use this link to get started and log into your account: <a href="<?php echo untrailingslashit( esc_url( wc_get_page_permalink( 'myaccount' ) ) ); ?>/pet-profiles/?gift_create=1"><?php echo untrailingslashit( esc_url( wc_get_page_permalink( 'myaccount' ) ) ); ?> '/pet-profiles/</a></h2>

<?php endif;
?></strong></p>

<p>Details of the membership are shown below:</p>
<?php

foreach ( $subscriptions as $subscription_id ) {
	$subscription = wcs_get_subscription( $subscription_id );

	do_action( 'wcs_gifting_email_order_details', $subscription, $sent_to_admin, $plain_text, $email );

	if ( is_callable( array( 'WC_Subscriptions_Email', 'order_download_details' ) ) ) {
		WC_Subscriptions_Email::order_download_details( $subscription, $sent_to_admin, $plain_text, $email );
	}
}

do_action( 'woocommerce_email_footer', $email );
