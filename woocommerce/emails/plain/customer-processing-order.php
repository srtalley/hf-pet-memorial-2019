<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/plain/customer-processing-order.php.
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
 echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
 echo esc_html( wp_strip_all_tags( $email_heading ) );
 echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

/* translators: %s: Customer first name */
echo sprintf( esc_html__( 'Dear %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ) . "\n\n";

if( $order_contains_gifts ) {
    echo 'Congratulations. We have received your gift order ' . esc_html( $order->get_order_number() ) . ', and it is now being processed.' . "\n\n";
} else {

    if( $order_contains_subscription && !$order_contains_donation) {
        echo 'We are so grateful to have you join us here at The Pet Memorial. Your monthly contribution will immediately go to work saving the lives of animals internationally.' . "\n\n";
    } else if( $order_contains_donation ) {
        echo 'Thank you for your very special donation to The Pet Memorial. Your contribution is such a beautiful way to honor your pet while saving the lives of other animals in need. We are deeply grateful and have sent you this tax receipt by email.' . "\n\n";
        echo 'Warmest wishes,' . "\n\n";
        echo '<strong>Laura Simpson' . "\n\n";
        echo 'Founder' . "\n";
        echo 'Harmony Fund &amp; The Pet Memorial' . "\n";
        echo '800 Main Street, Suite 217, Holden, MA 01520, USA' . "\n";
    } else {
        echo 'We are so grateful to have you join us here at The Pet Memorial. Your contribution will immediately go to work saving the lives of animals internationally.' . "\n\n";
    }
    if( !$order_contains_donation ) {
        echo 'CREATE YOUR PET LEGACY PAGE' . "\n\n";

        echo 'To create your pet\'s page or add more pets, simply login to the account you created on our website: ' . esc_url( wc_get_page_permalink( 'myaccount' ) ) . 'pet-profiles/create';
    }

}

/* translators: %s: Order number */
if( $order_contains_subscription || $order_contains_donation ) {
    echo esc_html__( 'Your order details are below, and you may keep this as a tax receipt for your tax deductible donation. You may also download tax receipts in the future for forthcoming donations by logging into your account', 'woocommerce' ) . "\n\n";
} else {
    echo esc_html__( 'Your order details are below, and you may keep this as a tax receipt for your tax deductible donation.', 'woocommerce' ) . "\n\n";
}
echo "\n----------------------------------------\n\n";

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

echo "\n----------------------------------------\n\n";

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

echo "\n----------------------------------------\n\n";

/**
 * Show user-defined additonal content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo esc_html( wp_strip_all_tags( wptexturize( $additional_content ) ) );
	echo "\n\n----------------------------------------\n\n";
}

echo esc_html__( 'The Pet Memorial Team', 'woocommerce' ) . "\n\n";

echo "\n----------------------------------------\n\n";

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
