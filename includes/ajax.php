<?php

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