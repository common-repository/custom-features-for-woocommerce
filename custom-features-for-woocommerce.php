<?php
/**
 * @package CustomFeaturesForWooCommerce
 * 
 * Plugin Name: Custom Features for WooCommerce
 * Plugin URI: htpps://techsometimes.com
 * Description: A plugin of some custom features for your WooCommerce site.
 * Version: 1.0.0
 * Author: Md. Amdadul Haque
 * Author URI: https://techsometimes.com
 * Licence: GPLv2 or Later 
 * Text Domain: custom-features-for-woocommerce
 */

/** 
  * Require files
  */
require_once( plugin_dir_path( __FILE__) . 'includes/store-close.php');
require_once( plugin_dir_path( __FILE__) . 'includes/cart-update.php');

/**
 * Load jQuery datepicker.
 */
add_action( 'admin_enqueue_scripts', 'cffw_enqueue_datepicker' );
function cffw_enqueue_datepicker() {
    // Load the datepicker script.
    wp_enqueue_script( 'jquery-ui-datepicker' );
    // Attached jQuery UI css
    wp_enqueue_style('jquery-ui-css', plugin_dir_url(__FILE__) . '/css/jquery-ui.css');
}

/**
 * Register an admin menu and add a page on this menu
 */

add_action('admin_menu', 'cffw_menu');
function cffw_menu() {
    add_menu_page(
        __( 'Custom Features for WooCommerce', 'custom-features-for-woocommerce' ), // page title
        __( 'Custom Features for WC', 'custom-features-for-woocommerce' ), // menu link text
        'manage_options', // capability to access the page
        'custom-features-for-woocommerce', // page URL slug
        'cffw_page_content', // callback function / show content
        'dashicons-image-filter', // menu icon
        59 // priority
    );
}

/**
 * Function for display the content
 */
function cffw_page_content() { 
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    //Get the active tab from the $_GET param
    $default_tab = null;
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;?>
    <!-- admin page content all inside .wrap -->
    <div class="wrap">
        <!-- Print the page title -->
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <!-- Here are our tabs -->
        <nav class="nav-tab-wrapper">
            <a href="?page=custom-features-for-woocommerce" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Store close</a>
            <a href="?page=custom-features-for-woocommerce&tab=cart-auto-update" class="nav-tab <?php if($tab==='cart-auto-update'):?>nav-tab-active<?php endif; ?>">Cart auto update</a>
        </nav>
        <div class="tab-content">
            <?php switch($tab) :
            case 'cart-auto-update':
            // cart update
            ?>
            <form action="options.php" method="post">
                <?php
                settings_fields( 'cffw_cart_update_settings' ); // settings group name
                do_settings_sections( 'cffw_cart_update' ); // just a page slug
                submit_button();
                ?>
            </form>
            <?php
                break;
            default:
            // store close
            ?>
            <form action="options.php" method="post">
                <?php
                settings_fields( 'cffw_store_close_settings' );
                do_settings_sections( 'cffw_store_close' );
                submit_button();
                ?>
            </form>
            <?php
                break;
            endswitch; ?>
        </div>
    </div>
<?php
}

/**
 *  Register setting and create field
 */
add_action( 'admin_init', 'cffw_register_settings' );
function cffw_register_settings() {
    // registet setting for store close
    register_setting(
        'cffw_store_close_settings', // settings group name
        'cffw_store_close_status' // option name
    );
    register_setting(
        'cffw_store_close_settings',
        'cffw_store_close_message',
        'sanitize_textarea_field' // sanitization function
    );
    register_setting(
        'cffw_store_close_settings',
        'cffw_store_close_still_date',
        'sanitize_text_field'
    );
    // register setting for cart update
    register_setting(
		'cffw_cart_update_settings',
		'cffw_cart_auto_update'
    );
    // add setting section for store close
    add_settings_section(
        'cffw_store_close_settings_section_id', // section ID
        'Store open-close settings', // title (if needed)
        'cffw_store_close_section_text', // callback function (if needed)
        'cffw_store_close' // page slug
    );
    // add setting section for cart update
    add_settings_section(
        'cffw_cart_update_settings_section_id',
        'Cart Update Settings',
        'cffw_cart_update_section_text',
        'cffw_cart_update'
    );
    // add setting field for store close
    add_settings_field(
        'cffw_store_close_status', // option name
        'Store Close?', // title
        'cffw_store_close_status_html', // function which prints the field
        'cffw_store_close', // page slug
        'cffw_store_close_settings_section_id', // section ID
        array(
            'label_for' => 'cffw_store_close_status',
        )
     );
     add_settings_field(
        'cffw_store_close_message',
        'Store Close Message',
        'cffw_store_close_message_html',
        'cffw_store_close',
        'cffw_store_close_settings_section_id',
        array(
            'label_for' => 'cffw_store_close_message',
        )
     );
     add_settings_field(
        'cffw_store_close_still_date',
        'Store Close Still Date',
        'cffw_store_close_still_date_html',
        'cffw_store_close',
        'cffw_store_close_settings_section_id',
        array(
            'label_for' => 'cffw_store_close_still_date',
        )
     );
    // add setting field for cart update
    add_settings_field(
		'cffw_cart_auto_update',
		'Cart Auto Update',
		'cffw_cart_auto_update_html',
		'cffw_cart_update',
		'cffw_cart_update_settings_section_id',
		array( 
			'label_for' => 'cffw_cart_auto_update'
		)
	);
}

/**
 * Plugin action links
 */
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'cffw_action_links' );
 
function cffw_action_links( $actions ) {
   $actions[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=custom-features-for-woocommerce') ) .'">Settings</a>';
   return $actions;
}

/**
 * Plugin row meta
 */
add_filter( 'plugin_row_meta', 'cffw_row_meta_links', 10, 4 );
function cffw_row_meta_links( $links_array, $plugin_file_name, $plugin_data, $status ) {
    if ( strpos( $plugin_file_name, basename(__FILE__) ) ) {
        $links_array[] = '<a href="https://techsometimes.com" target="_blank">More plugins by Techsometimes</a>';
    }
    return $links_array;
}

/**
 * Admin notices
 */
add_action( 'admin_notices', 'cffw_admin_notice' );
function cffw_admin_notice()
{
    //get the current screen
    $screen = get_current_screen();
    //return if not plugin settings page 
    if ( $screen->id !== 'toplevel_page_custom-features-for-woocommerce') return;

    // also check the page
    global $pagenow; 
    if ( $pagenow == 'admin.php' ) { 
        //Checks if settings updated 
        if ( isset( $_GET['settings-updated'] ) ) {
            //if settings updated successfully 
            if ( 'true' === $_GET['settings-updated'] ) : ?>
                <div class="notice notice-success is-dismissible">
                    <p><strong><?php _e('Settings saved.', 'custom-features-for-woocommerce') ?></strong></p>
                </div>
            <?php else : ?>
                <div class="notice notice-warning is-dismissible">
                    <p><?php _e('Sorry, I can not go through this.', 'custom-features-for-woocommerce') ?></p>
                </div>
            <?php endif;
        }
    }
}
?>
