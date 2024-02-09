<?php

	/**
	* Plugin Name: Localizador
	* Plugin URI: https://rockinmedia.es/
	* Description: Mapa de localizaciones 
	* Version: 0.1.5
	* Author: Rockin
	* Author URI: https://rockinmedia.es/
	**/

	/**
	 * It prevent public user to directly access your .php files through URL.
	 */

	if(!defined('ABSPATH')){
		exit;
	}

	/**
	 * Add an action hook to the admin menu.
	 */

	add_action( 'admin_menu', 'add_admin_localizador');

	/**
	 * Callback function to add a menu page in the WordPress admin.
	 */

	function add_admin_localizador(){

		require_once 'views/setting_tabs.php'; // tabs callback.

		/**
		 * Add a menu page.
		 */

		add_menu_page( 
			__( 'Localizador', 'localizador' ), // page title
			__( 'Localizador', 'localizador' ), // menu title
			'manage_options', // capability
			'localizador-menu', // menu slug
			'tabs', // callback
			'dashicons-location', // icon url
			6 // position
		);

		/**
		 * Add action hook to enqueue scripts and styles for the admin page.
		 */

		add_action('admin_enqueue_scripts', 'admin_scripts');
	}

	/**
	 * Callback function to enqueue scripts and styles for the admin page.
	 */

	function admin_scripts($hook) {

		if('toplevel_page_localizador-menu' != $hook){ // Check if the current admin page is the specified menu page.
			return;
		}

		wp_enqueue_media(); // Enqueue WordPress media scripts for media uploader functionality.

		/**
		 * Enqueue custom scripts for media uploader, Edit class, and AJAX and styles.
		 */

		wp_enqueue_style(
			'admin',
			plugin_dir_url( __FILE__ ). 'css/admin.css'
		);
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

		/**
		 * Localize the 'ajax' script with necessary data for AJAX calls.
		 */

		wp_localize_script('ajax', 'admin_ajax', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax_nonce'),
		));
	}
	

	/**
	 * Add action hook to register setting options.
	 */

	add_action('admin_init', 'register_options_localizador');

	/**
	 * Callback function to register setting options.
	 */

	function register_options_localizador(){

		require_once 'includes/sanitize.php'; // Sanitize functions.

		/**
		 * Register a setting in WordPress.
		 */

		register_setting( 
			'_localizador_settings_group', // setting group name
			'_localizador_api_key', // setting name
			array(
				'type' 				=> 'string', // data type
				'show_in_rest'      => true, // Whether to expose the setting in the REST API
				'sanitize_callback' => 'sanitize_text', // sanitize callback
			)
		);
		register_setting( 
			'_localizador_settings_group', // setting group name
			'_localizador_theme', // setting name
			array(
				'type' 				=> 'string', // data type
				'show_in_rest'      => true, // Whether to expose the setting in the REST API
				'sanitize_callback' => 'sanitize_text', // sanitize callback
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
			'_localizador_settings_group',
			'_localizador_icon_not_found',
			array(
				'type' 				=> 'number',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_number',
			)
		);
		register_setting( 
			'_localizador_promotion_group', 
			'_localizador_effect', 
			array(
				'type' 				=> 'boolean',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_boolean',
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
			'_localizador_promotion_group', 
			'_localizador_color', 
			array(
				'type' 				=> 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text',
			)
		);
		register_setting( 
			'_localizador_promotion_group', 
			'_localizador_background', 
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

	/**
	 * Add action hook to create localizador shortcode.
	 */

	add_shortcode('localizador', 'localizador_shortcode');

	/**
	 * Callback function to create localizador shortcode with parameters.
	 */

	function localizador_shortcode($atts, $content = ""){

		require_once 'views/map.php'; // $content

		/**
		 * Enqueue custom scripts for map and styles.
		 */

		wp_enqueue_style(
			'style',
			plugin_dir_url( __FILE__ ). 'css/style.css'
		);
		wp_enqueue_script(
			'map',
			plugin_dir_url( __FILE__ ). 'js/map.js',
			array(),
			null,
		);

		/**
		 * Localize the 'ajax' script with necessary data for AJAX calls.
		 */

		wp_localize_script('map', 'admin_ajax', array(
			'ajaxurl' => admin_url('admin-ajax.php'))
		);

		return $content; // render shortcode content.
	}

	require_once 'includes/ajax.php'; // Add action hooks for AJAX.
?>