<?php

    /**
     * Function to display 'Promoción' settings.
     */

    function setting_promotion(){
        ?>
            <form action="options.php" method="post">
                
                <?php settings_fields('_localizador_promotion_group');?>
                
                <h2 class="title">Contenido</h2>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Mensaje de promoción</th>
                        <td>
                            <textarea name="_localizador_promotion" id="" cols="50" rows="5"><?php echo esc_attr(get_option('_localizador_promotion'));?></textarea>
                            <p class="description">Este texto se mostrará en la sede que tenga activada la promoción.</p>
                        </td>
                    </tr>
                </table>

                <h2 class="title">Estilos</h2>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Color de texto</th>
                        <td>
                            <input type="text" placeholder="#ffffff" name="_localizador_color" value="<?php echo esc_attr(get_option('_localizador_color'));?>"/>
                            <p class="description">El color del texto en el banner de promoción en el mapa. Por defecto es blanco.</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Color del fondo</th>
                        <td>
                            <input type="text" placeholder="#000000" name="_localizador_background" value="<?php echo esc_attr(get_option('_localizador_background'));?>"/>
                            <p class="description">El color del fondo del banner de promoción en el mapa. Por defecto es negro.</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Efecto texto en movimiento</th>
                        <td>
                            <label class="switch">
                                <input type="checkbox" name="_localizador_effect" <?php echo get_option('_localizador_effect') ? 'checked' : '' ?>>
                                <span class="slider round"></span>
                            </label>
                            <p class="description">Activa el movimiento en el mensaje de promoción.</p>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        <?php
    }
?>