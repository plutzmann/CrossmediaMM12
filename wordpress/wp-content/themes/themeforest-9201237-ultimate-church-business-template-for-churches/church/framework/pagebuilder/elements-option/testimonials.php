<?php
global $waves_elements, $waves_element_options;
$waves_elements["testimonials"] = array(
    "name" => "Testimonials",
    "size" => "col-md-4",
    "content" => "items",
    "help" => "http://support.themewaves.com/knowledgebase/testimonial-element-tutorial/",
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
            "title" => "timeout",
            "type" => "text",
            "default" => "2000",
            "desc" => "",
        ),
        "add_item" => array(
            "title" => "",
            "type" => "button",
            "data" => array("item" => "testimonials", "settings" => "items"),
            "default" => "Add Testimonial",
        ),
        "items" => array(
            "title" => "Items",
            "type" => "container",
            "container_type" => "toggle",
            "title_as" => "name",
            "add_button" => "add_item",
            "default" => array(
                array(
                    "name" => array(
                        "title" => "Testimonial Name",
                        "type" => "text",
                    ),
                    "url" => array(
                        "title" => "Link URL(optional)",
                        "type" => "text",
                    ),
                    "content" => array(
                        "type" => "textArea",
                    ),
                )
            ),
        ),
    ),
);