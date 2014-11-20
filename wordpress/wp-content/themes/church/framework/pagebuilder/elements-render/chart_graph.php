<?php
/* ================================================================================== */
/*      Chart Graph Shortcode
/* ================================================================================== */

// Chart Graph Container
if (!function_exists('shortcode_tw_chart_graph')) {
    function shortcode_tw_chart_graph($atts, $content) {
        wp_enqueue_script('waves-chart', THEME_DIR . '/assets/js/Chart.min.js', false, false, true);
        $atts = shortcode_atts(array(
            'size'  => 'col-md-3',
            'class' => '',
            'title' => '',
            'labels' => '',
            'item_height' => '',
            'type' => 'Line',
            'begin_at_zero' => 'false',
            'animation_delay'=>'',
        ), $atts);
        $atts['item_height'] = str_replace(' ','',$atts['item_height']);
        $atts['animation_delay'] = empty($atts['animation_delay']) ? '0': str_replace(' ','',$atts['animation_delay']);
        $data  = ' data-zero="' . $atts['begin_at_zero'] . '" data-labels="' . $atts['labels'] . '" data-type="' . $atts['type'] . '" data-item-height="'.$atts['item_height'].'" data-animation-delay="'.$atts['animation_delay'].'" data-animation-offset="90%"' ;
        $output  = waves_item($atts);
            $output .= '<div class="tw-chart-graph tw-animate tw-redraw not-drawed"'.$data.'>';
                $output .= '<ul style="display:none;" class="data">';
                    $output .= do_shortcode($content);
                $output .= '</ul>';
                $output .= '<canvas></canvas>';
            $output .= '</div>';
        $output .= '</div>';
        return $output;
    }
}
add_shortcode('tw_chart_graph', 'shortcode_tw_chart_graph');
// Chart Graph Item
if (!function_exists('shortcode_tw_chart_graph_item')) {

    function shortcode_tw_chart_graph_item($atts, $content) {
        $atts = shortcode_atts(array(
            'datas' => '',
            'fill_color' => '',
            'fill_text' => '',
                ), $atts);
        $output = '<li data-datas="' . $atts['datas'] . '" data-fill-color="' . $atts['fill_color'] . '" data-fill-text="' . $atts['fill_text'] . '"></li>';
        return $output;
    }

}
add_shortcode('tw_chart_graph_item', 'shortcode_tw_chart_graph_item');