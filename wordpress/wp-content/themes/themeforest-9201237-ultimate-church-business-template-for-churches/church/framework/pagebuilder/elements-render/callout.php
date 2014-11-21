<?php
/* ================================================================================== */
/*      Callout Shortcode
/* ================================================================================== */

function waves_callout($atts, $content) {
    $atts = shortcode_atts( array(
        'size'  => 'col-md-12',
        'title' => '',
        'animation' => 'none',
        'animation_delay' => '',
        'text' => '<b>CRAFT</b> is all about business and gaining great opportunities so dont hesitate',
        'callout_style' => 'style1',
        'btn_text' => '',
        'btn_url' => '#',
        'btn_target' => '_blank',
    ), $atts );
    
    if(!empty($atts['btn_text'])){
        // With Button
        $url = !empty($atts['btn_url']) ? $atts['btn_url'] : '#';
        $target = isset($atts['btn_target']) ? $atts['btn_target'] : '_blank';
        
        if($atts['callout_style']==='style2'){
            $btn = '<a href="' . esc_url($url) . '" target="' . $target . '" class="btn btn-callout">' . $atts['btn_text'] . '</a>';
            $output = waves_item($atts,'waves-callout with-button style2');
        } else {
            $btn = '<a href="' . esc_url($url) . '" target="' . $target . '" class="btn btn-callout">' . $atts['btn_text'] . '</a>';
            $output = waves_item($atts,'waves-callout with-button');
        }
        $output .= '<div class="callout-container">';
        $output .= '<div class="callout-text">';
        $output .= '<p>' . $atts['text'] . '</p>';
        $output .= $btn;
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        
    } else {
        // WithOut Button
        $output = waves_item($atts,'waves-callout');
        if($atts['callout_style']==='style2'){            
            $output = waves_item($atts,'waves-callout style2');
        } else {
            $output = waves_item($atts,'waves-callout');
        }
        $output .= '<div class="callout-container">';
        $output .= '<div class="callout-text">';
        $output .= '<p>' . $atts['text'] . '</p>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
    }
    

    return $output;
}
    
add_shortcode('tw_callout', 'waves_callout');