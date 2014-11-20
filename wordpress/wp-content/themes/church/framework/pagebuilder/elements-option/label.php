<?php
global $waves_elements;
$waves_elements["label"] = array(
    "name" => "Label",
    "only" => "shortcode", //builder
    "content" => "text",
    "settings" => array(
        "text" => array(
            "title" => "Label Text",
            "type" => "text",
            "holder" => "",
            "default" => "",
            "desc" => "Insert label text.",
        ),
        "color" => array(
            "title" => "Label Color",
            "type" => "color",
            "holder" => "",
            "default" => "",
            "desc" => "Choose label color.",
        ),
    ),
);