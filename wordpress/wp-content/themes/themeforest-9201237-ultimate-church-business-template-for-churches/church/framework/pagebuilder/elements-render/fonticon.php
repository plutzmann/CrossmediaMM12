<?php
/* ================================================================================== */
/*      Font Icon Shortcode
/* ================================================================================== */

function shortcode_tw_fonticon($atts, $content) {
    $atts = shortcode_atts(array(
        'size' => 'col-md-3',
        'class' => '',
        'title' => '',
        // ----------------
        "fi" => "",
        "fi_size" => "30",
        "fi_padding" => "20",
        "fi_color" => "#aaaaaa",
        "fi_bg_color" => "",
        "fi_border_color" => "#aaaaaa",
        "fi_rounded" => "6",
        "fi_rounded_size" => "3",
        "fi_box_shadow" => "false",
        "fi_rotate" => "false",
        "fi_icon" => "fa-glass",
    ), $atts);
    
    $atts['fi_size'] = str_replace('px', '', $atts['fi_size']);
    $atts['fi_padding'] = str_replace('px', '', $atts['fi_padding']);
    $atts['fi_rounded'] = str_replace('px', '', $atts['fi_rounded']);
    $atts['fi_rounded_size'] = str_replace('px', '', $atts['fi_rounded_size']);
    $style = 'text-align:center;';
    $style .='font-size:' . $atts['fi_size'] . 'px;';
    $style .='width:' . ($atts['fi_size']+2) . 'px;';
    $style .='line-height:' . ($atts['fi_size']+2) . 'px;';
    $style .='padding:' . $atts['fi_padding'] . 'px;';
    $style .='color:' . $atts['fi_color'] . ';';
    $style .='background-color:' . $atts['fi_bg_color'] . ';';
    $style .='border-color:' . $atts['fi_border_color'] . ';';
    $style .='border-width:' . $atts['fi_rounded'] . 'px;';
    $style .='border-radius:' . $atts['fi_rounded_size'] . 'px;';
    $style .='-webkit-border-radius:' . $atts['fi_rounded_size'] . 'px;';
    $style .='-moz-border-radius:' . $atts['fi_rounded_size'] . 'px;';
    if ($atts['fi_box_shadow']==='true'){
        $style .='-webkit-box-shadow: inset 0px 0px 0px 2px ' . $atts['fi_color'] . '; -moz-box-shadow: inset 0px 0px 0px 2px ' . $atts['fi_color'] . '; box-shadow: inset 0px 0px 0px 2px ' . $atts['fi_color'] . ';';
    }
    $output = '<i class="tw-font-icon fa ' . $atts['fi_icon'] .($atts['fi_rotate']==='true'?' fi-rotate':''). '" style="border-style: solid;font-style:normal;' . $style . '"></i>';
    return $output;
}
add_shortcode('tw_fonticon', 'shortcode_tw_fonticon');