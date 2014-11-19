<?php
global $waves_elements;
$waves_elements["dropcap"] = array(
    "name" => "Dropcap",
    "only" => "shortcode", //builder
    "content" => "text",
    "settings" => array(
        "text" => array(
            "title" => "Dropcap Text",
            "type" => "text",
            "holder" => "",
            "default" => "",
            "desc" => "Insert dropcap text.",
        ),
        "color" => array(
            "title" => "Dropcap Color",
            "type" => "color",
            "holder" => "#6DAEB7",
            "default" => "#6DAEB7",
            "desc" => "Choose dropcap background color.",
        ),
        "style" => array(
            "title" => "Dropcap Style",
            "type" => "select",
            "options" => array("simple" => "Simple", "square" => "Square Flat", "circle" => "Circle Flat", "square_border" => "Square Border", "circle_border" => "Circle Border"),
            "holder" => "",
            "default" => "square",
            "desc" => "Choose dropcap text color.",
        ),
    ),
);