<?php
/**
 * Created by PhpStorm.
 * User: Tran Huy
 * Date: 5/3/2018
 * Time: 2:20 PM
 */

class JmsHeaderBuilder_Customize {
    public function __construct() {
        add_action( 'customize_register', array( $this, 'header_customize' ) );
    }
    public function header_customize($wp_customize ) {
        $theme_options = null;

        // Get all headers.
        $list_header = new WP_Query( array(
            'posts_per_page' => -1,
            'post_type'      => 'jms_header_builder',
            'post_status'    => 'publish',
            'suppress_filters' => true,
        ));

        $header_layout = array();

        // Set to normal headers default
        if ( $list_header->post_count ) {
            foreach( $list_header->posts as $val ){
                $header_layout[ $val->ID ] = $val->post_title;
            }
        };
        $wp_customize->add_section( 'header_layout' , array(
            'title'    => __( 'Header', 'starter' ),
            'priority' => 30
        ) );

        $wp_customize->add_setting( 'header_layout_setting' , array(
            'default'           => 0,
            'sanitize_callback' => '',
        ) );

        $wp_customize->add_control( header_layout_setting , array(
            'label'          => __( 'Dark or light theme version?', 'theme_name' ),
            'section'        => 'header_layout',
            'settings'       => 'header_layout_setting',
            'type'           => 'select',
            'choices'        => $header_layout
        ) );
    }
}