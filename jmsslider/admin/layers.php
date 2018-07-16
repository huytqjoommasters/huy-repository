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
*/

if (!defined('ABSPATH')) {
    exit;
}
global $wpdb;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = 0;
}
$_query = "SELECT *  FROM " . $wpdb->prefix . "jms_slider_slides WHERE id_slide = '" . $id . "'";
$slide = $wpdb->get_row($_query);
$slide_params = $slide->params;
$_params = json_decode($slide_params);
$class = $_params->class;
$bg_type = $_params->bg_type;
$bg_color = $_params->bg_color;
$bg_image = $_params->bg_image;
$_query = "SELECT *  FROM " . $wpdb->prefix . "jms_sliders WHERE id_slider = '" . $slide->id_slider . "'";
$slider = $wpdb->get_row($_query);
$slider_settings = $slider->settings;
$_settings = json_decode($slider_settings, true);
$_width = $_settings['max_width'];
$_height = $_settings['max_height'];
$data = $slide->layers;
$layers = is_string($data) ? json_decode($data, true) : $data;
$list_slide_safe_link = wp_nonce_url('admin.php?page=jmssliderlayer&task=list_slides&id=' . esc_html($slide->id_slider), 'list_slides_' . $slide->id_slider, 'list_slides_nonce');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES) && $_FILES["zip_file"] != null ) {
        if ($_FILES["zip_file"]["error"] > 0) {
            echo "Error: " . $_FILES["zip_file"]["error"] . "<br />";
        } else {
            if( $_FILES["zip_file"]["type"] == 'application/x-zip-compressed' ) {
                /*$target_file = get_home_path().'wp-content/plugins/jmsslider/json/';
                move_uploaded_file($_FILES["zip_file"]["tmp_name"], $target_file.$_FILES["zip_file"]["name"]);*/
                $id_slide = $_POST['id_slide'];
                $overrides = array( 'test_form' => false, 'test_type' => false );
                wp_handle_upload( $_FILES["zip_file"], $overrides );

                WP_Filesystem();
                $destination = wp_upload_dir();
                $destination_path = $destination['path'];

                $unzipfile = unzip_file( $destination_path.'/'.$_FILES["zip_file"]["name"], $destination_path);
                unlink($destination_path.'/'.$_FILES["zip_file"]["name"]);
                if ( is_wp_error( $unzipfile ) ) {
                    echo 'There was an error unzipping the file.';
                } else {
                    if( file_exists($destination_path.'/images') ) {
                        full_copy($destination_path.'/images/uploads', WP_CONTENT_DIR.'/uploads');
                        deleteDirectory($destination_path.'/images');
                    }
                    if( file_exists($destination_path.'/slider.txt') ) {
                        $layersjson = file_get_contents($destination_path.'/slider.txt');
                        if ( $layersjson != $data ) {
                            $update_slide = $wpdb->update(
                                $wpdb->prefix . 'jms_slider_slides',
                                array(
                                    'layers' => $layersjson
                                ),
                                array('id_slide' => $id),
                                array(
                                    '%s'
                                ),
                                array('%d')
                            );
                            if ($update_slide) {
                                echo '<div class="updated"><p><strong>';
                                echo esc_html_e('The slide layers was imported successfully', 'jmsslider') . '.</strong></p></div>';
                                echo '<script>
							setTimeout(function(){ window.location.reload(1); } , 3000);
					  </script>';
                            } else {
                                echo '<div id="message" class="error"><p>';
                                echo esc_html_e('Error in update process', 'jmsslider') . '.</p></div>';
                            }
                        } else {
                            echo '<div id="message" class="error"><p>';
                            echo esc_html_e('Data is same', 'jmsslider') . '!</p></div>';
                        }
                        unlink($destination_path.'/slider.txt');
                    }
                }
            }
        }
    } else {
        $id_slide = $_POST['id_slide'];
        $layersjson = stripslashes_deep($_POST['layersjson']);
        $slidejson = stripslashes_deep($_POST['slidejson']);
        $slidetitle = stripslashes_deep($_POST['slidetitle']);
        if ($layersjson != $data || $slidejson != $slide->params) {
            $update_slide = $wpdb->update(
                $wpdb->prefix . 'jms_slider_slides',
                array(
                    'title' => $slidetitle,
                    'params' => $slidejson,
                    'layers' => $layersjson
                ),
                array('id_slide' => $id_slide),
                array(
                    '%s'
                ),
                array('%d')
            );
            if ($update_slide) {
                echo '<div class="updated"><p><strong>';
                echo esc_html_e('The slide layers was updated successfully', 'jmsslider') . '.</strong></p></div>';
                echo '<script>
							setTimeout(function(){ window.location.reload(1); } , 3000);
					  </script>';
            } else {
                echo '<div id="message" class="error"><p>';
                echo esc_html_e('Error in update process', 'jmsslider') . '.</p></div>';
            }
        } else {
            echo '<div id="message" class="error"><p>';
            echo esc_html_e('Data is same', 'jmsslider') . '!</p></div>';
        }
    }
}

function full_copy( $source, $target ) {
    if ( is_dir( $source ) ) {
        @mkdir( $target );
        $d = dir( $source );
        while ( FALSE !== ( $entry = $d->read() ) ) {
            if ( $entry == '.' || $entry == '..' ) {
                continue;
            }
            $Entry = $source . '/' . $entry;
            if ( is_dir( $Entry ) ) {
                full_copy( $Entry, $target . '/' . $entry );
                continue;
            }
            copy( $Entry, $target . '/' . $entry );
        }

        $d->close();
    }else {
        copy( $source, $target );
    }
}

