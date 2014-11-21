<?php
/* ================================================================================== */
/*      Chart Pie Shortcode
/* ================================================================================== */

// Chart Pie Container
if (!function_exists('shortcode_tw_chart_pie')) {

    function shortcode_tw_chart_pie($atts, $content) {
        wp_enqueue_script('waves-chart', THEME_DIR . '/assets/js/Chart.min.js', false, false, true);
        $atts = shortcode_atts(array(
            'size'  => 'col-md-3',
            'class' => '',
            'title' => '',
            'type'  => 'PolarArea',
            'begin_at_zero' => 'false',
            'label_list' => 'false',
            'animation_delay'=>'',
        ), $atts);
        $atts['animation_delay'] = empty($atts['animation_delay']) ? '0': str_replace(' ','',$atts['animation_delay']);
        $data = ' data-labellist="' . $atts['label_list'] . '" data-zero="' . $atts['begin_at_zero'] . '" data-type="' . $atts['type'] . '" data-animation-delay="'.$atts['animation_delay'].'" data-animation-offset="90%"';
        $output  = waves_item($atts);
            $output .= '<div class="tw-chart-pie tw-animate tw-redraw not-drawed"'.$data.'>';
                $output .= '<ul style="display:none;" class="data">';
                    $output .= do_shortcode($content);
                $output .= '</ul>';
                $output .= '<canvas></canvas>';
            $output .= '</div>';
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_chart_pie', 'shortcode_tw_chart_pie');
// Chart Pie Item
if (!function_exists('shortcode_tw_chart_pie_item')) {

    function shortcode_tw_chart_pie_item($atts, $content) {
        $atts = shortcode_atts(array(
            'value' => '',
            'color' => '',
            'fill_text' => '',
        ), $atts);
        $output = '<li data-value="' . $atts['value'] . '" data-color="' . $atts['color'] . '" data-fill-text="' . $atts['fill_text'] . '"></li>';
        return $output;
    }

}
add_shortcode('tw_chart_pie_item', 'shortcode_tw_chart_pie_item');