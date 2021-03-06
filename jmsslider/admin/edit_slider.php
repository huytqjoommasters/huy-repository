<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["slider_submit"])) {
        $errors = array();
        $slider = new JmsSlider();
        if (empty($_POST['title'])) {
            $errors[] = 'title';
        } else {
            $slider->setTitle(sanitize_text_field($_POST['title']));
        }

        if (empty($_POST['alias'])) {
            $errors[] = 'alias';
        } else {
            $slider->setAlias(sanitize_html_class($_POST['alias']));
        }

        // Settings
        if (empty($_POST['JMS_SLIDER_DELAY'])) {
            $delay = '1000';
        } else {
            $delay = intval($_POST['JMS_SLIDER_DELAY']);
        }

        if (empty($_POST['JMS_SLIDER_DURATION'])) {
            $duration = '7000';
        } else {
            $duration = intval($_POST['JMS_SLIDER_DURATION']);
        }

        if (empty($_POST['JMS_SLIDER_X'])) {
            $position_x = '0';
        } else {
            $position_x = intval($_POST['JMS_SLIDER_X']);
        }

        if (empty($_POST['JMS_SLIDER_Y'])) {
            $position_y = '0';
        } else {
            $position_y = intval($_POST['JMS_SLIDER_Y']);
        }

        if (isset($_POST['JMS_SLIDER_TRANSITION'])) {
            $transition = $_POST['JMS_SLIDER_TRANSITION'];
        } else {
            $transition = 'fade';
        }

        if (isset($_POST['JMS_SLIDER_TRANSITION_IN'])) {
            $transition_in = $_POST['JMS_SLIDER_TRANSITION_IN'];
        } else {
            $transition_in = 'fade';
        }

        if (isset($_POST['JMS_SLIDER_TRANSITION_OUT'])) {
            $transition_out = $_POST['JMS_SLIDER_TRANSITION_OUT'];
        } else {
            $transition_out = 'fade';
        }

        if (isset($_POST['JMS_SLIDER_EASE_IN'])) {
            $ease_in = $_POST['JMS_SLIDER_EASE_IN'];
        } else {
            $ease_in = 'linear';
        }

        if (isset($_POST['JMS_SLIDER_EASE_OUT'])) {
            $ease_out = $_POST['JMS_SLIDER_EASE_OUT'];
        } else {
            $ease_out = 'linear';
        }

        if (empty($_POST['JMS_SLIDER_SPEED_IN'])) {
            $speed_in = '500';
        } else {
            $speed_in = intval($_POST['JMS_SLIDER_SPEED_IN']);
        }

        if (empty($_POST['JMS_SLIDER_SPEED_OUT'])) {
            $speed_out = '500';
        } else {
            $speed_out = intval($_POST['JMS_SLIDER_SPEED_OUT']);
        }

        if (empty($_POST['JMS_SLIDER_MAX_WIDTH'])) {
            $max_width = '1170';
        } else {
            $max_width = intval($_POST['JMS_SLIDER_MAX_WIDTH']);
        }

        if (empty($_POST['JMS_SLIDER_MAX_HEIGHT'])) {
            $max_height = '450';
        } else {
            $max_height = intval($_POST['JMS_SLIDER_MAX_HEIGHT']);
        }
        if (empty($_POST['JMS_SLIDER_TABLET_HEIGHT'])) {
            $tablet_height = '450';
        } else {
            $tablet_height = intval($_POST['JMS_SLIDER_TABLET_HEIGHT']);
        }
        if (empty($_POST['JMS_SLIDER_MOBILE_HEIGHT'])) {
            $mobile_height = '300';
        } else {
            $mobile_height = intval($_POST['JMS_SLIDER_MOBILE_HEIGHT']);
        }
        if (isset($_POST['JMS_SLIDER_BG_ANIMATE'])) {
            $bg_animate = $_POST['JMS_SLIDER_BG_ANIMATE'];
        } else {
            $bg_animate = '0';
        }

        if (isset($_POST['JMS_SLIDER_BG_EASE'])) {
            $bg_ease = $_POST['JMS_SLIDER_BG_EASE'];
        } else {
            $bg_ease = 'linear';
        }

        if (isset($_POST['JMS_SLIDER_END_ANIMATE'])) {
            $end_animate = $_POST['JMS_SLIDER_END_ANIMATE'];
        } else {
            $end_animate = '1';
        }

        if (isset($_POST['JMS_SLIDER_FULL_WIDTH'])) {
            $full_width = $_POST['JMS_SLIDER_FULL_WIDTH'];
        } else {
            $full_width = '0';
        }
        if (isset($_POST['JMS_SLIDER_FULL_HEIGHT'])) {
            $full_height = $_POST['JMS_SLIDER_FULL_HEIGHT'];
        } else {
            $full_height = '0';
        }
        if (isset($_POST['JMS_SLIDER_RESPONSIVE'])) {
            $responsive = $_POST['JMS_SLIDER_RESPONSIVE'];
        } else {
            $responsive = '1';
        }

        if (isset($_POST['JMS_SLIDER_AUTO_CHANGE'])) {
            $auto_change = $_POST['JMS_SLIDER_AUTO_CHANGE'];
        } else {
            $auto_change = '1';
        }

        if (isset($_POST['JMS_SLIDER_PAUSE_HOVER'])) {
            $pause_hover = $_POST['JMS_SLIDER_PAUSE_HOVER'];
        } else {
            $pause_hover = '1';
        }

        if (isset($_POST['JMS_SLIDER_SHOW_PAGERS'])) {
            $show_pagers = $_POST['JMS_SLIDER_SHOW_PAGERS'];
        } else {
            $show_pagers = '1';
        }

        if (isset($_POST['JMS_SLIDER_SHOW_CONTROLS'])) {
            $show_controls = $_POST['JMS_SLIDER_SHOW_CONTROLS'];
        } else {
            $show_controls = '1';
        }

        $m = array(
            'delay' => $delay,
            'duration' => $duration,
            'position_x' => $position_x,
            'position_y' => $position_y,
            'transition_all' => $transition,
            'transition_in' => $transition_in,
            'transition_out' => $transition_out,
            'ease_in' => $ease_in,
            'ease_out' => $ease_out,
            'speed_in' => $speed_in,
            'speed_out' => $speed_out,
            'max_width' => $max_width,
            'max_height' => $max_height,
            'tablet_height' => $tablet_height,
            'mobile_height' => $mobile_height,
            'background_animate' => $bg_animate,
            'background_ease' => $bg_ease,
            'end_animate' => $end_animate,
            'full_width' => $full_width,
            'full_height' => $full_height,
            'responsive' => $responsive,
            'auto_change' => $auto_change,
            'pause_hover' => $pause_hover,
            'show_pagers' => $show_pagers,
            'show_controls' => $show_controls
        );
        $slider->setSettings($m);
        $slider->submitSlider($id);
    }
    if (isset($_POST["slide_submit"])) {
        $slide = new JmsSlide();
        $id_slider = $_POST['id_slider'];
        $errors = array();
        if (empty($_POST['title'])) {
            $errors[] = 'title';
        } else {
            $slide->setTitle($_POST['title']);
        }

        $slide_link = sanitize_text_field($_POST['slide_link']);
        $class = sanitize_html_class($_POST['class']);
        $bg_type = "";
        if (isset($_POST['bg_type'])) {
            $bg_type = $_POST['bg_type'];
        }
        $image_url = sanitize_text_field($_POST['image_url']);
        $bg_color = sanitize_text_field($_POST['bg_color']);
        $m = array(
            'slide_link' => $slide_link,
            'class' => $class,
            'bg_type' => $bg_type,
            'bg_image' => $image_url,
            'bg_color' => $bg_color
        );
        $slide->setParams($m);
        $slide->submitSlide($errors, $id, $id_slider);
    }
} //End if submit condition
?>
<div class="wrap jmsslider">
    <h2>
        <?php echo esc_html_e('Slider title and shortcode', 'jmsslider'); ?>
    </h2>
    <?php
    global $wpdb;
    if (isset($_GET['id']))
        $id = (int)$_GET['id'];
    $slider_row = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "jms_sliders WHERE id_slider = " . $id . "");
    $slider_list_safe_link = wp_nonce_url('admin.php?page=jmssliderlayer');

    $_query = "SELECT *  FROM " . $wpdb->prefix . "jms_slider_slides WHERE id_slider = '" . $id . "'";
    $slide = $wpdb->get_results($_query);

    $export_safe_link = wp_nonce_url('admin.php?page=jmssliderlayer&task=export_slider&id=' . esc_html($id), 'export_' . $id, 'export_nonce');
    $import_safe_link = wp_nonce_url('admin.php?page=jmssliderlayer&task=import_slider&id=' . esc_html($id), 'import_' . $id, 'import_nonce');
    ?>
    <form action="#" method="POST" class="edit_form" id="edit_form">
        <div class="add-slider">
            <div class="row-input">
                <input type="text" id="title" name="title" value="<?php if (!empty($slider_row->title)) {
                    echo $slider_row->title;
                } else {
                    echo 'New slider';
                } ?>" placeholder="<?php echo esc_html_e('Enter your Slider Name here', 'jmsslider'); ?>"
                       autofocus="autofocus">
                <p class="description"><?php echo esc_html_e('The title of the slider, example: Slider 1', 'jmsslider'); ?></p>
            </div>
            <div class="row-input">
                <input type="text" id="alias" name="alias" value="<?php if (!empty($slider_row->alias)) {
                    echo $slider_row->alias;
                } else {
                    echo '';
                } ?>" placeholder="<?php echo esc_html_e('Enter your Slider Alias here', 'jmsslider'); ?>">
                <p class="description"><?php echo esc_html_e('The alias for embedding your slider, example: slider1', 'jmsslider'); ?></p>
            </div>
            <div class="row-input">
                <input type="text" id="shortcode-alias" name="shortcode-alias"
                       value="[jmsslider alias='<?php if (isset($slider_row->alias)) echo $slider_row->alias; ?>']"
                       readonly="readonly">
                <p class="description"><?php echo esc_html_e('Place the shortcode where you want to show the slider', 'jmsslider'); ?></p>
            </div>
            <ul class="btn-action">
                <li>
                    <button type="submit" name="slider_submit"
                            class="btn-save fixed-right" title="<?php echo esc_html_e('Save', 'jmsslider'); ?>">
                        <i class="dashicons dashicons-welcome-write-blog"></i>
                    </button>
                </li>
                <li>
                    <a href="<?php echo $slider_list_safe_link; ?>"
                       class="btn-back" title="<?php echo esc_html_e('Back to Slider Manager', 'jmsslider'); ?>">
                        <i class="dashicons dashicons-arrow-left-alt"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $export_safe_link; ?>" class="btn-export"
                       title="<?php echo esc_html_e('Export slider', 'jmsslider'); ?>">
                        <i class="dashicons dashicons-download"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="btn-import" title="<?php echo esc_html_e('Import slider', 'jmsslider'); ?>">
                        <i class="dashicons dashicons-upload"></i>
                    </a>
                </li>
            </ul>
        </div><!-- add slider -->
        <?php
        if (count($slider_row) > 0) {
            ?>
            <ul class="list-slides">
                <?php
                foreach ($slide as $slide_item) {
                    //print_r($slide_item);
                    $_params = json_decode($slide_item->params);
                    $bg_image = "";
                    if (isset($_params->bg_image)) {
                        $bg_image = $_params->bg_image;
                    }
                    $bg_color = "";
                    if (isset($_params->bg_color)) {
                        $bg_color = $_params->bg_color;
                    }
                    $bg_type = $_params->bg_type;
                    $layers_safe_link = wp_nonce_url('admin.php?page=jmssliderlayer&task=layers&slider=' . $id . '&id=' . esc_html($slide_item->id_slide), 'layers_' . $slide_item->id_slide, 'layers_nonce');
                    $delete_slide_safe_link = wp_nonce_url('admin.php?page=jmssliderlayer&task=edit_slider&id=' . esc_html($slide_item->id_slider) . '&id_slide=' . esc_html($slide_item->id_slide), 'delete_slide_' . $slide_item->id_slide, 'edit_slider_nonce');
                    ?>
                    <li class="item-slide">
                        <?php if ($bg_type == 'image') { ?>
                            <span class="slide-bg"
                                  style="<?php if (isset($bg_image) && $bg_image != "") { ?> background-image: url(<?php echo site_url().$bg_image; ?>);<?php } ?> background-size:cover;"></span>
                        <?php } else { ?>
                            <span class="slide-bg"
                                  <?php if (isset($bg_color) && $bg_color != ""){ ?>style="background-color:<?php echo $bg_color; ?>; background-image: none;"<?php } ?> ></span>
                        <?php } ?>
                        <div class="slide-title">
                            <?php echo $slide_item->title; ?>
                        </div>
                        <a href="<?php echo $delete_slide_safe_link; ?>" class="delete-slide" title="Delete slide"><i
                                    class="dashicons dashicons-trash"></i></a>
                        <a href="<?php echo $layers_safe_link; ?>" class="edit-slide" title="Edit slide"><i
                                    class="dashicons dashicons-edit"></i></a>
                    </li>
                    <?php
                }
                ?>
                <li class="item-slide add">
                    <span class="slide-bg"></span>
                    <?php
                    $new_slide_safe_link = wp_nonce_url('admin.php?page=jmssliderlayer&task=add_slide&id_slider=' . $id, 'new_slide', 'new_slide_nonce');
                    ?>
                    <div class="slide-title">
                        <?php echo esc_html_e('New slide', 'jmsslider'); ?>
                    </div>
                    <a href="<?php echo $new_slide_safe_link; ?>" class="add-slide-btn">
                        <i class="dashicons dashicons-plus"></i>
                    </a>
                </li>
            </ul>
            <?php
        }
        if (isset($slider_row)) {
            $json = $slider_row->settings;
            $j_setting = json_decode($json);

            $delay = $j_setting->delay;
            $duration = $j_setting->duration;
            $max_width = $j_setting->max_width;
            $max_height = $j_setting->max_height;
            $mobile_height = $j_setting->mobile_height;
            if (isset($j_setting->tablet_height)) {
                $tablet_height = $j_setting->tablet_height;
            }
            $background_animate = $j_setting->background_animate;
            $background_ease = $j_setting->background_ease;
            $end_animate = $j_setting->end_animate;
            $full_width = $j_setting->full_width;
            $full_height = $j_setting->full_height;
            $responsive = $j_setting->responsive;
            $auto_change = $j_setting->auto_change;
            $pause_hover = $j_setting->pause_hover;
            $show_pagers = $j_setting->show_pagers;
            $show_controls = $j_setting->show_controls;
        }
        ?>
        <div class="setting-wrap">
            <h3><?php echo esc_html_e('Slider Settings', 'jmsslider'); ?></h3>
            <div class="option-block col-5">
                <div class="form-group has-background">
                    <label for="JMS_SLIDER_DELAY"><?php echo esc_html_e('Start after', 'jmsslider'); ?>
                        <div class="help">?
                            <div class="help-block">
                                <p><?php echo esc_html_e('Default delay for elements', 'jmsslider'); ?></p>
                            </div>
                        </div>
                    </label>
                    <input name="JMS_SLIDER_DELAY" id="JMS_SLIDER_DELAY" value="<?php if (isset($delay)) {
                        echo $delay;
                    } else {
                        echo '1000';
                    } ?>" type="text">
                    <span>ms</span>
                </div>
                <div class="form-group">
                    <label for="JMS_SLIDER_DURATION"><?php echo esc_html_e('Duration', 'jmsslider'); ?>
                        <div class="help">?
                            <div class="help-block">
                                <p><?php echo esc_html_e('default timeout before switching slides', 'jmsslider'); ?></p>
                            </div>
                        </div>
                    </label>
                    <input name="JMS_SLIDER_DURATION" id="JMS_SLIDER_DURATION" value="<?php if (isset($duration)) {
                        echo $duration;
                    } else {
                        echo '5000';
                    } ?>" type="text">
                    <span>ms</span>
                </div>
                <div class="form-group has-background">
                    <label for="JMS_SLIDER_MAX_WIDTH"><?php echo esc_html_e('Max Width', 'jmsslider'); ?>
                        <div class="help">?
                            <div class="help-block">
                                <p><?php echo esc_html_e('Slide Width in Pixel', 'jmsslider'); ?></p>
                            </div>
                        </div>
                    </label>
                    <input type="text" id="JMS_SLIDER_MAX_WIDTH" name="JMS_SLIDER_MAX_WIDTH"
                           value="<?php if (isset($max_width)) {
                               echo $max_width;
                           } else {
                               echo '1170';
                           } ?>"> <span>px</span>
                </div>
                <div class="form-group">
                    <label for="JMS_SLIDER_MAX_HEIGHT"><?php echo esc_html_e('Max Height', 'jmsslider'); ?>
                        <div class="help">?
                            <div class="help-block">
                                <p><?php echo esc_html_e('Slide Height in Pixel', 'jmsslider'); ?></p>
                            </div>
                        </div>
                    </label>
                    <input type="text" id="JMS_SLIDER_MAX_HEIGHT" name="JMS_SLIDER_MAX_HEIGHT"
                           value="<?php if (isset($max_height)) {
                               echo $max_height;
                           } else {
                               echo '450';
                           } ?>"> <span>px</span>
                </div>
                <div class="form-group">
                    <label for="JMS_SLIDER_MAX_HEIGHT"><?php echo esc_html_e('Tablet Height', 'jmsslider'); ?>
                        <div class="help">?
                            <div class="help-block">
                                <p><?php echo esc_html_e('Slide Height in Tablet', 'jmsslider'); ?></p>
                            </div>
                        </div>
                    </label>
                    <input type="text" id="JMS_SLIDER_TABLET_HEIGHT" name="JMS_SLIDER_TABLET_HEIGHT"
                           value="<?php if (isset($tablet_height)) {
                               echo $tablet_height;
                           } else {
                               echo '450';
                           } ?>"> <span>px</span>
                </div>
                <div class="form-group">
                    <label for="JMS_SLIDER_MAX_HEIGHT"><?php echo esc_html_e('Mobile Height', 'jmsslider'); ?>
                        <div class="help">?
                            <div class="help-block">
                                <p><?php echo esc_html_e('Slide Height in Mobile', 'jmsslider'); ?></p>
                            </div>
                        </div>
                    </label>
                    <input type="text" id="JMS_SLIDER_MOBILE_HEIGHT" name="JMS_SLIDER_MOBILE_HEIGHT"
                           value="<?php if (isset($mobile_height)) {
                               echo $mobile_height;
                           } else {
                               echo '420';
                           } ?>"> <span>px</span>
                </div>
                <div class="form-group">
                    <label for="JMS_SLIDER_FULL_WIDTH"><?php echo esc_html_e('FullWidth slide', 'jmsslider'); ?>
                        <div class="help">?
                            <div class="help-block">
                                <p><?php echo esc_html_e('transition over the full width of the window', 'jmsslider'); ?></p>
                            </div>
                        </div>
                    </label>
                    <input id="JMS_SLIDER_FULL_WIDTH_on" name="JMS_SLIDER_FULL_WIDTH" value="1"
                           type="radio" <?php if (isset($full_width) && (int)$full_width == 1) echo 'checked="checked"'; ?>> <?php echo esc_html_e('Yes', 'jmsslider'); ?>
                    <input id="JMS_SLIDER_FULL_WIDTH_off" name="JMS_SLIDER_FULL_WIDTH" value="0"
                           type="radio" <?php if (isset($full_width) && (int)$full_width == 0) echo 'checked="checked"'; ?>> <?php echo esc_html_e('No', 'jmsslider'); ?>
                </div>
                <div class="form-group">
                    <label for="JMS_SLIDER_FULL_SCREEN"><?php echo esc_html_e('FullHeight slide', 'jmsslider'); ?>
                        <div class="help">?
                            <div class="help-block">
                                <p><?php echo esc_html_e('transition over the full height of the window', 'jmsslider'); ?></p>
                            </div>
                        </div>
                    </label>
                    <input id="JMS_SLIDER_FULL_HEIGHT_on" name="JMS_SLIDER_FULL_HEIGHT" value="1"
                           type="radio" <?php if (isset($full_height) && (int)$full_height == 1) echo 'checked="checked"'; ?>> <?php echo esc_html_e('Yes', 'jmsslider'); ?>
                    <input id="JMS_SLIDER_FULL_HEIGHT_off" name="JMS_SLIDER_FULL_HEIGHT" value="0"
                           type="radio" <?php if (isset($full_height) && (int)$full_height == 0) echo 'checked="checked"'; ?>> <?php echo esc_html_e('No', 'jmsslider'); ?>
                </div>
            </div>
            <div class="option-block col-5">

                <div class="form-group has-background">
                    <label for="JMS_SLIDER_RESPONSIVE"><?php echo esc_html_e('Responsive', 'jmsslider'); ?>
                        <div class="help">?
                            <div class="help-block">
                                <p><?php echo esc_html_e('Activates the responsive slider', 'jmsslider'); ?></p>
                            </div>
                        </div>
                    </label>
                    <input id="JMS_SLIDER_RESPONSIVE_on" name="JMS_SLIDER_RESPONSIVE" value="1"
                           type="radio" <?php if (isset($responsive) && (int)$responsive == 1) echo 'checked="checked"'; ?>> <?php echo esc_html_e('Yes', 'jmsslider'); ?>
                    <input id="JMS_SLIDER_RESPONSIVE_off" name="JMS_SLIDER_RESPONSIVE" value="0"
                           type="radio" <?php if (isset($responsive) && (int)$responsive == 0) echo 'checked="checked"'; ?>> <?php echo esc_html_e('No', 'jmsslider'); ?>
                </div>
                <div class="form-group">
                    <label for="JMS_SLIDER_AUTO_CHANGE"><?php echo esc_html_e('Auto change slide', 'jmsslider'); ?>
                        <div class="help">?
                            <div class="help-block">
                                <p><?php echo esc_html_e('Auto change slide', 'jmsslider'); ?></p>
                            </div>
                        </div>
                    </label>
                    <input id="JMS_SLIDER_AUTO_CHANGE_on" name="JMS_SLIDER_AUTO_CHANGE" value="1"
                           type="radio" <?php if (isset($auto_change) && (int)$auto_change == 1) echo 'checked="checked"'; ?>> <?php echo esc_html_e('Yes', 'jmsslider'); ?>
                    <input id="JMS_SLIDER_AUTO_CHANGE_off" name="JMS_SLIDER_AUTO_CHANGE" value="0"
                           type="radio" <?php if (isset($auto_change) && (int)$auto_change == 0) echo 'checked="checked"'; ?>> <?php echo esc_html_e('No', 'jmsslider'); ?>
                </div>
                <div class="form-group has-background">
                    <label for="JMS_SLIDER_PAUSE_HOVER"><?php echo esc_html_e('Pause hover', 'jmsslider'); ?>
                        <div class="help">?
                            <div class="help-block">
                                <p><?php echo esc_html_e('Pauses slider on hover (current step will still be completed)', 'jmsslider'); ?></p>
                            </div>
                        </div>
                    </label>
                    <input id="JMS_SLIDER_PAUSE_HOVER_on" name="JMS_SLIDER_PAUSE_HOVER" value="1"
                           type="radio" <?php if (isset($pause_hover) && (int)$pause_hover == 1) echo 'checked="checked"'; ?>> <?php echo esc_html_e('Yes', 'jmsslider'); ?>
                    <input id="JMS_SLIDER_PAUSE_HOVER_off" name="JMS_SLIDER_PAUSE_HOVER" value="0"
                           type="radio" <?php if (isset($pause_hover) && (int)$pause_hover == 0) echo 'checked="checked"'; ?>> <?php echo esc_html_e('No', 'jmsslider'); ?>
                </div>
                <div class="form-group">
                    <label for="JMS_SLIDER_SHOW_PAGERS"><?php echo esc_html_e('Show pager', 'jmsslider'); ?>
                        <div class="help">?
                            <div class="help-block">
                                <p><?php echo esc_html_e('Pager controls on/off', 'jmsslider'); ?></p>
                            </div>
                        </div>
                    </label>
                    <input id="JMS_SLIDER_SHOW_PAGERS_on" name="JMS_SLIDER_SHOW_PAGERS" value="1"
                           type="radio" <?php if (isset($show_pagers) && (int)$show_pagers == 1) echo 'checked="checked"'; ?>> <?php echo esc_html_e('Yes', 'jmsslider'); ?>
                    <input id="JMS_SLIDER_SHOW_PAGERS_off" name="JMS_SLIDER_SHOW_PAGERS" value="0"
                           type="radio" <?php if (isset($show_pagers) && (int)$show_pagers == 0) echo 'checked="checked"'; ?>> <?php echo esc_html_e('No', 'jmsslider'); ?>
                </div>
                <div class="form-group has-background">
                    <label for="JMS_SLIDER_SHOW_CONTROLS"><?php echo esc_html_e('Show controls', 'jmsslider'); ?>
                        <div class="help">?
                            <div class="help-block">
                                <p><?php echo esc_html_e('Controls on/off', 'jmsslider'); ?></p>
                            </div>
                        </div>
                    </label>
                    <input id="JMS_SLIDER_SHOW_CONTROLS_on" name="JMS_SLIDER_SHOW_CONTROLS" value="1"
                           type="radio" <?php if (isset($show_controls) && (int)$show_controls == 1) echo 'checked="checked"'; ?>> <?php echo esc_html_e('Yes', 'jmsslider'); ?>
                    <input id="JMS_SLIDER_SHOW_CONTROLS_off" name="JMS_SLIDER_SHOW_CONTROLS" value="0"
                           type="radio" <?php if (isset($show_controls) && (int)$show_controls == 0) echo 'checked="checked"'; ?>> <?php echo esc_html_e('No', 'jmsslider'); ?>
                </div>

            </div><!-- option block -->
        </div><!-- setting wrap -->

    </form>
</div>
<div class="upload-slider-popup">
    <a href="#" class="close-upload">
        <i class="dashicons dashicons-no-alt"></i>
    </a>
    <h3>Chose slider top upload.</h3>
    <form method="post" action="<?php echo $import_safe_link; ?>" enctype="multipart/form-data" name="importtForm"
          id="importtForm">
        <input type="file" name="zip_file" id="zip_file"/>
        <input type="submit" value="upload" class="button"/>
    </form>
</div>
<div class="upload-bg"></div>