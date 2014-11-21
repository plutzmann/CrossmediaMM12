<?php

add_action('admin_print_scripts', 'waves_builder_admin_scripts');
add_action('admin_print_styles', 'waves_builder_admin_styles');
if (!function_exists('waves_builder_admin_scripts')) {
    function waves_builder_admin_scripts() {
        global $post,$pagenow;
        $pID = '';
        if(!empty($post->ID)){ $pID=$post->ID; }
        if (current_user_can('edit_posts') && ($pagenow == 'post-new.php' || $pagenow == 'post.php')) {
            if( isset($post) ) {
                wp_localize_script( 'jquery', 'waves_script_data', array(
                    'home_uri' => home_url(),
                    'post_id' => $post->ID,
                    'nonce' => wp_create_nonce( 'themewaves-ajax' ),
                    'image_ids' => get_post_meta( $post->ID, 'gallery_image_ids', true ),
                    'label_create' => __("Create Featured Gallery", "waves"),
                    'label_edit' => __("Edit Featured Gallery", "waves"),
                    'label_save' => __("Save Featured Gallery", "waves"),
                    'label_saving' => __("Saving...", "waves")
                ));
                wp_register_script('waves-easy-pie-chart', THEME_DIR . '/assets/js/jquery.easy-pie-chart.js');
                wp_register_script('waves-colorpicker', WAVES_DIR . 'js/admin-colorpicker.js');
                wp_register_script('waves-metabox', WAVES_DIR.'js/admin-waves-metabox.js');
                wp_register_script('waves-builder', WAVES_DIR . 'js/admin-waves-builder.js');
                
                wp_enqueue_script('jquery-ui-dialog');
                wp_enqueue_script('waves-easy-pie-chart');
                wp_enqueue_script('waves-colorpicker');
                wp_enqueue_script('waves-metabox');
                wp_enqueue_script('waves-builder');
            }
        }
    }
}
if (!function_exists('waves_builder_admin_styles')) {
    function waves_builder_admin_styles() {
        global $pagenow;
        if (current_user_can('edit_posts') && ($pagenow == 'post-new.php' || $pagenow == 'post.php')) {
            wp_register_style('waves-font-awesome',     THEME_DIR . '/assets/css/font-awesome.min.css', false, '1.00', 'screen');
            wp_register_style('waves-colorpicker',     WAVES_DIR . 'css/admin-colorpicker.css', false, '1.00', 'screen');
            wp_register_style('waves-metabox', WAVES_DIR . 'css/admin-waves-metabox.css', false, '1.00', 'screen');            
            wp_register_style('waves-builder', WAVES_DIR . 'css/admin-waves-builder.css', false, '1.00', 'screen');            
            
            wp_enqueue_style('waves-font-awesome');
            wp_enqueue_style('waves-colorpicker');
            wp_enqueue_style('waves-metabox');
            wp_enqueue_style('waves-builder');
        }
    }
}

//====== Back-End Includes  ======//

add_action('admin_init', 'waves_elements_include');

function waves_elements_include(){
    global $waves_elementfiles, $waves_elements;
    $waves_elements = array(); 
    
    require_once (WAVES_PATH . "pagebuilder/elements-option/element_globals.php");
    foreach($waves_elementfiles as $file){
        require_once (WAVES_PATH . "pagebuilder/elements-option/$file.php");
    }
    require_once WAVES_PATH.'pagebuilder/waves-shortcode.php';
    
    if(tw_option('pagebuilder')) {
        add_meta_box('waves_pagebuilder', __('Waves Page Builder', 'waves'), 'waves_pagebuilder_box', 'page', 'normal', 'high');
    }
    
    add_action('wp_ajax_template_add', 'pbTemplateAdd');
    add_action('wp_ajax_template_get', 'pbTemplateGet');
    add_action('wp_ajax_template_remove', 'pbTemplateRemove');
    add_action('wp_ajax_get_circlechart', 'pbGetCircleChart');
    add_action('wp_ajax_get_fonticon', 'pbGetFonticon');
}

