<?php

/* ================================================================================== */
/*      Item Title Shortcode
  /* ================================================================================== */

function waves_heading($atts, $content) {
    $atts = shortcode_atts(array(
        'size' => 'col-md-12',
        'class' => '',
        'title' => '',
        "position" => 'center',
        'animation' => 'none',
        'animation_delay' => 'bottom-in-view'
    ), $atts);
    $title = $atts['title'];    
    if(!empty($title)){
        $atts['title'] = '';
        $output  = waves_item($atts, 'waves-heading '.$atts['position']);
                $output .= '<h3 class="heading-title">'.rawUrlDecode($title).'</h3>';
                if(!empty($content)) {$output .= '<p>'.do_shortcode($content).'</p>';}
        $output .= '</div>';
        return $output;
    }
}

add_shortcode('tw_heading', 'waves_heading');