function deleteDirectory($dirPath) {
    if (is_dir($dirPath)) {
        $objects = scandir($dirPath);
        foreach ($objects as $object) {
            if ($object != "." && $object !="..") {
                if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                    deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
                } else {
                    unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                }
            }
        }
        reset($objects);
        rmdir($dirPath);
    }
}
?>
<div class="wrap jmsslider">
    <h2><?php echo esc_html_e('Edit Slide', 'jmsslider'); ?>
        <a href="<?php echo $list_slide_safe_link; ?>"
           class="btn pull-right"><?php echo esc_html_e('Back to Slides List', 'jmsslider'); ?></a>
    </h2>
    <?php
    if ($id) {
        $json = $slide->params;
        $j_setting = json_decode($json);
        $class = $j_setting->class;
        $slide_link = isset($j_setting->slide_link) ? $j_setting->slide_link : '';
        $bg_type = isset($j_setting->bg_type) ? $j_setting->bg_type : '';
        $bg_color = isset($j_setting->bg_color) ? $j_setting->bg_color : '';
        $bg_image = isset($j_setting->bg_image) ? $j_setting->bg_image : '';
    }
    ?>
    <div class="edit-form jmsslider-setting">
        <div class="option-block col-5">
            <h3><?php echo esc_html_e('General', 'jmsslider'); ?></h3>
            <div class="slide-title">
                <label for="bg_type"><?php echo esc_html_e('Slide Title', 'jmsslider'); ?></label>
                <input type="text" name="title" value="<?php if (!empty($slide->title)) {
                    echo $slide->title;
                } else {
                    echo 'New slide';
                } ?>" placeholder="<?php echo esc_html_e('Enter your Slide Name here', 'jmsslider'); ?>"
                       autofocus="autofocus">
            </div>
            <div class="row-input">
                <label for="bg_type"><?php echo esc_html_e('Slide Class Suffix', 'jmsslider'); ?></label>
                <input type="text" name="class" value="<?php if (!empty($class)) {
                    echo $class;
                } else {
                    echo '';
                } ?>" placeholder="<?php echo esc_html_e('Enter your Slide Class here', 'jmsslider'); ?>"/>
            </div>
            <div class="row-input">
                <label for="bg_type"><?php echo esc_html_e('Slide Link', 'jmsslider'); ?></label>
                <input type="text" name="slide_link" value="<?php if (isset($slide_link) && !empty($slide_link)) {
                    echo $slide_link;
                } else {
                    echo '#';
                } ?>" placeholder="<?php echo esc_html_e('Enter your Slide Link here', 'jmsslider'); ?>"/>
            </div>
        </div>
        <div class="option-block col-5">
            <h3><?php echo esc_html_e('Background', 'jmsslider'); ?></h3>
            <div class="row-input image">
                <label for="bg_type"><?php echo esc_html_e('Background Image', 'jmsslider'); ?></label>
                <input type="radio" id="bg_image" name="bg_type" value="image"
                       <?php if (isset($bg_type) && $bg_type == 'image') { ?>checked="checked"<?php } ?> > <?php echo esc_html_e('Image', 'jmsslider'); ?>
                <input type="hidden" id="image_url" name="bg_image"
                       value="<?php if (isset($bg_type) && !empty($bg_image)) {
                           echo $bg_image;
                       } ?>">
                <button id="pick_images" class="button"><?php echo esc_html_e('Select Images', 'jmsslider'); ?></button>
            </div>
            <div class="row-input">
                <label for="bg_type"><?php echo esc_html_e('Background Color', 'jmsslider'); ?></label>
                <input type="radio" id="bg_color" name="bg_type" value="color"
                       <?php if (isset($bg_type) && $bg_type == 'color') { ?>checked="checked"<?php } ?>> <?php echo esc_html_e('Color', 'jmsslider'); ?>
                <input style="display:inline-block;" type="text" class="pick_color" name="bg_color" id="bg_color"
                       value="<?php if (isset($bg_color) && !empty($bg_color)) {
                           echo $bg_color;
                       } ?>" data-default-color="#ffffff">
            </div>
        </div>
    </div>
