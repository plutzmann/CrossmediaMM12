<?php

/* ================================================================================== */
/*      Tab Shortcode
  /* ================================================================================== */

// Tab container
function waves_tab($atts, $content) {
    $position = (!empty($atts['layout']) || $atts['layout'] != 'top') ? (' tabs-' . $atts['layout']) : '';
    $count = !empty($atts['tab_count']) ? ($atts['tab_count']) : '';
    $output =  waves_item($atts, 'waves-tab tabbable tab-init ' . $count . $position);
    $output .= do_shortcode($content);
    $output .= '<ul class="nav nav-tabs clearfix"></ul>';
    $output .= '<div class="tab-content"></div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('tw_tab', 'waves_tab');

// Tab Item
function waves_tab_item($atts, $content) {
    global $tw_isshortcode;
    $tw_isshortcode='true';
    $atts = shortcode_atts(array(
        'title_icon' => '',
        'title' => '',
            ), $atts);
    if (!empty($atts['title_icon'])) {
        $output = '<li class="with-icon">';
    } else {
        $output = '<li>';
    }
    $output .= '<a href="">';
    if (!empty($atts['title_icon'])) {
        $output .= '<i class="fa ' . $atts['title_icon'] . '"></i>';
    }
    if (!empty($atts['title'])) {
        $output .= '<span>' . $atts['title'] . '</span>';
    }
    $output .= '</a>';
    $output .= '</li>';
    $output .= '<div class="tab-pane">';
    $output .= apply_filters("the_content", $content);
    $output .= '</div>';
    $tw_isshortcode='false';
    return $output;
}

add_shortcode('tw_tab_item', 'waves_tab_item');