function waves_pagebuilder_box(){
        global $post, $waves_elements,$waves_elements_list;
        $items     = '';
        $waves_elements_list = '';
        foreach ($waves_elements as $element_slug => $element_array) {
            if(empty($element_array['only']) || $element_array['only']==='builder'){
                $items               .= wavesGetItem($element_slug);
                $waves_elements_list .= wavesGetItem($element_slug,array(),false);
            }
        }        
        $_pb_content_area = '';
        $_pb_content   = get_post_meta($post->ID, WAVES_PAGEBUILDER, true);
        $_pb_rows = json_decode(rawUrlDecode($_pb_content), true);
        
        if(!empty($_pb_rows)&&is_array($_pb_rows)){
            foreach($_pb_rows as $_pb_row){
                $_pb_content_area .= wavesGetRow($_pb_row);
            }
        }else{
            $_pb_content_area .= wavesGetRow(array('default_row'=>'true'));
        }

        $puilderLogo  = '<div class="pb-logo"></div>';
        
        
        $layoutAddButtons  = '<div class="pb-add-layout-conteiner">';
            $layoutAddButtons .= '<a href="#" class="pb-add-layout" data-possition="bottom">'.__('Add Container','themewaves').'</a>';
            $layoutAddButtons .= '<div class="data hidden">'.wavesGetRow().'</div>';
            $layoutAddButtons .= '<div class="loader">Loading...</div>';
        $layoutAddButtons .= '</div>';
        
        $templates  = '<div class="tw-template-container">';
            $templates .= '<div id="template-save" class="dropdown" tabindex="1">';
                $templates .= '<div class="template"><span class="image-save"></span>Templates</div>';
                $templates .= '<ul class="dropdown template-container">';
                    $templates .= '<li class="template-item"><a class="template-add">Save this to Template</a></li>';
                    $templates_array = get_option('tw_pb_'.strtolower(THEMENAME).'_templates',array());
                    if ($templates_array !== false) {
                        foreach ($templates_array as $templates_name => $templates_content) {
                            $templates .= '<li class="template-item"><a class="template-name">' . $templates_name . '</a><span class="template-delete">X</span></li>';
                        }
                    }
                $templates .= '</ul>';
            $templates .= '</div>';
        $templates .= '</div>';

        $pbAdditionalTools = $puilderLogo.$layoutAddButtons.$templates;
        
        wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');
        
        echo '<div class="pagebuilder-container">
                    <textarea id="pb_content"   name="pb_content"   class="hidden">' . $_pb_content   . '</textarea>
                    <ul id="size-list" class="hidden">
                        <li data-class="col-md-3" data-text="1 / 4" class="min"></li>
                        <li data-class="col-md-4" data-text="1 / 3"></li>
                        <li data-class="col-md-6" data-text="1 / 2"></li>
                        <li data-class="col-md-8" data-text="2 / 3"></li>
                        <li data-class="col-md-9" data-text="3 / 4"></li>
                        <li data-class="col-md-12" data-text="1 / 1" class="max"></li>
                    </ul>
                    <ul id="custom-content-list" class="hidden" ></ul>
                    <div id="items-list" class="hidden">'.$items.'</div>
                    ' . $pbAdditionalTools . '
                    <div id="pagebuilder-area" class="clearfix">'.$_pb_content_area.'</div>
            </div>';
}





