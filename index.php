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


add_action( 'admin_menu', 'add_admin_localizador');

function add_admin_localizador(){

    add_menu_page( 
        __( 'Localizador', 'localizador' ),
		__( 'Localizador', 'localizador' ),
		'manage_options',
		'localizador-menu',
		'callback_localizador',
		'dashicons-location',
		6
    );

	// add_action('admin_init', 'register_settings_localizador');

}

add_action('admin_init', 'register_settings_localizador');

function register_settings_localizador(){
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

function sanitize_text($strt){
	
	// add_settings_error(
	// 	'myUniqueIdentifyer',
	// 	esc_attr( 'settings_updated' ),
	// 	'holi',
	// 	'error'
	// );

	return $strt;
}

function sanitize_locations($location){

	return $location;
}

function callback_localizador(){

    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : $_GET['tab'] = 'settings';
	
	?>
	<div class="wrap">

		<?php
			settings_errors();
		?>

		<h2 class="nav-tab-wrapper">
			<a href="?page=localizador-menu&tab=settings" class="nav-tab <?php
				echo $active_tab == 'settings' ? 'nav-tab-active' : '';
			?>">Configuración</a>
			<a href="?page=localizador-menu&tab=locations-settings" class="nav-tab <?php
				echo $active_tab == 'locations-settings' ? 'nav-tab-active' : '';
			?>">Localizaciones</a>
		</h2>

		<?php

			if(isset($_GET['tab'])){

				switch($_GET['tab']){
					case 'settings':
						settings_content();
						break;
					case 'locations-settings':
						locations_settings_content();
						break;
				}
			};

		?>

	</div>
	<?php
}

function settings_content(){
	?>
		<form action="options.php" method="post">
			<?php settings_fields('_localizador');?>

			<h2 class="title">API de Google Maps Platform</h2>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Clave de API</th>
					<td>
						<input type="text" name="_localizador_api_key" value="<?php echo esc_attr(get_option('_localizador_api_key'));?>"/>
						<p class="description" id="api-key-description"></p>
					</td>
				</tr>
			</table>

			<h2 class="title">Ajustes del mapa</h2>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Región</th>
					<td>
						<input type="text" name="_localizador_region" value="<?php echo esc_attr(get_option('_localizador_region') );?>"/>
						<p class="description" id="api-key-description">Esta función controla la región de la Google API. Ingresa el código del país, por ejemplo, para España es ES. Puedes encontrar el código del país <a href="https://developers.google.com/maps/coverage?hl=es">aquí</a></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Icono</th>
					<td>
						<button type="button" class="browser button button-hero" id="__wp-uploader-id-1" aria-labelledby="__wp-uploader-id-1 post-upload-info" style="position: relative; z-index: 1;">Subir icono</button>
					</td>
				</tr>
			</table>

			<?php submit_button(); ?>
		</form>
	<?php
}

function locations_settings_content(){
	?>
		<form action="options.php" method="post">
			<?php settings_fields('_localizador');?>

			<h2 class="title">Nueva localización</h2>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Sede</th>
					<td>
						<input type="text" name="_localizador_locations[]"/>
						<p class="description" id="api-key-description"></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Calle</th>
					<td>
						<input type="text" name="_localizador_locations[]"/>
						<p class="description" id="api-key-description"></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Código postal</th>
					<td>
						<input type="text" name="_localizador_locations[]"/>
						<p class="description" id="api-key-description"></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Localidad</th>
					<td>
						<input type="text" name="_localizador_locations[]"/>
						<p class="description" id="api-key-description"></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Ciudad</th>
					<td>
						<input type="text" name="_localizador_locations[]"/>
						<p class="description" id="api-key-description"></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Coordenadas</th>
					<td>
						<input type="text" name="_localizador_locations[]" placeholder="41.40338, 2.17403"/>
						<p class="description" id="api-key-description"></p>
					</td>
				</tr>
			</table>

			<?php submit_button(); ?>
		</form>
	<?php
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
        plugin_dir_url( __FILE__ ). 'js/function.js',
        array(),
        null,
    );
    wp_localize_script('function', 'admin_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));

	return $content;
}

function localizador(){
    $data = [
		'api' => esc_attr(get_option('_localizador_api_key')),
		'language' => esc_attr(get_option('_localizador_language')),
		'region' => esc_attr(get_option('_localizador_region')),
	];
    echo json_encode($data);
    exit;
}

add_action('wp_ajax_nopriv_localizador_ajax','localizador');
add_action('wp_ajax_localizador_ajax','localizador');

?>