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
$id_slider = $_GET['id_slider'];	
if(isset($_GET['id'])) {
	$id = (int)$_GET['id'];	
}	
$list_slide_safe_link = wp_nonce_url( 'admin.php?page=jmssliderlayer&task=list_slides&id=' . esc_html($id_slider), 'list_slides_' . $id_slider, 'list_slides_nonce' );
$slide = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "jms_slider_slides WHERE id_slide = ".$id."" );

?>
<div class="wrap jmsslider">
	<h2><?php echo esc_html_e( 'Edit Slide', 'jmsslider' );?>
	<a href="<?php echo $list_slide_safe_link; ?>" class="btn pull-right"><?php echo esc_html_e( 'Back to Slides List', 'jmsslider' );?></a>
	</h2>
	<?php
	if($id) {
		$json = $slide->params;
		$j_setting = json_decode($json);
		$class = $j_setting->class;	
		$slide_link = isset($j_setting->slide_link) ? $j_setting->slide_link : '';	
		$bg_type = isset($j_setting->bg_type) ? $j_setting->bg_type : '';	
		$bg_color = isset($j_setting->bg_color) ? $j_setting->bg_color : '';	
		$bg_image = isset($j_setting->bg_image) ? $j_setting->bg_image : '';	
	}	
	?>		
	<form action="#" method="POST" class="edit-form">
		<div class="option-block col-6">
			<h3><?php echo esc_html_e( 'General', 'jmsslider' );?></h3>
			<div class="row-input">
				<label for="bg_type"><?php echo esc_html_e( 'Slide Title', 'jmsslider' );?></label>
				<input type="text" name="title" value="<?php if(!empty($slide->title)) {echo $slide->title;} else {echo 'New slide';} ?>" placeholder="<?php echo esc_html_e( 'Enter your Slide Name here', 'jmsslider' );?>" autofocus="autofocus">
			</div>
			<div class="row-input">
				<label for="bg_type"><?php echo esc_html_e( 'Slide Class Suffix', 'jmsslider' );?></label>
				<input type="text" name="class" value="<?php if(!empty($class)) {echo $class;} else {echo '';} ?>" placeholder="<?php echo esc_html_e( 'Enter your Slide Class here', 'jmsslider' );?>" />
			</div>
			<div class="row-input">
				<label for="bg_type"><?php echo esc_html_e( 'Slide Link', 'jmsslider' );?></label>
				<input type="text" name="slide_link" value="<?php if(isset($slide_link) && !empty($slide_link)) {echo $slide_link;} else {echo '#';} ?>" placeholder="<?php echo esc_html_e( 'Enter your Slide Link here', 'jmsslider' );?>" />
			</div>
		</div>
		<div class="option-block col-6">
			<h3><?php echo esc_html_e( 'Background', 'jmsslider' );?></h3>
			<div class="row-input image">
				<label for="bg_type"><?php echo esc_html_e( 'Background Image', 'jmsslider' );?></label>
				<input type="radio" id="bg_image" name="bg_type" value="image" <?php if(isset($bg_type) && $bg_type == 'image') {?>checked="checked"<?php } ?> > <?php echo esc_html_e( 'Image', 'jmsslider' );?>
				<input type="hidden" id="image_url" name="image_url" value="<?php if(isset($bg_type) && !empty($bg_image)) { echo $bg_image; }?>" >
				<button id="pick_images" class="button"><?php echo esc_html_e( 'Select Images', 'jmsslider' );?></button>
				<?php if(!empty($bg_image)) {?><div class="img-preview"><span class="button"><?php echo esc_html_e( 'Preview', 'jmsslider' );?></span><img src="<?php echo site_url().$bg_image;?>" /></div><?php } ?>
			</div>
			<div class="row-input">
				<label for="bg_type"><?php echo esc_html_e( 'Background Color', 'jmsslider' );?></label>
				<input type="radio" id="bg_color" name="bg_type" value="color" <?php if(isset($bg_type) && $bg_type == 'color') {?>checked="checked"<?php } ?>> <?php echo esc_html_e( 'Color', 'jmsslider' );?>
				<input style="display:inline-block;" type="text" class="pick_color" name="bg_color" id="bg_color" value="<?php if(isset($bg_color) && !empty($bg_color)) { echo $bg_color; }?>" data-default-color="#ffffff">
			</div>
		</div>
		<input type="submit" name="submit" class="btn btn-success fixed-right" value="Save">
		<input type="hidden" name="id_slide" value="<?php echo $id; ?>">
		<input type="hidden" name="id_slider" value="<?php echo $id_slider; ?>">
		<input type="hidden" id="site_url" name="site_url" value="<?php echo site_url(); ?>">
	</form>
</div>
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$id_slider = $_POST['id_slider'];
		$errors = array();
		if (empty($_POST['title'])) {
			$errors[] = 'title';
		} else {
			$title = sanitize_text_field($_POST['title']);
		}
		$slide_link = sanitize_text_field($_POST['slide_link']);				
		$class = sanitize_html_class($_POST['class']);		
		$bg_type = $_POST['bg_type'];
		$image_url = sanitize_text_field($_POST['image_url']);		
		$bg_color = sanitize_text_field($_POST['bg_color']);
		$m = array(
			'slide_link' 	=> $slide_link,
			'class'       	=> $class,
			'bg_type'		=> $bg_type,
			'bg_image'		=> $image_url,
			'bg_color'		=> $bg_color
		);

		$data_setting = json_encode($m);

		if (empty($errors)) {
			global $wpdb;
			if (isset($id) && $id != 0) { //edit slide
				$update_slide = $wpdb->update(
					$wpdb->prefix . 'jms_slider_slides',
					array( 						
						'title'     => $title,
						'params'  => $data_setting
					),
					array( 'id_slide' => $id ), 
					array( 						
						'%s', 
						'%s'
					),
					array( '%d' )	
				);
				if($update_slide) {
					echo '<div class="updated"><p><strong>'; echo esc_html_e( 'The slide was updated successfully', 'jmsslider' ).'.</strong></p></div>';
					echo '<script>
						setTimeout(function(){location.href="admin.php?page=jmssliderlayer&task=list_slides&id='.$id_slider.'"} , 5000);
					</script>';	
				} else {
					echo '<div id="message" class="error"><p>'; echo esc_html_e( 'Error in update process', 'jmsslider' ).'.</p></div>';
				}					
			} else {
				$add_slide = $wpdb->insert( 
					$wpdb->prefix . 'jms_slider_slides',
					array( 
						'id_slider' => $id_slider,
						'title'     => $title,
						'params'  => $data_setting,
					), 
					array( 
						'%d', 
						'%s', 
						'%s' 
					) 
				);
				if($add_slide) {
					echo '<div class="updated"><p><strong>'; echo esc_html_e( 'The slide was added successfully', 'jmsslider' ).'.</strong></p></div>';
					echo '<script>
						setTimeout(function(){location.href="admin.php?page=jmssliderlayer&task=list_slides&id='.$id_slider.'"} , 5000);
					</script>';	
				} else {
					echo '<div id="message" class="error"><p>'; echo esc_html_e( 'Error in add process', 'jmsslider' ).'.</p></div>';
				}
			}
			
		} else {
			echo '<div id="message" class="error"><p>'; echo esc_html_e( 'Please fill all the required fields', 'jmsslider' ).'.</p></div>';
		}
	} //End if submit condition	
	


?>

