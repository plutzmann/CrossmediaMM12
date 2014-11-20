<?php

/* ================================================================================== */
/*      Service Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_service')) {
    function shortcode_tw_service($atts, $content) {
        $atts = shortcode_atts(array(
            'size' => 'col-md-3',
            'class' => '',
            'title' => '',
            "service_style" => "top",
            "service_hover" => "none",
            "title_line" => "true",
            "rotate"=>"false",
            "thumb_type" => "fi",
            "service_thumb_width" => "20",
            "service_thumb" => "",
            "add_thumb" => "Upload",
            // Font icon
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
            // Circle Chart
            "cc" => "",
            "cc_type" => "text",
            'cc_line_cap' => 'butt',
            "cc_line_width" => "8",
            "cc_text" => "80%",
            "cc_percent" => "80",
            "cc_size" => "100",
            "cc_font_size" => "30",
            "cc_font_color" => "#6DAEB7",
            "cc_color" => "#6DAEB7",
            "cc_track_color" => "#f9f9f9",
            "cc_icon" => "fa-star",
            // -----------------------
            "service_title" => "Your Service Title",
            "more_text" => "Read More",
            "more_url" => "",
            "more_target" => "_blank",
            'animation' => 'none',
            'animation_delay' => ''
        ), $atts);

        $class=$thumb=$styleDesc=$marginDesc='';
        $thumbType = isset($atts['thumb_type']) ? $atts['thumb_type'] : 'fi';
        $marginBox = $marginIcon = '';
        $iconHeight = ($thumbType === 'fi' ? ($atts['fi_size'] + $atts['fi_padding'] + $atts['fi_padding'] + ($atts['fi_rounded'] * 2)) : ($thumbType === 'image' ? intval($atts['service_thumb_width']) : intval($atts['cc_size'])));
        $iconHeightHalf = $iconHeight/2;
        $class = $atts['service_style'].'-service';
        if ($atts['service_style'] === 'left'){
            $styleDesc  = 'desc_unstyle';
            $marginDesc = 'margin-left:' . ($thumbType === 'fi' ? ($iconHeightHalf + 25) : ($thumbType === 'image' ? ($iconHeightHalf + 30) : ($iconHeightHalf + 15))) . 'px;';
            $marginBox  = 'margin-left:' . $iconHeightHalf . 'px;';
            $marginIcon = 'margin-left:-' . $iconHeightHalf . 'px;';
            if($atts['service_hover']==='style_2')
                $marginIcon = 'margin-left:-' . $iconHeightHalf . 'px;margin-top:-' . $iconHeightHalf . 'px;';
        }
        elseif ($atts['service_style'] === 'right') {
            $styleDesc  = 'desc_unstyle';
            $marginDesc = 'margin-right:' . ($thumbType === 'fi' ? ($iconHeightHalf + 25) : ($thumbType === 'image' ? ($iconHeightHalf + 30) : ($iconHeightHalf + 15))) . 'px;';
        } else {
            $marginBox  = 'margin-top:' . $iconHeightHalf . 'px;';
            $marginIcon = 'margin-top:-' . $iconHeightHalf . 'px;';
        }
        if ($thumbType === 'image') {
            $thumb = isset($atts['service_thumb']) ? '<img title="' . $atts['service_title'] . '" width="' . $atts['service_thumb_width'] . '" src="' . $atts['service_thumb'] . '" />' : '';
        } elseif ($thumbType === 'fi') {
            $thumb = do_shortcode('[tw_fonticon size="waves-shortcode" fi_size="' . $atts['fi_size'] . '" fi_padding="' . $atts['fi_padding'] . '" fi_color="' . $atts['fi_color'] . '" fi_bg_color="' . $atts['fi_bg_color'] . '" fi_border_color="' . $atts['fi_border_color'] . '" fi_rounded="' . $atts['fi_rounded'] . '" fi_rounded_size="' . $atts['fi_rounded_size'] .  '" fi_box_shadow="' . $atts['fi_box_shadow'] . '" fi_rotate="' . $atts['fi_rotate'] . '" fi_icon="' . $atts['fi_icon'] . '"]');
        } elseif ($thumbType === 'cc') {
            $thumb = do_shortcode('[tw_chart_circle size="waves-shortcode" cc_type="' . $atts['cc_type'] . '" cc_line_cap="' . $atts['cc_line_cap'] . '" cc_line_width="' . $atts['cc_line_width'] . '" cc_text="' . $atts['cc_text'] . '" cc_percent="' . $atts['cc_percent'] . '" cc_size="' . $atts['cc_size'] . '" cc_font_size="' . $atts['cc_font_size'] . '" cc_font_color="' . $atts['cc_font_color'] . '" cc_color="' . $atts['cc_color'] . '" cc_track_color="' . $atts['cc_track_color'] . '" cc_icon="' . $atts['cc_icon'] . '"]');
        }
        if (isMobile() && !tw_option('moblile_animation')) {
            $atts['item_animation'] = 'none';
        }
        if(!empty($atts['service_hover'])){
            $class.=' '.$atts['service_hover'];
        }
        if($atts['title_line']!=='true'){
            $class.=' no-titleline';
        }

        $output = waves_item($atts, '', '', '');
            $output .= '<div class="tw-service-box ' . $class . '" style="'.$marginBox.'">';
                $output .= '<div class="tw-service-icon" style="' . $marginIcon . '">' . $thumb . '</div>';
                $output .= '<div class="tw-service-content ' . $styleDesc . '" style="' . $marginDesc . '">';
                    $output .= '<h3>' . $atts['service_title'] . '</h3>';
                    $output .= '<div class="service-title-sep"></div>';
                    if ($content != ''){
                        $output .= '<p>' . do_shortcode($content) . '</p>';
                    }
                    if (!empty($atts['more_url'])){
                        $output .= '<div class="service-title-sep last"></div>';
                        $output .= '<a class="more" href="' . $atts['more_url'] . '" target="' . $atts['more_target'] . '">' . $atts['more_text'] . '</a>';
                    }
                $output .= '</div>';
            $output .= "</div>";
        $output .= "</div>";
        return $output;
    }
}
add_shortcode('tw_service', 'shortcode_tw_service');
