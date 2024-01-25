<?php

    function settings_settings(){
        ?>
            <form action="options.php" method="post">
                <?php settings_fields('_localizador_settings');?>

                <h2 class="title">API de Google Maps Platform</h2>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Clave de API</th>
                        <td>
                            <input type="text" name="_localizador_api_key" value="<?php echo esc_attr(get_option('_localizador_api_key'));?>"/>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                </table>

                <h2 class="title">Ajustes del mapa</h2>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Región</th>
                        <td>
                            <input type="text" name="_localizador_region" value="<?php echo esc_attr(get_option('_localizador_region'));?>"/>
                            <p class="description" id="api-key-description">Esta función controla la región de la Google API. Ingresa el código del país, por ejemplo, para España es ES. Puedes encontrar el código del país <a href="https://developers.google.com/maps/coverage?hl=es">aquí</a></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Icono</th>
                        <td>
                            <button type="button" class="browser button button-hero" id="__wp-uploader-id-1" aria-labelledby="__wp-uploader-id-1 post-upload-info" style="position: relative; z-index: 1;">Subir icono</button>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        <?php
    }
    
?>