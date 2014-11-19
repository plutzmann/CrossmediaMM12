<?php
global $waves_elements;
$waves_elements["map"] = array(
    "name" => "Map",
    "size" => "col-md-12",
    "content" => "map_embed",
    "settings" => array(
        "type" => array(
            "title" => "Choose Post type",
            "type" => "select",
            "options" => array("boxed" => "Boxed", "full" => "Full"),
            "default" => "boxed",
            "desc" => "Choose Map type.",
        ),
        "map_embed" => array(
            "title" => "Embeded Code",
            "type" => "textArea",
            "holder" => "",
            "default" => "",
            "desc" => "",
        ),
    ),
);