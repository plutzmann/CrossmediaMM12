<?php
/* ================================================================================== */
/*      Column Shortcode
/* ================================================================================== */

function waves_column($atts, $content){
    global $tw_isshortcode;
    $tw_isshortcode='true';
    $output  = waves_item($atts);
        $output .= apply_filters("the_content", $content);
    $output .= '</div>';
    $tw_isshortcode='false';
    return $output;
}
add_shortcode('tw_column', 'waves_column');