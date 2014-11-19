<?php
/* ================================================================================== */
/*      Slider Shortcode
/* ================================================================================== */
function waves_slider($atts, $content) {
    $atts = shortcode_atts(array(
        'size'  => 'col-md-12',
        'class' => '',
        'slider_type'     => 'masterslider',
        'masterslider_id' => '',
        'layerslider_id'  => '',
        'revslider_id'    => '',
    ), $atts);
    $output = waves_item($atts,' waves-slider');
        $slider='';
        $id='';
        
        if($atts['slider_type']==='masterslider'&&!empty($atts['masterslider_id'])){
            $slider='[masterslider id="'.$atts['masterslider_id'].'"]';
        }elseif($atts['slider_type']==='layerslider'&&!empty($atts['layerslider_id'])){
            $slider='[layerslider id="'.$atts['layerslider_id'].'"]';
        }elseif($atts['slider_type']==='revslider'&&!empty($atts['revslider_id'])){
            $slider='[rev_slider '.$atts['revslider_id'].']';
        }
        
        if(!empty($slider)){
            $output .= do_shortcode($slider);
        }else{
            $output .= '<pre>'.__('Choose Slider','themewaves').'</pre>';
        }
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_slider', 'waves_slider');