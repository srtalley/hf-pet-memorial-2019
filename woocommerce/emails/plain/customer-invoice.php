<?php
/**
 * Customer invoice email (plain text)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/plain/customer-invoice.php.
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

 echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
 echo esc_html( wp_strip_all_tags( $email_heading ) );
 echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

/* translators: %s: Customer first name */
echo sprintf( esc_html__( 'Dear %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ) . "\n\n";

if( $order_contains_gifts ) {
    echo 'We are so grateful for your gift order ' . esc_html( $order->get_order_number() ) . ' at The Pet Memorial. Your contribution goes to work saving the lives of animals internationally.' . "\n\n";
} else {
    echo 'We are so grateful to have you join us here at The Pet Memorial.  Your contribution will immediately go to work saving the lives of animals internationally.' . "\n\n";

    echo 'If you have not yet done so, simply login to our website to create your pet’s memorial page where you can share photos and a tribute message to your beloved pet.  Together, you will be making a tremendous difference in the lives of animals in need.' . "\n\n";
}

if ( $order->has_status( 'pending' ) ) {
	echo wp_kses_post(
        sprintf(
    		/* translators: %1$s Site title, %2$s Order pay link */
    		__( 'Your invoice is below, with a link to make payment when you’re ready: %1$s', 'woocommerce' ),
    		esc_url( $order->get_checkout_payment_url() )
    	)
    ) . "\n\n";

} else {
	/* translators: %s Order date */
	echo esc_html__( 'Your order details are below, and you may keep this as a tax receipt for your tax deductible donation:', 'woocommerce' ) . "\n\n";
}

/**
 * Hook for the woocommerce_email_order_details.
 *
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

echo "\n----------------------------------------\n\n";

/**
 * Hook for the woocommerce_email_order_meta.
 *
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/**
 * Hook for woocommerce_email_customer_details
 *
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

echo "\n\n----------------------------------------\n\n";

/**
 * Show user-defined additonal content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo esc_html( wp_strip_all_tags( wptexturize( $additional_content ) ) );
	echo "\n\n----------------------------------------\n\n";
}

echo esc_html__( 'The Pet Memorial Team', 'woocommerce' ) . "\n\n";

echo "\n\n----------------------------------------\n\n";

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
