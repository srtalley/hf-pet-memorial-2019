<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/plain/customer-new-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails/Plain
 * @version 3.7.0
 */

 defined( 'ABSPATH' ) || exit;

 /* GIFT ORDER - BEGIN */
 $manage_wording = 'pet memorial pages';
 $login_url = esc_url( wc_get_page_permalink( 'myaccount' ) );
 if( isset( $order ) ) {
     if( HFPSP_WC_Gifts::order_contains_gifts( $order ) ) {
         // Override heading
         $email_heading = 'Your Account with ' . esc_html( $blogname );
         $manage_wording = 'account';
         $login_url = untrailingslashit( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) . '/pet-profiles/?gift_create=1';
     }
 }
 /* GIFT ORDER - END */

 echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
 echo esc_html( wp_strip_all_tags( $email_heading ) );
 echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

/* translators: %s Customer first name */
echo esc_html__( 'Hi,', 'woocommerce' ) . "\n\n";
/* translators: %1$s: Site title, %2$s: Username, %3$s: My account link */
echo sprintf( esc_html__( 'Thank you for joining us at %1$s. Your username is %2$s. You can access your account area to manage your ' . $manage_wording . ', view subscriptions, change your password, and more at: %3$s', 'woocommerce' ), esc_html( $blogname ), esc_html( 'your email address' ), esc_html( $login_url ) ) . "\n\n";

if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated ) {
	/* translators: %s Auto generated password */
	echo sprintf( esc_html__( 'Your password has been automatically generated: %s.', 'woocommerce' ), esc_html( $user_pass ) ) . "\n\n";
}

echo "\n\n----------------------------------------\n\n";

/**
 * Show user-defined additonal content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo esc_html( wp_strip_all_tags( wptexturize( $additional_content ) ) );
	echo "\n\n----------------------------------------\n\n";
}

echo esc_html__( 'Warmest wishes,', 'woocommerce' ) . "\n\n";
echo esc_html__( 'Laura Simpson, Founder of The Pet Memorial', 'woocommerce' ) . "\n\n";

echo "\n\n----------------------------------------\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
