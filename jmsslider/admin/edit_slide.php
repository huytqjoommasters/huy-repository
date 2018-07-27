<div class="wrap jmsslider">
	<h2>
        <?php echo esc_html_e( 'Edit Slide', 'jmsslider' );?>
	</h2>
	<?php
global $wpdb;
$id_slider = $_GET['id_slider'];	
if(isset($_GET['id'])) {
	$id = (int)$_GET['id'];	
}
$list_slide_safe_link = wp_nonce_url( 'admin.php?page=jmssliderlayer&task=list_slides&id=' . esc_html($id_slider), 'list_slides_' . $id_slider, 'list_slides_nonce' );
$slide = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "jms_slider_slides WHERE id_slide = ".$id."" );
$edit_slider_safe_link = wp_nonce_url( 'admin.php?page=jmssliderlayer&task=edit_slider&id=' . esc_html( $id_slider ), 'edit_slider_' . $id_slider, 'edit_slider_nonce' );
$add_slide_safe_link = wp_nonce_url( 'admin.php?page=jmssliderlayer&task=edit_slider&id=' . esc_html( $id_slider ), 'add_slide', 'edit_slider_nonce' );
?>
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
	<form action="<?php echo $add_slide_safe_link; ?>" method="POST" class="edit-form">
		<div class="option-block col-5">
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
		<div class="option-block col-5">
			<h3><?php echo esc_html_e( 'Background', 'jmsslider' );?></h3>
			<div class="row-input image">
				<label for="bg_type"><?php echo esc_html_e( 'Background Image', 'jmsslider' );?></label>
				<input type="radio" id="bg_image" name="bg_type" value="image" <?php if(isset($bg_type) && $bg_type == 'image') {?>checked="checked"<?php } ?> > <?php echo esc_html_e( 'Image', 'jmsslider' );?>
				<input type="hidden" id="image_url" name="image_url" value="<?php if(isset($bg_type) && !empty($bg_image)) { echo $bg_image; }?>" >
                <input type="hidden" id="root_url" name="root_url" value="<?php echo site_url(); ?>"/>
                <button id="pick_images" class="button"><?php echo esc_html_e( 'Select Images', 'jmsslider' );?></button>
				<?php if(!empty($bg_image)) {?><div class="img-preview"><span class="button"><?php echo esc_html_e( 'Preview', 'jmsslider' );?></span><img src="<?php echo site_url().$bg_image;?>" /></div><?php } ?>
			</div>
			<div class="row-input">
				<label for="bg_type"><?php echo esc_html_e( 'Background Color', 'jmsslider' );?></label>
				<input type="radio" id="bg_color" name="bg_type" value="color" <?php if(isset($bg_type) && $bg_type == 'color') {?>checked="checked"<?php } ?>> <?php echo esc_html_e( 'Color', 'jmsslider' );?>
				<input style="display:inline-block;" type="text" class="pick_color" name="bg_color" id="bg_color" value="<?php if(isset($bg_color) && !empty($bg_color)) { echo $bg_color; }?>" data-default-color="#ffffff">
			</div>
		</div>
		<input type="hidden" name="id_slide" value="<?php echo $id; ?>">
		<input type="hidden" name="id_slider" value="<?php echo $id_slider; ?>">
		<input type="hidden" id="site_url" name="site_url" value="<?php echo site_url(); ?>">
        <ul class="btn-action">
            <li>
                <button type="submit" name="slide_submit"
                        class="btn-save fixed-right" title="<?php echo esc_html_e('Save', 'jmsslider'); ?>">
                    <i class="dashicons dashicons-welcome-write-blog"></i>
                </button>
            </li>
            <li>
                <a href="<?php echo $edit_slider_safe_link; ?>"
                   class="btn-back" title="<?php echo esc_html_e('Back to Slider Manager', 'jmsslider'); ?>">
                    <i class="dashicons dashicons-arrow-left-alt"></i>
                </a>
            </li>
        </ul>
	</form>
</div>