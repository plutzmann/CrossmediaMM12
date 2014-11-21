<?php
/* ================================================================================== */
/*      Partner Shortcode
/* ================================================================================== */

function waves_carousel_partner($atts, $content) {
    $atts = shortcode_atts( array(
        'size'  => 'col-md-3',
        'class' => '',
        'title' => '',
        'auto_play' => 'false',
        'animation' => 'none',
        'animation_delay' => 'bottom-in-view'
    ), $atts );
   $with_title=empty($atts['title'])?'':' with-title';
    $output  = waves_item($atts,"carousel-container".$with_title);
        $output .= '<div class="waves-carousel-partner list_carousel" data-autoplay="'.$atts['auto_play'].'">';
            $output .= '<div class="waves-carousel">';
                $output .= do_shortcode($content);
            $output .= '</div>';
            $output .= '<div class="clearfix"></div>';
        $output .= '</div>';
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_partner', 'waves_carousel_partner');




/* ================================================================================== */
/*      Partner item
/* ================================================================================== */

function waves_partner_item($atts, $content) {
    $atts = shortcode_atts( array(
        "title" => "",
        "link" => "",
        "thumb" => "",
    ), $atts );
    $output = '<div class="tw-owl-item">';
        if ($atts['link'] != '') {$output .= '<a href="' . $atts['link'] . '" title="'.$atts['title'].'">';}
            $output .= '<img alt="'.$atts['title'].'" src="'.$atts['thumb'].'" />';
        if ($atts['link'] != '') {$output .= '</a>';}
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_partner_item', 'waves_partner_item');