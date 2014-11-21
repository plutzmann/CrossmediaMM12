<?php
global $waves_elements, $waves_element_options;
$waves_elements["accordion"] = array(
    "name" => "Accordion",
    "size" => "col-md-4",
    "content" => "items",
    "help" => "http://support.themewaves.com/knowledgebase/accordion-element-tutorial/",
    "settings" => array(
        "add_item" => array(
            "title" => "",
            "type" => "button",
            "data" => array("item" => "accordion", "settings" => "items"),
            "default" => "Add Accordion",
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
                        "title" => "Accordion Title",
                        "type" => "text",
                        "default" => "Who are we?",
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
                        "default" => "Accordion Content",
                    ),
                )
            ),
        ),
    ),
);