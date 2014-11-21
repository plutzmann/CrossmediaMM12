<?php
global $waves_elements, $waves_element_options;
$waves_elements["slider"] = array(
    "name" => "Slider",
    "size" => "col-md-12",
    "content" => "items",
    "help" => "http://support.themewaves.com/knowledgebase/accordion-element-tutorial/",
    "settings" => array(
        "slider_type" => array(
            "title"   => "Choose the Slider Type",
            "type"    => "select",
            "options" => array(
                'masterslider'=>'Master Slider',
                'layerslider' =>'Layer Slider',
                'revslider'   =>'Rev Slider',
            ),
            "hide"    => array("masterslider" => "layerslider_id,revslider_id","layerslider" => "revslider_id,masterslider_id", "revslider" => "layerslider_id,masterslider_id"),
            "default" => "masterslider",
            "desc"    => "",
        ),
        "masterslider_id" => array(
            "title"   => "Choose the Slider",
            "type"    => "select",
            "options" => $waves_element_options['masterslider'],
            "default" => "0",
            "desc"    => "Your created Sliders will be displayed here. Including LayersSlider and all of our used sliders.",
        ),
        "layerslider_id" => array(
            "title"   => "Choose the Slider",
            "type"    => "select",
            "options" => $waves_element_options['layerslider'],
            "default" => "0",
            "desc"    => "Your created Sliders will be displayed here. Including LayersSlider and all of our used sliders.",
        ),
        "revslider_id" => array(
            "title"   => "Choose the Slider",
            "type"    => "select",
            "options" => $waves_element_options['revslider'],
            "default" => "0",
            "desc"    => "Your created Sliders will be displayed here. Including LayersSlider and all of our used sliders.",
        ),
    ),
);