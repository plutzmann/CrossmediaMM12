<?php
/* ================================================================================== */
/*      Messagebox Container
/* ================================================================================== */

function waves_messagebox($atts, $content) {
    $output  = waves_item($atts,"waves-messagebox");
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_message_box', 'waves_messagebox');



/* ================================================================================== */
/*      Messagebox Item
/* ================================================================================== */

function waves_messagebox_item($atts, $content) {
    $atts = shortcode_atts( array(
        'size'  => 'col-md-3',
        'class' => '',
        'title' => '',
        'type' => 'default',
        'animation' => 'none',
        'animation_delay' => ''
    ), $atts );
    $class=$animation='';
    if($atts['animation']!=='none'){
        $class .= ' tw-animate-gen';
        $atts['animation_delay'] = empty($atts['animation_delay']) ? '': str_replace(' ','',$atts['animation_delay']);
        $animation = ' data-animation="'.$atts['animation'].'" data-animation-delay="'.$atts['animation_delay'].'" data-animation-offset="90%" style="opacity:0;"';
    }
    $output  = '<div class="alert alert-' . $atts['type'] . $class . '"'.$animation.'>';
        $output .= do_shortcode($content);
    $output .= '</div>';

    return $output;
}
add_shortcode('tw_message_box_item', 'waves_messagebox_item');