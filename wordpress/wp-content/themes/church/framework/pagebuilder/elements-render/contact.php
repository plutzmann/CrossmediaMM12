<?php
/* ================================================================================== */
/*      Contact Shortcode
/* ================================================================================== */

function waves_contact($atts, $content) {
    $atts = shortcode_atts(array(
        'size'  => 'col-md-12',
        'class' => '',
        'title' => '',
        'animation' => 'none',
        'animation_delay' => '',
        "thumb" => "",
        "sub_title" => "",
        "info" => "",
        "location" => "",
        "map_url" => "",
        "custom_margin" => "",
        "custom_height" => "",
    ), $atts);
    $styles =empty($atts['custom_margin'])?'':'margin-top:'.$atts['custom_margin'].'px;';
    $stylesHeader=empty($atts['custom_height'])?'':'height:'.$atts['custom_height'].'px;max-height:'.$atts['custom_height'].'px;min-height:'.$atts['custom_height'].'px;';
    
    $output  = waves_item($atts,'waves-contact','',$styles);
        $output .= '<div class="waves-contact-header" style="'.$stylesHeader.'">';
            if(!empty($atts['thumb'])){
                $output .= '<img src="'.$atts['thumb'].'" />';
            }
            if(!empty($atts['sub_title'])){
                $output .= '<h3>'.$atts['sub_title'].'</h3>';
            }
            if(!empty($atts['info'])){
                $output .= '<div class="contact-info">'.$atts['info'].'</div>';
            }
            if(!empty($atts['location'])){
                $output .= '<div class="contact-location btn">'.$atts['location'].'</div>';
            }
            if(!empty($atts['map_url'])){
                $output .= '<a href="'.$atts['map_url'].'" target="_blank" class="contact-button btn" >'.__('View Map','waves').'</a>';
            }
        $output .= '</div>';
        $output .= '<div class="waves-contact-footer">';
            $output .= $content;
        $output .= '</div>';
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_contact', 'waves_contact');