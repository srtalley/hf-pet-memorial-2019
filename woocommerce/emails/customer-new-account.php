<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
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

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s Customer username */ ?>
<p><?php esc_html__( 'Hi,', 'woocommerce' ); ?></p>
<?php /* translators: %1$s: Site title, %2$s: Username, %3$s: My account link */ ?>
<p><?php printf( esc_html__( 'Thank you for joining us at %1$s. Your username is %2$s. You can access your account area to manage your ' . $manage_wording . ', view subscriptions, change your password, and more at: %3$s', 'woocommerce' ), esc_html( $blogname ), '<strong>' . esc_html( 'your email address' ) . '</strong>', make_clickable( $login_url ) ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?></p>

<?php if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated ) : ?>
	<?php /* translators: %s Auto generated password */ ?>
	<p><?php printf( esc_html__( 'Your password has been automatically generated: %s', 'woocommerce' ), '<strong>' . esc_html( $user_pass ) . '</strong>' ); ?></p>
<?php endif; ?>

<?php
/**
 * Show user-defined additonal content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}
?>

<p><?php esc_html_e( 'Warmest wishes,', 'woocommerce' ); ?></p>
<p><?php esc_html_e( 'Laura Simpson, Founder of The Pet Memorial', 'woocommerce' ); ?></p>

<?php
do_action( 'woocommerce_email_footer', $email );
