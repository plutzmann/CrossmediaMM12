<?php
global $waves_elements, $waves_element_options;
$waves_elements["progress"] = array(
    "name" => "Progress Bar",
    "size" => "col-md-4",
    "content" => "items",
    "help" => "http://support.themewaves.com/knowledgebase/progress-bar-element-tutorial/",
    "settings" => array(
        "add_item" => array(
            "title" => "",
            "type" => "button",
            "data" => array("item" => "progress", "settings" => "items"),
            "default" => "Add Progress Bar",
            "desc" => "",
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
                        "title" => "",
                        "type" => "text",
                        "holder" => "Progress title",
                        "default" => "Progress title",
                        "desc" => "",
                    ),
                    "animation" => array(
                        "title" => "Animation",
                        "type" => "select",
                        "options" => $waves_element_options['animations'],
                        "default" => "none",
                        "desc" => "Animation.",
                    ),
                    "animation_delay" => array(
                        "title" => "Animation Delay",
                        "type" => "text",
                        "holder" => "Example:300",
                        "desc" => "",
                    ),
                    "percent" => array(
                        "title" => "Progress Percent",
                        "type" => "text",
                        "default" => "50",
                        "desc" => "integer value in 0-100.",
                    ),
                    "type" => array(
                        "title" => "Choose Type",
                        "type" => "select",
                        "options" => array("default" => "Default", "striped" => "Striped", "animated" => "Animated"),
                        "desc" => "Choose Type",
                    ),
                    "color" => array(
                        "title" => "Color of Progress",
                        "type" => "color",
                        "holder" => "Color of Progress",
                        "default" => "#6DAEB7",
                        "desc" => "",
                    ),
                )
            ),
            "desc" => "Items",
        ),
    ),
);