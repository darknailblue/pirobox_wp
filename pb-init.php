<?php
/*
Plugin Name: Pirobox Extended
Plugin URI: http://wordpress.org/extend/plugins/pirobox-extended-for-wp-v10/
Description: This plugin automatically add the rel="gallery" and media="gallery" to images linked in a post.&nbsp; If the script finds more than 1 image, it automatically creates an image gallery.&nbsp; The plugin adds all necessary files to make it work. You also have the option to call any kind of file with Pirobox Extended.&nbsp; Just follow <a href="http://www.pirolab.it/pirobox/">these instructions</a>.
Author: <a href="http://piroblog.pirolab.it/">Diego Valobra</a>, <a href="http://chriscarvache.com/">Chris Carvache</a>
Author URI: http://piroblog.pirolab.it/
Version: 1.2.3
License: GPL2

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Define all globals
 */
define('PB_VERSION', 0123);
define('PB_URL', rtrim(plugin_dir_url(__FILE__)));
define('PB_DIR', rtrim(plugin_dir_path(__FILE__)));
$pb_style_array = array(
	'0'	=> array(
		'value'	=>	'style_1',
		'label'	=>	'Double Border, White on Black  '
	),
	'1'	=> array(
		'value'	=>	'style_4',
		'label'	=>	'Double Border,  Black on White '
	),
	'2'	=> array(
		'value'	=>	'style_2',
		'label'	=>	'White with Shadow'
	),
	'3'	=> array(
		'value'	=>	'style_3',
		'label'	=>	'Black with Shadow'
	)
);

$pb_animation_speed = array(
	'0' => array (
		'value' => '400',
		'label' => '400ms'
	),
	'1' => array (
		'value' => '600',
		'label' => '600ms'
	),
	'2' => array (
		'value' => '800',
		'label' => '800ms'
	),
	'3' => array (
		'value' => '1000',
		'label' => '1000ms'
	),
	'4' => array (
		'value' => '1200',
		'label' => '1200ms'
	)
);

$pb_background_opacity = array(
	'0' => array (
		'value' => '0',
		'label' => '0%'
	),
	'1' => array (
		'value' => '.1',
		'label' => '10%'
	),
	'2' => array (
		'value' => '.2',
		'label' => '20%'
	),
	'3' => array (
		'value' => '.3',
		'label' => '30%'
	),
	'4' => array (
		'value' => '.4',
		'label' => '40%'
	),
	'5' => array (
		'value' => '.5',
		'label' => '50%'
	),
	'6' => array (
		'value' => '.6',
		'label' => '60%'
	),
	'7' => array (
		'value' => '.7',
		'label' => '70%'
	),
	'8' => array (
		'value' => '.8',
		'label' => '80%'
	),
	'9' => array (
		'value' => '.9',
		'label' => '90%'
	),
	'10' => array (
		'value' => '1',
		'label' => '100%'
	)
);

$pb_zoom_animation = array(
	'0' => array (
		'value' => 'mousemove',
		'label' => 'Mousemove'
	),
	'1' => array (
		'value' => 'drag',
		'label' => 'Drag'
	)
);


/**
 * Add our actions
 */
add_action('admin_init', 'pb_register_settings');
add_action('admin_menu', 'pb_plugin_menu');
add_action('add_meta_boxes', 'pb_add_meta');
add_action('save_post', 'pb_save_post');
add_action('wp_enqueue_scripts', 'pb_enqueue_scripts');
add_action('wp_footer', 'pb_footer', 999);
add_action('media_buttons', 'pb_media_button', 20);

/**
 * Install the plugin
 */
register_activation_hook( __FILE__, 'pb_activate' );


/**
 * Load our functions
 */
require_once('pb-functions.php');