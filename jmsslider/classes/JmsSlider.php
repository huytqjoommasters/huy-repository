<?php
class JmsSlider {
    protected $title = null;
    protected $alias = null;
    protected $data_settings = null;

    public function setSettings($arr) {
        $this->data_settings = json_encode($arr);
    }

    public function setTitle($val) {
        $this->title = sanitize_text_field($val);
    }

    public function setAlias($val) {
        $this->alias = sanitize_html_class($val);
    }

    public function submitSlider($id) {
        if (empty($errors)) {
            $slider_rows = $this->sliderRows($id);
            if ( $slider_rows > 0 ) {
                echo '<div id="message" class="error"><p>' . esc_html_e('This Alias is exist, please fill other Alias', 'jmsslider') . '.</p></div>';
                return;
            }
            if (isset($id) && $id != 0) { //edit slider
                $add_slider = $this->upadteSlider();
                echo '<div class="updated"><p><strong>';
                echo esc_html_e('The slider was updated successfully', 'jmsslider') . '.</strong></p></div>';
            } else {
                $add_slider = $this->insertSlider();
                if ($add_slider) {

                    echo '<div class="updated"><p><strong>';
                    echo esc_html_e('The slider was added successfully', 'jmsslider') . '.</strong></p></div>';
                    echo '<script>
						setTimeout(function(){location.href="admin.php?page=jmssliderlayer"} , 2000);
					</script>';
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

    public function sliderRows($id) {
        global $wpdb;
        $slider_rows = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "jms_sliders WHERE id_slider != " . $id . " AND alias = '" . $this->alias . "'");
        return count($slider_rows);
    }

    public function insertSlider() {
        global $wpdb;
        return $wpdb->insert(
            $wpdb->prefix . 'jms_sliders',
            array(
                'title' => $this->title,
                'alias' => $this->alias,
                'settings' => $this->data_settings
            ),
            array(
                '%s',
                '%s',
                '%s'
            )
        );
    }

    public function upadteSlider() {
        global $wpdb;
        return $wpdb->insert(
            $wpdb->prefix . 'jms_sliders',
            array(
                'title' => $this->title,
                'alias' => $this->alias,
                'settings' => $this->data_settings
            ),
            array(
                '%s',
                '%s',
                '%s'
            )
        );
    }

    public function deleteSlider($id) {
        global $wpdb;
        $remove_slider = $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "jms_sliders WHERE id_slider = %d", $id );
        if ( ! $wpdb->query( $remove_slider ) ) { ?>
            <div id="message" class="error"><p><?php echo esc_html_e( 'Error On Remove Process', 'jmsslider' );?></p></div>
            <?php
        } else {
            $this->deleteAllSlides($id);
            ?>
            <div class="updated"><p><strong><?php echo esc_html_e( 'Item Deleted', 'jmsslider' );?>.</strong></p></div>
            <?php
        }
    }
    public function deleteAllSlides($id) {
        global $wpdb;
        $remove_slides = $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "jms_slider_slides WHERE id_slider = %d", $id );
        $wpdb->query( $remove_slides );
    }

    public function getSliderList() {
        global $wpdb;
        $query = "SELECT *  FROM " . $wpdb->prefix . "jms_sliders";
        $rows = $wpdb->get_results( $query );
        ?>
        <?php
        foreach($rows as $key=>$row):
            ?>
            <tr>
                <?php
                $delete_slider_safe_link = wp_nonce_url('admin.php?page=jmssliderlayer&task=remove_slider&id=' . esc_html($row->id_slider), 'delete_slider_' . $row->id_slider, 'remove_slider_nonce');
                $edit_slider_safe_link = wp_nonce_url( 'admin.php?page=jmssliderlayer&task=edit_slider&id=' . esc_html( $row->id_slider ), 'edit_slider_' . $row->id_slider, 'edit_slider_nonce' );
                ?>
                <td><span>#<?php echo $row->id_slider; ?></span></td>
                <td><a href="<?php echo esc_attr($edit_slider_safe_link); ?>"><?php echo $row->title; ?></a></td>
                <td class="align-center"><a href="<?php echo esc_attr($edit_slider_safe_link); ?>" title="<?php echo esc_html_e( 'Edit', 'jmsslider' );?>"><i class="dashicons dashicons-edit"></i></a></td>
                <td class="align-center"><a href="<?php echo esc_attr($delete_slider_safe_link); ?>" class="jms-delete-item" title="<?php echo esc_html_e( 'Delete', 'jmsslider' );?>"><i class="dashicons dashicons-trash"></i></a></td>
            </tr>
        <?php endforeach; ?>
        <?php
    }
}