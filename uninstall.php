<?php

/**
 * If uninstall.php is not called by WordPress, die.
 */

if(!defined('WP_UNINSTALL_PLUGIN')){
    die();
};

/**
 * An array with all setting names.
 */

$settings = array(
    '_localizador_api_key',
    '_localizador_icon_map',
    '_localizador_icon_map_active',
    '_localizador_icon_list',
    '_localizador_icon_list_active',
    '_localizador_icon_not_found',
    '_localizador_effect',
    '_localizador_promotion',
    '_localizador_color',
    '_localizador_background',
    '_localizador_locations',
    '_localizador_theme'
);

/**
 * Delete options registered with register_setting when uninstalling the plugin.
 */

foreach($settings as $option){
    delete_option($option);
}
?>