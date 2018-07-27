<?php
/*
* Plugin Name: Jms Slider Layer
* Plugin URI: http://joommasters.com
* Description: Responsive Wordpress Slider Plugin
* Version: 1.0
* Author: Joommasters
* Author URI: http://joommasters.com
* License:     GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: jmsslider
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define('JMS_SLIDER_PLUGIN_URL', plugin_dir_url(__FILE__));
define('JMS_SLIDER_CSS_URL', JMS_SLIDER_PLUGIN_URL . 'css');
define('JMS_SLIDER_JS_URL', JMS_SLIDER_PLUGIN_URL . 'js');
define('JMS_SLIDER_IMAGES_URL', JMS_SLIDER_PLUGIN_URL . 'images');
define('JMS_SLIDER_PLUGIN_PATH' , plugin_dir_path(__FILE__));
define('JMS_SLIDER_ADMIN_PATH' , JMS_SLIDER_PLUGIN_PATH . 'admin');
function jmsslider_load_textdomain() {
    load_plugin_textdomain( 'jmsslider', false, dirname( plugin_basename(__FILE__) ) . '/languages' );
}
add_action( 'init', 'jmsslider_load_textdomain' );

/**
 *
 * Add menu item to Wordpress Admin
 *
 */
add_action( 'admin_menu', 'jmsslider_admin_menu' );
function jmsslider_admin_menu() {
    add_menu_page('Slider Layer', 'Slider Layer', 'manage_options', 'jmssliderlayer', 'jmsslider_page', '', 98);
}
add_action( 'admin_enqueue_scripts', 'jmsslider_admin_style' );
function jmsslider_admin_style() {
	
    if ( isset($_GET['page']) && ($_GET['page'] == 'jmssliderlayer' || $_GET['page'] == 'setting_slider_styles' )) {
		wp_enqueue_style( 'jms-slider-animate-style', JMS_SLIDER_CSS_URL . '/animate.css' );
        wp_enqueue_style( 'jms-slider-admin-style', JMS_SLIDER_CSS_URL . '/admin.css' );
		wp_enqueue_style('tipsy', JMS_SLIDER_CSS_URL .'/tipsy.css');	
		wp_enqueue_style( 'jms-slider-jqueryui-style', JMS_SLIDER_CSS_URL . '/jquery-ui.css' );		
		if(file_exists(get_template_directory().'/assets/css/jmsslider/style.css')) {			
			wp_register_style( 'fractionsliderStyle', get_template_directory_uri().'/assets/css/jmsslider/style.css');
		} else {
			wp_register_style( 'fractionsliderStyle', JMS_SLIDER_CSS_URL.'/style.css');
		}	
		wp_enqueue_style('fractionsliderStyle');
		
    }
    // Add the color picker css file       
	wp_enqueue_style( 'jquery-ui' ); 
    wp_enqueue_style( 'wp-color-picker' ); 
}

add_action( 'admin_enqueue_scripts', 'jmsslider_admin_script' );
function jmsslider_admin_script($hook) {
	if ( isset($_GET['page']) && ($_GET['page'] == 'jmssliderlayer' || $_GET['page'] == 'setting_slider_styles' )) {
		wp_enqueue_media();
		wp_enqueue_script('tipsy', JMS_SLIDER_JS_URL .'/jquery.tipsy.js');
		wp_enqueue_script( 'jmss-lider-admin-script', JMS_SLIDER_JS_URL . '/admin.js', array(
				'jquery',
				'jquery-ui-core',
				'wp-color-picker',
				'jquery-ui-sortable',
				'jquery-ui-resizable',
				'jquery-ui-accordion',
				'tipsy')
			, false, true  );
		if(isset($_GET['task']) && $_GET['task'] == 'layers') {
			wp_register_script( 'fractionsliderJs', JMS_SLIDER_JS_URL.'/jquery.fractionslider.min.js' , array ('jquery'), '1.0.0', true);
			wp_enqueue_script('fractionsliderJs');
		}		
	}		
}
/**
 *
 * Add shortcode
 *
 */
function jmsslider_shortcode($args) {
	extract(shortcode_atts(array('alias' => ''), $args, 'jmsslider'));		
    wp_register_script( 'fractionsliderJs',plugins_url('js/jquery.fractionslider.min.js', __FILE__) , array ('jquery'), '1.0.0', true);
    wp_enqueue_script('fractionsliderJs');
    
    wp_register_style( 'jms-slider-fraction-style',plugins_url("css/fractionslider.css", __FILE__));
    wp_enqueue_style('jms-slider-fraction-style');

    wp_register_style( 'jms-slider-front-style',plugins_url("css/style.css", __FILE__));
    wp_enqueue_style('jms-slider-style');
    require_once 'views/slider-frontend-html.php';
}
add_shortcode( 'jmsslider', 'jmsslider_shortcode' );
/**
 *
 * Save order slider
 *
 */
