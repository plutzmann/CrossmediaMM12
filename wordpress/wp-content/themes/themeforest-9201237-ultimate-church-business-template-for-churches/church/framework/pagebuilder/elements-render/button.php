<?php

/* ================================================================================== */
/*      Button Shortcode
  /* ================================================================================== */

function waves_button($atts, $content) {
    $rounded = !empty($atts['rounded']) && $atts['rounded'] == 'true' ? ' rounded' : '';
    $link = !empty($atts['link']) ? $atts['link'] : '#';
    $style = !empty($atts['btn_style']) ? (' btn-' . $atts['btn_style']) : '';
    $size = !empty($atts['size']) ? (' btn-' . $atts['size']) : '';
    $span = '';
    $target = !empty($atts['target']) ? ($atts['target']) : '_blank';
    $color = '';
    $whitecolor = '';
    if (!empty($atts['color'])) {
        $color .= ' style="border-color:' . $atts['color'] . ';';
        $color .= (!empty($atts['btn_style']) && $atts['btn_style'] === 'border' ? ('color:' . $atts['color']) : ('background-color:' . $atts['color'])) . '"';
        if ($atts['color'] == '#fff' || $atts['color'] == '#ffffff' || $atts['color'] == 'white')
            $whitecolor = ' white-button';
    }
    if(!empty($atts['btn_style']) && $atts['btn_style'] === 'border'){
        $span.='<span style="background-color:'.$atts['color'].';"></span>';
    }
    return '<a href="' . $link . '" target="' . $target . '" class="btn' . $rounded . $style . $size . $whitecolor . '"' . $color . '>' . $content . $span .'</a>';
}

add_shortcode('tw_button', 'waves_button');
