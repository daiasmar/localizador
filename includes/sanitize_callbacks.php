<?php

    function sanitize_text($strt){

        return $strt;
        
        // add_settings_error(
        //     'myUniqueIdentifyer',
        //     esc_attr( 'settings_updated' ),
        //     'holi',
        //     'error'
        // );

    }

    function sanitize_locations($inputs){

        $locations_option = get_option('_localizador_locations');

        $sede = $inputs['sede'];
        $calle = $inputs['calle'];
        $cp = $inputs['cp'];
        $localidad = $inputs['localidad'];
        $ciudad = $inputs['ciudad'];
        $latitud = $inputs['latitud'];
        $longitud = $inputs['longitud'];
        $URL = $inputs['URL'];

        $location_data = array(
            'sede' => sanitize_text_field($sede),
            'calle' => sanitize_text_field($calle),
            'cp' => absint($cp),
            'localidad' => sanitize_text_field($localidad),
            'ciudad' => sanitize_text_field($ciudad),
            'coordenadas' => array($latitud, $longitud),
            'URL' => esc_url(get_permalink($URL)),
        );

        if(empty($locations_option)){

            $locations_option = array();
            $location_data['id'] = 1;
            $locations_option[] = $location_data;
            return $locations_option;
        }

        $nextID = $locations_option[count($locations_option) - 1]['id'] + 1;
        $location_data['id'] = $nextID;
        $locations_option[] = $location_data;
        return $locations_option;

        // La primera ubicación se guarda unicamente cuando la opción esta ya añadida en la tabla wp_options.

    }

?>