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

    function sanitize_locations($location){

        $locations_option = get_option('_localizador_locations');

        $size = is_countable($locations_option) ? count($locations_option) : 0;

        $nextID = $size > 0 ? $locations_option[count(get_option('_localizador_locations')) - 1]->id + 1 : 1;

        $location['id'] = $nextID;
        // let proximoId = datos.length > 0 ? datos[datos.length - 1].id + 1 : 1;
        
        return $location;
    }

?>