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
        $cuidad = $inputs['ciudad'];
        $latitud = $inputs['latitud'];
        $longitud = $inputs['longitud'];
        $URL = $inputs['URL'];

        $location_data = array(
            'sede' => $sede,
            'calle' => $calle,
            'cp' => $cp,
            'localidad' => $localidad,
            'ciudad' => $cuidad,
            'coordenadas' => array($latitud, $longitud),
            'URL' => get_permalink($URL),
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