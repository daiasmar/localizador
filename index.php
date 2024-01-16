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

	}

	require_once 'includes/sanitize_callbacks.php';

	add_action('admin_init', 'register_options_localizador');

	function register_options_localizador(){
		register_setting( 
			'_localizador', 
			'_localizador_api_key', 
			array(
				'type' => 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text',
			)
		);
		register_setting( 
			'_localizador', 
			'_localizador_region', 
			array(
				'type' => 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text',
			)
		);
		register_setting( 
			'_localizador', 
			'_localizador_locations', 
			array(
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_locations',
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
		wp_localize_script('function', 'admin_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));

		return $content;
	}

	add_action('wp_ajax_nopriv_localizador_ajax','localizador');
	add_action('wp_ajax_localizador_ajax','localizador');

	function localizador(){
		$data = [
			'api' => esc_attr(get_option('_localizador_api_key')),
			'language' => esc_attr(get_option('_localizador_language')),
			'region' => esc_attr(get_option('_localizador_region')),
		];
		echo json_encode($data);
		exit;
	}

?>