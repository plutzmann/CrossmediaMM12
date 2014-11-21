<?php
/* ================================================================================== */
/*      List Container
/* ================================================================================== */

function waves_list($atts, $content) {
    $output  = waves_item($atts);
    $output .= '<ul class="waves-list">';
    $output .= do_shortcode($content);
    $output .= '</ul>';
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_list', 'waves_list');

/* ================================================================================== */
/*      List Item
/* ================================================================================== */

function waves_list_item($atts, $content) {
    $atts = shortcode_atts( array(
        'item_icon' => '',
        'animation' => 'none',
        'animation_delay' => ''
    ), $atts );
    
    $class=$animation='';    
    if($atts['animation']!=='none'){
        $class .= ' tw-animate-gen';
        $atts['animation_delay'] = empty($atts['animation_delay']) ? '0': str_replace(' ','',$atts['animation_delay']);
        $animation = ' data-animation="'.$atts['animation'].'" data-animation-delay="'.$atts['animation_delay'].'" data-animation-offset="90%" style="opacity:0;"';
    }
    
    $output = '<li class="'.$class.'"'.$animation.'><i class="fa ' . $atts['item_icon'] . '"></i>' . do_shortcode($content) . '</li>';
    return $output;
}
add_shortcode('tw_list_item', 'waves_list_item');