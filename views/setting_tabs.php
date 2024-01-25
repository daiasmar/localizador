<?php

    require_once 'setting_locations.php';
    require_once 'setting_settings.php';

    function tabs(){

        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : $_GET['tab'] = 'settings';
        
        ?>
        <div class="wrap">

            <?php
                settings_errors();
            ?>

            <h2 class="nav-tab-wrapper">
                <a href="?page=localizador-menu&tab=settings" class="nav-tab <?php
                    echo $active_tab == 'settings' ? 'nav-tab-active' : '';
                ?>">Configuración</a>
                <a href="?page=localizador-menu&tab=locations-settings" class="nav-tab <?php
                    echo $active_tab == 'locations-settings' ? 'nav-tab-active' : '';
                ?>">Localizaciones</a>
            </h2>

            <?php

                if(isset($_GET['tab'])){

                    switch($_GET['tab']){
                        case 'settings':
                            settings_settings();
                            break;
                        case 'locations-settings':
                            locations_settings();
                            break;
                    }
                };

            ?>

        </div>
        <?php
    }

?>