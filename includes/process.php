<?php

    add_action('admin_init', 'process');

    function process(){

        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            return;
        }
    
        if(empty($_POST['_localizador_locations'])){
            return;
        }
    
        if(!isset($_POST['_wpnonce'])){
            return;
        }
    
        $locations_option = get_option('_localizador_locations');
    
        $sede = $_POST['_localizador_locations']['sede'];
        $calle = $_POST['_localizador_locations']['calle'];
        $cp = $_POST['_localizador_locations']['cp'];
        $localidad = $_POST['_localizador_locations']['localidad'];
        $ciudad = $_POST['_localizador_locations']['ciudad'];
        $latitud = $_POST['_localizador_locations']['latitud'];
        $longitud = $_POST['_localizador_locations']['longitud'];
        $URL = $_POST['_localizador_locations']['URL'];
    
        if($_POST['submit'] == 'Guardar cambios'){
    
            if(!wp_verify_nonce($_POST['_wpnonce'], 'create_location')){
                return;
            }
            echo 'bien';
    
            $location_data = array(
                'sede' => sanitize_text_field($sede),
                'calle' => sanitize_text_field($calle),
                'cp' => absint($cp),
                'localidad' => sanitize_text_field($localidad),
                'ciudad' => sanitize_text_field($ciudad),
                'coordenadas' => array($latitud, $longitud),
                'URL' => absint($URL),
            );
    
            if(empty($locations_option)){
    
                $locations_option = array();
                $location_data['id'] = 1;
                $locations_option[] = $location_data;
                return update_option('_localizador_locations', $locations_option);
            }
    
            $nextID = $locations_option[count($locations_option) - 1]['id'] + 1;
            $location_data['id'] = $nextID;
            $locations_option[] = $location_data;
            return update_option('_localizador_locations', $locations_option);
        }
    
        if($_POST['submit'] == 'Actualizar'){
    
            if(!wp_verify_nonce($_POST['_wpnonce'], 'update_location')){
                return;
            }

            foreach($locations_option as $key => &$location){
                if($_POST['id'] == $location['id']){
                    $locations_option[$key]['sede'] = $sede;
                    $locations_option[$key]['calle'] = $calle;
                    $locations_option[$key]['cp'] = $cp;
                    $locations_option[$key]['localidad'] = $localidad;
                    $locations_option[$key]['ciudad'] = $ciudad;
                    $locations_option[$key]['coordenadas'][0] = $latitud;
                    $locations_option[$key]['coordenadas'][1] = $longitud;
                    $locations_option[$key]['URL'] = $URL;
                    return update_option('_localizador_locations', $locations_option);
                }
            }
        }
    }
      
?>