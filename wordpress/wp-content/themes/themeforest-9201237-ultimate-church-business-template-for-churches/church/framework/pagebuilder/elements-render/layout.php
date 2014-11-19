<?php
/* ================================================================================== */
/*      Layout Shortcode
/* ================================================================================== */

function waves_layout($atts, $content) {
    if(!empty($atts['bg_type'])) {
        if($atts['bg_type']=='video') {
            add_action('wp_footer', 'waves_jplayer_script');
        } elseif($atts['bg_type']=='parallax') {
            add_action('wp_footer', 'waves_parallax_script');
        }
    }
    
    if(!empty($atts['main_size'])){
        $atts['size']=$atts['main_size'];
    }
    
    $output = '<div class="' . $atts['size'] . ' ' . $atts['layout_custom_class'] . '">' . do_shortcode($content) . '</div>';
    return $output;
}
add_shortcode('tw_layout', 'waves_layout');