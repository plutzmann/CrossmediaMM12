<?php
/* ================================================================================== */
/*      Image Slider Shortcode
/* ================================================================================== */
//  Image Slider Container
if (!function_exists('shortcode_tw_image_slider')) {
    function shortcode_tw_image_slider($atts, $content) {
        $atts = shortcode_atts( array(
            'size'  => 'col-md-3',
            'class' => '',
            'title' => '',
            'gallery_list' => '',
            'animation' => 'none',
            'animation_delay' => 'bottom-in-view'
        ), $atts );
        $output  = waves_item($atts,'');
            $output .= '<div class="image-slider-element image-slide-container list_carousel clearfix">';
            $output .= '<div class="waves-carousel">';
                $images = empty($atts['gallery_list']) ? false : explode(",", $atts['gallery_list']);
                if($images){
                    foreach ($images as $id) {
                        if(!empty($id)){
                            $output .= '<div class="tw-owl-item">';
                                $output .= '<img src="' . wp_get_attachment_url($id) . '" alt="' . get_the_title() . '" style="width:100%;">';
                            $output .= '</div>';
                        }
                    }    
                }
            $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }
}
add_shortcode('tw_image_slider', 'shortcode_tw_image_slider');