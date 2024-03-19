<?php

    /**
	 * Add action hook to performe an AJAX action for non-logged-in users and logged-in users.
	 */

    add_action('wp_ajax_nopriv_localizador_ajax','localizador');
    add_action('wp_ajax_localizador_ajax','localizador');

    /**
	 * Callback function to performe an AJAX action when charging map.
	 */

    function localizador(){
        // Parse the URL of the home URL and extract the domain
        $urlparts = wp_parse_url(home_url());
		$domain = $urlparts['host'];

        $locations = get_option('_localizador_locations'); // Value option from the WordPress options table.
		$message = esc_attr(get_option('_localizador_promotion')); // Retrieve and escape the promotion message from the WordPress options table.
		
		// Translate promotion message using Weglot if the Weglot class exists.
		if(class_exists('Context_Weglot')){
            // Get the Weglot instance and the current language code
			$weglot_instance = Context_Weglot::weglot_get_context();
			$current_language = $weglot_instance->get_service( 'Request_Url_Service_Weglot' )->get_current_language()->getInternalCode();
			
            // If the current language is not Spanish, translate the message.
			if($current_language != 'es'){
                // Retrieve Weglot API key and construct translation API URL.
				$weglot_api = $weglot_instance->get_service( 'Option_Service_Weglot' )->get_option('api_key_private');
				$weglot_url = 'https://api.weglot.com/translate?api_key=' . $weglot_api ;

                // Set request arguments for translation API.
				$request_args = array(
					'body' => json_encode(array(
						'l_from' => 'es',
						'l_to' => $current_language,
						'words' => [
							["w" => $message, "t" => 1],
						],
						'request_url' => $domain,
					)),
					'headers' => array(
						'Content-Type' => 'application/json'
					),
				);
                // Send POST request to Weglot translation API.
				$response = wp_remote_post($weglot_url, $request_args);
                
                // Retrieve and decode translated data.
				$translated_data = json_decode(wp_remote_retrieve_body($response), true);

                // Update the message with the translated text.
				$message = $translated_data['to_words'][0];
			}
		}

        foreach($locations as &$location){
            // Get the permalink URL for the location
            $location_link = get_permalink($location['URL']); // Changes URL number page to link.

            // Check if Context_Weglot class exists and the current language is not Spanish
            if(class_exists('Context_Weglot') && $current_language != 'es'){
                $explode_url = explode('/', $location_link); // Split the URL into parts
                array_splice($explode_url, 3, 0, $current_language); // Insert the current language code at the third position
                $location_link = implode('/', $explode_url,); // Recombine the URL parts into a string
            }

            // Update the URL of the location with the modified link
            $location['URL'] = $location_link;
        }

        $data = [
            'api' => esc_attr(get_option('_localizador_api_key')), // API Key
            'theme' => esc_attr(get_option('_localizador_theme')), // Map theme
            'locations' => $locations, // Locations array
            'media' => array( // Media images for the map
                'marker' => false != get_option('_localizador_icon_map') ? esc_url(wp_get_attachment_image_url(get_option('_localizador_icon_map'), 'full', true)) : '',

                'marker_active' => false != get_option('_localizador_icon_map_active') ? esc_url(wp_get_attachment_image_url(get_option('_localizador_icon_map_active'), 'full', true)) : '',

                'logo' => false != get_option('_localizador_icon_list') ? esc_url(wp_get_attachment_image_url(get_option('_localizador_icon_list'), 'full', true)) : '',

                'logo_active' => false != get_option('_localizador_icon_list_active') ? esc_url(wp_get_attachment_image_url(get_option('_localizador_icon_list_active'), 'full', true)) : '',

                'not_found' => false != get_option('_localizador_icon_not_found') ? esc_url(wp_get_attachment_image_url(get_option('_localizador_icon_not_found'), 'full', true)) : '',
            ),
            'promotion' => array( // Promotion text and styles for the map.
                'message' => $response,
                'color' => esc_attr(get_option('_localizador_color')),
                'background' => esc_attr(get_option('_localizador_background')),
                'effect' => esc_attr(get_option('_localizador_effect')),
            )
        ];

        echo json_encode($data); // Encode data as JSON and send the response.
        exit;
    }

    /**
	 * Add action hook to performe an AJAX action for logged-in users.
	 */

    add_action('wp_ajax_remove_location', 'remove_location_localizador');

    /**
	 * Callback function to performe an AJAX action to remove a specific location.
	 */

    function remove_location_localizador(){

        $response['result'] = 'ko'; // State variable

        if(!wp_verify_nonce($_POST['nonce'],'ajax_nonce')){ // Verify the nonce submitted in the POST, if fails, exit.
            return;
        }

        $locations = get_option('_localizador_locations'); // Value option from the WordPress options table.

        foreach ($locations as $key => $location) { // Iterate through each element in the option value.
            if($location['id'] == $_POST['id']){ // Check if the 'id' value in the current locations matches the 'id' value in the POST data.
                array_splice($locations, $key, 1); // Remove one element from the array at the specified position $key.
                update_option('_localizador_locations', $locations); // Update the option in the WordPress option.
                $response['result'] = 'ok'; // Set the result key to 'ok'.
                break;
            }
        }

        echo json_encode($response); // Encode data as JSON and send the response.
        exit;
    }

    /**
	 * Add action hook to performe an AJAX action for logged-in users.
	 */

    add_action('wp_ajax_edit_location', 'edit_location_localizador');

    /**
	 * Callback function to performe an AJAX action to quick edit.
	 */

    function edit_location_localizador(){

        $response['result'] = 'ko'; // State variable.

        if(!wp_verify_nonce($_POST['nonce'],'ajax_nonce')){ // Verify the nonce submitted in the POST, if fails, exit.
            return;
        }

        $locations = get_option('_localizador_locations'); // Value option from the WordPress options table.

        foreach ($locations as $key => $location) { // Iterate through each element in the option value.
            if($location['id'] == $_POST['id']){ // Check if the 'id' value in the current locations matches the 'id' value in the POST data.
                array_slice($locations, $key, 1); // Extract and return one element.
                $response['data'] = $location; // Set the 'data' to the selected location.
                $response['nonce'] = wp_create_nonce('update_location'); // Generate a nonce for security and set it.
                $response['pages'] = get_pages(); // Fetch an array of pages
                $response['result'] = 'ok';  // Set the result key to 'ok'.
                break;
            }
        }

        echo json_encode($response); // Encode data as JSON and send the response.
        exit;
    }
?>