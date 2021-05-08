<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* GIFT ORDER - BEGIN */
$order_contains_gifts = HFPSP_WC_Gifts::order_contains_gifts( $order );
if( $order_contains_gifts ) {
    // Override heading
    $email_heading = 'Thank you for your gift order';
}
/* GIFT ORDER - END */
/* ORDER CONTAINS SUBSCRIPTION - BEGIN */
$order_contains_subscription = HFPSP_WC_Subscriptions::order_contains_subscription( $order );
/* ORDER CONTAINS SUBSCRIPTION - END */
/* ORDER CONTAINS DONATION - BEGIN */
$order_contains_donation = HFPSP_Donations::order_contains_donation( $order );
/* ORDER CONTAINS DONATION - END */
/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<p><?php printf( esc_html__( 'Dear %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>

<?php if( $order_contains_gifts ) : ?>
    <p><?php printf( 'Congratulations. We have received your gift order %s, and it is now being processed.', esc_html( $order->get_order_number() ) ); ?></p>
<?php else: ?>
    <?php if( $order_contains_subscription && !$order_contains_donation) : ?>
        <p>We are so grateful to have you join us here at The Pet Memorial. Your monthly contribution will immediately go to work saving the lives of animals internationally.</p>
    <?php elseif( $order_contains_donation ) : ?>
        <p>Thank you for your very special donation to The Pet Memorial. Your contribution is such a beautiful way to honor your pet while saving the lives of other animals in need. We are deeply grateful and have sent you this tax receipt by email.</p>
        <p>Warmest wishes,</p>

        <p><strong>Laura Simpson</strong></p>

        <strong>Founder</strong><br />
        <strong>Harmony Fund &amp; The Pet Memorial</strong><br />
        800 Main Street, Suite 217, Holden, MA 01520, USA<br />
        <a href="https://harmonyfund.org/"><strong>Our Website  </strong></a><br />
        <a href="https://www.facebook.com/HarmonyFundAnimalRescue/"><strong>Our Facebook Page</strong></a><br />
        <a href="https://www.instagram.com/harmony_fund/"><strong>Follow us on Instagram</strong></a><br />
        <br />
        <hr>
        <br />
    <?php else: ?>
        <p>We are so grateful to have you join us here at The Pet Memorial. Your contribution will immediately go to work saving the lives of animals internationally.</p>
    <?php endif; ?>

    <?php /* translators: %s: Order number */ ?>
    <?php if( !$order_contains_donation ) : ?>
    <h2>CREATE YOUR PET LEGACY PAGE</h2>
    <p>To create your pet's legacy page or add more pets, simply login to the <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>pet-profiles/create" target="_blank">account you created</a> on our website.</p>
    <?php endif; ?>
<?php endif; ?>
<?php if( $order_contains_subscription || $order_contains_donation) : ?>
    <p><?php echo esc_html__( 'Your donation details are below, and you may keep this as a tax receipt for your tax deductible donation. You may also download tax receipts in the future for forthcoming donations by logging into your account.', 'woocommerce' ); ?> <span>And if you’d like to stay posted on our work, you may enjoy <a href="https://www.facebook.com/The-Pet-Memorial-276741059544132/">following us on Facebook</a>.</span></p>
<?php else: ?>
    <p><?php echo esc_html__( 'Your donation details are below, and you may keep this as a tax receipt for your tax deductible donation.', 'woocommerce' ); ?> <span>And if you’d like to stay posted on our work, you may enjoy <a href="https://www.facebook.com/The-Pet-Memorial-276741059544132/">following us on Facebook</a>.</span></p>
<?php endif; ?>
<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additonal content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

?>
<p>
<?php esc_html_e( 'The Pet Memorial Team', 'woocommerce' ); ?>
</p>
<?php

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );