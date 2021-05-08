<?php
/**
 * Coupon Email Content
 *
 * @author      StoreApps
 * @version     1.1.1
 * @package     woocommerce-smart-coupons/templates/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $store_credit_label, $woocommerce_smart_coupon;

if ( ! isset( $email ) ) {
	$email = null;
}
$email_heading = "A Gift in Honor of Your Pet";
if ( has_action( 'woocommerce_email_header' ) ) {
	do_action( 'woocommerce_email_header', $email_heading, $email );
} else {
	if ( function_exists( 'wc_get_template' ) ) {
		wc_get_template( 'emails/email-header.php', array( 'email_heading' => $email_heading ) );
	} else {
		woocommerce_get_template( 'emails/email-header.php', array( 'email_heading' => $email_heading ) );
	}
}
?>

<style type="text/css">
		.coupon-container {
			margin: .2em;
			box-shadow: 0 0 5px #e0e0e0;
			display: inline-table;
			text-align: center;
			cursor: pointer;
			padding: .55em;
			line-height: 1.4em;
		}

		.coupon-content {
			padding: 0.2em 1.2em;
		}

		.coupon-content .code {
			font-family: monospace;
			font-size: 1.2em;
			font-weight:700;
		}

		.coupon-content .coupon-expire,
		.coupon-content .discount-info {
			font-family: Helvetica, Arial, sans-serif;
			font-size: 1em;
		}
		.coupon-content .discount-description {
			font: .7em/1 Helvetica, Arial, sans-serif;
			width: 250px;
			margin: 10px inherit;
			display: inline-block;
		}

</style>
<style type="text/css"><?php echo ( isset( $coupon_styles ) && ! empty( $coupon_styles ) ) ? $coupon_styles : ''; // phpcs:ignore ?></style>
<style type="text/css">
	.coupon-container.left:before,
	.coupon-container.bottom:before {
		background: <?php echo esc_html( $foreground_color ); ?> !important;
	}
	.coupon-container.left:hover, .coupon-container.left:focus, .coupon-container.left:active,
	.coupon-container.bottom:hover, .coupon-container.bottom:focus, .coupon-container.bottom:active {
		color: <?php echo esc_html( $background_color ); ?> !important;
	}
</style>

<?php /* PWD - BEGIN */ ?>
<?php
if( ! isset( $blogname ) ) {
    $blogname = get_bloginfo( 'name' );
}
$coupon_target = HFPSP_WC_Coupons::get_coupon_target( $coupon_code );
?>

<p>Hello,</p>

<p>A gift membership to <?php echo esc_html( $blogname ); ?> has been given to you<?php echo ( isset( $sender ) ) ? ' by ' . $sender : ''; ?>. <?php echo esc_html( $blogname ); ?> was created to honor pets who have passed on. Membership sponsors the work of underdog animal rescue squads who are providing food, shelter and protection-from-cruelty for thousands of animals across the planet.</p>

<h2>How to Add Your Pet to The Memorial</h2>

<p>Your pet’s name will be added to our physical memorial when it is created in 2026. </p>

<p>Today, we invite you to create your own online tribute page for your pet on our virtual memorial. This page can include a few favorite photos and special words about your pet.</p>

<p>It’s easy to get started. We created an account for you, and naturally there is no cost at all as this is a gift for you.</p>

<p><strong><?php

$order_id = $order->get_id();

$recipient_email = HFPSP_WC_Coupons::hfpsp_get_smart_coupon_order_email($order_id);

if($recipient_email != false): 

	$recipient_user_id = email_exists( $recipient_email );

	$new_recipient = get_user_meta( $recipient_user_id, 'wcsg_update_account', true );

	if ( 'true' == $new_recipient ) : 

		// get the login token
		$login_token = get_user_meta( $recipient_user_id, 'one-time-login-token', true );

	?>
		<h2>Please use this link to get started: <a href="<?php echo site_url(); ?>/?token=<?php echo $login_token;?>" target="_blank"><?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?></a></h2>

	<?php else : ?>

		<h2>Please use this link to get started and log into your account: <a href="<?php echo untrailingslashit( esc_url( wc_get_page_permalink( 'myaccount' ) ) ); ?>/pet-profiles/?gift_create=1"><?php echo untrailingslashit( esc_url( wc_get_page_permalink( 'myaccount' ) ) ); ?>/pet-profiles/</a></h2>

	<?php endif;
	?></strong></p>

	

