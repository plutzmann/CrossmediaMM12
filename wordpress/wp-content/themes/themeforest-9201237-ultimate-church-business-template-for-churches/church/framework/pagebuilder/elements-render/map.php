<?php
/* ================================================================================== */
/*      Map Shortcode
/* ================================================================================== */

function waves_map($atts, $content) {
    $atts = shortcode_atts(array(
        'size'  => 'col-md-12',
        'class' => '',
        'title' => '',
        'type'  => 'boxed',
        'animation' => 'none',
        'animation_delay' => ''
    ), $atts);
    $output  = waves_item($atts);
        $output .= '<div class="waves-map'.($atts['type']==='full'?' waves-full-element':'').'">';
            $output .= $content;
        $output .= '</div>';
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_map', 'waves_map');