<?php
class JmsSlide {
    protected $title = null;
    protected $params = null;
    protected $layers = null;

    public function setTitle($val) {
        $this->title = sanitize_text_field($val);
    }
    public  function setParams($val) {
        $this->params = json_encode($val);
    }
    public function submitSlide($errors, $id, $id_slider) {
        if (empty($errors)) {
            global $wpdb;
            if (isset($id_slide) && $id_slide != 0) { //edit slide
                $update_slide = $wpdb->update(
                    $wpdb->prefix . 'jms_slider_slides',
                    array(
                        'title' => $this->title,
                        'params' => $this->params
                    ),
                    array('id_slide' => $id),
                    array(
                        '%s',
                        '%s'
                    ),
                    array('%d')
                );
                if ($update_slide) {
                    echo '<div class="updated"><p><strong>';
                    echo esc_html_e('The slide was updated successfully', 'jmsslider') . '.</strong></p></div>';
                } else {
                    echo '<div id="message" class="error"><p>';
                    echo esc_html_e('Error in update process', 'jmsslider') . '.</p></div>';
                }
            } else {
                $add_slide = $wpdb->insert(
                    $wpdb->prefix . 'jms_slider_slides',
                    array(
                        'id_slider' => $id_slider,
                        'title' => $this->title,
                        'params' => $this->params,
                    ),
                    array(
                        '%d',
                        '%s',
                        '%s'
                    )
                );
                if ($add_slide) {
                    echo '<div class="updated"><p><strong>';
                    echo esc_html_e('The slide was added successfully', 'jmsslider') . '.</strong></p></div>';
                } else {
                    echo '<div id="message" class="error"><p>';
                    echo esc_html_e('Error in add process', 'jmsslider') . '.</p></div>';
                }
            }

        } else {
            echo '<div id="message" class="error"><p>';
            echo esc_html_e('Please fill all the required fields', 'jmsslider') . '.</p></div>';
        }
    }
    public function deleteSlide($id_slide) {
        global $wpdb;
        $remove_slide = $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "jms_slider_slides WHERE id_slide = %d", $id_slide );
        if( $wpdb->query($remove_slide) ) { ?>
            <div class="updated">
                <p><strong>
                        <?php echo esc_html_e( 'Item Deleted', 'jmsslider' );?>.</strong></p>
            </div>
            <?php
        }
    }
    public function upadteSlide($id_slide, $slidetitle, $slidejson, $layersjson) {
        global $wpdb;
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
    }
}