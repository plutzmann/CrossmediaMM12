<?php
global $waves_elements, $waves_element_options;
$waves_elements["text_carousel"] = array(
    "name" => "Text carousel",
    "size" => "col-md-12",
    "content" => "items",
    "settings" => array(
        "auto_play" => array(
            "title" => "Auto Play ?",
            "type" => "checkbox",
            "default" => "false",
        ),
        "duration" => array(
            "title" => "Duration",
            "type" => "text",
            "default" => "1000",
            "desc" => "",
        ),
        "timeout" => array(
            "title" => "Timeout",
            "type" => "text",
            "default" => "2000",
            "desc" => "",
        ),
        "height" => array(
            "title" => "Height",
            "type" => "text",
            "default" => "200",
            "desc" => "",
        ),
        "add_item" => array(
            "title" => "",
            "type" => "button",
            "data" => array("item" => "text_carousel", "settings" => "items"),
            "default" => "Add Text carousel",
        ),
        "items" => array(
            "title" => "Items",
            "type" => "container",
            "container_type" => "toggle",
            "title_as" => "title",
            "add_button" => "add_item",
            "default" => array(
                array(
                    "title" => array(
                        "title" => "Text",
                        "type" => "text",
                        "default" => "",
                        "desc" => "",
                    ),
                    "background_image" => array(
                        "title" => "Background image",
                        "type" => "text",
                        "holder" => "",
                        "default" => "",
                        "desc" => "",
                    ),
                    "add_background_image" => array(
                        "title" => "",
                        "type" => "button",
                        "save_to" => "background_image",
                        "default" => "Upload",
                        "desc" => "",
                    ),
                    "link_url" => array(
                        "title" => "",
                        "type" => "text",
                        "default" => "#",
                        "desc" => "Text Carousel Link",
                    ),
                    "link_target" => array(
                        "title" => "",
                        "type" => "select",
                        "options" => $waves_element_options['target'],
                        "default" => "_blank",
                        "desc" => "Blank will open new window, self will open current",
                    ),
                )
            ),
        ),
    ),
);