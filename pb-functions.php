<?php
/**
 * Outputs checked="checked" if the value is checked
 */
function pb_checked( $value, $optionname ) {
	if ($optionname == $value)
		echo ' checked="checked"';	
}


/**
 * Outputs selected="selected" if the value is selected
 */
function pb_selected( $value, $optionname ) {
	if ($optionname == $value)
		echo ' selected="selected"';	
}


/**
 * Add options page
 */
function pb_plugin_menu() {
	// Create a new options page
	$plugin_page = add_options_page( 'Pirobox Extended', 'Pirobox Extended', 'manage_options', 'pb-options', 'pb_options');
	add_action ('admin_head-' . $plugin_page, 'pb_add_css');
}


/**
 * Add CSS file to admin page
 */
function pb_add_css() {
	echo '<link href="' . PB_URL . 'css/pb-admin.css" rel="stylesheet" type="text/css" />';
}


/**
 * Register settings
 */
function pb_register_settings() {
	// Register the settings
	register_setting( 'pb_settings', 'pb_settings' );
}


/**
 * Plugin activation hook
 */
function pb_activate() {
	// Only send if the plugin hasn't been activated before
	$isinstalled = get_option('pb_version');
	
	if (!$isinstalled) {
		// Send email to the adminstrator of the site
	}
	
	// Update version
	update_option( 'pb_version', PB_VERSION );
	
	// Check to see if there are any default settings
	$hasglobaloptions = get_option('pb_settings');
	
	if (!$hasglobaloptions) {
		$defaultoptions = array(
			'global_speed'			=>		'900',
			'global_opacity'		=>		'0.5',
			'global_center'			=>		'true',
			'zoom_option'			=>		'true',
			'zoom_animation'		=>		'mousemove',
			'enable_post_type_post' =>		1,
			'enable_post_type_page' =>		1,
			'enable_by_default' 	=>		'on',
			'default_style' 		=>		'style_2',
			'global_share'			=>		'true'
		);
		update_option('pb_settings', $defaultoptions);
	}
}


/**
 * Global Options Page
 */
