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
?>
<div class="slider-wrapper">
	<div class="responisve-container">
		<div class="slider">
			<div class="fs_loader"></div>
			<?php 
				global $wpdb;
				$q = "SELECT *  FROM " . $wpdb->prefix . "jms_sliders WHERE alias = '".$alias."'";
				$slider = $wpdb->get_row( $q );					
				$q = "SELECT *  FROM ". $wpdb->prefix ."jms_slider_slides WHERE id_slider = ".$slider->id_slider." ORDER BY slide_order ASC";
				$slides = $wpdb->get_results( $q );		
				$setting = json_decode($slider->settings, true);
			?>

			<?php foreach($slides as $slide) : ?>
				<?php $params = json_decode($slide->params, true); ?>
					<div class="slide <?php echo esc_attr($params['class']); ?>" id="slide_<?php echo intval($slide->id_slide); ?>" style="<?php if ($params['bg_type'] == 'color') { echo 'background-color: '.esc_attr($params['bg_color']).';'; } elseif($params['bg_type'] == 'image') { if(strpos($params['bg_image'], "http") !== false) $bg_url = $params['bg_image']; else $bg_url = site_url().$params['bg_image']; echo 'background: url('. esc_url($bg_url) .') no-repeat scroll center center / cover;';  } ?>">
						<?php $layers = json_decode($slide->layers, true);
						if(count($layers) > 0)
						foreach($layers as $layer) : ?>
						<?php if($layer['type'] == 'text') { ?>
							<div class="<?php if(isset($layer['class'])) echo esc_attr($layer['class']);?>" data-position-mobile="500,100" data-position="<?php echo intval($layer['y']);?>,<?php echo intval($layer['x']);?>" <?php if(isset($layer['delay'])) {?>data-delay="<?php echo intval($layer['delay']);?>"<?php } ?> <?php if(isset($layer['time'])) {?>data-time="<?php echo intval($layer['time']);?>"<?php } ?> <?php if(isset($layer['in'])) {?>data-in="<?php echo esc_attr($layer['in']);?>"<?php } ?> <?php if(isset($layer['step'])) {?>data-step="<?php echo esc_attr($layer['step']);?>"<?php } ?> <?php if(isset($layer['out'])) {?>data-out="<?php echo esc_attr($layer['out']);?>"<?php } ?> <?php if(isset($layer['ease_in'])) {?>data-ease-in="<?php echo esc_attr($layer['ease_in']);?>"<?php } ?> <?php if(isset($layer['ease_out'])) {?>data-ease-out="<?php echo esc_attr($layer['ease_out']);?>"<?php } ?> <?php if(isset($layer['transform_in'])) {?>data-transform-in="<?php echo esc_attr($layer['transform_in']);?>"<?php } ?> <?php if(isset($layer['transform_out'])) {?>data-transform-out="<?php echo esc_attr($layer['transform_out']);?>"<?php } ?> <?php if(isset($layer['special'])) {?>data-special="<?php echo esc_attr($layer['special']);?>"<?php } ?> <?php if(isset($layer['mfontsize'])) {?>data-mfontsize="<?php echo intval($layer['mfontsize']);?>"<?php } ?> style="<?php if(isset($layer['z_index'])) {?> z-index:<?php echo intval($layer['z_index']);?>;<?php } ?><?php if(isset($layer['fontsize'])) {?> font-size:<?php echo $layer['fontsize'].'px';?>;<?php } ?><?php if(isset($layer['textcolor'])) {?> color:<?php echo $layer['textcolor'];?>;<?php } ?><?php if(isset($layer['fontstyle'])) {?> font-style:<?php echo $layer['fontstyle'];?>;<?php } ?><?php if(isset($layer['fontweight'])) {?> font-weight:<?php echo $layer['fontweight'];?>;<?php } ?><?php if(isset($layer['texttransform'])) {?> text-transform:<?php echo $layer['texttransform'];?>;<?php } ?><?php if(isset($layer['letterspacing'])) {?> letter-spacing:<?php echo $layer['letterspacing'];?>;<?php } ?>" <?php if(isset($layer['align'])) {?>data-align="<?php echo $layer['align'];?>"<?php } ?> <?php if(isset($layer['offset'])) {?>data-offset="<?php echo $layer['offset'];?>"<?php } ?> <?php if(isset($layer['fontstyle'])) {?>data-fontstyle="<?php echo $layer['fontstyle'];?>"<?php } ?> <?php if(isset($layer['fontweight'])) {?>data-fontweight="<?php echo $layer['fontweight'];?>"<?php } ?> <?php if(isset($layer['letterspacing'])) {?>data-letterspacing="<?php echo $layer['letterspacing'];?>"<?php } ?> <?php if(isset($layer['letterspacing'])) {?>data-letterspacing="<?php echo $layer['letterspacing'];?>"<?php } ?> <?php if(isset($layer['texttransform'])) {?>data-texttransform="<?php echo $layer['texttransform'];?>"<?php } ?>>
								<?php echo $layer['text'];?>
							</div>
							<?php } ?>
							<?php if($layer['type'] == 'link') { ?>
							<div class="<?php if(isset($layer['class'])) echo esc_attr($layer['class']);?>" data-position="<?php echo intval($layer['y']);?>,<?php echo intval($layer['x']);?>" <?php if(isset($layer['delay'])) {?>data-delay="<?php echo intval($layer['delay']);?>"<?php } ?> <?php if(isset($layer['time'])) {?>data-time="<?php echo intval($layer['time']);?>"<?php } ?> <?php if(isset($layer['in'])) {?>data-in="<?php echo esc_attr($layer['in']);?>"<?php } ?> <?php if(isset($layer['step'])) {?>data-step="<?php echo esc_attr($layer['step']);?>"<?php } ?> <?php if(isset($layer['out'])) {?>data-out="<?php echo esc_attr($layer['out']);?>"<?php } ?> <?php if(isset($layer['ease_in'])) {?>data-ease-in="<?php echo esc_attr($layer['ease_in']);?>"<?php } ?> <?php if(isset($layer['ease_out'])) {?>data-ease-out="<?php echo esc_attr($layer['ease_out']);?>"<?php } ?> <?php if(isset($layer['transform_in'])) {?>data-transform-in="<?php echo esc_attr($layer['transform_in']);?>"<?php } ?> <?php if(isset($layer['transform_out'])) {?>data-transform-out="<?php echo esc_attr($layer['transform_out']);?>"<?php } ?> <?php if(isset($layer['special'])) {?>data-special="<?php echo esc_attr($layer['special']);?>"<?php } ?> <?php if(isset($layer['mfontsize'])) {?>data-mfontsize="<?php echo intval($layer['mfontsize']);?>"<?php } ?> style="" <?php if(isset($layer['align'])) {?>data-align="<?php echo $layer['align'];?>"<?php } ?> <?php if(isset($layer['offset'])) {?>data-offset="<?php echo $layer['offset'];?>"<?php } ?>>
								<a class="button-slider" style="<?php if(isset($layer['z_index'])) {?> z-index:<?php echo intval($layer['z_index']);?>;<?php } ?><?php if(isset($layer['fontsize'])) {?> font-size:<?php echo $layer['fontsize'].'px';?>;<?php } ?><?php if(isset($layer['textcolor'])) {?> color:<?php echo $layer['textcolor'];?>;<?php } ?><?php if(isset($layer['fontstyle'])) {?> font-style:<?php echo $layer['fontstyle'];?>;<?php } ?><?php if(isset($layer['fontweight'])) {?> font-weight:<?php echo $layer['fontweight'];?>;<?php } ?>" href="<?php if(isset($layer['link'])) {?><?php echo $layer['link']; } else { echo "#"; } ?>"><?php echo $layer['text'];?></a>
							</div>
							<?php } ?>
							<?php if($layer['type'] == 'image') { ?>
							<img src="<?php if(strpos($layer['url'], "http") !== false) echo $layer['url']; else echo site_url().$layer['url'];?>" alt="image layer" class="<?php if(isset($layer['class'])) echo esc_attr($layer['class']);?>" data-position="<?php echo intval($layer['y']);?>,<?php echo intval($layer['x']);?>" <?php if(isset($layer['delay'])) {?>data-delay="<?php echo intval($layer['delay']);?>"<?php } ?> <?php if(isset($layer['time'])) {?>data-time="<?php echo intval($layer['time']);?>"<?php } ?> <?php if(isset($layer['in'])) {?>data-in="<?php echo esc_attr($layer['in']);?>"<?php } ?> <?php if(isset($layer['step'])) {?>data-step="<?php echo esc_attr($layer['step']);?>"<?php } ?> <?php if(isset($layer['out'])) {?>data-out="<?php echo esc_attr($layer['out']);?>"<?php } ?> <?php if(isset($layer['ease_in'])) {?>data-ease-in="<?php echo esc_attr($layer['ease_in']);?>"<?php } ?> <?php if(isset($layer['ease_out'])) {?>data-ease-out="<?php echo esc_attr($layer['ease_out']);?>"<?php } ?> <?php if(isset($layer['transform_in'])) {?>data-transform-in="<?php echo esc_attr($layer['transform_in']);?>"<?php } ?> <?php if(isset($layer['transform_out'])) {?>data-transform-out="<?php echo esc_attr($layer['transform_out']);?>"<?php } ?> <?php if(isset($layer['special'])) {?>data-special="<?php echo esc_attr($layer['special']);?>"<?php } ?> style="z-index:<?php if(isset($layer['z_index'])) echo intval($layer['z_index']);?>;" />
							<?php } ?>
							<?php if($layer['type'] == 'video') { ?>
								<?php if ($layer['videotype'] == 'youtube') { ?>
									<iframe <?php if ($layer['videobg'] == '1'){ ?> width="<?php echo intval($setting['max_width']);?>" height="<?php echo intval($setting['max_height']);?>" <?php } else { ?>width="<?php echo intval($layer['width']);?>px;" height="<?php echo intval($layer['height']);?>px;"<?php } ?> src="https://www.youtube.com/embed/<?php echo esc_attr($layer['videoid']);?>?autoplay=<?php echo esc_attr($layer['autoplay']);?>&controls=<?php echo esc_attr($layer['controls']);?>&loop=<?php echo esc_attr($layer['loop']);?>" allowfullscreen frameborder="0" style="z-index:<?php echo intval($layer['z_index']);?>;"></iframe>
								<?php } elseif ($layer['videotype'] == 'vimeo') {?>
									<iframe <?php if ($layer['videobg'] == '1'){ ?> width="<?php echo intval($setting['max_width']);?>" height="<?php echo intval($setting['max_height']);?>" <?php } else { ?>width="<?php echo intval($layer['width']);?>px;" height="<?php echo intval($layer['height']);?>px;"<?php } ?> src="https://player.vimeo.com/video/<?php echo esc_attr($layer['videoid']);?>?autoplay=<?php echo esc_attr($layer['autoplay']);?>&loop=<?php echo esc_attr($layer['loop']);?>" allowfullscreen frameborder="0" style="z-index:<?php echo intval($layer['z_index']);?>;"></iframe>
								<?php } ?>
							<?php } ?>
						<?php endforeach; ?>
					</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($) {
		$('.slider-wrapper .slider').fractionSlider({
            'delay': <?php if( (int) $setting['delay'] > 0 ) { echo esc_js($setting['delay']); } else { echo '500'; } ?>,
            'timeout': <?php if( (int) $setting['duration'] > 0 ) { echo esc_js($setting['duration']); } else { echo '1500'; } ?>,
            'autoChange': <?php if($setting['auto_change'] == 1) { echo 'true'; } else { echo 'false'; } ?>,
            'controls': <?php if($setting['show_controls'] == 1) echo 'true'; else echo 'false'; ?>,
            'pager': <?php if($setting['show_pagers'] == 1) echo 'true'; else echo 'false'; ?>,
            'responsive': <?php if($setting['responsive'] == 1) echo 'true'; else echo 'false'; ?>,
            'dimensions': "<?php echo (int) $setting['max_width'];?>, <?php echo (int) $setting['max_height'];?>",
			'mobileHeight':<?php echo (int) $setting['mobile_height'];?>,
            'pauseOnHover': <?php if($setting['pause_hover'] == 1) echo 'true'; else echo 'false'; ?>,
            'backgroundEase': '<?php echo esc_attr($setting['background_ease']); ?>',
            'speedIn': <?php if( (int) $setting['speed_in'] > 0 ) { echo esc_js($setting['speed_in']); } else { echo '500'; } ?>,
            'speedOut': <?php if( (int) $setting['speed_out'] > 0 ) { echo esc_js($setting['speed_out']); } else { echo '500'; } ?>,
			'fullWidth': <?php if($setting['full_width'] == '1') echo 'true'; else echo 'false'; ?>,
  			'fullHeight': <?php if($setting['full_height'] == '1') echo 'true'; else echo 'false'; ?>,
            'easeIn': '<?php echo esc_attr($setting['ease_in']);?>',
            'easeOut': '<?php echo esc_attr($setting['ease_out']);?>',
            'transitionIn': '<?php echo esc_attr($setting['transition_in']);?>',
            'transitionOut': '<?php echo esc_attr($setting['transition_out']);?>',
			'slideTransition' : 'fade',
			'slideTransitionSpeed' : 200,
			'slideEndAnimation' : true,
			'backgroundAnimation': <?php if($setting['background_animate'] == 1) echo 'true'; else echo 'false'; ?>
		});
    });
</script>