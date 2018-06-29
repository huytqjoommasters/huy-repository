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

if ( ! defined( 'ABSPATH' )) {
	exit;
}	
global $wpdb;
$query = "SELECT *  FROM " . $wpdb->prefix . "jms_sliders";
$rows = $wpdb->get_results( $query );
?>
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
	            <th scope="col" class="align-center"><span><?php echo esc_html_e( 'Slides Manager', 'jmsslider' );?></span></th>
	            <th scope="col" class="align-center"><span><?php echo esc_html_e( 'Edit', 'jmsslider' );?></span></th>
	            <th scope="col" class="align-center"><span><?php echo esc_html_e( 'Delete', 'jmsslider' );?></span></th>
	        </tr>
	    </thead>
	    <tbody id="the-list">
	    	<?php foreach($rows as $key=>$row): ?>
	        <tr>
	        	<?php 
					$list_slide_safe_link = wp_nonce_url( 'admin.php?page=jmssliderlayer&task=list_slides&id=' . esc_html($row->id_slider), 'list_slides_' . $row->id_slider, 'list_slides_nonce' );
	        		
	            	$delete_slider_safe_link = wp_nonce_url('admin.php?page=jmssliderlayer&task=remove_slider&id=' . esc_html($row->id_slider), 'delete_slider_' . $row->id_slider, 'remove_slider_nonce');
	            	$edit_slider_safe_link = wp_nonce_url( 'admin.php?page=jmssliderlayer&task=edit_slider&id=' . esc_html( $row->id_slider ), 'edit_slider_' . $row->id_slider, 'edit_slider_nonce' );
	            	$id_slider = $row->id_slider;
	            ?>
	        	<td><span>#<?php echo $row->id_slider; ?></span></td>
	            <td><a href="<?php echo esc_attr($edit_slider_safe_link); ?>"><?php echo $row->title; ?></a></td>
	            <td class="align-center"><a href="<?php echo esc_attr($list_slide_safe_link); ?>" title="<?php echo esc_html_e( 'Slides Manager', 'jmsslider' );?>"><i class="dashicons dashicons-format-gallery"></i></a></td>
	            <td class="align-center"><a href="<?php echo esc_attr($edit_slider_safe_link); ?>" title="<?php echo esc_html_e( 'Edit', 'jmsslider' );?>"><i class="dashicons dashicons-edit"></i></a></td>
	            <td class="align-center"><a href="<?php echo esc_attr($delete_slider_safe_link); ?>" class="jms-delete-item" title="<?php echo esc_html_e( 'Delete', 'jmsslider' );?>"><i class="dashicons dashicons-trash"></i></a></td>
	        </tr>
		    <?php endforeach; ?>
	    </tbody>
	</table>
	<p><strong><?php echo esc_html_e( 'Usage', 'jmsslider' );?>:</strong> <?php echo esc_html_e( 'Copy & paste the shortcode directly into any WordPress post or page', 'jmsslider' );?>.</p>
</div>