<?php
/* ================================================================================== */
/*      Accordion container
/* ================================================================================== */

function waves_accordion($atts, $content) {
    $output = waves_item($atts,'waves-accordion');
        $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_accordion', 'waves_accordion');


/* ================================================================================== */
/*      Accordion item
/* ================================================================================== */

function waves_accordion_item($atts, $content) {
    $atts = shortcode_atts( array(
		'title' => __('Accordion', 'waves'),
		'expand' => 'false',
		'animation' => 'none',
		'animation_delay' => ''
    ), $atts );
    $class=$animation=$active='';
    if($atts['animation']!=='none'){
        $class .= ' tw-animate-gen';
        $atts['animation_delay'] = empty($atts['animation_delay']) ? '0': str_replace(' ','',$atts['animation_delay']);
        $animation .= ' data-animation="'.$atts['animation'].'" data-animation-delay="'.$atts['animation_delay'].'" data-animation-offset="90%" style="opacity:0;"';
    }
    if($atts['expand']=='true'){
        $active = ' active';
    }

    $output = '<div class="accordion-group'.$class.$active.'"'.$animation.'>';
        $output .= '<div class="accordion-heading">';
            $output .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="" href="#">';
                $output .= $atts['title'];
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
add_shortcode('tw_accordion_item', 'waves_accordion_item');