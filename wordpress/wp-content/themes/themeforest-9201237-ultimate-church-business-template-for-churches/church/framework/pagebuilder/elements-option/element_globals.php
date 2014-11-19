<?php
global $waves_element_options, $waves_global_options;

$waves_element_options['order'] = array(
    "date_desc" => "Date Desc",
    "date_asc" => "Date Asc",
    "title_desc" => "Title Desc",
    "title_asc" => "Title Asc",
    "random" => "Random",
);

$waves_element_options['animations'] = array(
    'none'=>'No Animation',
    'fadeIn'=>'FadeIn',
    'fadeInUp'=>'FadeInUp',
    'fadeInDown'=>'FadeInDown',
    'fadeInLeft'=>'FadeInLeft',
    'fadeInRight'=>'FadeInRight',
    'fadeInUpBig'=>'FadeInUpBig',
    'fadeInDownBig'=>'FadeInDownBig',
    'fadeInLeftBig'=>'FadeInLeftBig',
    'fadeInRightBig'=>'FadeInRightBig',
    'fadeIn2'=>'Another FadeIn',
    'slideUp'=>'SlideUp',
    'slideDown'=>'SlideDown',
    'slideLeft'=>'SlideLeft',
    'slideRight'=>'SlideRight',
    'slideExpandUp'=>'SlideExpandUp',
    'expandUp'=>'ExpandUp',
    'expandOpen'=>'ExpandOpen',
    'bigEntrance'=>'BigEntrance',
    'hatch'=>'Hatch',
    'bounce'=>'Bounce',
    'pulse'=>'Pulse',
    'floating'=>'Floating',
    'tossing'=>'Tossing',
    'pullUp'=>'PullUp',
    'pullDown'=>'PullDown',
    'stretchLeft'=>'StretchLeft',
    'stretchRight'=>'StretchRight',
    'flash'=>'Flash',
    'shake'=>'Shake',
    'tada'=>'Tada',
    'swing'=>'Swing',
    'wobble'=>'Wobble',
    'pulse'=>'Pulse',
    'flip'=>'Flip',
    'flipInX'=>'FlipInX',
    'flipInY'=>'FlipInY',
    'bounceIn'=>'BounceIn',
    'bounceInDown'=>'BounceInDown',
    'bounceInUp'=>'BounceInUp',
    'bounceInLeft'=>'BounceInLeft',
    'bounceInRight'=>'BounceInRight',
    'rotateIn'=>'RotateIn',
    'rotateInDownLeft'=>'RotateInDownLeft',
    'rotateInDownRight'=>'RotateInDownRight',
    'rotateInUpLeft'=>'RotateInUpLeft',
    'rotateInUpRight'=>'RotateInUpRight',
    'lightSpeedIn'=>'LightSpeedIn',
    'rollIn'=>'RollIn'
);

$waves_element_options['target'] = array("_blank" => "Blank", "_self" => "Self");

$waves_element_options['yesno'] = array("true" => "Yes", "false" => "No");

$waves_element_options['bgposition'] = array(
    "left top" => "left top",
    "left center" => "left center",
    "left bottom" => "left bottom",
    "right top" => "right top",
    "right center" => "right center",
    "right bottom" => "right bottom",
    "center top" => "center top",
    "center center" => "center center",
    "center bottom" => "center bottom"
);

$arraySidebar = array("Default sidebar" => "Default sidebar");
$sidebars = get_option('sbg_sidebars');
if (!empty($sidebars)) {
    foreach ($sidebars as $sidebar) {
        $arraySidebar[$sidebar] = $sidebar;
    }
}
$waves_element_options['sidebars'] = $arraySidebar;
//LayerSlider
global $wpdb;
$sliders='';
$table_name = $wpdb->prefix . "layerslider";
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'")) {
    $sliders = $wpdb->get_results( "SELECT * FROM $table_name
                                WHERE flag_hidden = '0' AND flag_deleted = '0'
                                ORDER BY date_c ASC LIMIT 100" );
}
$waves_element_options['layerslider']  = array("0" => "Select Slider");
if(!empty($sliders)) {
    foreach($sliders as $item) {
        $name = empty($item->name) ? ('Unnamed('.$item->id.')') : $item->name;
        $waves_element_options['layerslider'][$item->id]=$name;
    }
}

//RevSlider
// global $wpdb;
$sliders='';
$table_name = $wpdb->prefix . "revslider_sliders";
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'")) {
    $sliders = $wpdb->get_results( "SELECT * FROM $table_name" );
}
$waves_element_options['revslider'] = array("0" => "Select Slider");
if(!empty($sliders)) {
    foreach($sliders as $item) {
        $name = empty($item->title) ? ('Unnamed('.$item->id.')') : $item->title;
        $waves_element_options['revslider'][$item->id]=$name;
    }
}

