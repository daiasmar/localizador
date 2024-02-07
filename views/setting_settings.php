<?php

    /**
     * Function to display 'Configuración' settings.
     */
    
    function setting_settings(){
        ?>
            <form action="options.php" method="post">
                <?php settings_fields('_localizador_settings_group');?>

                <h2 class="title">API de Google Maps Platform</h2>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Clave de API</th>
                        <td>
                            <input type="text" name="_localizador_api_key" value="<?php echo esc_attr(get_option('_localizador_api_key'));?>"/>
                        </td>
                    </tr>
                </table>
                
                <h2 class="title">Ajustes del mapa</h2>
                <table class="form-table permalink-structure">
                    <tr valign="top">
                        <th scope="row">Marcador</th>
                        <td>
                            <fieldset class="structure-selection">
                                <input type="hidden" name="_localizador_icon_map" id="attachment_id" value=<?php echo get_option('_localizador_icon_map')?>>
                                <div class="row" style="width: 100px;" >
                                    <img id="attachment_preview" style="width: 100%;" src=<?php echo esc_url(wp_get_attachment_image_url(get_option('_localizador_icon_map'), 'full', true))?> />
                                </div>
                                <button class="button" id="media-uploader-button">Seleccionar icono</button>
                                <?php
                                    if(get_option('_localizador_icon_map')){
                                        ?>
                                            <button class="button" id="media-delete-icon" style="color: #cc1818; border-color: #cc1818;">Eliminar</button>
                                        <?php
                                    }
                                ?>
                                <p class="description">Es el icono que señalará las localizaciones en el mapa.</p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Marcador activo</th>
                        <td>
                            <fieldset class="structure-selection">
                                <input type="hidden" name="_localizador_icon_map_active" id="attachment_id" value=<?php echo get_option('_localizador_icon_map_active')?>>
                                <div class="row" style="width: 100px;" >
                                    <img id="attachment_preview" style="width: 100%;" src=<?php echo esc_url(wp_get_attachment_image_url(get_option('_localizador_icon_map_active'), 'full', true))?> />
                                </div>
                                <button class="button" id="media-uploader-button">Seleccionar icono</button>
                                <?php
                                    if(get_option('_localizador_icon_map_active')){
                                        ?>
                                            <button class="button" id="media-delete-icon" style="color: #cc1818; border-color: #cc1818;" >Eliminar</button>
                                        <?php
                                    }
                                ?>
                                <p class="description">Es el icono que aparecerá en la localización seleccionada.</p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Logo</th>
                        <td>
                            <fieldset class="structure-selection">
                                <input type="hidden" name="_localizador_icon_list" id="attachment_id" value=<?php echo get_option('_localizador_icon_list')?>>
                                <div class="row" style="width: 100px;" >
                                    <img id="attachment_preview" style="width: 100%;" src=<?php echo esc_url(wp_get_attachment_image_url(get_option('_localizador_icon_list'), 'full', true))?> />
                                </div>
                                <button class="button" id="media-uploader-button">Seleccionar icono</button>
                                <?php
                                    if(get_option('_localizador_icon_list')){
                                        ?>
                                            <button class="button" id="media-delete-icon" style="color: #cc1818; border-color: #cc1818;" >Eliminar</button>
                                        <?php
                                    }
                                ?>
                                <p class="description">Es el logo que aparecerá en la lista de localizaciones.</p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Logo activo</th>
                        <td>
                            <fieldset class="structure-selection">
                                <input type="hidden" name="_localizador_icon_list_active" id="attachment_id" value=<?php echo get_option('_localizador_icon_list_active')?>>
                                <div class="row" style="width: 100px;" >
                                    <img id="attachment_preview" style="width: 100%;" src=<?php echo esc_url(wp_get_attachment_image_url(get_option('_localizador_icon_list_active'), 'full', true))?> />
                                </div>
                                <button class="button" id="media-uploader-button">Seleccionar icono</button>
                                <?php
                                    if(get_option('_localizador_icon_list_active')){
                                        ?>
                                            <button class="button" id="media-delete-icon" style="color: #cc1818; border-color: #cc1818;" >Eliminar</button>
                                        <?php
                                    }
                                ?>
                                <p class="description">Es el logo que aparecerá en la localización seleccionada dentro de la lista.</p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Imagen "No encontrado"</th>
                        <td>
                            <fieldset class="structure-selection">
                                <input type="hidden" name="_localizador_icon_not_found" id="attachment_id" value=<?php echo get_option('_localizador_icon_not_found')?>>
                                <div class="row" style="width: 100px;" >
                                    <img id="attachment_preview" style="width: 100%;" src=<?php echo esc_url(wp_get_attachment_image_url(get_option('_localizador_icon_not_found'), 'full', true))?> />
                                </div>
                                <button class="button" id="media-uploader-button">Seleccionar icono</button>
                                <?php
                                    if(get_option('_localizador_icon_not_found')){
                                        ?>
                                            <button class="button" id="media-delete-icon" style="color: #cc1818; border-color: #cc1818;" >Eliminar</button>
                                        <?php
                                    }
                                ?>
                                <p class="description">Es la imagen que aparece cuando no se detectaron coincidencias en la busqueda.</p>
                            </fieldset>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        <?php
    }
    
?>