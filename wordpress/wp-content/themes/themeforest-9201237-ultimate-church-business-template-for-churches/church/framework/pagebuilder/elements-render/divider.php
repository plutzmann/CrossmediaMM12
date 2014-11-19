<?php

/* ================================================================================== */
/*      Divider Shortcode
  /* ================================================================================== */

function waves_divider($atts, $content) {
   $atts = shortcode_atts(array(
        'size' => 'col-md-12',
        'class' => '',
        'title' => '',
        'icon' => '',
        'type' => '',
        'color' => '',
        'text' => '',
        'position' => 'center',
        'top' => '0',
        'bottom' => '0',
        'animation'     =>'none',
        'animation_delay'=>'',
    ), $atts);
    $class='divider-'.$atts['position'].' tw-divider';
    $style2=$data='';
    $style='display:block;margin-bottom:' . $atts['bottom'] . 'px;margin-top:' . $atts['top'] . 'px;';
    if ($atts['type'] == 'space') {
        $class.='-space';
    } elseif ($atts['type'] == 'top') {
        $class.=' divider-top';
        $style2='background-color:'.$atts['color'].';';
    } else {
        $style2='background-color:'.$atts['color'].';';
    }
    
    $output  = waves_item($atts,$class,$data,$style);
    $output  .= "<div style='$style2'>";
        if($atts['type'] !== 'space'){
            if (!empty($atts['icon'])) {$output .= '<i class="fa '. $atts['icon'].' '.$atts['type'].' " style="color:'.$atts['color'].';border-color:'.$atts['color'].'"></i>';}
            elseif (!empty($atts['text'])) {$output .= '<h6><span style="border-color:'.$atts['color'].'">'.$atts['text'].'</span></h6>';}
        }
    $output .= '</div></div>';
    return $output;
}

add_shortcode('tw_divider', 'waves_divider');
