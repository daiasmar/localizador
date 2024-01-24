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
	
	require_once 'includes/sanitize_callbacks.php';

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

	add_action('wp_ajax_nopriv_localizador_ajax','localizador');
	add_action('wp_ajax_localizador_ajax','localizador');

	function localizador(){

		$locations = get_option('_localizador_locations');

		foreach($locations as &$location){
			$location['URL'] = get_permalink($location['URL']);
		}

		$data = [
			'api' => esc_attr(get_option('_localizador_api_key')),
			'locations' => $locations,
			'region' => esc_attr(get_option('_localizador_region')),
		];

		echo json_encode($data);
		exit;
	}

	add_action('wp_ajax_remove_location', 'remove_location_localizador');

	function remove_location_localizador(){

		$response['result'] = 'ko';

		if(!wp_verify_nonce($_POST['nonce'],'ajax_nonce')){
			return;
		}

		$locations = get_option('_localizador_locations');

		foreach ($locations as $key => $location) {
			if($location['id'] == $_POST['id']){
				array_splice($locations, $key, 1);
				// unset($locations[$key]);
				update_option('_localizador_locations', $locations);
				$response['result'] = 'ok';
				break;
			}
		}

		echo json_encode($response);
    	exit;
	}

	add_action('wp_ajax_edit_location', 'edit_location_localizador');

	function edit_location_localizador(){

		$response['result'] = 'ko';

		if(!wp_verify_nonce($_POST['nonce'],'ajax_nonce')){
			return;
		}

		$locations = get_option('_localizador_locations');

		foreach ($locations as $key => $location) {
			if($location['id'] == $_POST['id']){
				array_slice($locations, $key, 1);
				$response['data'] = $location;
				$response['pages'] = get_pages();
				$response['result'] = 'ok';
				break;
			}
		}

		echo json_encode($response);
    	exit;
	}
?>