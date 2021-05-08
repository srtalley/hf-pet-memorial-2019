<?php
/**
 * Coupon Email Content
 *
 * @author      StoreApps
 * @package     WooCommerce Smart Coupons/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} ?>

<?php
global $store_credit_label;

/* PWD - BEGIN */
$email_heading = 'A Gift In Honor of Your Pet';
/* PWD - END */

if ( function_exists( 'wc_get_template' ) ) {
	wc_get_template( 'emails/email-header.php', array( 'email_heading' => $email_heading ) );
} else {
	woocommerce_get_template( 'emails/email-header.php', array( 'email_heading' => $email_heading ) );
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
<style type="text/css"><?php echo ( isset( $coupon_styles ) && ! empty( $coupon_styles ) ) ? $coupon_styles : ''; // WPCS: XSS ok. ?></style>
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

<p>A gift membership to <?php echo esc_html( $blogname ); ?> has been given to you<?php echo ( isset( $sender ) ) ? ' by ' . $sender : ''; ?>. <?php echo esc_html( $blogname ); ?> was created to honor pets who have passed on and to give pet guardians a way to channel their love into a beautiful mission to help needy animals all over the planet. </p>

<ul>
    <li><span style="font-size: 150%; font-weight: 600;">Create your own tribute page</span> on our virtual memorial to honor and memorialize the pets they have loved.</li>
    <li><span style="font-size: 150%; font-weight: 600;">We’re saving lives in honor of your pet.</span> <strong>Membership in The Pet Memorial sponsors the work of underdog animal rescue squads</strong> who are providing food, shelter, protection-from-cruelty and rescue to thousands of animals across the planet.</li>
</ul>

<?php if( isset( $sender ) && $message_from_sender ) : ?>
    <?php if( isset( $gift_certificate_sender_name ) ) : ?>
        <h2>Message from <?php echo esc_html__( $gift_certificate_sender_name ); ?></h2>
    <?php else : ?>
        <h2>Message from <?php echo $sender; ?></h2>
    <?php endif; ?>
<p style="font-style:italic;"><?php echo $message_from_sender; ?></p>
<?php endif; ?>

<h2 style="color:#ed5a50;">How to Add Your Pet to The Memorial</h2>
<p>You may add your pet to our online memorial by uploading favorite photos and a words of tribute to your beloved pet.</p>
<p>To redeem your gift membership please click below or enter your gift code: <span style="font-style:italic; font-weight:600;"><?php echo $coupon_code; ?></span> at the following URL: <strong><a href="<?php echo site_url('/redeem-your-gift/'); ?>"><?php echo site_url('/redeem-your-gift/'); ?></a></strong>.</p>
<p style="text-align:center;"><a class="button btn" style="display:inline-block; padding:10px 20px; background:#ed5a50; color:#fff; text-transform:uppercase; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.25); text-decoration: none; font-size: 150%;" href="<?php echo $coupon_target; ?>">Click Here To Begin</a></p>

<?php /* PWD - END */ ?>

<?php
$coupon = new WC_Coupon( $coupon_code );

if ( $this->is_wc_gte_30() ) {
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

$coupon_data = $this->get_coupon_meta_data( $coupon );

/*
$coupon_target = '';
$wc_url_coupons_active_urls = get_option( 'wc_url_coupons_active_urls' ); // From plugin WooCommerce URL coupons.

if ( ! empty( $wc_url_coupons_active_urls ) ) {
	$coupon_target = ( ! empty( $wc_url_coupons_active_urls[ $coupon_id ]['url'] ) ) ? $wc_url_coupons_active_urls[ $coupon_id ]['url'] : '';
}
if ( ! empty( $coupon_target ) ) {
	$coupon_target = home_url( '/' . $coupon_target );
} else {
	$coupon_target = home_url( '/?sc-page=cart&coupon-code=' . $coupon_code );
}

$coupon_target = apply_filters( 'sc_coupon_url_in_email', $coupon_target, $coupon );
*/
?>

<div style="margin: 10px 0; text-align: center; font-size: 125%; line-height: 1.5;" title="<?php echo esc_html__( 'Click to visit store. This gift certificate will be applied automatically.', 'woocommerce-smart-coupons' ); ?>">
	<a href="<?php echo esc_url( $coupon_target ); ?>" style="color: #444; line-height: 1.5 !important">

		<div class="coupon-container <?php echo esc_attr( $this->get_coupon_container_classes() ); ?>" style="cursor:pointer; text-align:center; <?php echo $this->get_coupon_style_attributes(); // WPCS: XSS ok. ?>">
			<?php
				echo '<div class="coupon-content ' . esc_attr( $this->get_coupon_content_classes() ) . '" style="line-height: 1.5 !important;">
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
				if ( $this->is_wc_gte_30() && $expiry_date instanceof WC_DateTime ) {
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
				$expiry_date = $this->get_expiration_format( $expiry_date );
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
<center><a href="<?php echo esc_url( $site_url ); ?>"><?php echo esc_html__( 'Visit Store', 'woocommerce-smart-coupons' ); ?></a></center>

<div style="clear:both;"></div>

<?php
if ( function_exists( 'wc_get_template' ) ) {
	wc_get_template( 'emails/email-footer.php' );
} else {
	woocommerce_get_template( 'emails/email-footer.php' );
}
