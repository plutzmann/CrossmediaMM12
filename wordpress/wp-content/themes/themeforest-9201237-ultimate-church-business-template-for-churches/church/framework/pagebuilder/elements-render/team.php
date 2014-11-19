<?php
/* ================================================================================== */
/*      Team container
/* ================================================================================== */

function waves_team($atts, $content) {
    $atts = shortcode_atts( array(
        'size'  => 'col-md-3',
        'class' => '',
        'title' => '',
        "team_title"    => "Team Title",
        "position" => "",
        "image"    => "",
        "facebook" => "",
        "google"   => "",
        "twitter"  => "",
        'animation' => 'none',
        'animation_delay' => ''
    ), $atts );
    $output  = waves_item($atts,'waves-team');
        if(!empty($atts['image'])){
            $output .= '<div class="member-image overlay-container">';
                    $output .='<img src="'.$atts['image'].'" alt="'.$atts['team_title'].'" />';
                    $output .='<div class="image-overlay">';
                        if (!empty($atts['facebook']) || !empty($atts['google']) || !empty($atts['twitter'])) {
                            $output .= '<div class="member-social">';
                                $output .= '<div class="tw-social-icon clearfix">';
                                    if (!empty($atts['facebook'])){
                                        $output .= '<a href="' . esc_url($atts['facebook']) . '" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a>';
                                    }
                                    if (!empty($atts['google'])){
                                        $output .= '<a href="' . esc_url($atts['google']) . '" target="_blank" class="gplus"><i class="fa fa-google-plus"></i></a>';
                                    }
                                    if (!empty($atts['twitter'])){
                                        $output .= '<a href="' . esc_url($atts['twitter']) . '" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a>';
                                    }
                                $output .= '</div>';
                            $output .= '</div>';
                        }
                    $output .='</div>';
            $output .='</div>';
        }
        $output .= '<div class="member-title">';
            $output .= '<h2>' . $atts['team_title'] . '</h2>';
            $output .= '<span class="title-sep"></span>';
            if (!empty($atts['position'])){
                $output .= '<div class="member-pos">' . $atts['position'] . '</div>';
            }
        $output .= '</div>';

        if (!empty($content)) {
            $output .= '<div class="team-content">';
                $output .= $content;
            $output .= '</div>';
        }
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_team', 'waves_team');