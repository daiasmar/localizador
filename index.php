<?php

	/**
	* Plugin Name: Localizador
	* Plugin URI: https://rockinmedia.es/
	* Description: Mapa de localizaciones 
	* Version: 0.1
	* Author: Rockin
	* Author URI: https://rockinmedia.es/
	**/

	if(!defined('ABSPATH')){
		exit;
	}

	require_once 'views/setting_tabs.php';

	add_action( 'admin_menu', 'add_admin_localizador');

	function add_admin_localizador(){

		add_menu_page( 
			__( 'Localizador', 'localizador' ),
			__( 'Localizador', 'localizador' ),
			'manage_options',
			'localizador-menu',
			'tabs',
			'dashicons-location',
			6
		);

		add_action('admin_enqueue_scripts', 'admin_scripts');
	}

	function admin_scripts($hook) {

		if('toplevel_page_localizador-menu' != $hook){
			return;
		}

		wp_enqueue_media();
		wp_enqueue_script(
			'mediaUploader',
			plugin_dir_url( __FILE__ ). 'js/mediaUploader.js',
			array(),
			null,
			true
		);
		wp_enqueue_script(
			'Edit',
			plugin_dir_url( __FILE__ ). 'js/Edit.js',
			array(),
			null,
			true
		);
		wp_enqueue_script(
			'ajax',
			plugin_dir_url( __FILE__ ). 'js/ajax.js',
			array(),
			null,
			true
		);
		wp_localize_script('ajax', 'admin_ajax', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax_nonce'),
		));
	}
	
	require_once 'includes/sanitize.php';

	add_action('admin_init', 'register_options_localizador');

	function register_options_localizador(){
		register_setting( 
			'_localizador_settings_group', 
			'_localizador_api_key', 
			array(
				'type' 				=> 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text',
			)
		);
		register_setting( 
			'_localizador_settings_group', 
			'_localizador_region', 
			array(
				'type' 				=> 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text',
			)
		);
		register_setting( 
			'_localizador_settings_group', 
			'_localizador_icon_map',
			array(
				'type' 				=> 'number',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_number',
			)
		);
		register_setting( 
			'_localizador_settings_group',
			'_localizador_icon_map_active',
			array(
				'type' 				=> 'number',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_number',
			)
		);
		register_setting( 
			'_localizador_settings_group',
			'_localizador_icon_list',
			array(
				'type' 				=> 'number',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_number',
			)
		);
		register_setting( 
			'_localizador_settings_group',
			'_localizador_icon_list_active',
			array(
				'type' 				=> 'number',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_number',
			)
		);
		register_setting( 
			'_localizador_promotion_group', 
			'_localizador_promotion', 
			array(
				'type' 				=> 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text',
			)
		);
		register_setting( 
			'_localizador_locations_group', 
			'_localizador_locations',
			array(
				'type' 				=> 'array',
				'show_in_rest'      => true,
			)
		);
	}

	add_shortcode('localizador', 'localizador_shortcode');

	function localizador_shortcode($atts, $content = ""){

		require_once 'views/map.php';

		wp_enqueue_style(
			'style',
			plugin_dir_url( __FILE__ ). 'css/style.css'
		);
		wp_enqueue_script(
			'function',
			plugin_dir_url( __FILE__ ). 'js/map.js',
			array(),
			null,
		);
		wp_localize_script('function', 'admin_ajax', array(
			'ajaxurl' => admin_url('admin-ajax.php'))
		);

		return $content;
	}

	require_once 'includes/ajax.php';
?>