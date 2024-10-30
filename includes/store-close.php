<?php
/**
 * Print the store close section text
 */
function cffw_store_close_section_text() {
    echo '<p>Please set the options for using store open or close.</p>';
}

/**
 * Print the store close status
 */
function cffw_store_close_status_html() {
    $cffw_store_close_status = get_option( 'cffw_store_close_status' );?>
    <input type="radio" name="cffw_store_close_status" value="1" id="cffw_store_close_status_yes" <?php if($cffw_store_close_status == 1): ?> checked = "checked" <?php endif;?>>
    <label for="cffw_auto_cart_update_yes">Yes</label>
    &nbsp
    <input type="radio" name="cffw_store_close_status" value="0" id="cffw_store_close_status_no" <?php if($cffw_store_close_status == 0): ?> checked="checked" <?php endif ?>>
    <label for="cffw_store_close_status_no">No</label>
    <?php
}

/**
 * Print the store close message
 */
function cffw_store_close_message_html() {
    $cffw_store_close_message = get_option( 'cffw_store_close_message' );
    printf('<textarea id="cffw_store_close_message" name="cffw_store_close_message" rows="4" cols="25" required>'.esc_html($cffw_store_close_message).'</textarea>', esc_attr($cffw_store_close_message));
}

/**
 * Print the store close still date
 */
function cffw_store_close_still_date_html() {
    $cffw_store_close_still_date = get_option( 'cffw_store_close_still_date' );
    printf('<input type="text" id="cffw_store_close_still_date" name="cffw_store_close_still_date" size="22" value="%s" required/>', esc_attr($cffw_store_close_still_date));
}

/**
 * Show the calendar
 */
add_action('admin_footer', 'cffw_show_calendar');
function cffw_show_calendar() { ?>
    <script>
    jQuery(document).ready(function($) {
        jQuery('#cffw_store_close_still_date').click(function() {
            jQuery("#cffw_store_close_still_date").datepicker({ 
                dateFormat: 'dd-mm-yy',
                maxDate: "+1m",
                minDate: 0,         
                }).datepicker( "show" );
            });
        });
    </script>
<?php
}

/**
 * Message show on store, category and single product page
 */
add_action( 'woocommerce_before_main_content', 'cffw_message_on_store_category_single_product_page', 10 );
function cffw_message_on_store_category_single_product_page() {
    $cffw_store_close_status = get_option( 'cffw_store_close_status' );
    $cffw_store_close_still_date = get_option( 'cffw_store_close_still_date' );
    $cffw_store_close_message = get_option( 'cffw_store_close_message' );
    if($cffw_store_close_status == 1) {
        // current date
        $current_date = date("d-m-Y");
        // Compare current date and close date
        if(strtotime($cffw_store_close_still_date) >= strtotime($current_date)) { ?>
            <div class="woocommerce-error">
                <strong>Store Closed! <?php echo esc_html($cffw_store_close_message); ?>,</strong> At this time you can place an order but WE ARE NOT AVAILABLE FOR DELIVERY ANY PRODUCT. Our next delivery service start from 
                <?php
                $closed_still_date = get_option( 'cffw_store_close_still_date' );
                if($closed_still_date != ''){
                    $closed_still_date_as_date = strtotime($closed_still_date);
                    $delivery_start_from = strtotime("+1 day", $closed_still_date_as_date);
                    echo '<strong>'.date('d-m-Y', esc_html($delivery_start_from)).'</strong>';
                }
                ?>
            </div>
    <?php }
    }
}

/**
 * Message show on cart page
 */
add_action( 'woocommerce_before_cart', 'cffw_message_on_cart_page', 10 );
function cffw_message_on_cart_page() {
    $cffw_store_close_status = get_option( 'cffw_store_close_status' );
    $cffw_store_close_still_date = get_option( 'cffw_store_close_still_date' );
    $cffw_store_close_message = get_option( 'cffw_store_close_message' );
    if($cffw_store_close_status == 1) {
        // current date
        $current_date = date("d-m-Y");
        // Compare current date and close date
        if(strtotime($cffw_store_close_still_date) >= strtotime($current_date)) { ?>
            <div class="woocommerce-error">
                <strong>Store Closed! <?php echo esc_html($cffw_store_close_message); ?>,</strong> At this time you can place an order but WE ARE NOT AVAILABLE FOR DELIVERY ANY PRODUCT. Our next delivery service start from 
                <?php
                $closed_still_date = get_option( 'cffw_store_close_still_date' );
                if($closed_still_date != ''){
                    $closed_still_date_as_date = strtotime($closed_still_date);
                    $delivery_start_from = strtotime("+1 day", $closed_still_date_as_date);
                    echo '<strong>'.date('d-m-Y', esc_html($delivery_start_from)).'</strong>';
                }
                ?>
            </div>
    <?php }
    }
}

/**
 * Message show on checkout page
 */
add_action( 'woocommerce_before_checkout_form', 'cffw_message_on_checkout_page', 10 );
function cffw_message_on_checkout_page() {
    $cffw_store_close_status = get_option( 'cffw_store_close_status' );
    $cffw_store_close_still_date = get_option( 'cffw_store_close_still_date' );
    $cffw_store_close_message = get_option( 'cffw_store_close_message' );
    if($cffw_store_close_status == 1) {
        // current date
        $current_date = date("d-m-Y");
        // Compare current date and close date
        if(strtotime($cffw_store_close_still_date) >= strtotime($current_date)) { ?>
            <div class="woocommerce-error">
                <strong>Store Closed! <?php echo esc_html($cffw_store_close_message); ?>,</strong> At this time you can place an order but WE ARE NOT AVAILABLE FOR DELIVERY ANY PRODUCT. Our next delivery service start from 
                <?php
                $closed_still_date = get_option( 'cffw_store_close_still_date' );
                if($closed_still_date != ''){
                    $closed_still_date_as_date = strtotime($closed_still_date);
                    $delivery_start_from = strtotime("+1 day", $closed_still_date_as_date);
                    echo '<strong>'.date('d-m-Y', esc_html($delivery_start_from)).'</strong>';
                }
                ?>
            </div>
    <?php }
    }
}
?>
