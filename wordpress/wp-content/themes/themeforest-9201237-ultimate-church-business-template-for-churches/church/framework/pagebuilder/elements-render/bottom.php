<?php
/* ================================================================================== */
/*      Core Content Shortcode
/* ================================================================================== */

function waves_bottom($atts, $content) {
    global $tw_isshortcode;
    $tw_isshortcode='true';
    $atts = shortcode_atts(array(
        'size'  => 'col-md-12',
        'class' => '',
        'title' => '',
        'animation'     =>'none',
        'animation_delay'=>'',
    ), $atts);
    $output  = waves_item($atts, 'waves-bottom');
    ob_start();
        if (tw_option("footer_widget")) { ?> 
            <div class="row">
                <?php
                $grid = tw_option('footer_layout') ? tw_option('footer_layout') : '3-3-3-3';
                $i = 1;
                foreach (explode('-', $grid) as $g) {
                    echo '<div class="col-md-' . $g . ' col-' . $i . '">';
                    dynamic_sidebar("footer-sidebar-$i");
                    echo '</div>';
                    $i++;
                }
                ?>
            </div><?php
        }
    $output .= ob_get_clean();
    $output .= '</div>';
    $tw_isshortcode='false';
    return $output;
}
add_shortcode('tw_bottom', 'waves_bottom');