<?php

/* ================================================================================== */
/*      Milestone Container
  /* ================================================================================== */

function waves_milestone($atts, $content) {
    $atts = shortcode_atts( array(
        'size'  => 'col-md-3',
        'title' => '',
        'mile_title' => 'Our Customers',
        'thumb_type' => 'fi',
        // Font Icon
        "fi" => "",
        "fi_size" => "30",
        "fi_padding" => "20",
        "fi_color" => "#aaaaaa",
        "fi_bg_color" => "",
        "fi_border_color" => "#aaaaaa",
        "fi_rounded" => "6",
        "fi_rounded_size" => "3",
        "fi_box_shadow" => "false",
        "fi_rotate" => "false",
        "fi_icon" => "fa-glass",
        // -----------------------
        'image' => '',
        'milsetone_type' => '',
        'animation' => 'none',
        'animation_delay' => '',
        'percent' => '50',
        'color' => '',
        'count' => '596'
    ), $atts);
    $atts2=$atts;
    $atts2['animation']='none';
    $output = waves_item($atts2, "waves-milestone");
        $class = $class2 = $animation = $icon = $type = $thumb = '';
        
        if ($atts['thumb_type'] === 'fi') {
            $thumb = do_shortcode('[tw_fonticon size="waves-shortcode" fi_size="' . $atts['fi_size'] . '" fi_padding="' . $atts['fi_padding'] . '" fi_color="' . $atts['fi_color'] . '" fi_bg_color="' . $atts['fi_bg_color'] . '" fi_border_color="' . $atts['fi_border_color'] . '" fi_rounded="' . $atts['fi_rounded'] . '" fi_rounded_size="' . $atts['fi_rounded_size'] . '" fi_box_shadow="' . $atts['fi_box_shadow'] . '" fi_rotate="' . $atts['fi_rotate'] . '" fi_icon="' . $atts['fi_icon'] . '"]');
        } else {
            $thumb = '<img src="' . $atts['image'] . '" />';
        }
        
        if ($atts['animation'] !== 'none') {
            $class .= ' tw-animate-gen';
            $atts['animation_delay'] = empty($atts['animation_delay']) ? '' : str_replace(' ', '', $atts['animation_delay']);
            $animation = ' data-animation="' . $atts['animation'] . '" data-animation-delay="' . $atts['animation_delay'] . '" data-animation-offset="90%" style="opacity:0;"';
        }

        if ($atts['milsetone_type'] == 'style_2') {
            $class2 .= 'float-left';
        } else {
            $class2 .= 'centered';
        }
        $output .= '<div class="tw-milestones-box tw-animate' . $class . '"' . $animation . '>';
            $output .= '<div class="tw-milestones-icon ' . $class2 . '">' . $thumb . '</div>';
            $output .= '<div class="tw-milestones-content ' . $class2 . '">';
                $output .= '<div class="tw-milestones-count clearfix">';
                    foreach (str_split($atts['count']) as $count) {
                        $output .= '<div class="tw-milestones-show">';
                            $output .= '<ul>';
                                if(is_numeric($count)){
                                    for ($i = 0; $i <= intval($count); $i++) {
                                        $output .= "<li>$i</li>";
                                    }
                                }else{
                                    $output .= "<li>$count</li>";
                                }
                            $output .= '</ul>';
                        $output .= '</div>';
                    }
                $output .= '</div>';
                if ($atts['milsetone_type'] == 'style_3') {
                    $output .= '<span class="title-seperator"></span>';
                }
                $output .= '<span>' . $atts['mile_title'] . '</span>';
            $output .= '</div>';
        $output .= '</div>';
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_milestones', 'waves_milestone');