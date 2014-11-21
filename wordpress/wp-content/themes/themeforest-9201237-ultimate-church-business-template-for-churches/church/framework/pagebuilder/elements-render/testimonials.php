<?php
/* ================================================================================== */
/*      Testimonials Shortcode
/* ================================================================================== */

function waves_testimonials($atts, $content) {
    $atts = shortcode_atts( array(
        'size'  => 'col-md-12',
        'class' => '',
        'title' => '',
        'auto_play' => 'true',
        'duration' => '1000',
        'timeout' => '2000',
        'animation' => 'none',
        'animation_delay' => ''
    ), $atts);
    global $parentAtts;
    $with_title=empty($atts['title'])?'':' with-title';
        $output  = waves_item($atts,'carousel-container'.$with_title);
            $output .= '<div class="waves-carousel-testimonial list_carousel clearfix" data-duration="' . $atts['duration'] . '" data-autoplay="'.$atts['auto_play'].'" data-timeout="' . $atts['timeout'] . '">';
                $output .= '<div class="waves-carousel">';
                    $output .= do_shortcode($content);
                $output .= '</div>';
            $output .= '</div>';
        $output .= '</div>';
    return $output;
}
add_shortcode('tw_testimonials', 'waves_testimonials');


/* ================================================================================== */
/*      Testimonials item
/* ================================================================================== */

function waves_testimonials_item($atts, $content) {
    $atts = shortcode_atts( array(
        "name"    =>"",
        "url"     =>"",
    ), $atts );
    $output  = '<div class="testimonial-item clearfix">';
        $output .= '<div class="testimonial-content"><div class="testimonial-content-inner"><p>'.do_shortcode($content).'</p></div></div>';
        $output .= '<h2><a href="' . esc_url($atts['url']) . '">' . $atts['name'] . '</a></h2>';
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_testimonials_item', 'waves_testimonials_item');