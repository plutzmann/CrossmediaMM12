<?php
/* ================================================================================== */
/*      Label Shortcode
/* ================================================================================== */

function waves_label($atts, $content) {
    $color = !empty($atts['color']) ? (' style="background:' . $atts['color'] . '"') : '';
    return '<span class="label"' . $color . '>' . $content . '</span>';
}
add_shortcode('tw_label', 'waves_label');