<?php

    require_once __DIR__.'/../includes/process.php';

    function locations_settings(){
        ?>
            <form action=<?php echo $_SERVER['REQUEST_URI']; ?> method="POST">

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

            <?php $locations = get_option('_localizador_locations'); ?>

            <table class="widefat fixed striped">
                <thead>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column">
                            <input id="cb-select-all-1" type="checkbox">
                            <label for="cb-select-all-1">
                                <span class="screen-reader-text">Seleccionar todo</span>
                            </label>
                        </td>
                        <th>Sede</th>
                        <th>Calle</th>
                        <th>Código postal</th>
                        <th>Localidad</th>
                        <th>Ciudad</th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th>URL</th>
                    </tr>

                    <?php if(!empty($locations)) : ?>

                    <?php foreach($locations as $location) : ?>

                    <tr>
                        <th scope="row" class="check-column">
                            <input id="cb-select-2" type="checkbox" name="post[]" value="2">
                                <label for="cb-select-2">
                                    <span class="screen-reader-text">Seleccionar Página de ejemplo</span>
                                </label>
                            <div class="locked-indicator"><span class="locked-indicator-icon" aria-hidden="true"></span><span class="screen-reader-text">«Página de ejemplo» está bloqueado</span></div>
                        </th>

                        <td>
                            <strong><?php echo $location['sede']?></strong>
                            <div class="row-actions">
                                <span class="inline hide-if-no-js">
                                    <button type="button" class="button-link editinline">Editar</button> | 
                                </span>
                                <span class="trash">
                                    <a href="" data-id=<?php echo $location['id'] ?>>Eliminar</a>
                                </span>
                            </div>
                        </td>

                        <td><p><?php echo $location['calle']?></p></td>
                        <td><p><?php echo $location['cp']?></p></td>
                        <td><p><?php echo $location['localidad']?></p></td>
                        <td><p><?php echo $location['ciudad']?></p></td>
                        <td><p><?php echo $location['coordenadas'][0]?></p></td>
                        <td><p><?php echo $location['coordenadas'][1]?></p></td>

                        <td>
                            <?php if(!empty($location['URL'])) : ?>

                            <strong>
                                <a class="row-title" href=<?php echo $location['URL']?>><?php echo get_the_title(url_to_postid($location['URL']))?></a>
                            </strong>

                            <?php endif ?>
                        </td>
                    </tr>

                    <?php endforeach ?>

                    <?php endif ?>  
                </thead>
            </table>

            <pre><?php print_r(get_option('_localizador_locations')) ?></pre>
        <?php
    }
    
?>