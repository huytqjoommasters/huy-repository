<?php

    /*
    * Plugin Name: JMS Header Builder
    * Plugin URI: http://joommasters.com
    * Description: Create Header.
    * Version: 1.0.0
    * Author: Joommasters
    * Author URI: http://joommasters.com
    * License:     GPL2
    * License URI: https://www.gnu.org/licenses/gpl-2.0.html
    * Text Domain: jmsheaderbuilder
    */

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    define('JMS_HEADER_BUILDER_PLUGIN_PATH' , plugin_dir_path(__FILE__));
    define('JMS_HEADER_BUILDER_URL', plugin_dir_url(__FILE__));
    define('JMS_HEADER_BUILDER_CSS_URL', JMS_HEADER_BUILDER_URL . 'assets/css/');
    define('JMS_HEADER_BUILDER_JS_URL', JMS_HEADER_BUILDER_URL . 'assets/js/');
    define('JMS_HEADER_BUILDER_ADMIN_PATH' , JMS_HEADER_BUILDER_PLUGIN_PATH . 'admin/');
    define('JMS_HEADER_BUILDER_INCLUDES_PATH' , JMS_HEADER_BUILDER_PLUGIN_PATH . 'includes/');
    define( 'JMS_HEADER_BUILDER_VERSION', '1.0.0' );

    require 'admin/admin.php';
    require 'includes/customize.php';

    register_activation_hook( __FILE__, 'jmsheaderbuilder_activate' );

    function jmsheaderbuilder_activate() {
        return true;
    }

    register_deactivation_hook( __FILE__, 'jmsheaderbuilder_deactivation' );

    function jmsheaderbuilder_deactivation() {
        return true;
    }

    new JmsHeaderBuilder_Admin();
    new JmsHeaderBuilder_Customize();