function getItemField($itemSlug, $itemArray) {
        $title = isset($itemArray['title']) ? $itemArray['title'] : '';
        $type = isset($itemArray['type']) ? $itemArray['type'] : '';
        $default = isset($itemArray['default']) ? $itemArray['default'] : '';
        $desc = isset($itemArray['desc']) ? $itemArray['desc'] : '';
        $holder = isset($itemArray['holder']) ? $itemArray['holder'] : '';
        $selector = isset($itemArray['selector']) ? $itemArray['selector'] : '';
        $save_to = isset($itemArray['save_to']) ? $itemArray['save_to'] : '';
        $tinyMCE = isset($itemArray['tinyMCE']) ? $itemArray['tinyMCE'] : '';
        $class = 'field'; ?>
        <div class="field-item<?php echo $type === 'hidden' ? ' hidden' : ''; echo' type-' . $type; echo $tinyMCE?' editor':''; echo " ".$itemSlug; ?>"><?php
            if($type!='container'){
                echo '<div class="field-title">'.$title.'</div>';
                $default = rawUrlDecode($default);
            } ?>
            <div class="field-data"><?php
                switch ($type) {
                    case 'cc' : { ?>
                        <div class="button show-cc-modal"><?php _e('Edit Chart','themewaves'); ?></div>
                        <div class="cc-viewer" style="padding: 20px 0;"></div><?php
                        break;
                    }
                    case 'fi' : { ?>
                        <div class="button show-fi-modal"><?php _e('Edit Icon','themewaves'); ?></div>
                        <div class="fi-viewer" style="padding: 20px 0;"></div><?php
                        break;
                    }
                    case 'gallery':
                    case 'hidden':
                    case 'button':
                    case 'number':
                    case 'text' : {
                        $typeOrg=$type;
                        if($type==='gallery'){$type='hidden';} ?>
                        <input    data-name="<?php echo $itemSlug; ?>" data-type="<?php echo $type; ?>" data-type-org="<?php echo $typeOrg; ?>" class="<?php echo $class; ?>" value="<?php echo htmlspecialchars($default); ?>" placeholder="<?php echo $holder; ?>" data-selector="<?php echo $selector; ?>" data-save-to="<?php echo $save_to; ?>" type="<?php echo $type; ?>"<?php if(isset($itemArray['min'])){echo' min="'.$itemArray['min'].'"';} if(isset($itemArray['max'])){echo' max="'.$itemArray['max'].'"';} if(isset($itemArray['step'])){echo' step="'.$itemArray['step'].'"';} ?>/><?php
                        if (!empty($itemArray['data'])) {
                            global $waves_elements;
                            echo '<div class="data hidden">';
                            $tmpItem = $itemArray['data']['item'];
                            $tmpSettings = $itemArray['data']['settings'];
                            getItemField($tmpSettings, $waves_elements[$tmpItem]['settings'][$tmpSettings]);
                            echo '</div>';
                        }
                        if($typeOrg==='gallery'){
                            echo '<ul class="gallery-images">';
                                $images = empty($default) ? false : explode(",", $default);
                                if($images){foreach ($images as $id) {if(!empty($id)){ ?><li><img src="<?php echo wp_get_attachment_url($id); ?>"></li><?php }}}
                            echo '</ul>';
                        }
                        $type=$typeOrg;
                        break;
                    }
                    case 'color': { ?>
                        <div style="background-color: <?php echo empty($default)?'':$default; ?>;" class="color-info"></div>
                        <input    data-name="<?php echo $itemSlug; ?>" data-type="<?php echo $type; ?>" class="<?php echo $class; ?>" value="<?php echo empty($default)?'':$default; ?>" placeholder="<?php echo $holder; ?>" type="text" /><?php
                        break;
                    }
                    case 'checkbox': { ?>
                        <input    data-name="<?php echo $itemSlug; ?>" data-type="<?php echo $type; ?>" class="<?php echo $class; ?> hidden" value="<?php echo $default; ?>" placeholder="<?php echo $holder; ?>" type="checkbox" <?php echo $default==='true'?'checked':''; ?> />
                        <div class="checkbox-text clearfix"><div class="checkbox-true"><?php _e('ON','themewaves'); ?></div><div class="checkbox-false"><?php _e('OFF','themewaves'); ?></div></div><?php
                        break;
                    }
                    case 'textArea': { ?>
                        <textarea data-name="<?php echo $itemSlug; ?>" data-type="<?php echo $type; ?>" class="<?php echo $class; ?>" placeholder="<?php echo $holder; ?>" data-tinyMCE="<?php echo $tinyMCE; ?>" ><?php echo $default; ?></textarea><?php
                        break;
                    }
                    case 'category':
                    case 'select': { ?>
                        <select   data-name="<?php echo $itemSlug; ?>" data-type="<?php echo $type; ?>" class="<?php echo $class; ?>"><?php
                            $hide = isset($itemArray['hide']) ? $itemArray['hide'] : '';
                            foreach ($itemArray['options'] as $val => $text) {
                                echo '<option value="' . $val . '"' . ($default === strval($val) ? ' selected="selected"' : '') . ' hide="' . (isset($hide[$val]) ? $hide[$val] : '') . '">' . $text . '</option>';
                            } ?>
                        </select>
                        <?php
                        if($type === 'category'){
                            echo '<div class="category-list-container"></div>';
                        }
                        break;
                    }
                    case 'container': {
                        $title_as = isset($itemArray['title_as']) ? $itemArray['title_as'] : '';
                        $add_button = isset($itemArray['add_button']) ? $itemArray['add_button'] : '';
                        $container_type = isset($itemArray['container_type']) ? $itemArray['container_type'] : ''; ?>
                        <div data-name="<?php echo $itemSlug; ?>" data-type="<?php echo $type; ?>" data-container-type="<?php echo $container_type; ?>" class="<?php echo $class; ?> container" placeholder="<?php echo $holder; ?>" data-title-as="<?php echo $title_as; ?>" data-add-button="<?php echo $add_button; ?>" ><?php
                            if(!empty($default)) {
                                foreach ($default as $data) { ?>
                                    <div class="container-item<?php echo $container_type==='image_slider'?' expanded':''; ?>">
                                        <div class="list clearfix">
                                            <div class="name"><?php if(isset($data[$title_as]['default'])){echo $data[$title_as]['default'];} ?></div>
                                            <div class="actions">
                                                <a href="#" class="action-edit" title="Edit">e</a>
                                                <a href="#" class="action-duplicate" title="Duplicate"></a>
                                                <a href="#" class="action-delete"  title="Delete"></a>
                                            </div>
                                        </div>
                                        <div class="content"><?php
                                            if($container_type==='image_slider'){
                                                echo '<img class="image-src" src="'.rawUrlDecode($data[$title_as]['default']).'" />';
                                            }
                                            $ccPrint=$fiPrint=true;
                                            foreach ($data as $slug => $setting) {
                                                //Font icon
                                                if(isset($setting['need_fi'])&&$setting['need_fi']==='true'&&$fiPrint){
                                                    echo getItemField('fi', array("type"=>"fi","title"=>"Add Icon"));
                                                }
                                                if($slug==='fi'){$fiPrint=false;}
                                                //Circle Chart
                                                if(isset($setting['need_cc'])&&$setting['need_cc']==='true'&&$ccPrint){
                                                    echo getItemField('cc', array("type"=>"cc","title"=>"Add Chart"));
                                                }
                                                if($slug==='cc'){$ccPrint=false;}
                                                echo getItemField($slug, $setting);
                                            } ?>
                                        </div>
                                    </div><?php
                                }
                            }?>
                        </div><?php
                        break;
                    }
                } ?>
            </div><?php
            if($type!='container'){ echo '<div class="field-desc">'.$desc.'</div>';} ?>
        </div><?php
}


    
    

