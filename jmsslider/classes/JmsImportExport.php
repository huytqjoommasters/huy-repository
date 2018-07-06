<?php

class JmsImportExport {
    public function exportSlider($id_slider) {
        global $wpdb;
        $_query = "SELECT *  FROM " . $wpdb->prefix . "jms_slider_slides WHERE id_slide = '" . $id_slider . "'";
        $slide = $wpdb->get_row($_query);
        $slide_layers = $slide->layers;
        //print_r($slide_layers); exit;
        // Create download file
        ob_clean();
        $slider = $slide->title;
        $filename = str_replace(' ', '_', $slider).'.txt';
        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="'.strtolower($filename).'"');
        $_output = $slide_layers;
        echo $_output;
        exit;
    }
}