//MasterSlider
// global $wpdb;
$sliders='';
$table_name = $wpdb->prefix . "masterslider_sliders";
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'")) {
    $sliders = $wpdb->get_results( "SELECT * FROM $table_name" );
}
$waves_element_options['masterslider'] = array("0" => "Select Slider");
if(!empty($sliders)) {
    foreach($sliders as $item) {
        $name = empty($item->title) ? ('Unnamed('.$item->ID.')') : $item->title;
        $waves_element_options['masterslider'][$item->ID]=$name;
    }
}


$ignoredPostType=array('page','attachment','revision','nav_menu_item');
$arrayPostType = array();
$arrayPostTypeHide = array();
$postTypeList = get_post_types(array(),'objects');
foreach($postTypeList as $slug => $typeOptions){
    if(!in_array($slug, $ignoredPostType)){
        $arrayPostType[$slug] = $typeOptions->labels->menu_name;
        //---------hide----------
        $tmpArr=array();
        foreach($postTypeList as $slugSub => $typeOptionsSub){
            if(!in_array($slugSub, $ignoredPostType)&&$slug!==$slugSub){$tmpArr[]='cat_'.$slugSub;}
        }
        $arrayPostTypeHide[$slug]=implode(",", $tmpArr);
    }
}

$categories=array();
foreach($arrayPostType as $slug => $name){
    $categories[$slug]=array();
    $taxonomyNames = get_object_taxonomies($slug);
    if(isset($taxonomyNames[0])){
        $taxonomyCategories = get_terms($taxonomyNames[0], 'hide_empty=0');
        $categories[$slug]["0"] = "Select Category";
        if(!empty($taxonomyCategories)) {
            foreach ($taxonomyCategories as $taxonomyCategorie) {
                $categories[$slug][$taxonomyCategorie->slug] = $taxonomyCategorie->name;
            }
        }
    }
}
$waves_element_options['cat'] = $categories;

$waves_global_options['element'] = array(
    "item_title" => array(
        "title" => "Element Title",
        "type" => "text",
    ),
    "custom_class" => array(
        "title" => "Custom Class",
        "type" => "text",
    ),
    "animation" => array(
        "title" => "Animation",
        "type" => "select",
        "options" => $waves_element_options['animations'],
        "default" => "none",
    ),
    "animation_delay" => array(
        "title" => "Animation Delay",
        "type" => "text",
        "holder" => "Example:300",
        "desc" => "",
    )
);

$waves_global_options["row"] = array(
    "row_custom_class" => array(
        "title" => "Custom Class",
        "type" => "text",
        "holder" => "",
        "default" => "",
        "desc" => "",
    ),
    "row_custom_id" => array(
        "title" => "Custom ID",
        "type" => "text",
        "holder" => "",
        "default" => "",
        "desc" => "ID will help you build One Page, Example: if you inserted about here then use the Menu section to yourwebsite.com/#about etc",
    ),
    "background_color" => array(
        "title" => "Background color",
        "type" => "color",
        "holder" => "",
        "default" => "",
        "desc" => "",
    ),
    "background_image" => array(
        "title" => "Background image",
        "type" => "text",
        "holder" => "",
        "default" => "",
        "desc" => "",
    ),
    "add_background_image" => array(
        "title" => "",
        "type" => "button",
        "save_to" => "background_image",
        "default" => "Upload",
        "desc" => "",
    ),
    "background_style" => array(
        "title" => "Background image style",
        "type" => "select",
        "options" => array("scroll" => "Scroll", "fixed" => "Fixed", "parallax" => "Parallax", "pattern" => "Pattern"),
        "default" => "",
        "desc" => "",
    ),
    "background_video" => array(
        "title" => "Background video url",
        "type" => "text",
        "holder" => "",
        "default" => "",
        "desc" => "This section can works with VIDEO pbuilder element.",
    ),
    "add_background_video" => array(
        "title" => "",
        "type" => "button",
        "save_to" => "background_video",
        "default" => "Upload",
        "desc" => "",
    ),
    "default_row" => array(
        "title" => "",
        "type" => "hidden",
        "holder" => "",
        "default" => "true",
        "desc" => "",
    ),
    "row_layout" => array(
        "title" => "",
        "type" => "hidden",
        "holder" => "",
        "default" => "full",
        "desc" => "",
    ),
    "row_contrast" => array(
        "title" => "Container Color Scheme",
        "type" => "select",
        "options" => array('dark' => 'Dark', 'light' => 'Light'),
        "default" => "light",
        "desc" => "If you have inserted Dark background image or color then you must choose dark then all element colors will be white.",
    ),
    "padding_top" => array(
        "title" => "Container Padding Top",
        "type" => "text",
        "holder" => "",
        "default" => "",
        "desc" => "Controlling Container top margin value. Note: Insert only Digits, 0 means no space, Default is 60px;",
    ),
    "padding_bottom" => array(
        "title" => "Container Padding Bottom",
        "type" => "text",
        "holder" => "",
        "default" => "",
        "desc" => "Those options will helps you insert images with no space top or bottom from container.",
    ),
    "border_color" => array(
        "title" => "Border Top Color",
        "type" => "color",
        "default" => "",
        "desc" => "",
    ),
);