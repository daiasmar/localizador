<?php

    /**
     * Add action hook to form processing.
     */

    add_action('admin_init', 'process');

    /**
	 * Callback function to form processing.
	 */

    function process(){

        if($_SERVER['REQUEST_METHOD'] != 'POST'){ // Check if the HTTP request method is not 'POST' then exit.
            return;
        }
    
        if(empty($_POST['_localizador_locations'])){ // Check if is empty '_localizador_locations' key in the $_POST array then exit.
            return;
        }
    
        if(!isset($_POST['_wpnonce'])){ // Check if not exist '_wpnonce' then exit.
            add_settings_error('setting_locations', esc_attr('error'), 'Se ha producido un error. Inténtelo más tarde.'); // Error message
            return;
        }

        if(empty($_POST['_localizador_locations']['sede'])){ // Check if is empty 'sede' then exit.
            add_settings_error('setting_locations', esc_attr('sede'), 'El campo "Sede" es obligatorio.'); // Error message
            return;
        }

        if(empty($_POST['_localizador_locations']['calle'])){ // Check if is empty 'calle' then exit.
            add_settings_error('setting_locations', esc_attr('calle'), 'El campo "Calle" es obligatorio.'); // Error message
            return;
        }

        if(empty($_POST['_localizador_locations']['cp']) || !preg_match('/^\d{5}$/', $_POST['_localizador_locations']['cp'])){ // Check if is empty 'cp' and not matches regex then exit.
            add_settings_error('setting_locations', esc_attr('cp'), 'El campo "CP" debe tener 5 dígitos y es obligatorio'); // Error message
            return;
        }

        if(empty($_POST['_localizador_locations']['poblacion'])){ // Check if is empty 'poblacion' then exit.
            add_settings_error('setting_locations', esc_attr('poblacion'), 'El campo "Población" es obligatorio.'); // Error message
            return;
        }

        if(empty($_POST['_localizador_locations']['provincia'])){ // Check if is empty 'provincia' then exit.
            add_settings_error('setting_locations', esc_attr('provincia'), 'El campo "Provincia" es obligatorio.'); // Error message
            return;
        }

        if(empty($_POST['_localizador_locations']['latitud']) || !preg_match('/^-?\d{1,3}\.\d+$/', $_POST['_localizador_locations']['latitud']) || ($_POST['_localizador_locations']['latitud'] > 90 || $_POST['_localizador_locations']['latitud'] < -90)){ // Check if is empty 'latitud' and not matches regex then exit.
            add_settings_error('setting_locations', esc_attr('latitud'), 'El campo "Latitud" es obligatorio y tiene que ser un número con decimales comprendido entre -90 y 90.'); // Error message
            return;
        }

        if(empty($_POST['_localizador_locations']['longitud']) || !preg_match('/^-?\d{1,3}\.\d+$/', $_POST['_localizador_locations']['longitud']) || ($_POST['_localizador_locations']['longitud'] > 180 || $_POST['_localizador_locations']['longitud'] < -180)){ // Check if is empty 'longitud' and not matches regex then exit.
            add_settings_error('setting_locations', esc_attr('latitud'), 'El campo "Longitud" es obligatorio y tiene que ser un número con decimales comprendido entre -180 y 180.'); // Error message
            return;
        }
        
        if(!preg_match('/^\d*$/', $_POST['_localizador_locations']['URL'])){ // Check if not matches regex then exit.
            return;
        }

        $locations_option = get_option('_localizador_locations'); // Value option from the WordPress options table.
        
        /**
         * Save in diferrent variables $_POST['_localizador_locations'] array.
         */

        $sede = sanitize_text_field($_POST['_localizador_locations']['sede']);
        $calle = sanitize_text_field($_POST['_localizador_locations']['calle']);
        $cp = $_POST['_localizador_locations']['cp'];
        $poblacion = sanitize_text_field($_POST['_localizador_locations']['poblacion']);
        $provincia = sanitize_text_field($_POST['_localizador_locations']['provincia']);
        $latitud = $_POST['_localizador_locations']['latitud'];
        $longitud = $_POST['_localizador_locations']['longitud'];
        $URL = absint($_POST['_localizador_locations']['URL']);
        $promocion = $_POST['_localizador_locations']['promocion'] ?? false;

        /**
         * Submit action to add new location.
         */
    
        if($_POST['submit'] == 'Añadir una nueva localización'){
    
            if(!wp_verify_nonce($_POST['_wpnonce'], 'create_location')){ // Verify the nonce submitted in the POST, if fails, exit.
                return;
            }
            
            /**
             * Array attached to the existing option
             */

            $location_data = array(
                'sede' => $sede,
                'calle' => $calle,
                'cp' => $cp,
                'poblacion' => $poblacion,
                'provincia' => $provincia,
                'coordenadas' => array($latitud, $longitud),
                'URL' => $URL,
                'promocion' => $promocion
            );
    
            if(empty($locations_option)){ // Check if is empty value option then attaches first location.
    
                $locations_option = array();
                $location_data['id'] = 1; // Add number one id to location array
                $locations_option[] = $location_data;
                return update_option('_localizador_locations', $locations_option);
            }
    
            $nextID = $locations_option[count($locations_option) - 1]['id'] + 1; // Calculate next id
            $location_data['id'] = $nextID; // Add to location array
            $locations_option[] = $location_data;
            return update_option('_localizador_locations', $locations_option);
        }

        /**
         * Submit action to update a single location.
         */
    
        if($_POST['submit'] == 'Actualizar'){
    
            if(!wp_verify_nonce($_POST['_wpnonce'], 'update_location')){ // Verify the nonce submitted in the POST, if fails, exit.
                return;
            }

            foreach($locations_option as $key => &$location){ // Iterate through each element in the option value.

                if($_POST['id'] == $location['id']){  // Check if the 'id' value in the current locations matches the 'id' value in the POST data.
                    
                    /**
                     * Update all values of the specify location.
                     */

                    $locations_option[$key]['sede'] = $sede;
                    $locations_option[$key]['calle'] = $calle;
                    $locations_option[$key]['cp'] = $cp;
                    $locations_option[$key]['poblacion'] = $poblacion;
                    $locations_option[$key]['provincia'] = $provincia;
                    $locations_option[$key]['coordenadas'][0] = $latitud;
                    $locations_option[$key]['coordenadas'][1] = $longitud;
                    $locations_option[$key]['URL'] = $URL;
                    $locations_option[$key]['promocion'] = $promocion;

                    return update_option('_localizador_locations', $locations_option); // Update the entire locations array.
                }
            }
        }
    }
      
?>