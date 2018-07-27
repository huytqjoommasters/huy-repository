<div class="wrap jmsslider">
    <?php
    $new_slider_safe_link = wp_nonce_url( 'admin.php?page=jmssliderlayer&task=add_slider', 'new_slider', 'new_slider_nonce' );
    ?>
    <h2><?php echo esc_html_e( 'Slider list', 'jmsslider' );?>
        <a href="<?php echo $new_slider_safe_link; ?>" class="btn btn-success pull-right"><?php echo esc_html_e( 'Add New Slider', 'jmsslider' );?></a>
    </h2>
    <table class="wp-list-table widefat fixed striped posts">
        <thead>
        <tr>
            <td id="cb"><span>#<?php echo esc_html_e( 'ID', 'jmsslider' );?></span></td>
            <th scope="col"><span><?php echo esc_html_e( 'Name', 'jmsslider' );?></span></th>
            <th scope="col" class="align-center"><span><?php echo esc_html_e( 'Edit', 'jmsslider' );?></span></th>
            <th scope="col" class="align-center"><span><?php echo esc_html_e( 'Delete', 'jmsslider' );?></span></th>
        </tr>
        </thead>
        <tbody id="the-list">
        <?php
        $slider = new JmsSlider();
        $slider->getSliderList();
        ?>
        </tbody>
    </table>
    <p><strong><?php echo esc_html_e( 'Usage', 'jmsslider' );?>:</strong> <?php echo esc_html_e( 'Copy & paste the shortcode directly into any WordPress post or page', 'jmsslider' );?>.</p>
</div>