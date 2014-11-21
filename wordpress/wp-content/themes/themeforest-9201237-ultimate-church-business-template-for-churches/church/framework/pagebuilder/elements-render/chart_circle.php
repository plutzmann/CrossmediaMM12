<?php
/* ================================================================================== */
/*      Chart Circle Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_chart_circle')) {

    function shortcode_tw_chart_circle($atts, $content) {
        wp_enqueue_script('waves-easy-pie-chart', THEME_DIR . '/assets/js/jquery.easy-pie-chart.js', false, false, true);
        $atts = shortcode_atts(array(
            'size'  => 'col-md-3',
            'class' => '',
            'title' => '',
            'chart_circle_pos' => 'style_1',
            'cc_type' => 'cc',
            'cc_line_cap' => 'butt',
            'cc_line_width' => '10',
            'cc_text' => '40%',
            'cc_percent' => '40',
            'cc_size' => '100',
            'cc_font_size' => '24',
            'cc_font_color' => '#000',
            'cc_color' => '#ecf0f1',
            'cc_track_color' => '#6DAEB7',
            'cc_icon' => 'fa-glass',
            'animation_delay'=>'',
        ), $atts);
        $atts['animation_delay'] = empty($atts['animation_delay']) ? '': str_replace(' ','',$atts['animation_delay']);
        
        $cClass='';
        $style = 'display:block; text-align:center; margin: 0 auto;';
        $style.='width:' . $atts['cc_size'] . 'px;';
        $style.='line-height:' . $atts['cc_size'] . 'px;';
        $cStyle = '';
        $cStyle.='color:' . $atts['cc_font_color'] . ';';
        $cStyle.='font-size:' . $atts['cc_font_size'] . 'px;';
        $data = '';
        $data .= ' data-percent="0"';
        $data .= ' data-percent-update="' . $atts['cc_percent'] . '"';
        $data .= ' data-line-cap="' . $atts['cc_line_cap'] . '"';
        $data .= ' data-line-width="' . $atts['cc_line_width'] . '"';
        $data .= ' data-size="' . $atts['cc_size'] . '"';
        $data .= ' data-color="' . $atts['cc_color'] . '"';
        $data .= ' data-track-color="' . $atts['cc_track_color'] . '"';
        $data .= ' data-animation-delay="'.$atts['animation_delay'].'"';
        $output = waves_item($atts);
            if ($atts['chart_circle_pos'] === 'style_2') {
                $cClass = ' style_2';
            } 
            $output .= '<div class="tw-circle-chart tw-animate'.$cClass.'"'.$data.'>';
                $output .='<span style="' . $cStyle . '">';
                    if ($atts['cc_type'] === 'fi') {
                        $output .='<i class="fa ' . $atts['cc_icon'] . '" style="' . $style . '"></i>';
                    } else {
                        $output .=$atts['cc_text'];
                    }
                $output .='</span>';
            $output .='</div>';
        $output .='</div>';
        return $output;
    }

}
add_shortcode('tw_chart_circle', 'shortcode_tw_chart_circle');