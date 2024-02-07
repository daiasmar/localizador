<?php

    /**
     * Necessary files containing functions for different setting pages.
     */

    require_once 'setting_locations.php';
    require_once 'setting_settings.php';
    require_once 'setting_promotion.php';

    /**
     * Callback function to display tabs and corresponding settings in the WordPress admin.
     */

    function tabs(){

        /**
         * Determine the active tab based on the 'tab' parameter in the URL.
         */

        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : $_GET['tab'] = 'setting-settings';
        
        ?>
        <div class="wrap">

            <?php
                settings_errors(); // Display any settings errors.
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
                
                /**
                 * Display the content of the selected tab.
                 */

                if(isset($_GET['tab'])){

                    switch($_GET['tab']){
                        case 'setting-settings':
                            setting_settings(); // Display the settings for 'Configuración'
                            break;
                        case 'setting-locations':
                            setting_locations(); // Display the settings for 'Localizaciones'
                            break;
                        case 'setting-promotion':
                            setting_promotion(); // Display the settings for 'Promoción'
                            break;
                    }
                };
            ?>
        </div>
        <?php
    }
?>