function pb_options(){ 
	global $pb_style_array, $pb_background_opacity, $pb_animation_speed, $pb_zoom_animation;	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div><h2><?php _e('Pirobox Extended'); ?></h2>
		<p><?php _e('Insert beautiful and flexible lightboxes into your Wordpress site with ease.'); ?></p>
		
		<form method="post" action="options.php">
			<?php
			settings_fields( 'pb_settings' );
			$options = get_option( 'pb_settings' );
			?>
			<h3><?php _e('Global Behavior'); ?></h3>
			<table class="form-table">
				<tr valign="top"><th scope="row"><label for="pb_settings[default_style]"><?php _e( 'Default Style' ); ?></label></th>
					<td>
						<select id="pb_settings[default_style]" name="pb_settings[default_style]">
							<?php foreach ($pb_style_array as $style) : ?>
								<option value="<?php echo $style['value']; ?>" <?php pb_selected($style['value'], $options['default_style']); ?>><?php echo $style['label']; ?></option>
							<?php endforeach; ?>
						</select>
						<img src="<?php echo PB_URL;?>/images/style1.jpg" alt="" />
						<img src="<?php echo PB_URL;?>/images/style2.jpg" alt="" />
						<img src="<?php echo PB_URL;?>/images/style3.jpg" alt="" />
						<img src="<?php echo PB_URL;?>/images/style4.jpg" alt="" />
					</td>
				</tr>
			
				<tr valign="top"><th scope="row"><label for="pb_settings[global_speed]"><?php _e( 'Transition Speed' ); ?></label></th>
					<td>
						<select id="pb_settings[global_speed]" name="pb_settings[global_speed]">
							<?php foreach ($pb_animation_speed as $speed) : ?>
								<option value="<?php echo $speed['value']; ?>" <?php pb_selected($speed['value'], $options['global_speed']); ?>><?php echo $speed['label']; ?></option>
							<?php endforeach; ?>
						</select>
						<span class="description"><?php _e( 'Enter a number in milliseconds used for transition speed.' ); ?></span>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Zoom Option' ); ?></th>
					<td>
						<input type="radio" name="pb_settings[zoom_option]" id="pb_settings_zoom_option_on" value="true" <?php if ($options['zoom_option'] == 'true') echo ' checked="checked"'; ?>/> <label for="pb_settings_zoom_option_on" style="padding-right: 15px;"><?php _e('Enabled'); ?></label>
						<input type="radio" name="pb_settings[zoom_option]" id="pb_settings_zoom_option_off" value="false" <?php if ($options['zoom_option'] == 'false') echo ' checked="checked"'; ?> /> <label for="pb_settings_zoom_option_off" style="padding-right: 15px;"><?php _e('Disabled'); ?></label><br />
						<span class="description"><?php _e('Enable zooming for large images'); ?></span>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><label for="pb_settings[zoom_animation]"><?php _e( 'Zoom Animation' ); ?></label></th>
					<td>
						<select id="pb_settings[zoom_animation]" name="pb_settings[zoom_animation]">
							<?php foreach ($pb_zoom_animation as $animation) : ?>
								<option value="<?php echo $animation['value']; ?>" <?php pb_selected($animation['value'], $options['zoom_animation']); ?>><?php echo $animation['label']; ?></option>
							<?php endforeach; ?>
						</select>
						<span class="description"><?php _e('Select the type of animation for large images.'); ?></span>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><label for="pb_settings[global_opacity]"><?php _e( 'Opacity' ); ?></label></th>
					<td>
						<select id="pb_settings[global_opacity]" name="pb_settings[global_opacity]">
							<?php foreach ($pb_background_opacity as $opacity) : ?>
								<option value="<?php echo $opacity['value']; ?>" <?php pb_selected($opacity['value'], $options['global_opacity']); ?>><?php echo $opacity['label']; ?></option>
							<?php endforeach; ?>
						</select>
						<span class="description"><?php _e( 'Enter a decimal that will be used to determine the Priobox\'s opacity.' ); ?></span>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Center Pirobox on page' ); ?></th>
					<td>
						<input type="radio" name="pb_settings[global_center]" id="pb_settings_global_center_on" value="true" <?php if ($options['global_center'] == 'true') echo ' checked="checked"'; ?>/> <label for="pb_settings_global_center_on" style="padding-right: 15px;"><?php _e('Yes'); ?></label>
						<input type="radio" name="pb_settings[global_center]" id="pb_settings_global_center_off" value="false" <?php if ($options['global_center'] == 'false') echo ' checked="checked"'; ?> /> <label for="pb_settings_global_center_off" style="padding-right: 15px;"><?php _e('No'); ?></label><br />
						<span class="description"><?php _e('Keeping this option on will make sure that the Pirobox is always display in the center of the page.'); ?></span>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Enable Share Features' ); ?></th>
					<td>
						<input type="radio" name="pb_settings[global_share]" id="pb_settings_global_share_on" value="true" <?php if ($options['global_share'] == 'true') echo ' checked="checked"'; ?>/> <label for="pb_settings_global_share_on" style="padding-right: 15px;"><?php _e('Enabled'); ?></label>
						<input type="radio" name="pb_settings[global_share]" id="pb_settings_global_share_off" value="false" <?php if ($options['global_share'] == 'false') echo ' checked="checked"'; ?> /> <label for="pb_settings_global_share_off" style="padding-right: 15px;"><?php _e('Disabled'); ?></label><br />
						<span class="description"><?php _e('This option will enabling sharing of Pirobox content via Facebook and Twitter.'); ?></span>
					</td>
				</tr>
				
			</table>
			
			<h3><?php _e('Implementation'); ?></h3>
			<table class="form-table">
				<tr valign="top"><th scope="row"><?php _e( 'Enable on these post types' ); ?></th>
					<td>
						<?php
						$post_types=get_post_types();
						foreach ($post_types as $post_type ) :
						?>
							<input type="checkbox" id="pb_settings[enable_post_type_<?php echo $post_type; ?>]" name="pb_settings[enable_post_type_<?php echo $post_type; ?>]" value="1" <?php pb_checked($options['enable_post_type_' . $post_type], 1); ?> />
							<label class="description" for="pb_settings[enable_post_type_<?php echo $post_type; ?>]"><?php _e( $post_type ); ?></label><br />
						<?php endforeach; ?>
					</td>
				</tr>
					
				<tr valign="top"><th scope="row"><?php _e( 'Enable on a post per post basis' ); ?></th>
					<td>
						<input type="radio" name="pb_settings[enable_by_default]" id="pb_settings_enable_by_default_on" value="on" <?php if ($options['enable_by_default'] == 'on') echo ' checked="checked"'; ?>/> <label for="pb_settings_enable_by_default_on" style="padding-right: 15px;"><?php _e('On'); ?></label>
						<input type="radio" name="pb_settings[enable_by_default]" id="pb_settings_enable_by_default_off" value="off" <?php if ($options['enable_by_default'] == 'off') echo ' checked="checked"'; ?> /> <label for="pb_settings_enable_by_default_off" style="padding-right: 15px;"><?php _e('Off'); ?></label><br />
						<span class="description"><?php _e('This option will enable the global Pirobox options on all the above selected post types by default.'); ?></span>
					</td>
				</tr>
								
			</table>
			<p class="submit">
		    	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		    </p>
		</form>
	</div><!-- .wrap -->
<?php }