<?php else: ?>
	<p>To redeem your gift membership please click below or enter your gift code: <span style="font-style:italic; font-weight:600;"><?php echo $coupon_code; ?></span> at the following URL: <strong><a href="<?php echo site_url('/redeem-your-gift/'); ?>"><?php echo site_url('/redeem-your-gift/'); ?></a></strong>.</p>

	<p style="text-align:center;"><a class="button btn" style="display:inline-block; padding:10px 20px; background:#ed5a50; color:#fff; text-transform:uppercase; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.25); text-decoration: none; font-size: 150%;" href="<?php echo $coupon_target; ?>">Click Here To Begin</a></p>

	<?php 
	$coupon = new WC_Coupon( $coupon_code );

	if ( $woocommerce_smart_coupon->is_wc_gte_30() ) {
		if ( ! is_object( $coupon ) || ! is_callable( array( $coupon, 'get_id' ) ) ) {
			return;
		}
		$coupon_id = $coupon->get_id();
		if ( empty( $coupon_id ) ) {
			return;
		}
		$coupon_amount    = $coupon->get_amount();
		$is_free_shipping = ( $coupon->get_free_shipping() ) ? 'yes' : 'no';
		$expiry_date      = $coupon->get_date_expires();
		$coupon_code      = $coupon->get_code();
	} else {
		$coupon_id        = ( ! empty( $coupon->id ) ) ? $coupon->id : 0;
		$coupon_amount    = ( ! empty( $coupon->amount ) ) ? $coupon->amount : 0;
		$is_free_shipping = ( ! empty( $coupon->free_shipping ) ) ? $coupon->free_shipping : '';
		$expiry_date      = ( ! empty( $coupon->expiry_date ) ) ? $coupon->expiry_date : '';
		$coupon_code      = ( ! empty( $coupon->code ) ) ? $coupon->code : '';
	}

	$coupon_post = get_post( $coupon_id );

	$coupon_data = $woocommerce_smart_coupon->get_coupon_meta_data( $coupon );

	?>

	<div style="margin: 10px 0; text-align: center; font-size: 125%; line-height: 1.5;" title="<?php echo esc_html__( 'Click to visit store. This gift certificate will be applied automatically.', 'woocommerce-smart-coupons' ); ?>">
		<a href="<?php echo esc_url( $coupon_target ); ?>" style="color: #444; line-height: 1.5 !important;">

			<div class="coupon-container <?php echo esc_attr( $woocommerce_smart_coupon->get_coupon_container_classes() ); ?>" style="cursor:pointer; text-align:center; <?php echo $woocommerce_smart_coupon->get_coupon_style_attributes(); // WPCS: XSS ok. ?>">
				<?php
					echo '<div class="coupon-content ' . esc_attr( $woocommerce_smart_coupon->get_coupon_content_classes() ) . '" style="line-height: 1.5 !important;">
						<div class="discount-info" style="line-height: 1.5 !important;">';

				if ( ! empty( $coupon_data['coupon_amount'] ) && 0 !== $coupon_amount ) {
					echo $coupon_data['coupon_amount']; // phpcs:ignore
					echo ' ' . $coupon_data['coupon_type'];  // phpcs:ignore
					if ( 'yes' === $is_free_shipping ) {
						echo esc_html__( ' &amp; ', 'woocommerce-smart-coupons' );
					}
				}

				if ( 'yes' === $is_free_shipping ) {
					echo esc_html__( 'Free Shipping', 'woocommerce-smart-coupons' );
				}
						echo '</div>';

						echo '<div style="line-height: 1.5 !important;">Gift Code: <span class="code">' . esc_html( $coupon_code ) . '</span></div>';  // PWD Edit

						$show_coupon_description = get_option( 'smart_coupons_show_coupon_description', 'no' );
				if ( ! empty( $coupon_post->post_excerpt ) && 'yes' === $show_coupon_description ) {
					echo '<div class="discount-description" style="line-height: 1.5 !important;">' . $coupon_post->post_excerpt . '</div>'; // WPCS: XSS ok.
				}

				if ( ! empty( $expiry_date ) ) {
					if ( $woocommerce_smart_coupon->is_wc_gte_30() && $expiry_date instanceof WC_DateTime ) {
						$expiry_date = $expiry_date->getTimestamp();
					} elseif ( ! is_int( $expiry_date ) ) {
						$expiry_date = strtotime( $expiry_date );
					}

					if ( ! empty( $expiry_date ) && is_int( $expiry_date ) ) {
						$expiry_time = (int) get_post_meta( $coupon_id, 'wc_sc_expiry_time', true );
						if ( ! empty( $expiry_time ) ) {
							$expiry_date += $expiry_time; // Adding expiry time to expiry date.
						}
					}
					$expiry_date = $woocommerce_smart_coupon->get_expiration_format( $expiry_date );
					echo '<div class="coupon-expire" style="line-height: 1.5 !important;">' . esc_html( $expiry_date ) . '</div>';
				} else {
					// echo '<div class="coupon-expire">' . esc_html__( 'Never Expires ', 'woocommerce-smart-coupons' ) . '</div>'; // PWD Edit
				}
					echo '</div>';
				?>
			</div>
		</a>
	</div>

	<?php $site_url = ! empty( $url ) ? $url : home_url(); ?>
	<center><a href="<?php echo esc_url( $site_url ); ?>"><?php //echo esc_html__( 'Visit Store', 'woocommerce-smart-coupons' ); ?></a></center>

<?php endif; ?>

<div style="clear:both;"></div>

<?php
if ( has_action( 'woocommerce_email_footer' ) ) {
	do_action( 'woocommerce_email_footer', $email );
} else {
	if ( function_exists( 'wc_get_template' ) ) {
		wc_get_template( 'emails/email-footer.php' );
	} else {
		woocommerce_get_template( 'emails/email-footer.php' );
	}
}
