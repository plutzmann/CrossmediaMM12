<?php
global $waves_elements, $waves_element_options;
$waves_elements["button"] = array(
    "name" => "Button",
    "size" => "col-md-4",
    "only" => "shortcode", //builder
    "content" => "text",
    "settings" => array(
        "text" => array(
            "title" => "Button Text",
            "type" => "text",
            "default" => "Button",
            "desc" => "Insert your button text",
        ),
        "size" => array(
            "title" => "Button Size",
            "type" => "select",
            "options" => array("small" => "Small", "medium" => "Medium", "large" => "Large"),
            "default" => "medium",
            "desc" => "Choose button size",
        ),
        "rounded" => array(
            "title" => "Rounded",
            "type" => "checkbox",
            "default" => "false",
        ),
        "btn_style" => array(
            "title" => "Button Style",
            "type" => "select",
            "options" => array("flat shadow" => "Flat Shadow", "flat" => "Flat", "border" => "Border"),
            "default" => "flat shadow",
            "desc" => "Choose button size",
        ),
        "color" => array(
            "title" => "Button Color",
            "type" => "color",
            "desc" => "Choose color",
        ),
        "link" => array(
            "title" => "Button Link",
            "type" => "text",
            "desc" => "Insert button link URL",
        ),
        "target" => array(
            "title" => "Button Target",
            "type" => "select",
            "options" => $waves_element_options['target'],
            "default" => "_blank",
            "desc" => "Blank will open new window, self will current window",
        ),
    ),
);