function wavesGetItem($itemSlug, $itemNewData = array(),$all=true) {
        global $waves_elements, $waves_global_options;
        
        $itemArray = $waves_elements[$itemSlug];
        $itemArray['size'] = empty($itemNewData['size']) ? $itemArray['size'] : $itemNewData['size'];
        ob_start(); ?>
        <div class="action-container item <?php echo $itemArray['size']; ?>" data-slug="<?php echo $itemSlug; ?>"<?php if(isset($itemArray['min-size'])){echo ' data-min="'.$itemArray['min-size'].'"';} ?> data-help="<?php echo isset($itemArray['help'])?$itemArray['help']:''; ?>">
            <div class="thumb"><span class="<?php echo $itemSlug; ?>"></span><?php echo $itemArray['name']; ?></div><?php
            if($all){ ?>
                <div class="list clearfix">
                    <div class="size-sizer-container">
                        <div class="size need-convert"><?php echo $itemArray['size']; ?></div>
                        <div class="sizer"><a class="up" href="#" title="Increase Size"></a><a class="down" href="#" title="Decrease Size"></a></div>
                    </div>
                    <div class="name"><?php echo $itemArray['name']; ?></div>
                    <div class="actions">
                        <a href="#" class="action-edit" title="Edit"></a>
                        <a href="#" class="action-duplicate" title="Duplicate"></a>
                        <a href="#" class="action-delete" title="Delete"></a>
                    </div>
                </div>
                <div class="data">
                    <div class="general-field-container clearfix"><?php
                        foreach ($waves_global_options['element'] as $pbHeadSettingSlug => $pbHeadSetting) {
                            $pbHeadSetting['default'] = isset($itemNewData[$pbHeadSettingSlug]) ? $itemNewData[$pbHeadSettingSlug] : (!empty($pbHeadSetting['default'])?$pbHeadSetting['default']:'');
                            echo getItemField($pbHeadSettingSlug, $pbHeadSetting);
                        } ?>
                    </div>
                    <div class="custom-field-container"><?php
                        foreach ($itemArray['settings'] as $pbItemSettingSlug => $pbItemSetting) {
                            if ($pbItemSetting['type'] === 'container' && isset($itemNewData['settings'][$pbItemSettingSlug])) {
                                $templateContainerItem = $pbItemSetting['default'][0];
                                foreach ($itemNewData['settings'][$pbItemSettingSlug] as $index => $containerItemNewData) {
                                    foreach ($containerItemNewData as $containerItemNewFieldSlug => $containerItemNewFieldValue) {
                                        $templateContainerItem[$containerItemNewFieldSlug]['default'] = $containerItemNewFieldValue;
                                        $itemNewData['settings'][$pbItemSettingSlug][$index][$containerItemNewFieldSlug] = $templateContainerItem[$containerItemNewFieldSlug];
                                    }
                                }
                            }
                            $pbItemSetting['default'] = isset($itemNewData['settings'][$pbItemSettingSlug]) ? $itemNewData['settings'][$pbItemSettingSlug] : (isset($pbItemSetting['default'])?$pbItemSetting['default']:"");
                            echo getItemField($pbItemSettingSlug, $pbItemSetting);
                        } ?>
                    </div>
                </div><?php
            } ?>
        </div><?php
        $output = ob_get_clean();
        return $output;
}




