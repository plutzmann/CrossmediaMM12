<?php
global $waves_demo_array;
$waves_demo_array = array(
    array(
        'slug' => 'default',
        'title'=> 'Default',
        'menu' => array(
            'main' =>'main-menu',
            'right'=>'right-menu'
        )
    ),
    array(
        'slug' => 'onepage',
        'title'=> 'One Page',
        'menu' => array(
            'main' =>'main-menu',
        )
    ),
);
add_action('admin_menu', 'waves_demo_menu');
function waves_demo_menu(){
    $page=add_theme_page('ThemeWaves Demo Content', 'Waves Demo Content', 'edit_theme_options', 'waves-demo-content-importer', 'waves_demo_print');
    add_action("admin_print_styles-$page",  'waves_demo_style');
    add_action("admin_print_scripts-$page", 'waves_demo_script');
}
function waves_demo_style(){
    wp_enqueue_style ('waves-demo-style', THEME_DIR . '/framework/css/admin-waves-demo.css');
}
function waves_demo_script(){
    wp_enqueue_script('waves-demo-script',THEME_DIR . '/framework/js/admin-waves-demo.js', false, false, true);
}
function waves_demo_print(){ ?>
    <div id="waves-demo-container">
        <h2 class="waves-demo-title"><?php _e('Demo Content', 'themewaves'); ?></h2>
        <div id="waves-demo-notice-container">
            <div id="waves-active-demo-with-content-notice" class="waves-notice">
                <div class="default"><?php _e('Importing Demo Content ...','themewaves'); ?></div>
                <div class="ajax"></div>
            </div>
            <div id="waves-active-demo-notice" class="waves-notice">
                <div class="default"><?php _e('Activating settings ...','themewaves'); ?></div>
                <div class="ajax"></div>
            </div>
            <div id="waves-backup-notice" class="waves-notice">
                <div class="restore"><?php _e('Restoring Backup ...','themewaves'); ?></div>
                <div class="delete"><?php _e('Deleting Backup ...','themewaves'); ?></div>
                <div class="ajax"></div>
            </div>
        </div>
        <ul id="waves-demo-list-container"><?php
            global $waves_demo_array;
            foreach($waves_demo_array as $currDemo){ ?>
                <li data-slug="<?php echo $currDemo['slug']; ?>" data-menu="{<?php
                    $i=0;
                    foreach($currDemo['menu'] as $menuPos=>$menuSlug){
                        if($i++){echo ',';}
                        echo "'".$menuPos."':'".$menuSlug."'";
                    }
                ?>}">
                    <div class="demo-thumb"><img src="<?php echo THEME_DIR . '/framework/waves_demo/demos/'.$currDemo['slug'].'/thumb.png'; ?>" /></div>
                    <h3><?php echo $currDemo['title']; ?></h3>
                    <div class="demo-buttons">
                        <div class="button active-demo"><?php _e('Active', 'themewaves'); ?></div>
                        <div class="button button-primary active-demo-with-content"><?php _e('Active With Demo Content', 'themewaves'); ?></div>
                    </div>
                </li><?php
            } ?>
        </ul>
        <h3><?php _e('Backups', 'themewaves'); ?></h3>
        <ul id="waves-demo-backup-list-container"><?php
            $backupIDs_array = get_option('tw_dc_'.strtolower(THEMENAME).'_backups',array());
            if(is_array($backupIDs_array)&&count($backupIDs_array)){
                krsort($backupIDs_array);
                foreach($backupIDs_array as $currTime=>$currDate){
                    if(get_option('tw_dc_'.strtolower(THEMENAME).'_backups_'.$currTime,array())){ ?>
                        <li data-id="<?php echo $currTime; ?>">
                            <div class="demo-backup-name"><?php echo 'tw_dc_'.strtolower(THEMENAME).'_backups_'.$currTime; ?></div>
                            <div class="demo-backup-date"><?php echo $currDate; ?></div>
                            <div class="demo-backup-buttons">
                                <div class="button restore-backup"><?php _e('Restore', 'themewaves'); ?></div>
                                <div class="button delete-backup"><?php _e('Delete', 'themewaves'); ?></div>
                            </div>
                        </li><?php
                    }
                }
            } ?>
        </ul>
    </div><?php
}
function waves_active_backup_demo_settings($settings=array()) {
    $oldSettings=array('menus'=>array(),'settings'=>array());
    $response = '';
    $time = (string)time();
    $date  = date("F j, Y, g:i a");

    $menus = get_theme_mod('nav_menu_locations');
    // ====== To prepare old settings ======
    // Old Menus
    foreach($menus as $menuPos=>$menuID){
        $currMenu=get_term_by('id',intval($menuID),'nav_menu');
        if($currMenu&&isset($currMenu->slug)){
            $oldSettings['menus'][$menuPos]=$currMenu->slug;
        }
    }
    // Old Settings
    global $of_options;
    foreach($of_options as $option){
        if(isset($option['id'])&&isset($option['type'])&&$option['type']!=='info'&&$option['type']!=='heading'){
            $oldSettings['settings'][$option['id']] = tw_option($option['id']);
        }
    }
    // ====== To backup old settings ======
    $upRes = update_option('tw_dc_'.strtolower(THEMENAME).'_backups_'.$time, $oldSettings);
    if($upRes){
        $backupIDs_array = get_option('tw_dc_'.strtolower(THEMENAME).'_backups',array());
        $backupIDs_array[$time]=$date;
        $upRes=update_option('tw_dc_'.strtolower(THEMENAME).'_backups',$backupIDs_array);
        if($upRes){
            $response .= '<div class="succes">' . __('Settings actived', 'themewaves') . '</div>';
        }else{
            $response .= '<div class="error">' . __('Settings not actived !!!', 'themewaves') . '</div>';
        }
    }else{
        $response .= '<div class="error">' . __('Settings not actived !!!', 'themewaves') . '</div>';
    }
    // ====== To set new settings ======
    // New Menus
    if(isset($settings['menus'])){
        foreach($settings['menus'] as $demoMenuPos=>$demoMenuSlug){
            $currMenu=term_exists(sanitize_title($demoMenuSlug),'nav_menu');
            if(is_array($currMenu)&&isset($currMenu['term_id'])){
                $menus[$demoMenuPos]=$currMenu['term_id'];
            }
        }
    }
    set_theme_mod('nav_menu_locations',$menus);
    // New Settings
    of_save_options($settings['settings']);
    
    return $response;
}
add_action( 'wp_ajax_waves-backup-action', 'waves_backup_action' );
add_action( 'wp_ajax_waves-active-demo', 'waves_active_demo' );
add_action( 'wp_ajax_waves-active-demo-with-content', 'waves_active_demo_with_content' );
function waves_backup_action() {
    $response = '';
    if(!is_user_logged_in() || !current_user_can('import')){
        $response .= '<div class="error">' . __("You Can't access restore !!!", 'themewaves') . '</div>';
    }elseif(!empty($_REQUEST['type'])&&!empty($_REQUEST['backup_id'])){
        $backupID=$_REQUEST['backup_id'];
        $type=$_REQUEST['type'];
        $backup=get_option('tw_dc_'.strtolower(THEMENAME).'_backups_'.$backupID,array());
        $backupIDs_array = get_option('tw_dc_'.strtolower(THEMENAME).'_backups',array());
        if(is_array($backup)&&count($backup)){
            if($type==='delete-backup'){
                unset($backupIDs_array[$backupID]);
                $upRes=update_option('tw_dc_'.strtolower(THEMENAME).'_backups',$backupIDs_array);
                if($upRes){
                    delete_option('tw_dc_'.strtolower(THEMENAME).'_backups_'.$backupID);
                    $response .= '<div class="succes">'.__("Backup deleted !!!",'themewaves').'</div>';
                }else{
                    $response .= '<div class="error">'.__("Backup deleting failed !!!",'themewaves').'</div>';
                }
            }elseif($type==='restore-backup'){
                if(empty($backupIDs_array[$backupID])){
                    $response .= '<div class="error">'.__("Not found !!!",'themewaves').'</div>';
                }else{
                    $response .=waves_active_backup_demo_settings($backup);
                }
            }else{
                $response .= '<div class="error">'.__("Undefined Action !!!",'themewaves').'</div>';
            }
        }else{
            $response .= '<div class="error">'.__("Not found !!!",'themewaves').'</div>';
        }
    }
    die('<div class="response">' . $response . '</div>');
}
function waves_active_demo() {
    $response = '';
    if (!is_user_logged_in() || !current_user_can('import')) {
        $response .= '<div class="error">' . __("You Can't change settings !!!", 'themewaves') . '</div>';
    }elseif(!empty($_REQUEST['demo_slug'])){
        $demoSlug=$_REQUEST['demo_slug'];
        $demoPath = THEME_PATH . '/framework/waves_demo/demos/'.$demoSlug.'/';
        $demoImportFile = '';
        if(file_exists($demoPath.'settings.json')){
            $settings = json_decode(file_get_contents($demoPath.'settings.json'),true);
            if(!empty($_REQUEST['demo_menu'])){
                $demoMenus= json_decode(str_replace("\'",'"',$_REQUEST['demo_menu']), true);
                if(is_array($demoMenus)&&count($demoMenus)){
                    $settings['menus']=$demoMenus;
                }
            }
            $response .=waves_active_backup_demo_settings($settings);
        }else{
            $response .= '<div class="error">'.__("Demo settings file not exists !!!",'themewaves').'</div>';
        }
    }
    die('<div class="response">' . $response . '</div>');
}
function waves_active_demo_with_content() {
    $response = '';
    if (!is_user_logged_in() || !current_user_can('import')) {
        $response .= '<div class="error">' . __("You Can't import !!!", 'themewaves') . '</div>';
    }elseif(!empty($_REQUEST['demo_slug'])){
        $demoSlug=$_REQUEST['demo_slug'];
        $demoPath = THEME_PATH . '/framework/waves_demo/demos/'.$demoSlug.'/';
        $demoImportMenu = true;
        $demoImportFile = '';
        
        if(empty($_REQUEST['demo_menu'])){
            $demoImportMenu = false;
        }else{
            $demoMenus=json_decode(str_replace("\'",'"',$_REQUEST['demo_menu']), true);
            if(is_array($demoMenus)&&count($demoMenus)){
                foreach ($demoMenus as $demoMenuPos=>$demoMenuSlug){
                    if(is_array(term_exists(sanitize_title($demoMenuSlug),'nav_menu')) ){
                        $demoImportMenu = false;
                    }
                }
            }else{$demoImportMenu = false;}
        }
        if($demoImportMenu&&file_exists( $demoPath.'content-with-menu.xml' )) {
            $demoImportFile=$demoPath.'content-with-menu.xml';
        }elseif(file_exists($demoPath.'content.xml')){
            $demoImportFile=$demoPath.'content.xml';
        }
        if(empty($demoImportFile)){
            $response .= '<div class="error">' . __("Demo content file not exists !!!", 'themewaves') . '</div>';
        }else{
            // WP Importer
            if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
            require_once(THEME_PATH . '/framework/waves_demo/wordpress-importer/wordpress-importer.php');
            $wp_import = new WP_Import();
            $wp_import->fetch_attachments = true;
            $wp_import->import($demoImportFile);
            $response .= '<div class="succes">' . __('Demo Imported', 'themewaves') . '</div>';
        }
    }
    die('<div class="response">' . $response . '</div>');
} ?>