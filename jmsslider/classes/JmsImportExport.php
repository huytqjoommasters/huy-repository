<?php

class JmsImportExport {
    public function exportSlider($id_slider) {
        global $wpdb;
        $_query = "SELECT *  FROM " . $wpdb->prefix . "jms_slider_slides WHERE id_slide = '" . $id_slider . "'";
        $slide = $wpdb->get_row($_query);
        $slide_layers = json_decode($slide->layers);
        $slide_params = $slide->params;

        $zip = new ZipArchive();
        $dir = get_home_path() . 'wp-content/plugins/jmsslider/json/';
        $dir_img = get_home_path() . 'wp-content/uploads/2018/05/';
        $zip_name = 'slide_' . time().".zip";
        file_put_contents($dir."slider.txt",$slide->layers );
        if( $zip->open($zip_name, ZIPARCHIVE::CREATE)=== TRUE) {
            foreach ( $slide_layers as $layer) {
                if( $layer->type == 'image' ) {
                    $str_arr = explode("/",$layer->url);
                    $date = $str_arr[3].'/'.$str_arr[4].'/';
                    $file_name = $str_arr[5];
                    $this->addFolderToZip($dir_img,$zip, 'images/uploads/'.$date, $file_name);
                }
            }
            $this->addFolderToZip($dir,$zip,'', '');
            $zip->close();
            ob_clean();
            header('Content-type: application/zip');
            header('Content-Disposition: attachment; filename="'.$zip_name.'"');
            readfile($zip_name);
            unlink($zip_name);
        }
        file_put_contents($dir."slider.txt", '' );
    }

    public function addFolderToZip($dir, $zipArchive, $zipdir = '', $file_name = ''){
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {

                //Add the directory
                if(!empty($zipdir)) $zipArchive->addEmptyDir($zipdir);

                // Loop through all the files
                while (($file = readdir($dh)) !== false ) {
                    //If it's a folder, run the function again!
                    if(!is_file($dir . $file)){
                        // Skip parent and root directories
                        if( ($file !== ".") && ($file !== "..") ){
                            addFolderToZip($dir . $file . "/", $zipArchive, $zipdir . $file . "/");
                        }
                    } else if( $file_name != '' ) {
                        // Add the files
                        if($file == $file_name ) {
                            $zipArchive->addFile($dir . $file, $zipdir . $file);
                        }
                    } else {
                        $zipArchive->addFile($dir . $file, $zipdir . $file);
                    }
                }
            }
        }
    }
}