<?php

    function locations_settings(){
        ?>
            <form action="options.php" method="post">
                <?php settings_fields('_localizador');?>

                <h2 class="title">Nueva localización</h2>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Sede</th>
                        <td>
                            <input type="text" name="_localizador_locations[]"/>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Calle</th>
                        <td>
                            <input type="text" name="_localizador_locations[]"/>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Código postal</th>
                        <td>
                            <input type="text" name="_localizador_locations[]"/>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Localidad</th>
                        <td>
                            <input type="text" name="_localizador_locations[]"/>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Ciudad</th>
                        <td>
                            <input type="text" name="_localizador_locations[]"/>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Coordenadas</th>
                        <td>
                            <input type="text" name="_localizador_locations[]" placeholder="41.40338, 2.17403"/>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        <?php
    }
    
?>