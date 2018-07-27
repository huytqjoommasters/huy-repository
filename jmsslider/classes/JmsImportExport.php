<?php
class JmsImportExport
{
    public function exportSlider($id_slider)
    {
        global $wpdb;
        $_query = "SELECT *  FROM " . $wpdb->prefix . "jms_slider_slides WHERE id_slider = '" . $id_slider . "'";
        $slides = $wpdb->get_results($_query);
        $slider_arr = array();
        $k = 0;
        foreach ($slides as $slide) {
            $slider_arr[$k]["title"] = $slide->title;
            $slider_arr[$k]["params"] = $slide->params;
            $slider_arr[$k]["layers"] = $slide->layers;
            $k++;
        }
        $zip = new ZipArchive();
        $dir = get_home_path() . 'wp-content/plugins/jmsslider/json/';
        $zip_name = 'slide_' . time() . ".zip";
        file_put_contents($dir . "slider.txt", json_encode($slider_arr));
        if ($zip->open($zip_name, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($slides as $slide) {
                $params = json_decode($slide->params);
                $layers = json_decode($slide->layers);
                foreach ($layers as $layer) {
                    if ( $layer->type =='image' && isset($layer->url) ) {
                        $str_arr = explode("/", $layer->url);
                        $date = $str_arr[3] . '/' . $str_arr[4] . '/';
                        $dir_img = get_home_path() . 'wp-content/uploads/'.$date;
                        $file_name = $str_arr[5];
                        $this->addFolderToZip($dir_img, $zip, 'images/uploads/' . $date, $file_name);
                    }
                }
                if( $params->bg_type == "image" && isset($params->bg_image) ) {
                    $str_arr = explode("/", $params->bg_image);
                    $date = $str_arr[3] . '/' . $str_arr[4] . '/';
                    $dir_img = get_home_path() . 'wp-content/uploads/'.$date;
                    $file_name = $str_arr[5];
                    $this->addFolderToZip($dir_img, $zip, 'images/uploads/' . $date, $file_name);
                }
            }
            $this->addFolderToZip($dir, $zip, '', '');
            $zip->close();
            ob_clean();
            header('Content-type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($zip_name) . '"');
            header("Content-Length: ".filesize($zip_name) );
            readfile($zip_name);
            unlink($zip_name);
            file_put_contents($dir . "slider.txt", '');
            exit;
        }
    }

    public function importSlider($file, $id) {
        $destination = wp_upload_dir();
        $destination_path = $destination['path'];
        $unzipfile = unzip_file($destination_path . '/' . $file, $destination_path);
        if (is_wp_error($unzipfile)) {
            //echo 'There was an error unzipping the file.';
            var_dump($unzipfile);
        } else {
            unlink($destination_path . '/' . $file);
            if (file_exists($destination_path . '/images')) {
                $this->full_copy($destination_path . '/images/uploads', WP_CONTENT_DIR . '/uploads');
                $this->deleteDirectory($destination_path . '/images');
            }
            if (file_exists($destination_path . '/slider.txt')) {
                global $wpdb;
                $slides = json_decode(file_get_contents($destination_path . '/slider.txt'));
                foreach ($slides as $slide) {
                    $wpdb->insert(
                        $wpdb->prefix . 'jms_slider_slides',
                        array(
                            'id_slider' => $id,
                            'title' => $slide->title,
                            'params' => $slide->params,
                            'layers' => $slide->layers
                        ),
                        array(
                            '%s'
                        )
                    );
                }
                unlink($destination_path . '/slider.txt');
                echo '<script>
							    setTimeout(function(){ window.location.reload(1); } , 1000);
					        </script>';
            }
        }
    }

    public function addFolderToZip($dir, $zipArchive, $zipdir = '', $file_name = '') {
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {

                //Add the directory
                if (!empty($zipdir)) $zipArchive->addEmptyDir($zipdir);

                // Loop through all the files
                while (($file = readdir($dh)) !== false) {
                    //If it's a folder, run the function again!
                    if (!is_file($dir . $file)) {
                        // Skip parent and root directories
                        if (($file !== ".") && ($file !== "..")) {
                            addFolderToZip($dir . $file . "/", $zipArchive, $zipdir . $file . "/");
                        }
                    } else if ($file_name != '') {
                        // Add the files
                        if ($file == $file_name) {
                            $zipArchive->addFile($dir . $file, $zipdir . $file);
                        }
                    } else {
                        $zipArchive->addFile($dir . $file, $zipdir . $file);
                    }
                }
            }
        }
    }

    public function full_copy($source, $target) {
        if (is_dir($source)) {
            @mkdir($target);
            $d = dir($source);
            while (FALSE !== ($entry = $d->read())) {
                if ($entry == '.' || $entry == '..') {
                    continue;
                }
                $Entry = $source . '/' . $entry;
                if (is_dir($Entry)) {
                    $this->full_copy($Entry, $target . '/' . $entry);
                    continue;
                }
                copy($Entry, $target . '/' . $entry);
            }

            $d->close();
        } else {
            copy($source, $target);
        }
    }

    public function deleteDirectory($dirPath) {
        if (is_dir($dirPath)) {
            $objects = scandir($dirPath);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                        $this->deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
                    } else {
                        unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dirPath);
        }
    }
}