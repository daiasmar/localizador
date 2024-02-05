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
            'media' => array(
                'marker' => esc_url(wp_get_attachment_image_url(get_option('_localizador_icon_map'), 'full', true)),
                'marker_active' => esc_url(wp_get_attachment_image_url(get_option('_localizador_icon_map_active'), 'full', true)),
                'logo' => esc_url(wp_get_attachment_image_url(get_option('_localizador_icon_list'), 'full', true)),
                'logo_active' => esc_url(wp_get_attachment_image_url(get_option('_localizador_icon_list_active'), 'full', true)),
            ),
            'promotion' => array(
                'message' => esc_attr(get_option('_localizador_promotion')),
                'color' => esc_attr(get_option('_localizador_color')),
                'background' => esc_attr(get_option('_localizador_background')),
                'effect' => esc_attr(get_option('_localizador_effect')),
            )
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
                $response['nonce'] = wp_create_nonce('update_location');
                $response['pages'] = get_pages();
                $response['result'] = 'ok';
                break;
            }
        }

        echo json_encode($response);
        exit;
    }
?>