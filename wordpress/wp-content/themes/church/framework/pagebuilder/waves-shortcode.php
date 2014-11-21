<?php
if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
if ( get_user_option('rich_editing') == 'true') {
     add_filter('mce_external_plugins', 'waves_tinymce_external');
     add_filter('mce_buttons', 'waves_tinymce_button');
}
   
function waves_tinymce_external($plugin_array) {
   $plugin_array['twshortcodegenerator'] = WAVES_DIR.'js/admin-waves-shortcode.js';
   return $plugin_array;
}
function waves_tinymce_button($buttons) {
   array_push($buttons, "|", "twshortcodegenerator");
   return $buttons;
}
    
function waves_refresh_mce($ver) {
    $ver += 3;
    return $ver;
}
add_filter( 'tiny_mce_version', 'waves_refresh_mce');

//====== START - Functions ======
if (!function_exists('waves_shortcode_admin_html')){
    function waves_shortcode_admin_html(){
        global $waves_elements; ?>
        <div id="tw-shortcode-template" style="display: none;">
            <div class="general-field-container">
                <div class="field-item clearfix type-select">
                    <div class="field-data">
                        <select id="style_shortcode" data-type="select" class="field">
                            <option value="none"><?php _e('Select Shortcode','themewaves'); ?></option><?php
                            if(!empty($waves_elements)){
                                foreach ($waves_elements as $pbItemSlug => $pbItemArray) {
                                    if(empty($pbItemArray['only']) || $pbItemArray['only']==='shortcode'){
                                        echo '<option value="' . $pbItemSlug . '" >' . $pbItemArray['name'] . '</option>';
                                    }
                                }
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="custom-field-container"></div>
        </div><?php
    }
}
add_action( 'admin_head', 'waves_shortcode_admin_html', 1 );

// Shortcode Builder
if (!function_exists('waves_shortcode_modal')) {
    function waves_shortcode_modal() {
        if (!empty($_REQUEST['shortcode_name'])) {            
            die(wavesGetItem($_REQUEST['shortcode_name']));
        }
    }
} add_action('wp_ajax_waves_shortcode_modal', 'waves_shortcode_modal');


if (!function_exists('waves_shortcode_print')) {
    function waves_shortcode_print(){
        if (!empty($_REQUEST['data'])) {
            $item_array = json_decode(rawUrlDecode(str_replace("\'","'",$_REQUEST['data'])), true);
            die(waves_builder_item($item_array));
        }
        die('<div class="error">Empty Request</div>');
    }
} add_action('wp_ajax_waves_shortcode_print', 'waves_shortcode_print');

if (!function_exists('rowStart')) {
    function rowStart($colCounter,$size){
        if($colCounter===0||$colCounter===12||$colCounter+$size>12 ){return array($size,'true');}
        return array($colCounter+$size,'false');
    }
}
if (!function_exists('waves_builder_item')) {
    function waves_builder_item($item_array) {
        global $waves_elements,$tw_layoutSize;
        ob_start();
        $itemSlug = $item_array['slug'];
        $itemSettingsArray = $item_array['settings'];
        $defaultItem=$waves_elements[$itemSlug];
        $defaultItemSettingsArray=$defaultItem['settings'];
        $itemClass = !empty($item_array['custom_class']) ? $item_array['custom_class'] : '';
        $item_array['full_layout'] = empty($item_array['full_layout']) ? 'false':$item_array['full_layout'];
        $onlyBuilderAtts='';
        if($item_array['size']==='shortcode-size'){
            $onlyBuilderAtts .= '  size="waves-shortcode"';
        }else{
            $onlyBuilderAtts .= ' title="'.$item_array['item_title'].'" size="'.$item_array['size'].'" full_layout="'.$item_array['full_layout'].'" class="'.str_replace('"','&quot;',rawUrlDecode($itemClass)).'" layout_size="'.$tw_layoutSize.'" row_type="'.(isset($item_array['row-type'])?$item_array['row-type']:'row').'" animation="'.(isset($item_array['animation'])?str_replace('"','&quot;',rawUrlDecode($item_array['animation'])):'none').'" animation_delay="'.(isset($item_array['animation_delay'])?str_replace('"','&quot;',rawUrlDecode($item_array['animation_delay'])):'').'"';
        }
        $content_slug=  empty($defaultItem['content'])?'':$defaultItem['content'];
        echo '[tw_'.$itemSlug.$onlyBuilderAtts;
            foreach($defaultItemSettingsArray as $settings_slug=>$default_settings_array){
                if($content_slug!==$settings_slug&&$default_settings_array['type']!='category'&&$default_settings_array['type']!='button'&&$default_settings_array['type']!='fi'&&$default_settings_array['type']!='cc'){
                    $settings_val=isset($itemSettingsArray[$settings_slug])?$itemSettingsArray[$settings_slug]:(isset($default_settings_array['default'])?$default_settings_array['default']:'');
                    echo ' '.$settings_slug.'="'.str_replace('"','&quot;',rawUrlDecode($settings_val)).'"';
                }
            }
        echo ']';
        if($content_slug){
            $settings_val='';
            if($defaultItemSettingsArray[$content_slug]['type']==='container'&&isset($defaultItemSettingsArray[$content_slug]['default'][0])){
                $defaultContainarItem=$defaultItemSettingsArray[$content_slug]['default'][0];
                $containarItemArray =$itemSettingsArray[$content_slug];
                foreach($containarItemArray as $index=>$containarItem){
                    $containarItemContent='';
                    $settings_val .= '[tw_'.$itemSlug.'_item';
                    foreach($containarItem as $slug=>$value){
                        if($defaultContainarItem[$slug]['type']!='category'&&$defaultContainarItem[$slug]['type']!='button'&&$defaultContainarItem[$slug]['type']!='fi'&&$default_settings_array['type']!='cc'){
                            if($defaultContainarItem[$slug]['type']==='textArea'){
                                $containarItemContent=rawUrlDecode($value);
                            }else{
                                $settings_val .= ' '.$slug.'="'.str_replace('"','&quot;',rawUrlDecode($value)).'"';
                            }
                        }
                    }
                    $settings_val .= ']';
                    if(!empty($containarItemContent)){
                        $settings_val .= $containarItemContent.'[/tw_'.$itemSlug.'_item]';
                    }
                }
            }else{
                $settings_val=isset($itemSettingsArray[$content_slug])?$itemSettingsArray[$content_slug]:$defaultItemSettingsArray[$content_slug]['default'];
                $settings_val=rawUrlDecode($settings_val);
            }
            echo $settings_val.'[/tw_'.$itemSlug.']';
        }
        $output = ob_get_clean();
        return $output;
    }
}
if (!function_exists('waves_page_builder')) {
    function waves_page_builder($_pb_row_array) {
        global $post,$tw_startPrinted,$waves_elements;
        $endPrint=false;
        ob_start();
        if(empty($_pb_row_array)){
            return false;
        }else{
            $layoutsEcho='';
            foreach($_pb_row_array as $_pb_row){
                $attrs=$bg_type="";
                $rowContrast = isset($_pb_row['row_contrast'])?(' '.$_pb_row['row_contrast']):'';
                $bgStyle = isset($_pb_row['background_style'])?$_pb_row['background_style']:'scroll';
                switch ($bgStyle) {
                    case 'scroll':
                        $bgClass = ' bg-scroll';
                        break;
                    case 'fixed':
                        $bgClass = ' bg-fixed';
                        break;
                    case 'parallax':
                        $bg_type = "parallax";
                        $bgClass = ' bg-parallax';
                        break;
                    default:
                        $bgClass = ' bg-pattern';
                        break;
                }
                if(!empty($_pb_row['row_animate_bg'])&&$_pb_row['row_animate_bg']==='true'){
                    $bgClass .= ' bg-animated';
                    $_pb_row['row_animate_bgs']=str_replace(" ","",$_pb_row['row_animate_bgs']);
                    if(!empty($_pb_row['row_animate_bgs'])){
                       $attrs.=' data-bgcolors="'.$_pb_row['row_animate_bgs'].'"';
                       $animColors=explode(",", $_pb_row['row_animate_bgs']);
                       if(is_array($animColors)){
                           $_pb_row['background_color']=$animColors[0];
                       }
                    }else{
                       $attrs.=' data-bgcolors="#00be59,#00d8e6,#654b9e,#ff5432,#ef008c"';
                       $_pb_row['background_color']='#ef008c';
                    }
                }
                
                $rowCustomClass = !empty($_pb_row['row_custom_class'])?(' '.$_pb_row['row_custom_class']):'';
                $rowCustomId = !empty($_pb_row['row_custom_id'])?(' id="'.$_pb_row['row_custom_id'].'"'):'';
                $class = $rowContrast.$bgClass.$rowCustomClass;
                $_pb_row['background_color']=isset($_pb_row['background_color'])?str_replace(' ','',$_pb_row['background_color']):'';
                $_pb_row['border_color']=isset($_pb_row['border_color'])?str_replace(' ','',$_pb_row['border_color']):'';
                $style = empty($_pb_row['background_color'])?'':('background-color:'.$_pb_row['background_color'].';');
                $style .= empty($_pb_row['background_image'])?'':('background-image:url('.$_pb_row['background_image'].');');
                $style .= empty($_pb_row['border_color'])?'':('border-top: 1px solid '.$_pb_row['border_color'].';');
                $padding_top = $padding_bottom = '';
                $customPaddingTop=false;
                if(isset($_pb_row['padding_top']) && $_pb_row['padding_top'] != '') {
                    $customPaddingTop=true;
                    $padding_top = intval($_pb_row['padding_top']) <= 60 ? ('<div style="margin-top:-'.(60-$_pb_row['padding_top']).'px"></div>') : ('<div style="padding-top:'.($_pb_row['padding_top']-60).'px"></div>');
                }
                if(isset($_pb_row['padding_bottom']) && $_pb_row['padding_bottom'] != '') {
                    $padding_bottom = intval($_pb_row['padding_bottom']) <= 60 ? ('<div style="margin-bottom:-'.(60-$_pb_row['padding_bottom']).'px"></div>') : ('<div style="padding-bottom:'.($_pb_row['padding_top']-60).'px"></div>');
                }
                if(!empty($_pb_row['background_video'])){
                    $bg_type='video';
                    $style .= 'overflow: hidden;position:relative;';
                    $layoutsEcho .= '<div'.$rowCustomId.' class="row-container'.$class.'" style="'.$style.'"'.$attrs.'>';
                    $layoutsEcho .= '<div class="video-mask"></div><div class="video-mask-color"></div><div class="background-video"><div id="jquery_jplayer_'.$post->ID.'" class="jp-jplayer jp-jplayer-bgvideo" data-pid="'.$post->ID.'" data-m4v="'.$_pb_row['background_video'].'" data-thumb="'.$_pb_row['background_image'].'"></div></div>';
                    $layoutsEcho .= '<div class="waves-container container" style="position:relative; z-index:4"><div class="row">'.$padding_top;
                } else {
                    $layoutsEcho .= '<div'.$rowCustomId.' class="row-container'.$class.'" style="'.$style.'"'.$attrs.'><div class="waves-container container"><div class="row">'.$padding_top;
                }
                $cnt=0;
                foreach($_pb_row['layouts'] as $_pb_layout){
                    $cnt++;
                    if($_pb_layout['size']!=='col-md-0'){                        
                        global $tw_layoutSize;
                        $_pb_layout['layout_custom_class']=isset($_pb_layout['layout_custom_class'])?$_pb_layout['layout_custom_class']:'';
                        $_pb_layout['main_size'] = '';
                        if($cnt === 1 && $_pb_layout['size'] === 'col-md-3' && $_pb_row['row_layout']==='3-9-0'){
                            $_pb_layout['main_size'] = 'waves-sidebar col-md-4';
                        }elseif($cnt === 2 && $_pb_layout['size'] === 'col-md-9' && ($_pb_row['row_layout']==='3-9-0'||$_pb_row['row_layout']==='0-9-3')){
                            $_pb_layout['main_size'] = 'waves-main col-md-8';
                        }elseif($cnt === 3 && $_pb_layout['size'] === 'col-md-3' && $_pb_row['row_layout']==='0-9-3'){
                            $_pb_layout['main_size'] = 'waves-sidebar col-md-4';
                        }
                        $tw_layoutSize = $_pb_layout['size'];
                        $layoutsEcho .= '[tw_layout bg_type="'.$bg_type.'" main_size="'.$_pb_layout['main_size'].'" size="'.$_pb_layout['size'].'" layout_custom_class="'.$_pb_layout['layout_custom_class'].'"]';
                            $tw_startPrinted=false;    
                            $colCounter=0;
                            $start='true';
                            foreach ($_pb_layout['items'] as $item_array){
                                list($colCounter,$start)=rowStart($colCounter,$_pb_layout['size']==='col-md-3'?12:intval(str_replace('col-md-','',$item_array['size'])));
                                $endPrint=true;
                                $rowClass = $item_array['row-type'] = !empty($waves_elements[$item_array['slug']]['row-type'])?$waves_elements[$item_array['slug']]['row-type']:'row';
                                if($start === "true") {
                                    if($tw_startPrinted){$layoutsEcho .= '</div>';}
                                    $tw_startPrinted=true;
                                    $layoutsEcho .= '<div class="'.$rowClass.'">';
                                }
                                $layoutsEcho .= waves_builder_item($item_array);
                            }
                            if($tw_startPrinted){$layoutsEcho.='</div>';}
                        $layoutsEcho .= '[/tw_layout]';
                    }
                }
                $layoutsEcho .= '</div>'.$padding_bottom.'</div></div>';
            }
            if($endPrint){
                echo $layoutsEcho;
            }else{
                return false;
            }
        }
        $output = ob_get_clean();
        return $output;
    }
}