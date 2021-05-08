<?php
/*
* push transaction to dataLayer after woocommerce thank you from making a donation
 */

add_action( 'woocommerce_thankyou', 'send_to_dl_on_thankyou', 1, 1);
function send_to_dl_on_thankyou ($order_id ){
    $order = wc_get_order( $order_id );
    $order_data = $order->get_data();
    $price = $order_data['total'];
    $t_id = $order->get_order_number();
    $order_total_tax = $order_data['total_tax'];
    $applied_coupon_list =  $order->get_used_coupons();
    $applied_coupons = implode( ', ', $applied_coupon_list );
    $object_array = [];
    $type = '';
    $coupon = ($applied_coupons ? $applied_coupons : 'none')
?>
<script>
    window.dataLayer = window.dataLayer || [];
    var ecommerceObj = {
        'event': 'Made Donation',
        'ecommerce': {
            'donate': {
                'actionField': {
                    'id': '<?php echo $t_id; ?>',                         // Transaction ID. Required for purchases and refunds.
                    'affiliation': 'Pet Memorial',
                    'donation amount': <?php echo $price; ?>,                     // Donation amount
                    'tax':<?php echo $order_total_tax; ?>,
                    'coupon': '<?php echo $coupon; ?>'
                },
                'products':[]

            }
        }
    }

    <?php

        foreach($order->get_items() as $key => $item):
            $product = $order->get_product_from_item( $item );
            $prod_price = number_format($order->get_line_subtotal($item), 2, ".", "");
            $discount_percent = ( ( ( $prod_price - number_format( $price, 2, ".", "" ) ) / $prod_price ) * 100 ) . '%';
        ?>
            ecommerceObj.prodType = '<?php echo $product->get_type() ?>';
            ecommerceObj.prodName = '<?php echo $item['name'] ?>';
            ecommerceObj.prodPrice = '<?php echo $price ?>';
            ecommerceObj['ecommerce']['donate']['products'].push({
                'name': '<?php echo $item['name']; ?>',
                'id': '<?php echo $item['product_id']; ?>',
                'price': '<?php echo $prod_price ?>',
                'brand': 'Pet Memorial',
                'category': 'Donations',
                'variant': '<?php echo $product->get_type(); ?>',
                'quantity': <?php echo $item['qty']; ?>,
            })

        <?php

        endforeach;
    // }
    ?>
    //console.log(ecommerceObj);
    dataLayer.push(ecommerceObj);

    return ecommerceObj;

    </script>
<?php
}
