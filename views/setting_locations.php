<?php

    require_once __DIR__.'/../includes/process.php';

    function locations_settings(){
        ?>

            <form action="?page=localizador-menu&tab=locations-settings" method="POST">

                <?php wp_nonce_field('create_location');?>

                <table class="wp-list-table widefat fixed striped table-view-list" style="margin-top:30px;">

                    <tbody id="the-list">
                        <tr class="inline-edit-row inline-edit-row-page quick-edit-row quick-edit-row-page inline-edit-page inline-editor">
                            <td class="colspanchange">
                                <div class="inline-edit-wrapper">
                                    <fieldset class="inline-edit-col-left">
                                        <legend class="inline-edit-legend">Nueva localización</legend>
                                        <div class="inline-edit-col">
                                            <label>
                                                <span class="title">Sede</span>
                                                <span class="input-text-wrap">
                                                    <input type="text" name="_localizador_locations[sede]" class="ptitle" placeholder="NUT Atocha">
                                                    <p class="description">Introduzca el nombre del almacén.</p>
                                                </span>
                                            </label>
                                            <label>
                                                <span class="title">Calle</span>
                                                <span class="input-text-wrap">
                                                    <input type="text" name="_localizador_locations[calle]" class="ptitle" placeholder="Paseo de las Delicias, 100">
                                                    <p class="description">Separa la dirección y el número con comas.</p>
                                                </span>
                                            </label>
                                            <label>
                                                <span class="title">CP</span>
                                                <span class="input-text-wrap">
                                                    <input type="text" name="_localizador_locations[cp]" class="ptitle" placeholder="28045">
                                                    <p class="description">Código postal.</p>
                                                </span>
                                            </label>
                                            <label>
                                                <span class="title">Localidad</span>
                                                <span class="input-text-wrap">
                                                    <input type="text" name="_localizador_locations[localidad]" class="ptitle" placeholder="Arganzuela">
                                                    <p class="description">Municipio, localidad, distrito o barrio.</p>
                                                </span>
                                            </label>
                                            <label>
                                                <span class="title">Ciudad</span>
                                                <span class="input-text-wrap">
                                                    <input type="text" name="_localizador_locations[ciudad]" class="ptitle" placeholder="Madrid">
                                                    <p class="description">Provincia o ciudad.</p>
                                                </span>
                                            </label>
                                        </div>
                                    </fieldset>
                                    <fieldset class="inline-edit-col-right">
                                        <div class="inline-edit-col">
                                            <label>
                                                <span class="title">Latitud</span>
                                                <span class="input-text-wrap">
                                                    <input type="text" name="_localizador_locations[latitud]" class="ptitle" placeholder="41.40338">
                                                    <p class="description">Valor comprendido entre -90 y 90.</p>
                                                </span>
                                            </label>
                                            <label>
                                                <span class="title">Longitud</span>
                                                <span class="input-text-wrap">
                                                    <input type="text" name="_localizador_locations[longitud]" class="ptitle" placeholder="-2.17403">
                                                    <p class="description">Valor comprendido entre -180 y 180.</p>
                                                </span>
                                            </label>
                                            <label>
                                                <span class="title">Página</span>
                                                <span class="input-text-wrap">
                                                    <?php wp_dropdown_pages(array(
                                                        'name' => '_localizador_locations[URL]',
                                                        'show_option_none' => 'Selecciona la página',
                                                        'option_none_value' => ''
                                                    )); ?>
                                                    <p class="description">Página de la sede.</p>
                                                </span>
                                            </label>
                                        </div>
                                    </fieldset>
                                </div>
                            </td>
                        </tr>             
                    </tbody>
                </table>

                <?php submit_button(); ?>
            </form>

            <?php $locations = get_option('_localizador_locations'); ?>

            <table class="wp-list-table widefat fixed striped table-view-list">
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
                </thead>
                <tbody id="the-list">
                    <?php if(!empty($locations)) : ?>

                    <?php foreach($locations as $location) : ?>

                    <tr id="localizacion-<?php echo $location['id']?>"data-id=<?php echo $location['id'] ?>>
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
                                <span class="inline hide-if-no-js edit">
                                    <button class="button-link editinline">Editar</button> | 
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
                                <a class="row-title" href=<?php echo get_permalink($location['URL'])?>><?php echo get_the_title($location['URL'])?></a>
                            </strong>

                            <?php endif ?>
                        </td>
                    </tr>

                    <?php endforeach ?>

                    <?php endif ?>
                </tbody>
            </table>
        <?php
    }
?>