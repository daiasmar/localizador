<?php

    require_once __DIR__.'/../includes/process.php';

    function setting_locations(){
        ?>

            <form action="?page=localizador-menu&tab=setting-locations" method="POST">

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
                                                <span class="title">Sede *</span>
                                                <span class="input-text-wrap">
                                                    <input type="text" name="_localizador_locations[sede]" class="ptitle" placeholder="Sede nueva" >
                                                    <p class="description">Introduzca el nombre del almacén.</p>
                                                </span>
                                            </label>
                                            <label>
                                                <span class="title">Calle *</span>
                                                <span class="input-text-wrap">
                                                    <input type="text" name="_localizador_locations[calle]" class="ptitle" placeholder="Dirección de la sede nueva" >
                                                    <p class="description">Separa la dirección y el número con comas.</p>
                                                </span>
                                            </label>
                                            <label>
                                                <span class="title">CP *</span>
                                                <span class="input-text-wrap">
                                                    <input type="number" name="_localizador_locations[cp]" class="ptitle" placeholder="00000" min="10000" max="99999">
                                                    <p class="description">Código postal.</p>
                                                </span>
                                            </label>
                                            <label>
                                                <span class="title">Localidad *</span>
                                                <span class="input-text-wrap">
                                                    <input type="text" name="_localizador_locations[localidad]" class="ptitle" placeholder="Nueva localidad" >
                                                    <p class="description">Municipio, localidad, distrito o barrio.</p>
                                                </span>
                                            </label>
                                        </div>
                                    </fieldset>
                                    <fieldset class="inline-edit-col-right">
                                        <div class="inline-edit-col">
                                            <label>
                                                <span class="title">Ciudad *</span>
                                                <span class="input-text-wrap">
                                                    <input type="text" name="_localizador_locations[ciudad]" class="ptitle" placeholder="Nueva ciudad">
                                                    <p class="description">Provincia o ciudad.</p>
                                                </span>
                                            </label>
                                            <label>
                                                <span class="title">Latitud *</span>
                                                <span class="input-text-wrap">
                                                    <input type="number" step="any" name="_localizador_locations[latitud]" class="ptitle" placeholder="0.0">
                                                    <p class="description">Comprendido entre -90 y 90 con decimales.</p>
                                                </span>
                                            </label>
                                            <label>
                                                <span class="title">Longitud *</span>
                                                <span class="input-text-wrap">
                                                    <input type="number" step="any" name="_localizador_locations[longitud]" class="ptitle" placeholder="0.0">
                                                    <p class="description">Comprendido entre -180 y 180 con decimales.</p>
                                                </span>
                                            </label>
                                            <label>
                                                <span class="title">Página</span>
                                                <span class="input-text-wrap">
                                                    <?php wp_dropdown_pages(array(
                                                        'name' => '_localizador_locations[URL]',
                                                        'show_option_none' => '— Elegir —',
                                                        'option_none_value' => 0
                                                    )); ?>
                                                    <p class="description"></p>
                                                </span>
                                            </label>
                                            <label>
                                                <input type="checkbox" name="_localizador_locations[promocion]">
                                                <span class="checkbox-title">¿Tiene promoción?</span>
                                            </label>
                                        </div>
                                    </fieldset>
                                </div>
                            </td>
                        </tr>             
                    </tbody>
                </table>

                <?php submit_button('Añadir una nueva localización'); ?>
            </form>

            <?php
                $locations = get_option('_localizador_locations');
                $orderby = $_GET['orderby'] ?? 'sede';
                $order = $_GET['order'] ?? 'asc';
                $order_constant = $order == 'asc' ? SORT_ASC : SORT_DESC;
                array_multisort(array_column($locations, $orderby), $order_constant, $locations);
            ?>

            <h2 class="title">Todas las localizaciones</h2>

            <table class="wp-list-table widefat fixed striped table-view-list">
                <thead>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column">
                            <input id="cb-select-all-1" type="checkbox">
                            <label for="cb-select-all-1">
                                <span class="screen-reader-text">Seleccionar todo</span>
                            </label>
                        </td>
                        <th class="manage-column column-title column-primary sorted <?php echo $order; ?>" >
                            <a href="http://localizador.test/wp-admin/?page=localizador-menu&tab=setting-locations&orderby=sede&order=<?php echo $order == 'asc' ? 'desc' : 'asc'?>">
                                <span>Sede</span>
                                <span class="sorting-indicators">
                                    <span class="sorting-indicator asc" aria-hidden="true"></span>
                                    <span class="sorting-indicator desc" aria-hidden="true"></span>
                                </span>
                            </a>
                        </th>
                        <th>Calle</th>
                        <th>Código postal</th>
                        <th class="manage-column column-title column-primary sorted <?php echo $order; ?>">
                            <a href="http://localizador.test/wp-admin/?page=localizador-menu&tab=setting-locations&orderby=localidad&order=<?php echo $order == 'asc' ? 'desc' : 'asc'?>">
                                <span>Localidad</span>
                                <span class="sorting-indicators">
                                    <span class="sorting-indicator asc" aria-hidden="true"></span>
                                    <span class="sorting-indicator desc" aria-hidden="true"></span>
                                </span>
                            </a>
                        </th>
                        <th class="manage-column column-title column-primary sorted <?php echo $order; ?>">
                            <a href="http://localizador.test/wp-admin/?page=localizador-menu&tab=setting-locations&orderby=ciudad&order=<?php echo $order == 'asc' ? 'desc' : 'asc'?>">
                                <span>Ciudad</span>
                                <span class="sorting-indicators">
                                    <span class="sorting-indicator asc" aria-hidden="true"></span>
                                    <span class="sorting-indicator desc" aria-hidden="true"></span>
                                </span>
                            </a>
                        </th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th>URL</th>
                        <th>¿Promoción?</th>
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

                        <td><p><?php echo $location['promocion'] ? 'SI' : 'NO' ?></p></td>
                    </tr>

                    <?php endforeach ?>

                    <?php endif ?>
                </tbody>
            </table>
        <?php
    }
?>