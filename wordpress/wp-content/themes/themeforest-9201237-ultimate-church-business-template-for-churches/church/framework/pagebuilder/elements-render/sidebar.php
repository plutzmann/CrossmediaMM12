<?php
/* ================================================================================== */
/*      Sidebar Shortcode
/* ================================================================================== */
if (!function_exists('shortcode_tw_sidebar')) {

    function shortcode_tw_sidebar($atts, $content) {
        $output  = waves_item($atts);
            ob_start();
                echo '<section id="sidebar">';
                    if (!dynamic_sidebar($atts['name'])) {
                        print 'There is no widget. You should add your widgets into <strong>';
                        print $atts['name'];
                        print '</strong> sidebar area on <strong>Appearance => Widgets</strong> of your dashboard. <br/><br/>';
                    }
                echo '</section>';
            $output .= ob_get_clean();
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_sidebar', 'shortcode_tw_sidebar');