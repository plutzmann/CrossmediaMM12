<?php
/* ================================================================================== */
/*      Toggle container
/* ================================================================================== */

function waves_toggle($atts, $content) {
    $output  = waves_item($atts,'waves-toggle');
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_toggle', 'waves_toggle');



/* ================================================================================== */
/*      Toggle Item
/* ================================================================================== */

function waves_toggle_item($atts, $content) {
    $atts = shortcode_atts( array(
		'title' => __('Toggle', 'waves'),
		'expand' => 'false',
		'animation' => 'none',
		'animation_delay' => ''
    ), $atts );
    $class=$animation=$active='';
    if($atts['animation']!=='none'){
        $class .= ' tw-animate-gen';
        $atts['animation_delay'] = empty($atts['animation_delay']) ? '0': str_replace(' ','',$atts['animation_delay']);
        $animation = ' data-animation="'.$atts['animation'].'" data-animation-delay="'.$atts['animation_delay'].'" data-animation-offset="90%" style="opacity:0;"';
    }
    if($atts['expand']=='true'){
        $active = ' active';
    }

    $output = '<div class="accordion-group'.$class.$active.'"'.$animation.'>';
        $output .= '<div class="accordion-heading">';
            $output .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="" href="#">';
                $output .= $atts['title'];
                $output .= '<span class="tw-check fa"><i class="fa-plus"></i><i class="fa-minus"></i></span>';
            $output .= '</a>';
        $output .= '</div>';
        $output .= '<div class="accordion-body collapse">';    
            $output .= '<div class="accordion-inner">';
                $output .= apply_filters('the_excerpt', $content);
            $output .= '</div>';
        $output .= '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('tw_toggle_item', 'waves_toggle_item');