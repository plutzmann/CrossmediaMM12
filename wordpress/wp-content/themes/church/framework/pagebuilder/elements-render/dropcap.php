<?php
/* ================================================================================== */
/*      Dropcap Shortcode
/* ================================================================================== */

function waves_dropcap($atts, $content) {
    $atts = shortcode_atts( array(
        'size'  => 'col-md-3',
        'class' => '',
        'title' => '',
        'style' => '',
        'color' => '#000'
    ), $atts );
    $class = '';
    $style = 'style="color: ' . $atts['color'] . ';"';
    
    if ($atts['style'] == 'circle') {
        $class = ' dropcap_circle';
        $style = 'style="background-color: ' . $atts['color'] . ';"';
    } elseif ($atts['style'] == 'square') {
        $class = ' dropcap_square dropcap_border';
        $style = 'style="background-color: ' . $atts['color'] . ';border-color: ' . $atts['color'] . ';"';
    } elseif ($atts['style'] == 'square_border') {
        $class = ' dropcap_square dropcap_border';
        $style = 'style="border-color: ' . $atts['color'] . '; color: ' . $atts['color'] . '"';
    } elseif ($atts['style'] == 'circle_border') {
        $class = ' dropcap_circle dropcap_border';
        $style = 'style="border-color: ' . $atts['color'] . '; color: ' . $atts['color'] . '"';
    }
    
    return '<span class="tw-dropcap' . $class . '" ' . $style . '>' . $content . '</span>';
}
add_shortcode('tw_dropcap', 'waves_dropcap');