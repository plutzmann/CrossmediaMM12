<?php
/* ================================================================================== */
/*      Text carousel Shortcode
/* ================================================================================== */

function waves_text_carousel($atts, $content) {
    $atts = shortcode_atts( array(
        'size'  => 'col-md-12',
        'class' => '',
        'title' => '',
        'height' => '',
        'duration' => '1000',
        'timeout' => '2000',
    ), $atts );
    global $parentAtts;
    $parentAtts=$atts;
    $with_title=empty($atts['title'])?'':' with-title';
    $output  = waves_item($atts,'carousel-container'.$with_title);
        $output .= '<div class="waves-carousel-text list_carousel clearfix" data-duration="' . $atts['duration'] . '" data-timeout="' . $atts['timeout'] . '">';
            $output .= '<div class="waves-carousel">';
                $output .= do_shortcode($content);
            $output .= '</div>';
        $output .= '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('tw_text_carousel', 'waves_text_carousel');


/* ================================================================================== */
/*      Text carousel item
/* ================================================================================== */

function waves_text_carousel_item($atts, $content) {
    global $parentAtts;
    $height = !empty($parentAtts['height']) ? ('height:'.$parentAtts['height'].'px;') : '';
    $bg = !empty($atts['background_image']) ? ('background-image:url('.$atts['background_image'].');') : '';
    $url = !empty($atts['link_url']) ? $atts['link_url'] : '#';
    $target = isset($atts['link_target']) ? $atts['link_target'] : '_blank';
    
    $output = '<div class="tw-owl-item" style="'.$height.$bg.'">';
        $output .= '<div class="text-carousel-item clearfix">';
            $output .= '<div class="text-carousel-content"><a href="' . esc_url($url) . '" target="' . $target . '">';
                $output .= $atts['title'];
            $output .= '</a></div>'; 
       $output .= '</div>';
    $output .= '</div>';
    

    return $output;
}
add_shortcode('tw_text_carousel_item', 'waves_text_carousel_item');