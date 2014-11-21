<?php
global $waves_elements, $waves_element_options;
$waves_elements["toggle"] = array(
    "name" => "Toggle",
    "size" => "col-md-4",
    "content" => "items",
    "help" => "http://support.themewaves.com/knowledgebase/toggle-element-tutorial/",
    "settings" => array(
        "add_item" => array(
            "title" => "",
            "type" => "button",
            "data" => array("item" => "toggle", "settings" => "items"),
            "default" => "Add Toggle",
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
                        "type" => "text",
                        "default" => "Toggle Title",
                    ),
                    "animation" => array(
                        "title" => "Animation",
                        "type" => "select",
                        "options" => $waves_element_options['animations'],
                        "default" => "none",
                    ),
                    "animation_delay" => array(
                        "title" => "Animation Delay",
                        "type" => "text",
                        "holder" => "Example:300",
                        "desc" => "",
                    ),
                    "expand" => array(
                        "title" => "Expand?",
                        "type" => "checkbox",
                        "default" => "false",
                    ),
                    "content" => array(
                        "type" => "textArea",
                        "tinyMCE" => "true",
                        "default" => "Toggle Content",
                    ),
                )
            ),
            "desc" => "Items",
        ),
    ),
);