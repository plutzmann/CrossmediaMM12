<?php
global $waves_elements, $waves_element_options;
$waves_elements["partner"] = array(
    "name" => "Partner Carousel",
    "size" => "col-md-12",
    "content" => "items",
    "help" => "http://support.themewaves.com/knowledgebase/carousel/",
    "settings" => array(
        "auto_play" => array(
            "title" => "Auto Play ?",
            "type" => "checkbox",
            "default" => "false",
        ),
        "add_item" => array(
            "title" => "",
            "type" => "button",
            "data" => array("item" => "partner", "settings" => "items"),
            "default" => "Add Partner",
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
                        "type" => "text",
                        "default" => "",
                        "desc" => "Partner Title",
                    ),
                    "link" => array(
                        "title" => "Partner Link to URL",
                        "type" => "text",
                        "default" => "",
                        "desc" => "Partner Link to URL",
                    ),
                    "thumb" => array(
                        "title" => "Thumbnail Image",
                        "type" => "text",
                    ),
                    "add_thumb" => array(
                        "type" => "button",
                        "save_to" => "thumb",
                        "default" => "Upload",
                    ),
                )
            ),
        ),
    ),
);