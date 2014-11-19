<?php
global $waves_elements;
$waves_elements["tab"] = array(
    "name" => "Tab",
    "size" => "col-md-6",
    "content" => "items",
    "help" => "http://support.themewaves.com/knowledgebase/tab-element-tutorial/",
    "settings" => array(
        "add_item" => array(
            "title" => "",
            "type" => "button",
            "data" => array("item" => "tab", "settings" => "items"),
            "default" => "Add Tab",
            "desc" => "",
        ),
        "layout" => array(
            "title" => "Choose Tab layout & Style",
            "type" => "select",
            "options" => array("top" => "Top", "left" => "Left", "top2" => "Top 2", "left2" => "Left 2"),
            "default" => "top",
            "desc" => "Tab Titles can be displayed top, right, left position.",
        ),
        "tab_count" => array(
            "title" => "Tab Title FullWidth",
            "type" => "select",
            "options" => array("tab-none" => "none", "tab-two" => "2 tabs", "tab-three" => "3 tabs", "tab-four" => "4 tabs", "tab-five" => "5 tabs"),
            "default" => "tab-none",
            "desc" => "If you chosen",
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
                        "default" => "Tab Title",
                    ),
                    "title_icon" => array(
                        "title" => "Icon code here",
                        "type" => "text",
                        "default" => "fa-star",
                        "desc" => '<a href="' . THEME_DIR . '/framework/font-awesome.html" target="_blank" title="369 Icons list">369 icons</a>. Copy the Icon name and paste here. Your Container color will be placed in your background of icon.',
                    ),
                    "content" => array(
                        "title" => "",
                        "type" => "textArea",
                        "tinyMCE" => "true",
                        "default" => "Tab Content",
                    ),
                )
            ),
            "desc" => "Items",
        ),
    ),
);