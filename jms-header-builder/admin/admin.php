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

    class JmsHeaderBuilder_Admin {

        public function __construct() {
            global $pagenow;
            add_action( 'init', array( $this, 'add_post_type' ) );
            $post_type_current = self::get_post_type();
            if( ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) && $post_type_current == 'jms_header_builder' ) {
                add_action( 'edit_form_after_title', array( $this, 'add_html' ), 999999 );
                add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 99999 );

                if(!function_exists('wp_get_current_user')) {
                    include(ABSPATH . "wp-includes/pluggable.php");
                }
                $current_user = wp_get_current_user();
                // Set screen layout columns
                update_user_meta( $current_user->ID, 'screen_layout_header_builder', 1 );
                add_action( 'save_post_header_builder', array( __CLASS__, 'save_post' ), 10, 1 );
            }
            add_action( 'wp_insert_post', array( $this, 'convert_serialize' ), 9999, 2 );
            add_action( 'admin_menu', array( $this, 'remove_appearance_sub' ));
            add_action( 'wp_enqueue_scripts', array( $this, 'hb_enqueue_scripts' ) );
        }

        public function remove_appearance_sub () {
            global $submenu;
            if ( isset( $submenu[ 'themes.php' ] ) ) {
                foreach ( $submenu[ 'themes.php' ] as $index => $menu_item ) {
                    if ( in_array( 'Header', $menu_item ) ) {
                        unset( $submenu[ 'themes.php' ][$index] );
                    }
                }
            }
        }

        public function add_post_type(){
            $label = array(
                'name'               => __( 'Header', 'jmsheaderbuilder' ),
                'singular_name'      => __( 'Header', 'jmsheaderbuilder' ),
                'menu_name'          => __( 'Header', 'jmsheaderbuilder' ),
                'name_admin_bar'     => __( 'Header', 'jmsheaderbuilder' ),
                'add_new'            => __( 'Add New', 'jmsheaderbuilder' ),
                'add_new_item'       => __( 'Add New header', 'jmsheaderbuilder' ),
                'new_item'           => __( 'New header', 'jmsheaderbuilder' ),
                'edit_item'          => __( 'Edit header', 'jmsheaderbuilder' ),
                'view_item'          => __( 'View header', 'jmsheaderbuilder' ),
                'all_items'          => __( 'Header Builder', 'jmsheaderbuilder' ),
                'search_items'       => __( 'Search header', 'jmsheaderbuilder' ),
                'parent_item_colon'  => __( 'Parent header:', 'jmsheaderbuilder' ),
                'not_found'          => __( 'No header found.', 'jmsheaderbuilder' ),
                'not_found_in_trash' => __( 'No header found in Trash.', 'nitro-toolkit' )
            );
            $arg = array(
                'labels' => $label,
                'public'              => false,
                'show_ui'             => true,
                'capability_type'     => 'post',
                'map_meta_cap'        => true,
                'publicly_queryable'  => false,
                'exclude_from_search' => true,
                'menu_position'       => 59,
                'hierarchical'        => false,
                'rewrite'             => false,
                'query_var'           => false,
                'has_archive'         => true,
                'supports'            => array( 'title' ),
                'show_in_nav_menus'   => false,
                'show_in_admin_bar'   => true,
                'hierarchical'        => true, // Set true for hide excerpt in list
            );
            register_post_type( 'jms_header_builder', $arg );
        }

        public function add_html() {
                require_once JMS_HEADER_BUILDER_INCLUDES_PATH.'layout.php';
        }

        public function admin_enqueue_scripts() {
                wp_enqueue_style( 'jmsheaderbuilder-awesome', JMS_HEADER_BUILDER_CSS_URL . 'font-awesome.css' );
                wp_enqueue_style( 'jmsheaderbuilder-css', JMS_HEADER_BUILDER_CSS_URL . 'header-builder.css' );
                wp_enqueue_style( 'jmsheaderbuilder-bs-css', JMS_HEADER_BUILDER_CSS_URL . 'bootstrap.css' );
                wp_enqueue_style( 'jmsheaderbuilder-bs-theme-css', JMS_HEADER_BUILDER_CSS_URL . 'bootstrap-theme.css' );
                wp_enqueue_script( 'jmsheaderbuilder-admin-js', JMS_HEADER_BUILDER_JS_URL . 'admin.js', array( 'jquery-ui-sortable', 'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery' ) );
                wp_enqueue_script( 'jmsheaderbuilder-bs-js', JMS_HEADER_BUILDER_JS_URL . 'bootstrap.min.js', array( 'jquery' ) );
        }

        public function hb_enqueue_scripts() {
            wp_enqueue_style( 'jmsheaderbuilder-front', JMS_HEADER_BUILDER_CSS_URL . 'front.css' );
        }

        public static function convert_serialize( $post_id, $post ) {
            // Conver JSON to serialize
            if( $post->post_type == 'jms_header_builder' && $post->post_content ) {
                $data_content = json_decode( $post->post_content, true );

                // Check validate is json
                if( phpversion() >= 5.3 && json_last_error() !== 0 ) {
                    return;
                }

                $data_content = serialize( $data_content );

                global $wpdb;

                $wpdb->update(
                    $wpdb->posts,
                    array(
                        'post_content' => $data_content,
                    ),
                    array(
                        'ID' => $post_id,
                    ),
                    array(
                        '%s',
                    )
                );
            }
        }

        public static function get_post_type() {
            global $pagenow;
            $post_type_current = '';

            if( ( $pagenow == 'edit.php' || $pagenow == 'post-new.php' ) && isset( $_GET['post_type'] ) && $_GET['post_type'] == 'jms_header_builder' ) {
                $post_type_current = esc_attr( $_GET['post_type'] );
            } elseif( $pagenow == 'post.php' ) {
                $post_type = get_post_type( isset( $_GET['post'] ) ? $_GET['post'] : 0 );
                if ( 'jms_header_builder' == $post_type ) {
                    $post_type_current = 'jms_header_builder';
                }
            }
            return $post_type_current;
        }


        public static function get_header() {
            if ( is_customize_preview() ) {
                global $wp_customize;
                $theme_options = $wp_customize->unsanitized_post_values();

                if( @count( $theme_options ) ) {
                    foreach ($theme_options as $id){
                        JmsHeaderBuilder_Admin::get_layout_header($id);
                    }
                } else {
                    $them_mod_data = get_theme_mods();
                    $header_id = $them_mod_data["header_layout_setting"];
                    JmsHeaderBuilder_Admin::get_layout_header($header_id);
                }
            } else {
                $them_mod_data = get_theme_mods();
                $header_id = $them_mod_data["header_layout_setting"];
                JmsHeaderBuilder_Admin::get_layout_header($header_id);
            }

        }

        public static function get_layout_header($header_id) {
            $header_obj = get_post($header_id);
            $header_data = unserialize($header_obj->post_content);
                foreach ($header_data as $row ){
                    if( $row['settings']['active'] != 0 ) {
                        ?>
                        <div class="jms-row">
                            <div class="row">
                                <?php
                                foreach ( $row['cols'] as $col ) {
                                    ?>
                                    <div class="<?php echo $col['className']; ?>" >
                                        <?php
                                        foreach ($col['addons'] as $addon) {

                                                 if( $addon['addon_name'] == 'menu' ) {
                                                     $menu = array(
                                                         'theme_location'  => 'primary-menu',
                                                         'container_class' => 'primary-menu-wrapper',
                                                         'menu_class'      => 'addon-menu primary-menu'
                                                     );
                                                     ?>
                                                     <div class="addon-box">
                                                         <?php wp_nav_menu( $menu ); ?>
                                                     </div>
                                                     <?php
                                                 }

                                                if( $addon['addon_name'] == 'search' ) {
                                                     ?>
                                                    <div class="addon-box">
                                                        <?php get_search_form(); ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                }
        }
    }