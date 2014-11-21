<?php
/* ================================================================================== */
/*      Core Content Shortcode
/* ================================================================================== */

function waves_content($atts, $content) {
    global $tw_isshortcode;
    $tw_isshortcode='true';
    $atts = shortcode_atts(array(
        'size'  => 'col-md-12',
        'class' => '',
        'title' => '',
        'animation'     =>'none',
        'animation_delay'=>'',
    ), $atts);
    $output  = waves_item($atts);
        $output .= '<div class="entry-content">';
            $output .= apply_filters("the_content", get_the_content());
        $output .= '</div>';
    $output .= '</div>';
    $tw_isshortcode='false';
    return $output;
}
add_shortcode('tw_content', 'waves_content');