<?php
/* ================================================================================== */
/*      Coming Soon Shortcode
/* ================================================================================== */

// Coming Soon
if (!function_exists('shortcode_tw_comingsoon')) {
    function shortcode_tw_comingsoon($atts, $content) {
        wp_enqueue_script('waves-coming-soon', THEME_DIR . '/assets/js/jquery.comingsoon.js', false, false, true);
        $atts = shortcode_atts(array(
            'size'  => 'col-md-12',
            'class' => '',
            'title' => '',
            'coming_title'  => '',
            'coming_years'  => '2018',
            'coming_months' => '12',
            'coming_days'   => '28',
            'coming_hours'  => '12',
            'coming_link'   => '',
            'animation'     =>'none',
            'animation_delay'=>'',
        ), $atts);
        $output  = waves_item($atts,'tw-cs-container');
        $output .= '<h1 class="tw-coming-soon-title">'.$atts['coming_title'].'</h1>';
        $output .= '<div class="tw-coming-soon clearfix" data-years="'.$atts['coming_years'].'" data-months="'.$atts['coming_months'].'" data-days="'.$atts['coming_days'].'" data-hours="'.$atts['coming_hours'].'" data-minutes="00" data-seconds="00">';
            $output .= '<div class="days">';
                $output .= '<div class="count"></div>';
                $output .= '<div class="text">'.__('DAYS','themewaves').'</div>';
            $output .= '</div>';
            $output .= '<div class="sep">:</div>';
            $output .= '<div class="hours">';
                $output .= '<div class="count"></div>';
                $output .= '<div class="text">'.__('HOURS','themewaves').'</div>';
            $output .= '</div>';
            $output .= '<div class="sep">:</div>';
            $output .= '<div class="minutes">';
                $output .= '<div class="count"></div>';
                $output .= '<div class="text">'.__('MINUTES','themewaves').'</div>';
            $output .= '</div>';
            $output .= '<div class="sep">:</div>';
            $output .= '<div class="seconds">';
                $output .= '<div class="count"></div>';
                $output .= '<div class="text">'.__('SECONDS','themewaves').'</div>';
            $output .= '</div>';
        $output .= '</div>';
        $output .= '<div class="tw-coming-soon-content">'.do_shortcode($content).'</div>';
        if($atts['coming_link']!=='') {
            $feed = $atts['coming_link'];
            $text = __('Your email here', 'themewaves');
            $submit = __('SUBSCRIBE NOW','themewaves');
            $output .= '<div class="subscribe-container">';
                $output .= '<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open(\'http://feedburner.google.com/fb/a/mailverify?uri='.$feed.'\', \'popupwindow\', \'scrollbars=yes,width=550,height=520\');return true">';
                    $output .= '<p>';
                        $output .= '<input type="text" value="" placeholder="'.$text.'"  name="email">';
                        $output .= '<input class="btn" type="submit" name="imageField" value="'.$submit.'" alt="Submit" />';
                        $output .= '<input type="hidden" value="'.$feed.'" name="uri"/>';
                        $output .= '<input type="hidden" name="loc" value="en_US" />';
                    $output .= '</p>';
                $output .= '</form>';
            $output .= '</div>';
        }
        $output .= '</div>';
        return $output;
    }
}
add_shortcode('tw_comingsoon', 'shortcode_tw_comingsoon');