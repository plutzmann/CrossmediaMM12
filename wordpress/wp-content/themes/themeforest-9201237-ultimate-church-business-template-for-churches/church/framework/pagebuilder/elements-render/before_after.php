<?php
/* ================================================================================== */
/*      Before After Shortcode
/* ================================================================================== */

function waves_before_after($atts, $content) {
    wp_enqueue_script('waves-event-move',  THEME_DIR . '/assets/js/jquery.event.move.js', false, false, true);
    wp_enqueue_script('waves-twentytwenty',  THEME_DIR . '/assets/js/jquery.twentytwenty.js', false, false, true);
    wp_enqueue_style('waves-twentytwenty', THEME_DIR . '/assets/css/twentytwenty.css');

    if(empty($atts['before'])){$atts['before']=WAVES_DIR.'images/no-image.png';}
    if(empty($atts['after'] )){$atts['after'] =WAVES_DIR.'images/no-image.png';}
    $output = waves_item($atts,'waves-before-after-container');
        $output .= '<div class="waves-before-after">';
            $output .= '<img src="'.$atts['before'].'" title="'.__('Before','waves').'" />';
            $output .= '<img src="'.$atts['after'] .'" title="'.__('After','waves') .'" />';
        $output .= '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('tw_before_after', 'waves_before_after');