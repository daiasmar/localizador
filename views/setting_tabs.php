<?php

    require_once 'setting_locations.php';
    require_once 'setting_settings.php';
    require_once 'setting_promotion.php';

    function tabs(){

        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : $_GET['tab'] = 'setting-settings';
        
        ?>
        <div class="wrap">

            <?php
                settings_errors();
            ?>

            <h2 class="nav-tab-wrapper">
                <a href="?page=localizador-menu&tab=setting-settings" class="nav-tab <?php
                    echo $active_tab == 'setting-settings' ? 'nav-tab-active' : '';
                ?>">Configuración</a>
                <a href="?page=localizador-menu&tab=setting-locations" class="nav-tab <?php
                    echo $active_tab == 'setting-locations' ? 'nav-tab-active' : '';
                ?>">Localizaciones</a>
                <a href="?page=localizador-menu&tab=setting-promotion" class="nav-tab <?php
                    echo $active_tab == 'setting-promotion' ? 'nav-tab-active' : '';
                ?>">Promoción</a>
            </h2>

            <?php

                if(isset($_GET['tab'])){

                    switch($_GET['tab']){
                        case 'setting-settings':
                            setting_settings();
                            break;
                        case 'setting-locations':
                            setting_locations();
                            break;
                        case 'setting-promotion':
                            setting_promotion();
                            break;
                    }
                };
            ?>
        </div>
        <?php
    }
?>