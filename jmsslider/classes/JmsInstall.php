<?php
class JmsInstall {
    public function jmsslider_activate() {
        global $wpdb;
        global $db_version;

        $charset_collate = $wpdb->get_charset_collate();
        $table1 = $wpdb->prefix . 'jms_sliders';
        $table2 = $wpdb->prefix . 'jms_slider_slides';

        $sql1 = "CREATE TABLE IF NOT EXISTS $table1 (
        id_slider int(10) NOT NULL AUTO_INCREMENT,
        title varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        alias varchar(100),
        settings longtext COLLATE utf8_unicode_ci,
        PRIMARY KEY(id_slider)
    ) $charset_collate;";

        $sql2 = "CREATE TABLE IF NOT EXISTS $table2 (
        id_slide int(10) NOT NULL AUTO_INCREMENT,
        id_slider int(10) NOT NULL,
		title varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        slide_order int(10),
        params longtext COLLATE utf8_unicode_ci,
        layers longtext COLLATE utf8_unicode_ci,
        PRIMARY KEY (id_slide, id_slider)
    ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql1 );
        dbDelta( $sql2 );
        add_option("db_version", $db_version);
    }

    function jmsslider_deactivation() {
        global $wpdb;
        $table1 = $wpdb->prefix . 'jms_sliders';
        $table2 = $wpdb->prefix . 'jms_slider_slides';
        $wpdb->query("DROP TABLE IF EXISTS $table1");
        $wpdb->query("DROP TABLE IF EXISTS $table2");
    }
}