/**
 * Add our meta box
 */
function pb_add_meta() {
	$options = get_option( 'pb_settings' );
	$post_types = get_post_types();
	foreach ($post_types as $post_type ) :
		if ($options['enable_post_type_' . $post_type]) {
			add_meta_box('myplugin_sectionid',
				__( 'Pirobox Settings', 'pb_domain' ), 
				'pb_output_meta',
				$post_type
			);
		}
	endforeach;
}


/**
 * Save the meta information
 */
function pb_save_post( $post_id ) {
	/**
	 * Verify if this is an auto save routine. 
	 * If it is our form has not been submitted, so we dont want to do anything
	 */
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;


	/**
	 * Verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times
	 */
	if ( !wp_verify_nonce( $_POST['pb_noncename'], plugin_basename( __FILE__ ) ) )
		return;


	/**
	 * Check permissions
	 */
	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
			return;
	}
	else {
		if ( !current_user_can( 'edit_post', $post_id ) )
			return;
	}

	
	/**
	 * OK, we're authenticated: we need to find and save the data
	 */
	$mydata = $_POST['pb_meta'];
	//$mydata = $_POST;
	update_post_meta($post_id, '_pb_meta', $mydata);
}


/**
 * Output the meta information
 */
function pb_output_meta( $post ) {
	global $pb_style_array, $pb_background_opacity, $pb_animation_speed, $pb_zoom_animation;

	/**
	 * Use nonce for verification
	 */
	wp_nonce_field( plugin_basename( __FILE__ ), 'pb_noncename' );

	
	/**
	 * Get global options
	 */
	$options = get_option( 'pb_settings' );

	
	/**
	 * Get the data and populate with
	 * global data if nothing is found
	 */
	$meta = get_post_meta($post->ID,'_pb_meta',TRUE);
	
	if (!$meta) {
		if ($options['enable_by_default'] == 'on')
			$option_translation = 'global';
		else
			$option_translation = 'off';
			
		$meta = array(
			'mode'				=>		$option_translation,
			'speed'				=>		$options['global_speed'],
			'opacity'			=>		$options['global_opacity'],
			'center'			=>		$options['global_center'],
			'style'				=>		$options['default_style'],
			'share'				=>		$options['global_share'],
			'zoom_option'		=>		$options['zoom_option'],
			'zoom_animation'	=>		$options['zoom_animation']
		);
	}
	?>
	<style type="text/css">
		.pb_custom select { width: 200px; }
	</style>
	<h4><?php _e('Mode'); ?></h4>
	<p>
		<input type="radio" name="pb_meta[mode]" id="pb_mode_off" value="off" class="pb_mode" <?php if ($meta['mode'] == 'off') echo ' checked="checked"'; ?> /> <label for="pb_mode_off" style="padding-right: 15px;">Off</label>
		<input type="radio" name="pb_meta[mode]" id="pb_mode_global" value="global" class="pb_mode" <?php if ($meta['mode'] == 'global') echo ' checked="checked"'; ?> /> <label for="pb_mode_global" style="padding-right: 15px;">Use Global Settings</label>
		<input type="radio" name="pb_meta[mode]" id="pb_mode_perpage" value="perpage" class="pb_mode" <?php if ($meta['mode'] == 'perpage') echo ' checked="checked"'; ?> /> <label for="pb_mode_perpage">Use Per Page Settings</label>
	</p>
	<div class="pb_global" <?php if (($meta['mode'] == 'off') || ($meta['mode'] == 'perpage')) echo ' style="display: none;"'; ?>>
		<h4 style="margin: 0; padding: 1.33em 0 1em;"><?php _e('Global Settings'); ?></h4>
		<table class="form-table" style="margin-top: 0;">
			<tr valign="top"><th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Style' ); ?></th>
				<td style="padding-top: 0;">
					<?php echo $options['default_style']; ?>
				</td>
			</tr>
			<tr valign="top"><th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Transition Speed' ); ?></th>
				<td style="padding-top: 0;">
					<?php echo $options['global_speed']; ?>
				</td>
			</tr>
			<tr valign="top"><th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Zoom Option' ); ?></th>
				<td style="padding-top: 0;">
					<?php echo $options['zoom_option']; ?>
				</td>
			</tr>
			<tr valign="top"><th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Zoom Animation' ); ?></th>
				<td style="padding-top: 0;">
					<?php echo $options['zoom_animation']; ?>
				</td>
			</tr>
			<tr valign="top"><th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Opacity' ); ?></th>
				<td style="padding-top: 0;">
					<?php echo $options['global_opacity']; ?>
				</td>
			</tr>
			<tr valign="top"><th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Center Pirobox on page' ); ?></th>
				<td style="padding-top: 0;">
					<?php echo $options['global_center']; ?>
				</td>
			</tr>
			<tr valign="top"><th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Enable Sharing Features' ); ?></th>
				<td style="padding-top: 0;">
					<?php echo $options['global_share']; ?>
				</td>
			</tr>
			
		</table>
	</div>
	<div class="pb_custom" <?php if (($meta['mode'] == 'off') || ($meta['mode'] == 'global')) echo ' style="display: none;"'; ?>>
		<h4 style="margin: 0; padding: 1.33em 0;"><?php _e('Per Page Settings'); ?></h4>
		<table class="form-table" style="margin-top: 0;">
			<tr valign="top"><th scope="row" style="padding-left: 0; padding-right: 0;"><label for="pb_settings[style]"><?php _e( 'Style' ); ?></label></th>
				<td>
					<select id="pb_meta[style]" name="pb_meta[style]">
						<?php foreach ($pb_style_array as $style) : ?>
							<option value="<?php echo $style['value']; ?>" <?php pb_selected($style['value'], $meta['style']); ?>><?php echo $style['label']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
		
			<tr valign="top"><th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><label for="pb_meta[speed]"><?php _e( 'Transition Speed' ); ?></label></th>
				<td style="padding-top: 0;">
					<select id="pb_meta[speed]" name="pb_meta[speed]">
						<?php foreach ($pb_animation_speed as $speed) : ?>
							<option value="<?php echo $speed['value']; ?>" <?php pb_selected($speed['value'], $meta['speed']); ?>><?php echo $speed['label']; ?></option>
						<?php endforeach; ?>
					</select>
					<span class="description"><?php _e( 'Select animation speed' ); ?></span>
				</td>
			</tr>
			
			<tr valign="top"><th scope="row" style="padding-left: 0; padding-right: 0;"><?php _e( 'Zoom Option' ); ?></th>
				<td>
					<input type="radio" name="pb_meta[zoom_option]" id="pb_meta_zoom_option_on" value="true" <?php if ($meta['zoom_option'] == 'true') echo ' checked="checked"'; ?>/> <label for="pb_meta_zoom_option_on" style="padding-right: 15px;"><?php _e('Enabled'); ?></label>
					<input type="radio" name="pb_meta[zoom_option]" id="pb_meta_zoom_option_off" value="false" <?php if ($meta['zoom_option'] == 'false') echo ' checked="checked"'; ?> /> <label for="pb_meta_zoom_option_off" style="padding-right: 15px;"><?php _e('Disabled'); ?></label><br />
					<span class="description"><?php _e('How to handle large images'); ?></span>
				</td>
			</tr>
			
			<tr valign="top"><th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><label for="pb_meta[speed]"><?php _e( 'Zoom Animation' ); ?></label></th>
				<td style="padding-top: 0;">
					<select id="pb_meta[zoom_animation]" name="pb_meta[zoom_animation]">
						<?php foreach ($pb_zoom_animation as $animation) : ?>
							<option value="<?php echo $animation['value']; ?>" <?php pb_selected($animation['value'], $meta['zoom_animation']); ?>><?php echo $animation['label']; ?></option>
						<?php endforeach; ?>
					</select>
					<span class="description"><?php _e( 'Large image zoom animation type' ); ?></span>
				</td>
			</tr>
			
			<tr valign="top"><th scope="row" style="padding-left: 0; padding-right: 0;"><label for="pb_meta[opacity]"><?php _e( 'Opacity' ); ?></label></th>
				<td>
					<select id="pb_meta[opacity]" name="pb_meta[opacity]">
						<?php foreach ($pb_background_opacity as $opacity) : ?>
							<option value="<?php echo $opacity['value']; ?>" <?php pb_selected($opacity['value'], $meta['opacity']); ?>><?php echo $opacity['label']; ?></option>
						<?php endforeach; ?>
					</select>
					<span class="description"><?php _e( 'Enter a decimal that will be used to determine the Priobox\'s opacity.' ); ?></span>
				</td>
			</tr>
			
			<tr valign="top"><th scope="row" style="padding-left: 0; padding-right: 0;"><?php _e( 'Center Pirobox on page' ); ?></th>
				<td>
					<input type="radio" name="pb_meta[center]" id="pb_meta_global_center_on" value="true" <?php if ($meta['center'] == 'true') echo ' checked="checked"'; ?>/> <label for="pb_meta_global_center_on" style="padding-right: 15px;"><?php _e('True'); ?></label>
					<input type="radio" name="pb_meta[center]" id="pb_meta_global_center_off" value="false" <?php if ($meta['center'] == 'false') echo ' checked="checked"'; ?> /> <label for="pb_meta_global_center_off" style="padding-right: 15px;"><?php _e('False'); ?></label><br />
					<span class="description"><?php _e('Keeping this option on will make sure that the Pirobox is always display in the center of the page.'); ?></span>
				</td>
			</tr>
			
			
			<tr valign="top"><th scope="row" style="padding-left: 0; padding-right: 0;"><?php _e( 'Enable sharing features' ); ?></th>
				<td>
					<input type="radio" name="pb_meta[share]" id="pb_meta_global_share_on" value="true" <?php if ($meta['share'] == 'true') echo ' checked="checked"'; ?>/> <label for="pb_meta_global_share_on" style="padding-right: 15px;"><?php _e('Enabled'); ?></label>
					<input type="radio" name="pb_meta[share]" id="pb_meta_global_share_off" value="false" <?php if ($meta['share'] == 'false') echo ' checked="checked"'; ?> /> <label for="pb_meta_global_share_off" style="padding-right: 15px;"><?php _e('Disabled'); ?></label><br />
					<span class="description"><?php _e('Keeping this option on will make sure that the Pirobox is always display in the center of the page.'); ?></span>
				</td>
			</tr>
		</table>
	</div>
	
	<script type="text/javascript">
		jQuery(function($){
			$('.pb_mode:radio').click(function(){
				mode = $(this).val();
				
				switch (mode) {
					case 'off':
						$('.pb_global').slideUp('fast');
						$('.pb_custom').slideUp('fast');
						break;
					case 'global':						
						$('.pb_custom').slideUp('fast', function(){
							$('.pb_global').slideDown('fast');
						});
						break;
					case 'perpage':
						$('.pb_global').slideUp('fast', function(){
							$('.pb_custom').slideDown('fast');
						});
						break;
				}
			});
		});
	</script>
	
<?php }


