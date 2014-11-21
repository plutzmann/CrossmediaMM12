<?php
global $waves_elements, $waves_element_options;
$waves_elements["message_box"] = array(
    "name" => "Message Box",
    "size" => "col-md-6",
    "content" => "items",
    "help" => "http://support.themewaves.com/knowledgebase/message-box-element-tutorial/",
    "settings" => array(
        "add_item" => array(
            "title" => "",
            "type" => "button",
            "data" => array("item" => "message_box", "settings" => "items"),
            "default" => "Add Message Box",
            "desc" => "",
        ),
        "items" => array(
            "title" => "Items",
            "type" => "container",
            "container_type" => "toggle",
            "title_as" => "type",
            "add_button" => "add_item",
            "default" => array(
                array(
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
                    "type" => array(
                        "title" => "",
                        "type" => "select",
                        "options" => array("success" => "Success", "info" => "Info", "warning" => "Warning", "danger" => "Danger"),
                        "default" => "success",
                        "desc" => "",
                    ),
                    "message_content" => array(
                        "title" => "",
                        "type" => "textArea",
                        "holder" => "Insert here Box Content",
                        "default" => "Insert here Box Content",
                        "desc" => "",
                    ),
                )
            ),
            "desc" => "Items",
        ),
    ),
);