</div>
<div class="wrap layer-manager jmsslider">
    <h2><?php echo esc_html_e('Layers Manager', 'jmsslider'); ?>
        <a href="<?php echo $list_slide_safe_link; ?>"
           class="btn pull-right"><?php echo esc_html_e('Back to Slides List', 'jmsslider'); ?></a>
    </h2>
    <?php
    $layers_safe_link = wp_nonce_url('admin.php?page=jmssliderlayer&task=export_slide&id=' . esc_html($slide->id_slide), 'export_' . $slide->id_slide, 'export_nonce');
    ?>
    <div class="import-export">
        <div class="export-wrapper">
            <a href="<?php echo $layers_safe_link; ?>" class="button" title="<?php echo esc_html_e('Export slider', 'jmsslider'); ?>">
                <i class="dashicons dashicons-download"></i>
            </a>
        </div>
        <div class="import-wrapper">
            <a href="#" class="button" title="<?php echo esc_html_e('Import slider', 'jmsslider'); ?>">
                <i class="dashicons dashicons-upload"></i>
            </a>
            <form method="post" action="" enctype="multipart/form-data" name="importtForm" id="importtForm">
                <input type="file" name="zip_file">
                <input type="submit" value="upload" class="button">
            </form>
        </div>
    </div>
    <?php
    $transitions = array(
        0 => array('id' => 'none', 'name' => 'none'),
        1 => array('id' => 'fade', 'name' => 'Fade'),
        2 => array('id' => 'left', 'name' => 'Left'),
        3 => array('id' => 'right', 'name' => 'Right'),
        4 => array('id' => 'top', 'name' => 'Top'),
        5 => array('id' => 'bottom', 'name' => 'Bottom'),
        6 => array('id' => 'topLeft', 'name' => 'Top Left'),
        7 => array('id' => 'bottomLeft', 'name' => 'Bottom Left'),
        8 => array('id' => 'topRight', 'name' => 'Top Right'),
        9 => array('id' => 'bottomRight', 'name' => 'Bottom Right'),
    );
    $transforms = array(
        0 => array('id' => 'bounce'),
        1 => array('id' => 'flash'),
        2 => array('id' => 'pulse'),
        3 => array('id' => 'rubberBand'),
        4 => array('id' => 'shake'),
        5 => array('id' => 'swing'),
        6 => array('id' => 'tada'),
        7 => array('id' => 'wobble'),
        8 => array('id' => 'jello'),
        9 => array('id' => 'bounceIn'),
        10 => array('id' => 'bounceInDown'),
        11 => array('id' => 'bounceInLeft'),
        12 => array('id' => 'bounceInRight'),
        13 => array('id' => 'bounceInUp'),
        14 => array('id' => 'bounceOut'),
        15 => array('id' => 'bounceOutDown'),
        16 => array('id' => 'bounceOutLeft'),
        17 => array('id' => 'bounceOutRight'),
        18 => array('id' => 'bounceOutUp'),
        19 => array('id' => 'fadeIn'),
        20 => array('id' => 'fadeInDown'),
        21 => array('id' => 'fadeInDownBig'),
        22 => array('id' => 'fadeInLeft'),
        23 => array('id' => 'fadeInLeftBig'),
        24 => array('id' => 'fadeInRight'),
        25 => array('id' => 'fadeInRightBig'),
        26 => array('id' => 'fadeInUp'),
        27 => array('id' => 'fadeInUpBig'),
        28 => array('id' => 'fadeOut'),
        29 => array('id' => 'fadeOutDown'),
        30 => array('id' => 'fadeOutDownBig'),
        31 => array('id' => 'fadeOutLeft'),
        32 => array('id' => 'fadeOutLeftBig'),
        33 => array('id' => 'fadeOutRight'),
        34 => array('id' => 'fadeOutRightBig'),
        35 => array('id' => 'fadeOutUp'),
        36 => array('id' => 'fadeOutUpBig'),
        37 => array('id' => 'flip'),
        38 => array('id' => 'flipInX'),
        39 => array('id' => 'flipInY'),
        40 => array('id' => 'flipOutX'),
        41 => array('id' => 'flipOutY'),
        42 => array('id' => 'lightSpeedIn'),
        43 => array('id' => 'lightSpeedOut'),
        44 => array('id' => 'rotateIn'),
        45 => array('id' => 'rotateInDownLeft'),
        46 => array('id' => 'rotateInDownRight'),
        47 => array('id' => 'rotateInUpLeft'),
        48 => array('id' => 'rotateInUpRight'),
        49 => array('id' => 'rotateOut'),
        50 => array('id' => 'rotateOutDownLeft'),
        51 => array('id' => 'rotateOutDownRight'),
        52 => array('id' => 'rotateOutUpLeft'),
        53 => array('id' => 'rotateOutUpRight'),
        54 => array('id' => 'slideInUp'),
        55 => array('id' => 'slideInDown'),
        56 => array('id' => 'slideInLeft'),
        57 => array('id' => 'slideInRight'),
        58 => array('id' => 'slideOutUp'),
        59 => array('id' => 'slideOutDown'),
        60 => array('id' => 'slideOutLeft'),
        61 => array('id' => 'slideOutRight'),
        62 => array('id' => 'zoomIn'),
        63 => array('id' => 'zoomInDown'),
        64 => array('id' => 'zoomInLeft'),
        65 => array('id' => 'zoomInRight'),
        66 => array('id' => 'zoomInUp'),
        67 => array('id' => 'zoomOut'),
        68 => array('id' => 'zoomOutDown'),
        69 => array('id' => 'zoomOutLeft'),
        70 => array('id' => 'zoomOutRight'),
        71 => array('id' => 'zoomOutUp'),
        72 => array('id' => 'hinge'),
        73 => array('id' => 'jackInTheBox'),
        74 => array('id' => 'rollIn'),
        75 => array('id' => 'rollOut')
    );
    ?>
    <div class="area-display">
        <div class="layerconfig layer-col">
            <div class="inner">
                <div class="responsive-list-wrapper">
                    <ul class="responsive-list">
                        <li id="desktop" class="item button desktop active"
                            title="<?php echo esc_html_e('Style on Desktop', 'jmsslider'); ?>"><i
                                    class="dashicons dashicons-desktop"></i></li>
                        <li id="tablet" class="item button tablet"
                            title="<?php echo esc_html_e('Style on Tablet', 'jmsslider'); ?>"><i
                                    class="dashicons dashicons-tablet"></i></li>
                        <li id="mobile" class="item button mobile"
                            title="<?php echo esc_html_e('Style on Mobile', 'jmsslider'); ?>"><i
                                    class="dashicons dashicons-smartphone"></i></li>
                    </ul>
                </div>
                <div class="tab">
                    <button class="tablinks" onclick="openCity(event, 'tab_setting')"
                            id="defaultOpen"><?php echo esc_html_e('Layer Setting', 'jmsslider'); ?></button>
                    <button class="tablinks tab-responsive tab-desktop"
                            onclick="openCity(event, 'tab_style_desktop')"><?php echo esc_html_e('Style', 'jmsslider'); ?></button>
                    <button class="tablinks"
                            onclick="openCity(event, 'tab_position')"><?php echo esc_html_e('Position', 'jmsslider'); ?></button>
                    <button class="tablinks"
                            onclick="openCity(event, 'tab_animation')"><?php echo esc_html_e('Animation', 'jmsslider'); ?></button>
                    <button class="tablinks video-settings"
                            onclick="openCity(event, 'tab_video_set')"><?php echo esc_html_e('Video Layer Setting', 'jmsslider'); ?></button>
                    <button class="tablinks tab-responsive tab-tablet"
                            onclick="openCity(event, 'tab_style_tablet')"><?php echo esc_html_e('Style Tablet < 992', 'jmsslider'); ?></button>
                    <button class="tablinks tab-responsive tab-mobile"
                            onclick="openCity(event, 'tab_style_mobile')"><?php echo esc_html_e('Style Moblie < 481', 'jmsslider'); ?></button>
                </div>
                <div id="tab_setting" class="tabcontent row">
                    <div class="col-2-10">
                        <div class="field-box">
                            <label for=""><?php echo esc_html_e('Title', 'jmsslider'); ?></label>
                            <input type="text" name="title" id="layer_title" class="layer-data" value="">
                        </div>
                    </div>
                    <div class="col-2-10">
                        <div class="field-box">
                            <label for=""><?php echo esc_html_e('Extra Class', 'jmsslider'); ?>
                                <div class="tooltip">
                                    <?php echo esc_html_e('Add Extra CLass for layer when you want to style for layer, add css style in style.css file', 'jmsslider'); ?>
                                </div>
                            </label>
                            <input type="text" name="class" id="layer_class" class="layer-data" value="">
                        </div>
                    </div>
                    <div class="col-2-10">
                        <div class="field-box linkurl">
                            <label for=""><?php echo esc_html_e('Link Url', 'jmsslider'); ?></label>
                            <input type="text" name="link" id="layer_link" class="layer-data" value="#"/>
                        </div>
                    </div>
                </div>
                <div id="tab_style_desktop" class="tabcontent responsive-tab row">
                    <div class="field-box">
                        <label>
                            <i class="icon-colortext icon-slider" title="Text color"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Font Color', 'jmsslider'); ?></div>
                        </label>
                        <input class="layer-data color-picker" id="layer_textcolor" name="textcolor" type="text"
                               value=""/>
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-fontsize icon-slider" title="Font size"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Font Size', 'jmsslider'); ?></div>
                        </label>
                        <input name="fontsize" id="layer_fontsize" class="layer-data" value="20" type="number"> px
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-letterspacing icon-slider" title="Letter Spacing"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Letter Spacing', 'jmsslider'); ?></div>
                        </label>
                        <input name="letterspacing" id="layer_letterspacing" class="layer-data" value="0" min="0"
                               max="10" step="0.1" type="number"> px
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-fontstyle icon-slider" title="Font Style"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Font Style', 'jmsslider'); ?></div>
                        </label>
                        <select name="fontstyle" id="layer_fontstyle" class="layer-data">
                            <option value="normal"
                                    selected="selected"><?php echo esc_html_e('normal', 'jmsslider'); ?></option>
                            <option value="italic"><?php echo esc_html_e('Italic', 'jmsslider'); ?></option>
                            <option value="oblique"><?php echo esc_html_e('Oblique', 'jmsslider'); ?></option>
                        </select>
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-fontweight icon-slider" title="Font Weight"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Font Weight', 'jmsslider'); ?></div>
                        </label>
                        <select name="fontweight" id="layer_fontweight" class="layer-data">
                            <option value="100"><?php echo esc_html_e('100', 'jmsslider'); ?></option>
                            <option value="200"><?php echo esc_html_e('200', 'jmsslider'); ?></option>
                            <option value="300"><?php echo esc_html_e('300', 'jmsslider'); ?></option>
                            <option value="400"
                                    selected="selected"><?php echo esc_html_e('400(normal)', 'jmsslider'); ?></option>
                            <option value="500"><?php echo esc_html_e('500', 'jmsslider'); ?></option>
                            <option value="600"><?php echo esc_html_e('600', 'jmsslider'); ?></option>
                            <option value="700"><?php echo esc_html_e('700(bold)', 'jmsslider'); ?></option>
                            <option value="800"><?php echo esc_html_e('800', 'jmsslider'); ?></option>
                            <option value="900"><?php echo esc_html_e('900', 'jmsslider'); ?></option>
                        </select>
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-transform icon-slider" title="Text Transform"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Text Transform', 'jmsslider'); ?></div>
                        </label>
                        <select name="texttransform" id="layer_texttransform" class="layer-data">
                            <option value="none"
                                    selected="selected"><?php echo esc_html_e('none', 'jmsslider'); ?></option>
                            <option value="uppercase"><?php echo esc_html_e('uppercase', 'jmsslider'); ?></option>
                            <option value="lowercase"><?php echo esc_html_e('lowercase', 'jmsslider'); ?></option>
                            <option value="capitalize"><?php echo esc_html_e('capitalize', 'jmsslider'); ?></option>
                        </select>
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-lineheight icon-slider" title="Line Height"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Line Height', 'jmsslider'); ?></div>
                        </label>
                        <input name="lineheight" id="layer_lineheight" class="layer-data" value="0" min="1" max="10"
                               step="0.1" type="number"> px
                    </div>
                </div>
                <div id="tab_style_tablet" class="tabcontent responsive-tab row">
                    <div class="row">
                        <div class="field-box">
                            <label>
                                <i class="icon-horizontal icon-slider" title="Move Horizontal"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Data X Position, Left Offset In Pixel', 'jmsslider'); ?></div>
                            </label>
                            <input type="number" name="tablet-x" id="layer_tablet-x" class="layer-data-tablet" value="">
                            px
                        </div>
                        <div class="field-box">
                            <label>
                                <i class="icon-vertical icon-slider" title="Move Vertical"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Data Y Position, Top Offset In Pixel', 'jmsslider'); ?></div>
                            </label>
                            <input type="number" name="tablet-y" id="layer_tablet-y" class="layer-data-tablet" value="">
                            px
                        </div>
                        <div class="field-box">
                            <label>
                                <i class="icon-align icon-slider" title="Edit align"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Align for Layer, Left : data X Will = 0, Right Data X will = 100%, Center Data X will = ([slide width] - [object x])/2.Note : When use Data Align Data X will not avaiable.', 'jmsslider'); ?></div>
                            </label>
                            <select name="tablet-align" id="layer_tablet-align" class="layer-data-tablet">
                                <option selected="" value=""><?php echo esc_html_e('none', 'jmsslider'); ?></option>
                                <option value="left"><?php echo esc_html_e('Left', 'jmsslider'); ?></option>
                                <option value="right"><?php echo esc_html_e('Right', 'jmsslider'); ?></option>
                                <option value="center"><?php echo esc_html_e('Center', 'jmsslider'); ?></option>
                            </select>
                        </div>
                        <div class="field-box">
                            <label>
                                <i class="icon-alignoffset icon-slider" title="Align offset"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Align Offset : Offset from align direction (Left, Right, Center). If set align "Right" it will offset with right side, if set align "Left" it will offset with left side, if set align "Center" it will offset with center of slider, example -30 will shift to left 30px, 30 will shift to right 30px.', 'jmsslider'); ?></div>
                            </label>
                            <input type="number" name="tablet-offset" id="layer_tablet-offset" class="layer-data-tablet"
                                   value="20"> (px)
                        </div>
                    </div>
                    <div class="row">
                        <div class="field-box">
                            <label>
                                <i class="icon-fontsize icon-slider" title="Font size"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Font Size', 'jmsslider'); ?></div>
                            </label>
                            <input name="tablet-fontsize" id="layer_tablet-fontsize" class="layer-data-tablet"
                                   value="20" type="number"> px
                        </div>
                        <div class="field-box">
                            <label>
                                <i class="icon-letterspacing icon-slider" title="Letter Spacing"></i>
                                <div class="tooltip"><?php echo esc_html_e('Letter Spacing', 'jmsslider'); ?></div>
                            </label>
                            <input name="tablet-letterspacing" id="layer_tablet-letterspacing" class="layer-data-tablet"
                                   value="0" min="0"
                                   max="10" step="0.1" type="number"> px
                        </div>
                        <div class="field-box">
                            <label>
                                <i class="icon-fontweight icon-slider" title="Font Weight"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Font Weight', 'jmsslider'); ?></div>
                            </label>
                            <select name="tablet-fontweight" id="layer_tablet-fontweight" class="layer-data-tablet">
                                <option value="100"><?php echo esc_html_e('100', 'jmsslider'); ?></option>
                                <option value="200"><?php echo esc_html_e('200', 'jmsslider'); ?></option>
                                <option value="300"><?php echo esc_html_e('300', 'jmsslider'); ?></option>
                                <option value="400"
                                        selected="selected"><?php echo esc_html_e('400(normal)', 'jmsslider'); ?></option>
                                <option value="500"><?php echo esc_html_e('500', 'jmsslider'); ?></option>
                                <option value="600"><?php echo esc_html_e('600', 'jmsslider'); ?></option>
                                <option value="700"><?php echo esc_html_e('700(bold)', 'jmsslider'); ?></option>
                                <option value="800"><?php echo esc_html_e('800', 'jmsslider'); ?></option>
                                <option value="900"><?php echo esc_html_e('900', 'jmsslider'); ?></option>
                            </select>
                        </div>
                        <div class="field-box">
                            <label>
                                <i class="icon-transform icon-slider" title="Text Transform"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Text Transform', 'jmsslider'); ?></div>
                            </label>
                            <select name="tablet-texttransform" id="layer_tablet-texttransform"
                                    class="layer-data-tablet">
                                <option value="none"
                                        selected="selected"><?php echo esc_html_e('none', 'jmsslider'); ?></option>
                                <option value="uppercase"><?php echo esc_html_e('uppercase', 'jmsslider'); ?></option>
                                <option value="lowercase"><?php echo esc_html_e('lowercase', 'jmsslider'); ?></option>
                                <option value="capitalize"><?php echo esc_html_e('capitalize', 'jmsslider'); ?></option>
                            </select>
                        </div>
                        <div class="field-box">
                            <label>
                                <i class="icon-lineheight icon-slider" title="Line Height"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Line Height', 'jmsslider'); ?></div>
                            </label>
                            <input name="tablet-lineheight" id="layer_tablet-lineheight" class="layer-data-tablet"
                                   value="0" min="1"
                                   max="10" step="0.1" type="number"> px
                        </div>
                    </div>
                </div>
                <div id="tab_style_mobile" class="tabcontent responsive-tab row">
                    <div class="row">
                        <div class="field-box">
                            <label>
                                <i class="icon-horizontal icon-slider" title="Move Horizontal"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Data X Position, Left Offset In Pixel', 'jmsslider'); ?></div>
                            </label>
                            <input type="number" name="mobile-x" id="layer_mobile-x" class="layer-data-mobile" value="">
                            px
                        </div>
                        <div class="field-box">
                            <label>
                                <i class="icon-vertical icon-slider" title="Move Vertical"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Data Y Position, Top Offset In Pixel', 'jmsslider'); ?></div>
                            </label>
                            <input type="number" name="mobile-y" id="layer_mobile-y" class="layer-data-mobile" value="">
                            px
                        </div>
                        <div class="field-box">
                            <label>
                                <i class="icon-align icon-slider" title="Edit align"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Align for Layer, Left : data X Will = 0, Right Data X will = 100%, Center Data X will = ([slide width] - [object x])/2.Note : When use Data Align Data X will not avaiable.', 'jmsslider'); ?></div>
                            </label>
                            <select name="mobile-align" id="layer_mobile-align" class="layer-data-mobile">
                                <option selected="" value=""><?php echo esc_html_e('none', 'jmsslider'); ?></option>
                                <option value="left"><?php echo esc_html_e('Left', 'jmsslider'); ?></option>
                                <option value="right"><?php echo esc_html_e('Right', 'jmsslider'); ?></option>
                                <option value="center"><?php echo esc_html_e('Center', 'jmsslider'); ?></option>
                            </select>
                        </div>
                        <div class="field-box">
                            <label>
                                <i class="icon-alignoffset icon-slider" title="Align offset"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Align Offset : Offset from align direction (Left, Right, Center). If set align "Right" it will offset with right side, if set align "Left" it will offset with left side, if set align "Center" it will offset with center of slider, example -30 will shift to left 30px, 30 will shift to right 30px.', 'jmsslider'); ?></div>
                            </label>
                            <input type="number" name="mobile-offset" id="layer_mobile-offset" class="layer-data-mobile"
                                   value="20"> (px)
                        </div>
                    </div>
                    <div class="row">
                        <div class="field-box">
                            <label>
                                <i class="icon-fontsize icon-slider" title="Font size"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Font Size', 'jmsslider'); ?></div>
                            </label>
                            <input name="mobile-fontsize" id="layer_mobile-fontsize" class="layer-data-mobile"
                                   value="20" type="number"> px
                        </div>
                        <div class="field-box">
                            <label>
                                <i class="icon-letterspacing icon-slider" title="Letter Spacing"></i>
                                <div class="tooltip"><?php echo esc_html_e('Letter Spacing', 'jmsslider'); ?></div>
                            </label>
                            <input name="mobile-letterspacing" id="layer_mobile-letterspacing" class="layer-data-mobile"
                                   value="0" min="0"
                                   max="10" step="0.1" type="number"> px
                        </div>
                        <div class="field-box">
                            <label>
                                <i class="icon-fontweight icon-slider" title="Font Weight"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Font Weight', 'jmsslider'); ?></div>
                            </label>
                            <select name="mobile-fontweight" id="layer_mobile-fontweight" class="layer-data-mobile">
                                <option value="100"><?php echo esc_html_e('100', 'jmsslider'); ?></option>
                                <option value="200"><?php echo esc_html_e('200', 'jmsslider'); ?></option>
                                <option value="300"><?php echo esc_html_e('300', 'jmsslider'); ?></option>
                                <option value="400"
                                        selected="selected"><?php echo esc_html_e('400(normal)', 'jmsslider'); ?></option>
                                <option value="500"><?php echo esc_html_e('500', 'jmsslider'); ?></option>
                                <option value="600"><?php echo esc_html_e('600', 'jmsslider'); ?></option>
                                <option value="700"><?php echo esc_html_e('700(bold)', 'jmsslider'); ?></option>
                                <option value="800"><?php echo esc_html_e('800', 'jmsslider'); ?></option>
                                <option value="900"><?php echo esc_html_e('900', 'jmsslider'); ?></option>
                            </select>
                        </div>
                        <div class="field-box">
                            <label>
                                <i class="icon-transform icon-slider" title="Text Transform"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Text Transform', 'jmsslider'); ?></div>
                            </label>
                            <select name="mobile-texttransform" id="layer_mobile-texttransform"
                                    class="layer-data-mobile">
                                <option value="none"
                                        selected="selected"><?php echo esc_html_e('none', 'jmsslider'); ?></option>
                                <option value="uppercase"><?php echo esc_html_e('uppercase', 'jmsslider'); ?></option>
                                <option value="lowercase"><?php echo esc_html_e('lowercase', 'jmsslider'); ?></option>
                                <option value="capitalize"><?php echo esc_html_e('capitalize', 'jmsslider'); ?></option>
                            </select>
                        </div>
                        <div class="field-box">
                            <label>
                                <i class="icon-lineheight icon-slider" title="Line Height"> </i>
                                <div class="tooltip"><?php echo esc_html_e('Line Height', 'jmsslider'); ?></div>
                            </label>
                            <input name="mobile-lineheight" id="layer_mobile-lineheight" class="layer-data-mobile"
                                   value="0" min="1"
                                   max="10" step="0.1" type="number"> px
                        </div>
                    </div>
                </div>
                <div id="tab_position" class="tabcontent row">
                    <div class="field-box">
                        <label>
                            <i class="icon-width icon-slider" title="Layer Width"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Layer Width', 'jmsslider'); ?></div>
                        </label>
                        <input type="number" name="layerwidthtext" id="layer_width-text" class="layer-data" value=""> px
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-height icon-slider" title="Layer Height"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Layer Height', 'jmsslider'); ?></div>
                        </label>
                        <input type="number" name="layerheighttext" id="layer_height-text" class="layer-data" value="">
                        px
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-horizontal icon-slider" title="Move Horizontal"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Data X Position, Left Offset In Pixel', 'jmsslider'); ?></div>
                        </label>
                        <input type="number" name="x" id="layer_x" class="layer-data" value=""> px
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-vertical icon-slider" title="Move Vertical"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Data Y Position, Top Offset In Pixel', 'jmsslider'); ?></div>
                        </label>
                        <input type="number" name="y" id="layer_y" class="layer-data" value=""> px
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-align icon-slider" title="Edit align"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Align for Layer, Left : data X Will = 0, Right Data X will = 100%, Center Data X will = ([slide width] - [object x])/2.Note : When use Data Align Data X will not avaiable.', 'jmsslider'); ?></div>
                        </label>
                        <select name="align" id="layer_align" class="layer-data">
                            <option selected="" value=""><?php echo esc_html_e('none', 'jmsslider'); ?></option>
                            <option value="left"><?php echo esc_html_e('Left', 'jmsslider'); ?></option>
                            <option value="right"><?php echo esc_html_e('Right', 'jmsslider'); ?></option>
                            <option value="center"><?php echo esc_html_e('Center', 'jmsslider'); ?></option>
                        </select>
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-alignoffset icon-slider" title="Align offset"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Align Offset : Offset from align direction (Left, Right, Center). If set align "Right" it will offset with right side, if set align "Left" it will offset with left side, if set align "Center" it will offset with center of slider, example -30 will shift to left 30px, 30 will shift to right 30px.', 'jmsslider'); ?></div>
                        </label>
                        <input type="number" name="offset" id="layer_offset" class="layer-data" value="20"> px
                    </div>
                </div>
                <div id="tab_animation" class="tabcontent row">
                    <div class="field-box">
                        <label>
                            <i class="icon-delay icon-slider" title="Delay"></i>
                            <div class="tooltip"><?php echo esc_html_e('Time in ms before the in transition starts (in the current step / see steps)', 'jmsslider'); ?></div>
                        </label>
                        <input type="number" name="delay" id="layer_delay" class="layer-data" value=""> (ms)
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-time icon-slider" title="Time"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Time after which the elements animation is complete. It will start at the beginning of the slide/step, or after its specificed delay', 'jmsslider'); ?></div>
                        </label>
                        <input type="number" name="time" id="layer_time" class="layer-data" value=""> (ms)
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-transition icon-slider" title="Transition In"> </i>
                            <div class="tooltip"><?php echo esc_html_e('type of the in-animation (default is left) possible values: fade, none ,left, topLeft, bottomLeft, right, topRight, bottomRight, top, bottom. none lets the element just appear/disappear at the desired location
the direction-type values define the direction in which the element is animated.', 'jmsslider'); ?></div>
                        </label>
                        <select id="layer_in" name="in" class="layer-data">
                            <?php foreach ($transitions as $transition) { ?>
                                <option value="<?php echo $transition['id']; ?>"><?php echo $transition['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-transitionout icon-slider" title="Transition Out"> </i>
                            <div class="tooltip"><?php echo esc_html_e('type of the out-animation (default is left) possible values: fade, none ,left, topLeft, bottomLeft, right, topRight, bottomRight, top, bottom. none lets the element just appear/disappear at the desired location
the direction-type values define the direction in which the element is animated.', 'jmsslider'); ?></div>
                        </label>
                        <select id="layer_out" class="layer-data" name="out">
                            <?php foreach ($transitions as $transition) { ?>
                                <option value="<?php echo $transition['id']; ?>"><?php echo $transition['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-transform icon-slider" title="Transform In"> </i>
                            <div class="tooltip"><?php echo esc_html_e('type of the transform for animation go in (default is fadeIn)', 'jmsslider'); ?></div>
                        </label>
                        <select id="layer_transform_in" class="layer-data" name="transform_in">
                            <?php foreach ($transforms as $transform) { ?>
                                <option value="<?php echo $transform['id']; ?>"><?php echo $transform['id']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="field-box">
                        <label>
                            <i class="icon-transformout icon-slider" title="Transform Out"> </i>
                            <div class="tooltip"><?php echo esc_html_e('Transform Out:type of the transform for animation go out (default is fadeIn)', 'jmsslider'); ?></div>
                        </label>
                        <select id="layer_transform_out" class="layer-data" name="transform_out">
                            <?php foreach ($transforms as $transform) { ?>
                                <option value="<?php echo $transform['id']; ?>"><?php echo $transform['id']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div id="tab_video_set" class="tabcontent row">
                    <div class="row">
                        <div class="col-4">
                            <div class="field-box">
                                <label for=""><?php echo esc_html_e('Auto Play', 'jmsslider'); ?></label>
                                <select name="autoplay" id="layer_autoplay" class="layer-data">
                                    <option value="1"
                                            selected="selected"><?php echo esc_html_e('Yes', 'jmsslider'); ?></option>
                                    <option value="0"><?php echo esc_html_e('No', 'jmsslider'); ?></option>
                                </select>
                            </div>
                            <div class="field-box">
                                <label for=""><?php echo esc_html_e('Loop', 'jmsslider'); ?></label>
                                <select name="loop" id="layer_loop" class="layer-data">
                                    <option value="1"><?php echo esc_html_e('Yes', 'jmsslider'); ?></option>
                                    <option value="0"
                                            selected="selected"><?php echo esc_html_e('No', 'jmsslider'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="field-box">
                                <label for=""><?php echo esc_html_e('Controls', 'jmsslider'); ?></label>
                                <select name="controls" id="layer_controls" class="layer-data">
                                    <option value="1"><?php echo esc_html_e('Yes', 'jmsslider'); ?></option>
                                    <option value="0"
                                            selected="selected"><?php echo esc_html_e('No', 'jmsslider'); ?></option>
                                </select>
                            </div>
                            <div class="field-box">
                                <label for=""><?php echo esc_html_e('Video Background', 'jmsslider'); ?></label>
                                <select name="videobg" id="layer_videobg" class="layer-data">
                                    <option value="0"
                                            selected="selected"><?php echo esc_html_e('No', 'jmsslider'); ?></option>
                                    <option value="1"><?php echo esc_html_e('Yes', 'jmsslider'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="field-box">
                                <label for=""><?php echo esc_html_e('Width', 'jmsslider'); ?></label>
                                <input type="number" name="width" id="layer_width" class="layer-data" value="500"> (px)
                            </div>
                            <div class="field-box">
                                <label for=""><?php echo esc_html_e('Height', 'jmsslider'); ?></label>
                                <input type="number" name="height" id="layer_height" class="layer-data" value="300">
                                (px)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end area-display -->
    <div id="layer-tools" class="layer-tools">
        <div id="add-layer-wrap">
            <a class="btn btn-tool" id="add-layer"><i
                        class="dashicons dashicons-plus"></i> <?php echo esc_html_e('Add Layer', 'jmsslider'); ?></a>
            <ul class="add-layer-list" style="display:none;">
                <li><a id="add-text"><i
                                class="dashicons dashicons-format-aside"></i> <?php echo esc_html_e('Text', 'jmsslider'); ?>
                    </a></li>
                <li><a id="add-image"><i
                                class="dashicons dashicons-format-image"></i> <?php echo esc_html_e('Image', 'jmsslider'); ?>
                    </a></li>
                <li><a id="add-video"><i
                                class="dashicons dashicons-format-video"></i> <?php echo esc_html_e('Video', 'jmsslider'); ?>
                    </a></li>
                <li><a id="add-link"><i
                                class="dashicons dashicons-admin-links"></i> <?php echo esc_html_e('Link', 'jmsslider'); ?>
                    </a></li>
            </ul>
        </div>
        <button id="save-layers" type="submit" class="btn btn-success fixed-right"
                title="Save Layers"><?php echo esc_html_e('Save', 'jmsslider'); ?></button>
        <div class="layers-list">
            <div id="layer-short-toolbar">
                <span id="button_show_all_layer">
                    <i class="dashicons dashicons-menu"></i>
                    <input type="text" name="the_current-editing-layer-title" id="the_current-editing-layer-title"
                           value="No Layer Selected"/>
                    <i id="edit-layer-btn" class="dashicons dashicons-edit"></i>
                <div class="hidden" id="layer-value-input">
                    <input type="hidden" id="layer_type"/>
                    <input type="hidden" id="layer_title"/>
                    <input type="hidden" id="layer_text"/>
                    <input type="hidden" id="layer_url"/>
                    <input type="hidden" id="layer_attachment_id"/>
                    <input type="hidden" id="layer_visibility"/>
                </div>
                </span>

            </div>
            <div id="quick-layers-wrapper">
                <ul class="list-dropdown" id="quick-layers-list">
                    <?php
                    if (count($layers)) {
                        foreach ($layers as $layer) {
                            ?>
                            <li data-text="<?php echo $layer['text']; ?>" data-text="<?php echo $layer['type']; ?>"
                                <?php if ($layer["type"] == 'image' && $layer['url'] != "") { ?>data-url="<?php echo $layer['url']; ?>" <?php } ?>
                                <?php if ($layer["type"] == 'image' && $layer['attachment_id'] != "") { ?>data-attachment_id="<?php echo $layer['attachment_id']; ?>" <?php } ?>
                                <?php if ($layer["type"] == 'image' && $layer['img_id'] != "") { ?>data-img_id="<?php echo $layer['img_id']; ?>" <?php } ?>
                                <?php if ($layer["type"] == 'link') { ?>data-link="<?php echo $layer['link']; ?>" <?php } ?>
                                <?php if ($layer["title"] != '') { ?>data-title="<?php echo $layer['title']; ?>" <?php } ?>
                                <?php if ($layer["class"] != '') { ?>data-class="<?php echo $layer['class']; ?>" <?php } ?>
                                <?php if ($layer["type"] != '') { ?>data-type="<?php echo $layer['type']; ?>" <?php } ?>
                            >
                                <?php
                                if ($layer["type"] == 'image') {
                                    ?>
                                    <i class="dashicons dashicons-format-image"></i>
                                    <?php
                                    if ($layer['text'] == "") {
                                        echo "<span>Image layers</span>";
                                    } else {
                                        echo "<span>" . $layer['text'] . "</span>";
                                    }
                                } ?>
                                <?php
                                if ($layer["type"] == 'text') {
                                    ?>
                                    <i class="dashicons dashicons-format-aside"></i>
                                    <?php
                                    if ($layer['text'] == "") {
                                        echo "<span>Text layers</span>";
                                    } else {
                                        echo "<span>" . $layer['text'] . "</span>";
                                    }
                                } ?>
                                <?php
                                if ($layer["type"] == 'link') {
                                    ?>
                                    <i class="dashicons dashicons-admin-links"></i>
                                    <?php
                                    if ($layer['text'] == "") {
                                        echo "<span>Link layers</span>";
                                    } else {
                                        echo "<span>" . $layer['text'] . "</span>";
                                    }
                                } ?>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <a class="btn btn-tool pull-right" id="del-layer" title="Delete Layer"><i
                    class="dashicons dashicons-trash"></i> <?php echo esc_html_e('Delete Layer', 'jmsslider'); ?></a>
        <a class="btn btn-tool pull-right" id="duplicate-layer" title="Duplicate Layer"><i
                    class="dashicons dashicons-admin-page"></i>
        </a>
        <a class="btn btn-tool pull-right show-layer-btn" id="show-layer" title="Show/Hide Layer"><i
                    class="dashicons dashicons-visibility"></i>
            <i
                    class="dashicons dashicons-hidden"></i>
        </a>
        <a class="btn btn-tool pull-right show-layer-btn" id="show-tablet-layer" title="Show/Hide Layer in Tablet"
           style="display:none;">
            <i
                    class="dashicons dashicons-visibility"></i>
            <i
                    class="dashicons dashicons-hidden"></i>
        </a>
        <a class="btn btn-tool pull-right show-layer-btn" id="show-mobile-layer" title="Show/Hide Layer in Mobile"
           style="display:none;">
            <i
                    class="dashicons dashicons-visibility"></i>
            <i
                    class="dashicons dashicons-hidden"></i>
        </a>
    </div>
    <div class="wrap-slider" id="wrap-slider">
        <div id="horlinie">
            <div id="horlinetext">0</div>
        </div>
        <div id="verlinie">
            <div id="verlinetext">0</div>
        </div>
        <div id="hor-css-linear">
            <ul class="linear-texts"></ul>
        </div>
        <div id="ver-css-linear">
            <ul class="linear-texts"></ul>
        </div>
        <div class="layers-wrapper">
            <div class="slider-background"
                <?php if ($_width) { ?> data-width="<?php echo $_width; ?>" <?php } ?>
                <?php if ($_height) { ?> data-height="<?php echo $_height; ?>" <?php } ?>
                <?php if ($_settings) { ?> data-mobile_height="<?php echo $_settings["mobile_height"]; ?>" <?php } ?>
                <?php if ($_settings) { ?> data-tablet_height="<?php echo $_settings["tablet_height"]; ?>" <?php } ?>
                 style="<?php if ($_height) echo "height:" . $_height . "px;" ?><?php if ($_width) echo "width:" . $_width . "px;" ?>">
                <div id="frame_layer" class="slider fraction-slider" style="<?php if ($bg_type == 'image') {
                    if (strpos($bg_image, "http") !== false) $bg_url = $bg_image; else $bg_url = site_url() . $bg_image;
                    echo 'background:url(' . $bg_url . ')  no-repeat scroll center center / cover;'; ?><?php } else { ?>background-color:<?php echo $bg_color; ?>;<?php } ?>background-size:100% 100%;position:relative;width:100%;height:100%">
                    <?php
                    if (count($layers)) {
                        foreach ($layers as $key => $layer) {
                            $data_arr = array();
                            foreach ($layer as $key => $val) {
                                $data_arr[] = 'data-' . $key . '="' . htmlentities($val) . '"';
                            }
                            $data_str = implode(" ", $data_arr);
                            ?>
                            <div class="tp-caption <?php if (isset($layer['class'])) echo $layer['class']; ?>"
                                <?php echo $data_str; ?>
                                 style="<?php if (isset($layer['videobg']) && $layer['videobg'] == '1') { ?>
                                         top:0; left:0; width:100%;height:100%;
                                 <?php } else {
                                     if (isset($layer['x'])) echo "left:" . $layer['x'] . 'px;';
                                     if (isset($layer['y'])) echo 'top:' . $layer['y'] . 'px;';
                                 } ?>
                                 <?php if ($layer['visibility'] == 0) { ?>opacity:0.3;<?php } ?>
                                 <?php if (isset($layer['z_index'])) { ?>z-index:<?php echo $layer['z_index']; ?>;<?php } ?>
                                 <?php if (isset($layer['fontsize'])) { ?> font-size:<?php echo $layer['fontsize'] . 'px';?>;<?php } ?>
                                 <?php if (isset($layer['textcolor'])) { ?> color:<?php echo $layer['textcolor'];?>;<?php } ?>
                                 <?php if (isset($layer['fontstyle'])) { ?> font-style:<?php echo $layer['fontstyle'];?>;<?php } ?>
                                 <?php if (isset($layer['fontweight'])) { ?> font-weight:<?php echo $layer['fontweight'];?>;<?php } ?>
                                 <?php if (isset($layer['texttransform'])) { ?> text-transform:<?php echo $layer['texttransform'];?>;<?php } ?>
                                 <?php if (isset($layer['letterspacing'])) { ?> letter-spacing:<?php echo $layer['letterspacing'] . 'px';?>;<?php } ?>">
                                <?php if ($layer['type'] == 'image') { ?>
                                    <img src="<?php if (strpos($layer['url'], "http") !== false) echo $layer['url']; else echo get_site_url() . $layer['url']; ?>"/>
                                <?php } elseif ($layer['type'] == 'text') { ?>
                                    <?php echo $layer['text']; ?>
                                <?php } elseif ($layer['type'] == 'video') { ?>
                                    <i class="dashicons dashicons-move" title="Keep mouse to move"></i>
                                    <?php if ($layer['videotype'] == 'youtube') { ?>
                                        <iframe
                                            <?php if (isset($layer['videobg']) && $layer['videobg'] == '1'){ ?>width="100%"
                                            height="100%" <?php } else {
                                            if (isset($layer['width'])) { ?>width="<?php echo $layer['width']; ?>px;"<?php }
                                        if (isset($layer['width'])) { ?> height="<?php echo $layer['height']; ?>px;"<?php }
                                        } ?>
                                            src="http://www.youtube.com/embed/<?php echo $layer['videoid']; ?>?autoplay=<?php echo $layer['autoplay']; ?>&controls=<?php echo $layer['controls']; ?>&loop=<?php echo $layer['loop']; ?>"
                                            allowfullscreen frameborder="0"></iframe>
                                    <?php } elseif ($layer['videotype'] == 'vimeo') { ?>
                                        <iframe
                                            <?php if (isset($layer['videobg']) && $layer['videobg'] == '1'){ ?>width="100%"
                                            height="100%" <?php } else { ?>width="<?php echo $layer['width']; ?>px;"
                                            height="<?php echo $layer['height']; ?>px;"<?php } ?>
                                            src="https://player.vimeo.com/video/<?php echo $layer['videoid']; ?>?autoplay=<?php echo $layer['autoplay']; ?>&loop=<?php echo $layer['loop']; ?>"
                                            allowfullscreen frameborder="0"></iframe>
                                    <?php } ?>
                                <?php } elseif ($layer['type'] == 'link') { ?>
                                    <a href="<?php if (isset($layer['link'])) { ?><?php echo $layer['link'];
                                    } else {
                                        echo "#";
                                    } ?>"><?php echo $layer['text']; ?></a>
                                <?php } ?>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End wrap-slider -->
    <div class="mastertimer-wrapper">
        <div class="mastertimer-left">
            <ul id="timeline-title">
                <li id="fulltime-title"><?php echo esc_html_e('Slide Time', 'jmsslider'); ?></li>
            </ul>
        </div>
        <div class="mastertimer-right">
            <div id="mastertimer-curtime"><span id="mastertimer-curtimeinner"></span></div>
            <div class="mastertimer">
                <div id="mastertimer-linear">
                    <ul class="linear-texts">
                    </ul>
                </div>
            </div>
            <input type="hidden" id="slide-duration" value="<?php echo $_settings['duration']; ?>"/>
            <div id="time-line">
                <ul>
                    <li id="fulltime" class="mastertimer-slide">
                        <div class="fulltime" style="width:<?php echo $_settings['duration'] / 10; ?>px;"></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="jms-wrap-model add_text_layer" style="display: none;">
        <div class="jms-theme-overlay"></div>
        <div id="jms-dialog">
            <div class="dialog-title">
                <span class="title"><?php echo esc_html_e('Add text or html', 'jmsslider'); ?></span>
                <span class="close dashicons dashicons-no-alt"></span>
            </div>
            <div class="add-form">
                <div class="form-group">
                    <label for="title_text_new"><?php echo esc_html_e('Title', 'jmsslider'); ?></label>
                    <input type="text" name="title_text_new" id="title_text_new">
                </div>
                <div class="form-group">
                    <label for="text_layer"><?php echo esc_html_e('Text or HTML', 'jmsslider'); ?></label>
                    <?php
                    $content = 'demo text';
                    $editor_id = 'text_layer';
                    $_settingss = array(
                        'textarea_name' => 'text_layer',
                        'textarea_rows' => 5,
                        'media_buttons' => FALSE,
                        'teeny' => FALSE,
                        'tinymce' => TRUE
                    );
                    wp_editor($content, $editor_id, $_settingss);
                    ?>
                </div>
                <div class="form-group">
                    <button type="button" id="submitLayerText"
                            class="button button-primary button-large"><?php echo esc_html_e('Add Layer', 'jmsslider'); ?></button>
                    <button type="button" id="updateLayerText"
                            class="button button-primary button-large"><?php echo esc_html_e('Update Layer', 'jmsslider'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="jms-wrap-model add_link_layer" style="display: none;">
        <div class="jms-theme-overlay"></div>
        <div id="jms-dialog">
            <div class="dialog-title">
                <span class="title"><?php echo esc_html_e('Add Link', 'jmsslider'); ?></span>
                <span class="close dashicons dashicons-no-alt"></span>
            </div>
            <div class="add-form">
                <div class="form-group">
                    <label for="title_link_new"><?php echo esc_html_e('Title', 'jmsslider'); ?></label>
                    <input type="text" name="title_link_new" id="title_link_new">
                </div>
                <div class="form-group">
                    <label for="link_text"><?php echo esc_html_e('Link Text', 'jmsslider'); ?></label>
                    <input type="text" name="link_text" id="link_text">
                </div>
                <div class="form-group">
                    <label for="link_url"><?php echo esc_html_e('Url', 'jmsslider'); ?></label>
                    <input type="text" name="link_url" id="link_url">
                </div>
                <div class="form-group">
                    <button type="button" id="submitLayerLink"
                            class="button button-primary button-large"><?php echo esc_html_e('Add Link', 'jmsslider'); ?></button>
                    <button type="button" id="updateLayerLink"
                            class="button button-primary button-large"><?php echo esc_html_e('Edit Link', 'jmsslider'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="jms-wrap-model add_video_layer" style="display: none;">
        <div class="jms-theme-overlay"></div>
        <div id="jms-dialog">
            <div class="dialog-title">
                <span class="title"><?php echo esc_html_e('Add Video (Youtube or Vimeo)', 'jmsslider'); ?></span>
                <span class="close dashicons dashicons-no-alt"></span>
            </div>
            <div class="add-form">
                <div class="form-group">
                    <label for="title_video_new"><?php echo esc_html_e('Title', 'jmsslider'); ?></label>
                    <input type="text" name="title_video_new" id="title_video_new">
                </div>
                <div class="form-group">
                    <label for="text_layer"><?php echo esc_html_e('Video Url', 'jmsslider'); ?></label>
                    <input type="text" name="data_video_new" id="data_video_new"/>
                    <p class="description">Eg: https://www.youtube.com/watch?v=2PEG82Udb90 or
                        https://vimeo.com/23259282</p>
                </div>
                <div class="form-group">
                    <button type="button" id="submitLayerVideo"
                            class="button button-primary button-large"><?php echo esc_html_e('Add Video', 'jmsslider'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <form action="#" method="POST" id="layersForm" name="layersForm">
        <input type="hidden" id="mw" name="mw" value="<?php echo $_width; ?>"/>
        <input type="hidden" id="mh" name="mh" value="<?php echo $_height; ?>"/>
        <input type="hidden" id="layersjson" name="layersjson" value=""/>
        <input type="hidden" id="slidejson" name="slidejson" value=""/>
        <input type="hidden" id="slidetitle" name="slidetitle" value=""/>
        <input type="hidden" id="importjson" name="importjson" value=""/>
        <input type="hidden" name="id_slide" value="<?php echo $id; ?>"/>
        <input type="hidden" id="root_url" name="root_url" value="<?php echo site_url(); ?>"/>
        <input type="file" name="zip_file" />
    </form>
    <p><strong><?php echo esc_html_e('Usage', 'jmsslider'); ?>
            :</strong> <?php echo esc_html_e('Click to Layer box or timeline to set for Layer active.', 'jmsslider'); ?>
    </p>
</div>

<script>
    var bg_type = '<?php echo $bg_type; ?>';

    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
</script>