function jmsslider_save_order() {
    global $wpdb;
	$data_post = isset( $_POST['data'] ) ? wp_unslash ( $_POST['data'] ) : NULL;
	$slides = explode(",", $data_post);
	$_index = 0;
	foreach($slides as $slide_id) {
		$update_slide = $wpdb->update(
			$wpdb->prefix . 'jms_slider_slides',
			array( 						
				'slide_order'     => $_index
			),
			array( 'id_slide' => $slide_id ), 
			array( 						
				'%d'
			),
			array( '%d' )	
		);
		$_index++;
	}
	exit( json_encode( array( 'status' => 'true' ) ) ) ;
}
add_action('wp_ajax_jmsslider_save_order', 'jmsslider_save_order');
/**
 *
 * Load template jms slider page
 *
 */
ob_start();
error_reporting(0);
function jmsslider_page() {
    if ( isset( $_GET["task"] ) ) {
        $task = sanitize_text_field( $_GET["task"] );
    } else {
        $task = '';
    }
    if ( isset( $_GET['id'] ) ) {
        $id = absint( $_GET['id'] );
    } else {
        $id = 0;
    }
    include_once 'classes/JmsSlider.php';
    include_once 'classes/JmsSlide.php';
    switch ( $task ) {
        case 'add_slider':
            if ( ! isset( $_GET['new_slider_nonce'] ) || ! wp_verify_nonce( $_GET['new_slider_nonce'], 'new_slider' ) ) {
                die( 'Security check failure.' );
            }
            require 'admin/edit_slider.php';
            break;
        case 'edit_slider':
            if ( ! isset( $_GET['edit_slider_nonce'] ) ) {
                die( 'Security check failure.' );
            }
            if( isset( $_GET['id_slide'] ) ) {
                if(  wp_verify_nonce( $_GET['edit_slider_nonce'], 'delete_slide_' . $_GET['id_slide'] ) ) {
                    $id_slide = $_GET['id_slide'];
                    $slide = new JmsSlide();
                    $slide->deleteSlide($id_slide);
                }
            }
            require 'admin/edit_slider.php';
            break;
        case 'remove_slider':
            if ( ! isset( $_GET['remove_slider_nonce'] ) || ! wp_verify_nonce( $_GET['remove_slider_nonce'], 'delete_slider_' . $id ) ) {
                die( 'Security check failure.' );
            }
            $del = new JmsSlider();
            $del->deleteSlider($id);
            require 'admin/list_slider.php';
            break;
        case 'add_slide':
			if ( ! isset( $_GET['new_slide_nonce'] ) || ! wp_verify_nonce( $_GET['new_slide_nonce'], 'new_slide' ) ) {
                die( 'Security check failure.' );
            }
            require 'admin/edit_slide.php';
            break;
        case 'edit_slide':
            if ( !isset( $_GET['edit_slide_nonce'] ) || ! wp_verify_nonce( $_GET['edit_slide_nonce'], 'edit_slide_' . $id ) ) {
                die( 'Security check failure' );
            }
            require 'admin/edit_slide.php';
            break;
        case 'layers':
			if ( !isset( $_GET['layers_nonce'] ) || ! wp_verify_nonce( $_GET['layers_nonce'], 'layers_' . $id ) ) {
                die( 'Security check failure' );
            }
			require 'admin/layers.php';
            break;
        case 'export_slider':
            if ( !isset( $_GET['export_nonce'] ) || ! wp_verify_nonce( $_GET['export_nonce'], 'export_' . $id ) ) {
                die( 'Security check failure' );
            }
            include_once 'classes/JmsImportExport.php';
            $export = new JmsImportExport();
            $export->exportSlider($_GET['id']);
            break;
		case 'import_slider':
            if ( !isset( $_GET['import_nonce'] ) || ! wp_verify_nonce( $_GET['import_nonce'], 'import_' . $id ) ) {
                die( 'Security check failure' );
            }
            include_once 'classes/JmsImportExport.php';
            require 'admin/import_slider.php';
            break;
        default:
            require 'admin/list_slider.php';
            break;
    }
}
/**
 *
 * Create custom database table on plugin activation.
 *
 */
include_once 'classes/JmsInStall.php';
register_activation_hook( __FILE__, array('JmsInstall' , 'jmsslider_activate') );
register_deactivation_hook(__FILE__, array('JmsInstall' , 'jmsslider_deactivation') );