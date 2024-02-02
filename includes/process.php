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
            add_settings_error('setting_locations', esc_attr('error'), 'Se ha producido un error. Inténtelo más tarde.');
            return;
        }

        if(empty($_POST['_localizador_locations']['sede'])){
            add_settings_error('setting_locations', esc_attr('sede'), 'El campo "Sede" es obligatorio.');
            return;
        }

        if(empty($_POST['_localizador_locations']['calle'])){
            add_settings_error('setting_locations', esc_attr('calle'), 'El campo "Calle" es obligatorio.');
            return;
        }

        if(empty($_POST['_localizador_locations']['cp']) || !preg_match('/^\d{5}$/', $_POST['_localizador_locations']['cp'])){
            add_settings_error('setting_locations', esc_attr('cp'), 'El campo "CP" debe tener 5 dígitos y es obligatorio');
            return;
        }

        if(empty($_POST['_localizador_locations']['localidad'])){
            add_settings_error('setting_locations', esc_attr('localidad'), 'El campo "Localidad" es obligatorio.');
            return;
        }

        if(empty($_POST['_localizador_locations']['ciudad'])){
            add_settings_error('setting_locations', esc_attr('ciudad'), 'El campo "Ciudad" es obligatorio.');
            return;
        }

        if(empty($_POST['_localizador_locations']['latitud']) || !preg_match('/^-?\d{1,3}\.\d+$/', $_POST['_localizador_locations']['latitud']) || ($_POST['_localizador_locations']['latitud'] > 90 || $_POST['_localizador_locations']['latitud'] < -90)){
            add_settings_error('setting_locations', esc_attr('latitud'), 'El campo "Latitud" es obligatorio y tiene que ser un número con decimales comprendido entre -90 y 90.');
            return;
        }

        if(empty($_POST['_localizador_locations']['longitud']) || !preg_match('/^-?\d{1,3}\.\d+$/', $_POST['_localizador_locations']['longitud']) || ($_POST['_localizador_locations']['longitud'] > 180 || $_POST['_localizador_locations']['longitud'] < -180)){
            add_settings_error('setting_locations', esc_attr('latitud'), 'El campo "Longitud" es obligatorio y tiene que ser un número con decimales comprendido entre -180 y 180.');
            return;
        }

        if(!preg_match('/^\d*$/', $_POST['_localizador_locations']['URL'])){
            return;
        }

        $locations_option = get_option('_localizador_locations');
    
        $sede = sanitize_text_field($_POST['_localizador_locations']['sede']);
        $calle = sanitize_text_field($_POST['_localizador_locations']['calle']);
        $cp = absint($_POST['_localizador_locations']['cp']);
        $localidad = sanitize_text_field($_POST['_localizador_locations']['localidad']);
        $ciudad = sanitize_text_field($_POST['_localizador_locations']['ciudad']);
        $latitud = $_POST['_localizador_locations']['latitud'];
        $longitud = $_POST['_localizador_locations']['longitud'];
        $URL = absint($_POST['_localizador_locations']['URL']);
        $promocion = $_POST['_localizador_locations']['promocion'] ?? false;
    
        if($_POST['submit'] == 'Añadir una nueva localización'){
    
            if(!wp_verify_nonce($_POST['_wpnonce'], 'create_location')){
                return;
            }
    
            $location_data = array(
                'sede' => $sede,
                'calle' => $calle,
                'cp' => $cp,
                'localidad' => $localidad,
                'ciudad' => $ciudad,
                'coordenadas' => array($latitud, $longitud),
                'URL' => $URL,
                'promocion' => $promocion
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
                    $locations_option[$key]['promocion'] = $promocion;
                    return update_option('_localizador_locations', $locations_option);
                }
            }
        }
    }
      
?>