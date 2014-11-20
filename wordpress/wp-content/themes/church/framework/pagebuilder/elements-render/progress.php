<?php
/* ================================================================================== */
/*      Progress Shortcode
/* ================================================================================== */

function waves_progress($atts, $content) {
    $output  = waves_item($atts);
        $output .= do_shortcode($content);
    $output .= '</div>';
    
    return $output;
}
add_shortcode('tw_progress', 'waves_progress');


/* ================================================================================== */
/*      Progress Shortcode
/* ================================================================================== */

function waves_progress_item($atts, $content) {
    $atts = shortcode_atts( array(
		'title' => __('Progress', 'waves'),
		'type' => 'default',
		'animation' => 'none',
		'animation_delay' => '',
		'percent' => '50',
		'color' => ''
    ), $atts );
    $class=$animation='';
    if($atts['animation']!=='none'){
        $class .= ' tw-animate-gen';
        $atts['animation_delay'] = empty($atts['animation_delay']) ? '': str_replace(' ','',$atts['animation_delay']);
        $animation = ' data-animation="'.$atts['animation'].'" data-animation-delay="'.$atts['animation_delay'].'" data-animation-offset="90%" style="opacity:0;"';
    }

    if ($atts['type'] == 'animated') {
        $output = '<div class="waves-progress progress-striped active'.$class.'"'.$animation.'>';
    } elseif ($atts['type'] == 'striped') {
        $output = '<div class="waves-progress progress-striped'.$class.'"'.$animation.'>';
    } else {
        $output = '<div class="waves-progress'.$class.'"'.$animation.'>';
    }
    $output .= '<h5 class="progress-title">'.$atts['title'].' <span>' . $atts['percent'] . '%</span></h5>';
    $output .= '<div class="bar-container"><div class="bar" style="width: ' . $atts['percent'] . '%;background-color: ' . $atts['color'] . '"></div></div>';
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_progress_item', 'waves_progress_item');