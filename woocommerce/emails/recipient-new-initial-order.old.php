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

<p>A gift membership to <?php echo esc_html( $blogname ); ?> has been given to you by <?php echo wp_kses( $subscription_purchaser, wp_kses_allowed_html( 'user_description' ) ); ?>. <?php echo esc_html( $blogname ); ?> was created to honor pets who have passed on and to give pet guardians a way to channel their love into a beautiful mission to help needy animals all over the planet.</p>

<ul>
    <li><span style="font-size: 150%; font-weight: 600;">Create your own tribute page</span> on our virtual memorial to honor and memorialize the pets they have loved.</li>
    <li><span style="font-size: 150%; font-weight: 600;">We’re saving lives in honor of your pet.</span> <strong>Membership in The Pet Memorial sponsors the work of underdog animal rescue squads</strong> who are providing food, shelter, protection-from-cruelty and rescue to thousands of animals across the planet.</li>
</ul>

<?php /*
<p><strong>Message:</strong></p>
<p><?php // Message field not available for gifted subscriptions ?></p>
*/ ?>

<h2>How to Add Your Pet to The Memorial</h2>
<p>You may add your pet to our online memorial by uploading favorite photos and a words of tribute to your beloved pet.</p>

<p><strong><?php
$new_recipient = get_user_meta( $recipient_user->ID, 'wcsg_update_account', true );

if ( 'true' == $new_recipient ) : ?>

<?php printf( esc_html_e( 'We noticed you didn\'t have an account with %1$s, so we created one for you. Your account login details will have been sent to you in a separate email.', 'woocommerce-subscriptions-gifting' ), esc_html( $blogname ) ); ?>

<?php else : ?>

<?php printf( esc_html__( 'You may access your account area to view your new %1$s here: %2$sMy Account%3$s.', 'woocommerce-subscriptions-gifting' ), 'membership',
    '<a href="' . untrailingslashit( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) . '/pet-profiles/?gift_create=1">',
    '</a>'
); ?>

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