function wavesGetRowTools($rowNewData=array()) {
    global $waves_elements, $waves_elements_list,$waves_global_options;
    $rowNewData['row_layout'] = isset($rowNewData['row_layout'])?$rowNewData['row_layout']:'0-12-0';
    $output ='<div class="list clearfix">';
        $output.='<div class="add-element">';
            $output.='<a href="#" class="elements-dropdown clearfix">Add Element</a>';
        $output.='</div>';
        $output.='<div class="change-layout">';
            $layoutArr=array(
                'Left Sidebar'=>'3-9-0',
                'Fullwidth'=>'0-12-0',
                'Right Sidebar'=>'0-9-3',
                '1-2'=>'0-6-6',
                '1-3'=>'4-4-4',
                '4-8'=>'4-8-0',
                '8-4'=>'0-8-4',
                '5-7'=>'5-7-0',
                '7-5'=>'0-7-5',
                '3-6-3'=>'3-6-3',
                '6-3-3'=>'6-3-3',
                '3-3-6'=>'3-3-6');
            foreach($layoutArr as $tooltip=>$vv){
                $output.='<a href="#" class="sidebar tooltip size-'. $vv .($rowNewData['row_layout']===$vv  ?' active':'').'" data-value="'.str_replace("-",",",$vv).'"  data-input="'.$vv.'" ><span>'.$tooltip.'</span></a>';
            }
        $output.='</div>';
        $output.='<div class="name">Container Settings</div>';
        $output.='<div class="actions">';
            $output.='<a href="#" class="action-edit tooltip"><span>Edit Settings</span></a>';
            $output.='<a href="#" class="action-duplicate tooltip"><span>Duplicate</span></a>';
            $output.='<a href="#" class="action-delete tooltip"><span>Delete</span></a>';
            $output.='<a href="#" class="action-expand tooltip"><span>Close</span></a>';
        $output.='</div>';
        $output.='<div class="pagebuilder-elements-container" class="clearfix">' . $waves_elements_list . '</div>';
    $output.='</div>';
    $output.='<div class="data">';
        $output.='<div class="custom-field-container">';
            foreach ($waves_global_options['row'] as $pbRowSettingSlug => $pbRowSetting){
                $pbRowSetting['default'] = isset($rowNewData[$pbRowSettingSlug]) ? $rowNewData[$pbRowSettingSlug] : (isset($pbRowSetting['default'])?$pbRowSetting['default']:'');
                ob_start();
                getItemField($pbRowSettingSlug, $pbRowSetting);
                $output.=ob_get_clean();
            }
        $output.='</div>';
    $output.='</div>';
    return $output;
}




function wavesGetLayout($_pb_layout) {
    $output  = '<div class="action-container clearfix builder-area '.$_pb_layout['size'].'">';
        if(isset($_pb_layout['items'])&&is_array($_pb_layout['items'])){
            foreach ($_pb_layout['items'] as $item_array) {
                $output .= wavesGetItem($item_array['slug'], $item_array);
            }
        }
    $output .= '</div>';
    return $output;
}




