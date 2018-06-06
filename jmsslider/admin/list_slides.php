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
$id_slider = $_GET['id'];
$slides = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "jms_slider_slides WHERE id_slider = ".$id_slider."" );
?>
<div class="wrap jmsslider">
	<?php
		$new_slide_safe_link = wp_nonce_url( 'admin.php?page=jmssliderlayer&task=add_slide&id_slider='.$id_slider, 'new_slide', 'new_slide_nonce' );
		$slider_list_safe_link = wp_nonce_url( 'admin.php?page=jmssliderlayer');
	?>

	<h2><?php echo esc_html_e( 'Slide List', 'jmsslider' );?>
		<a href="<?php echo $new_slide_safe_link; ?>" class="btn btn-success pull-right"><?php echo esc_html_e( 'Add New Slide', 'jmsslider' );?></a>
		<a href="<?php echo $slider_list_safe_link; ?>" class="btn pull-right"><?php echo esc_html_e( 'Back to Slider List', 'jmsslider' );?></a>
	</h2>
	<table class="wp-list-table widefat fixed striped posts">
	    <thead>
	        <tr>
	            <td id="cb"><span>#<?php echo esc_html_e( 'ID', 'jmsslider' );?></span></td>
	            <th scope="col"><span><?php echo esc_html_e( 'Name', 'jmsslider' );?></span></th>
	            <th scope="col" class="align-center"><span><?php echo esc_html_e( 'Layers Manager', 'jmsslider' );?></span></th>
	            <th scope="col" class="align-center"><span><?php echo esc_html_e( 'Edit', 'jmsslider' );?></span></th>
	            <th scope="col" class="align-center"><span><?php echo esc_html_e( 'Delete', 'jmsslider' );?></span></th>
	        </tr>
	    </thead>
	    <tbody id="the-list">
	    	<?php foreach($slides as $slide): ?>
	        <tr data-id="<?php echo esc_html( $slide->id_slide ); ?>">
	        	<?php
	            	$delete_slide_safe_link = wp_nonce_url('admin.php?page=jmssliderlayer&task=remove_slide&id_slider='.$id_slider.'&id=' . esc_html($slide->id_slide), 'delete_slide_' . $slide->id_slide, 'remove_slide_nonce');
	            	$edit_slide_safe_link = wp_nonce_url( 'admin.php?page=jmssliderlayer&task=edit_slide&id=' . esc_html( $slide->id_slide ).'&id_slider='.$id_slider, 'edit_slide_' . $slide->id_slide, 'edit_slide_nonce' );
					$layers_safe_link = wp_nonce_url( 'admin.php?page=jmssliderlayer&task=layers&id=' . esc_html( $slide->id_slide ), 'layers_' . $slide->id_slide, 'layers_nonce' );
	            ?>
	        	<td><span>#<?php echo $slide->id_slide; ?></span></td>
	            <td><a href="<?php echo esc_attr($edit_slide_safe_link); ?>"><?php echo $slide->title; ?></a></td>
	            <td class="align-center"><a href="<?php echo esc_attr($layers_safe_link); ?>" title="<?php echo esc_html_e( 'Layers Manager', 'jmsslider' );?>"><i class="dashicons dashicons-schedule"></i></a></td>
	            <td class="align-center"><a href="<?php echo esc_attr($edit_slide_safe_link); ?>" title="<?php echo esc_html_e( 'Edit', 'jmsslider' );?>"><i class="dashicons dashicons-edit"></i></a></td>
	            <td class="align-center"><a href="<?php echo esc_attr($delete_slide_safe_link); ?>" class="jms-delete-item" title="<?php echo esc_html_e( 'Delete', 'jmsslider' );?>"><i class="dashicons dashicons-trash"></i></a></td>
	        </tr>
		    <?php endforeach; ?>
	    </tbody>
	</table>
	<p><strong><?php echo esc_html_e( 'Usage', 'jmsslider' );?>:</strong> <?php echo esc_html_e( 'Drag & Drop Row to change Slide order', 'jmsslider' );?></p>
	<script>
		jQuery(document).ready(function($) {
			var sortEventHandler = function(event, ui){
				var trs = $('#the-list tr');
				var slides = [];
				trs.each(function(index){
					slides[index] = $(this).attr('data-id');
				});
				var slides_str = slides.join(',');
				$.ajax( {
					type   : "POST",
					url    : ajaxurl,
					data   : {
						action           : 'jmsslider_save_order',
						data             : slides_str
					},
					success: function ( data_return ) {
						var update_order = $('<div class="updated"><p><strong><?php echo esc_html_e( 'Slides ordering was updated successfully', 'jmsslider' );?>.</strong></p></div>');
						$('.jmsslider').prepend(update_order);
						setTimeout(function(){update_order.hide()} , 4000);
					}
				});

			};
			jQuery('tbody#the-list').sortable({
				stop: sortEventHandler
			});
		});
    </script>
</div>