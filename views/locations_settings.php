<?php

    function locations_settings(){
        ?>
            <form action="options.php" method="post">

                <?php settings_fields('_localizador_locations_group');?>

                <h2 class="title">Nueva localización</h2>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Sede</th>
                        <td>
                            <input type="text" name="_localizador_locations[sede]"/>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Calle</th>
                        <td>
                            <input type="text" name="_localizador_locations[calle]"/>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Código postal</th>
                        <td>
                            <input type="text" name="_localizador_locations[cp]"/>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Localidad</th>
                        <td>
                            <input type="text" name="_localizador_locations[localidad]"/>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Ciudad</th>
                        <td>
                            <input type="text" name="_localizador_locations[ciudad]"/>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Latitud</th>
                        <td>
                            <input type="text" name="_localizador_locations[latitud]" placeholder="ej 41.40338"/>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Longitud</th>
                        <td>
                            <input type="text" name="_localizador_locations[longitud]" placeholder="ej 2.17403"/>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">URL</th>
                        <td>
                            <?php wp_dropdown_pages(array(
                                'name' => '_localizador_locations[URL]',
                                'show_option_none' => 'Selecciona una página',
                                'option_none_value' => ''
                            )); ?>
                            <p class="description" id="api-key-description"></p>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
            <pre><?php print_r(get_option('_localizador_locations')) ?></pre>
        <?php
    }
    
?>