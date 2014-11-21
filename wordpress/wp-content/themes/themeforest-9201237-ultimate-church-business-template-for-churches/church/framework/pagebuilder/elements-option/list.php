<?php
global $waves_elements, $waves_element_options;
$waves_elements["list"] = array(
    "name" => "List",
    "size" => "col-md-4",
    "content" => "items",
    "help" => "http://support.themewaves.com/knowledgebase/list-element-tutorial/",
    "settings" => array(
        "add_item" => array(
            "title" => "",
            "type" => "button",
            "data" => array("item" => "list", "settings" => "items"),
            "default" => "Add List",
            "desc" => "",
        ),
        "items" => array(
            "title" => "Items",
            "type" => "container",
            "container_type" => "toggle",
            "title_as" => "item_icon",
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
                    "item_icon" => array(
                        "title" => "",
                        "type" => "text",
                        "holder" => "fa-heart",
                        "default" => "fa-heart",
                        "desc" => '<a href="' . THEME_DIR . '/framework/font-awesome.html" target="_blank" title="369 Icons list">369 icons</a>. Copy the Icon name and paste here. Your Container color will be placed in your background of icon.',
                    ),
                    "item_text" => array(
                        "title" => "",
                        "type" => "textArea",
                        "holder" => "Insert some text",
                        "default" => "Insert some text",
                        "desc" => "",
                    ),
                )
            ),
            "desc" => "Items",
        ),
    ),
);