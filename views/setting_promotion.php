<?php

    function setting_promotion(){
        ?>
            <form action="options.php" method="post">
                
                <?php settings_fields('_localizador_promotion_group');?>
                
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Texto de la promoción</th>
                        <td>
                            <textarea name="_localizador_promotion" id="" cols="50" rows="5"><?php echo esc_attr(get_option('_localizador_promotion'));?></textarea>
                            <p class="description">Este texto se mostrará en la sede que tenga activada la promoción.</p>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        <?php
    }
?>