<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $GLOBALS['wp_rewrite'] = new WP_Rewrite();
        
        $locations_option = get_option('_localizador_locations');

        if(empty($_POST['_localizador_locations'])){
            return;
        }

        $sede = $_POST['_localizador_locations']['sede'];
        $calle = $_POST['_localizador_locations']['calle'];
        $cp = $_POST['_localizador_locations']['cp'];
        $localidad = $_POST['_localizador_locations']['localidad'];
        $ciudad = $_POST['_localizador_locations']['ciudad'];
        $latitud = $_POST['_localizador_locations']['latitud'];
        $longitud = $_POST['_localizador_locations']['longitud'];
        $URL = $_POST['_localizador_locations']['URL'];

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

?>