/**
 * Populate our post meta information
 */
function pb_populate_post_meta( $postID ) {
	/**
	 * Get out post's meta information
	 */
	$meta = get_post_meta($postID,'_pb_meta',TRUE);
	$options = get_option( 'pb_settings' );
	
	/**
	 * Handle our post having no meta information
	 * or if the post uses global information
	 */
	if ((!$meta) || ($meta['mode'] == 'global')) {
		if (!$meta) {
			if ($options['enable_by_default'] == 'on')
				$option_translation = 'global';
			else
				$option_translation = 'off';
		} else
			$option_translation = $meta['mode'];
		
		$meta = array(
			'mode'				=>		$option_translation,
			'speed'				=>		$options['global_speed'],
			'opacity'			=>		$options['global_opacity'],
			'center'			=>		$options['global_center'],
			'share'				=>		$options['global_share'],
			'style'				=>		$options['default_style'],
			'zoom_option'		=>		$options['zoom_option'],
			'zoom_animation'	=>		$options['zoom_animation']
		);
	}
	
	return $meta;
}


/**
 * Add our Pirobox!
 */
function pb_footer(){
	global $post;
	$options = get_option( 'pb_settings' );
	$meta = pb_populate_post_meta( $post->ID );
	
	if ($options['enable_post_type_' . $post->post_type] == 1) {
		if ($meta['mode'] != 'off') { ?>
<script type="text/javascript">
	jQuery(function($) {
		jQuery('a[href$="jpg"], a[href$="bmp"], a[href$="gif"], a[href$="jpeg"], a[href$="png"]').addClass('pirobox_gall_<?php echo $post->ID; ?>').attr('media','gallery');
		$.pirobox_ext({
			piro_speed : <?php echo $meta['speed']; ?>,
			zoom_mode : <?php echo $meta['zoom_option']; ?>,
			move_mode : '<?php echo $meta['zoom_animation']; ?>',
			bg_alpha : <?php echo $meta['opacity']; ?>,
			piro_scroll : <?php echo $meta['center']; ?>,
			share: <?php echo $meta['share']; ?>
		});
	});
</script>
			<?php
		}
	}
}

/**
 * This function injects scripts
 * properly into the header
 */
function pb_enqueue_scripts(){
	global $post;
	$options = get_option( 'pb_settings' );
	$meta = pb_populate_post_meta( $post->ID );
	
	if ($options['enable_post_type_' . $post->post_type] == 1) {
		if ($meta['mode'] != 'off') { 
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-draggable');
			
			wp_enqueue_style( 'pirobox', PB_URL . 'css/' . $meta['style'] . '/style.css');
			
			wp_enqueue_script('pirobox-js', PB_URL . 'js/pirobox_extended_v.1.2.js', 'jquery-ui-draggable', null, true);
		}
	}
}


function pb_media_button() {
	$url = PB_URL . 'pb-popup.php?tab=add&amp;TB_iframe=true';
	echo '<a href="' . $url . '" class="thickbox" title="' . __('Embed Pirobox External / Video Content') . '"><img src="' . PB_URL . 'images/pb-icon.gif" alt="' . __('Add Pirobox Video') . '"></a>';
}