function wavesGetRow($_pb_row=array() ) {
    $output  = '<div class="row-container action-container clearfix '.(isset($_pb_row['default_row'])&&$_pb_row['default_row']==='true'?'default':'additional').'-row">';
        $output .= wavesGetRowTools($_pb_row); 
        if(isset($_pb_row['layouts'])&&is_array($_pb_row['layouts'])){
            foreach($_pb_row['layouts'] as $_pb_layout){
                $output .= wavesGetLayout($_pb_layout);
            }
        }else{
            foreach(array('col-md-0','col-md-12','col-md-0')as$size){
                $output .= wavesGetLayout(array('size'=>$size));
            }
        }
    $output .= '</div>';
    return $output;
}




// Save fields data

add_action('save_post', 'waves_pagebuilder_save');

function waves_pagebuilder_save($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;
        if (isset($_GET['post_type']) && 'page' == $_GET['post_type']) {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
        } else {
            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }
        if (isset($_POST['pb_content'])) {
            update_post_meta($post_id, WAVES_PAGEBUILDER, $_POST['pb_content']);
            $_pb_row_array = json_decode(rawUrlDecode(str_replace("\'","'",$_POST['pb_content'])), true);
            update_post_meta($post_id, WAVES_SHORTCODE,waves_page_builder($_pb_row_array));
        }
}



// Template Ajax Action


function pbTemplateAdd() {
    
    if (isset($_REQUEST['template_name']) && isset($_REQUEST['template_content'])) {
        $response = '';
        $templates_array = get_option('tw_pb_'.strtolower(THEMENAME).'_templates',array());
        if (isset($templates_array[$_REQUEST['template_name']])) {
            $response .= '<div class="error">' . __('Template name is allready exist. Please insert the template name and try again', 'themewaves') . '</div>';
        } else {
            $upRes = update_option('tw_pb_'.strtolower(THEMENAME).'_templates_'.$_REQUEST['template_name'], $_REQUEST['template_content']);
            if($upRes){
                $templates_array[$_REQUEST['template_name']] = 'true';
                $upRes=update_option('tw_pb_'.strtolower(THEMENAME).'_templates', $templates_array);
            }
            if($upRes){
                $response .= '<div class="succes">' . __('Template added', 'themewaves') . '</div>';
            }else{
                $response .= '<div class="error">' . __('Not Saved !!!', 'themewaves') . '</div>';
            }
        }
        die('<div class="response">' . $response . '</div>');
    }
}



function pbTemplateGet() {
    if (isset($_REQUEST['template_name'])) {
        $response = '';
        $templates_array = get_option('tw_pb_'.strtolower(THEMENAME).'_templates',array());
        $currTemplate    = get_option('tw_pb_'.strtolower(THEMENAME).'_templates_'.$_REQUEST['template_name'],false);
        if (isset($templates_array[$_REQUEST['template_name']])&&$currTemplate!==false) {
            $currTemplateArea = '';
            $currTemplateRows = json_decode(rawUrlDecode(str_replace("\'","'",$currTemplate)), true);
            if(!empty($currTemplateRows)&&is_array($currTemplateRows)){
                foreach($currTemplateRows as $currTemplateRow){
                    $currTemplateArea .= wavesGetRow($currTemplateRow);
                }
            }else{
                $currTemplateArea .= wavesGetRow(array('default_row'=>'true'));
            }
            $response .= '<div class="data">';
                $response .= '<div class="content">'. $currTemplateArea . '</div>';
            $response .= '</div>';
        } else {
            $response .= '<div class="error">' . __('Template name not exsist', 'themewaves') . '</div>';
        }
        die('<div class="response">' . $response . '</div>');
    }
}



function pbTemplateRemove() {
    if (isset($_REQUEST['template_name'])) {
        $response = '';
        $templates_array = get_option('tw_pb_'.strtolower(THEMENAME).'_templates',array());
        if (isset($templates_array[$_REQUEST['template_name']])) {
            unset($templates_array[$_REQUEST['template_name']]);
            update_option('tw_pb_'.strtolower(THEMENAME).'_templates', $templates_array);
            delete_option('tw_pb_'.strtolower(THEMENAME).'_templates_'.$_REQUEST['template_name']);
        } else {
            $response .= '<div class="error">' . __('Template name not exsist', 'themewaves') . '</div>';
        }
        die('<div class="response">' . $response . '</div>');
    }
}


function pbGetFonticon() {
    require_once (WAVES_PATH . "pagebuilder/font-icon.php");
    die();
}



function pbGetCircleChart() {
    require_once (WAVES_PATH . "pagebuilder/circle-chart.php");
    die();
}