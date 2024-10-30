<?php
/**
 * Print the cart auto update section text
 */
function cffw_cart_update_section_text() {
    echo '<p>Please set the options for cart auto update or not</p>';
}

/**
 * Print the cart auto update field
 */
function cffw_cart_auto_update_html() {
    $cffw_cart_auto_update = get_option( 'cffw_cart_auto_update' );?>
    <input type="radio" name="cffw_cart_auto_update" value="1" id="cffw_cart_auto_update_yes" <?php if($cffw_cart_auto_update == 1): ?> checked = "checked" <?php endif;?>>
    <label for="cffw_auto_cart_update_yes">Yes</label>
    &nbsp
    <input type="radio" name="cffw_cart_auto_update" value="0" id="cffw_cart_auto_update_no" <?php if($cffw_cart_auto_update == 0): ?> checked="checked" <?php endif ?>>
    <label for="cffw_cart_auto_update_no">No</label>&nbsp;<span>(If set is "Yes" then "Update cart" button will be hide. Cart data will be automatically update after change product quantity)</span>
    <?php
}

/**
 * Hide "Update Cart" button by CSS 
 */
add_action('wp_head', 'cffw_hide_update_cart_button');
function cffw_hide_update_cart_button() { 
    $cffw_cart_auto_update = get_option( 'cffw_cart_auto_update' );
    if($cffw_cart_auto_update == 1){ ?>
        <style>
            .woocommerce button[name="update_cart"],
            .woocommerce input[name="update_cart"] {
	            display: none;
            } 
        </style>
    <?php }
}

/**
 * Update cart after change input qty.
 */
add_action('wp_footer', 'cffw_update_cart_after_change_qty');
function cffw_update_cart_after_change_qty() {
    $cffw_cart_auto_update = get_option( 'cffw_cart_auto_update' );
    if($cffw_cart_auto_update == 1){ ?>
        <script>
            var timeout;
            jQuery( function( $ ) {
	            $('.woocommerce').on('change', 'input.qty', function(){
		            if ( timeout !== undefined ) {
			            clearTimeout( timeout );
	    	        }
		            timeout = setTimeout(function() {
			            $("[name='update_cart']").trigger("click");
		            }, 1000 );
	            });
            } );
        </script>
    <?php }
}
?>
