<?php
/* ================================================================================== */
/*      Social Shortcode
/* ================================================================================== */

function waves_social($atts, $content) {
    $atts = shortcode_atts( array(
        'size'  => 'col-md-12',
        'class' => '',
        'title' => '',
        'count' => '',
    ), $atts );
    $with_title=empty($atts['title'])?'':' with-title';
    $count = !empty($atts['count']) ? $atts['count'] : 1;
    $output  = waves_item($atts,'socials-container'.$with_title);
        $output .= '<div class="waves-social-items social-count-'.$count.' clearfix">';
                $output .= do_shortcode($content);
        $output .= '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('tw_social', 'waves_social');


/* ================================================================================== */
/*      Text carousel item
/* ================================================================================== */

function waves_social_item($atts, $content) {
    $link = !empty($atts['link']) ? $atts['link'] : '#';
    
    $output = '<div class="social-item '.$atts['title'].'">';
                $output .= '<a href="'. $link .'">'.$atts['title'].'</a>';
    $output .= '</div>';
    

    return $output;
}
add_shortcode('tw_social_item', 'waves_social_item');