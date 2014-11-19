<?php
/* ================================================================================== */
/*      Video Shortcode
/* ================================================================================== */

function waves_video($atts, $content) {
    global $tw_isshortcode;
    $tw_isshortcode='true';
    $atts = shortcode_atts(array(
        'size'  => 'col-md-3',
        'class' => '',
        'title' => '',
        'type'  => 'background',
        'video_m4v'    => '',
        'video_thumb' => '',
        'video_text_direction' => 'vertical',
        'video_text_first' => '',
        'video_text_last' => '',
        'animation' => 'none',
        'animation_delay' => ''
    ), $atts);
    $output  = waves_item($atts);
        ob_start();
            if($atts['type'] == 'background') {
                echo '<div class="bg-video-container bg-video-'.$atts['video_text_direction'].'">';
                    echo '<h2 class="bg-video-first-text">'.$atts['video_text_first'].'</h2>';
                    echo '<i class="bg-video-play tw-font-icon fa fa-play"></i>';
                    echo '<h2 class="bg-video-last-text">'.$atts['video_text_last'].'</h2>';
                echo '</div>';
            } elseif ($atts['type'] == 'embed') {
                echo apply_filters("the_content", $content);
            } elseif (!empty($atts['video_m4v'])) {
                global $post;
                add_action('wp_footer', 'waves_jplayer_script');
                waves_jplayer_video($post->ID, $atts['video_m4v'], $atts['video_thumb']);
            }
        $output .= ob_get_clean();
    $output .= '</div>';
    $tw_isshortcode='false';
    return $output;
}
add_shortcode('tw_video', 'waves_video');