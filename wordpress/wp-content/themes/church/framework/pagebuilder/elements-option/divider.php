<?php

global $waves_elements;
$waves_elements["divider"] = array(
    "name" => "Divider",
    "size" => "col-md-12",
    "help" => "http://support.themewaves.com/knowledgebase/divider-element-tutorial/",
    "settings" => array(
        "type" => array(
            "title" => "Choose Divider Type",
            "type" => "select",
            "options" => array("line" => "Line", "square" => "Square", "space" => "Space", "top" => "Go Top"),
            "hide"    => array("line" => "none", "space" => "position,text,icon,color", "top"=>"text"),
            "default" => "line",
            "desc" => "Line and Square will refer on Icon radius",
        ),
        "position" => array(
            "title" => "Choose Position",
            "type" => "select",
            "options" => array("left" => "Left", "center" => "Center", "right" => "Right"),
            "default" => "center",
            "desc" => "",
        ),
        "text" => array(
            "title" => "With text",
            "type" => "text",
            "default" => "",
            "desc" => 'If you entered Text then Icon will not display and only text will display.',
        ),
        "icon" => array(
            "title" => "Icon code here",
            "type" => "text",
            "default" => "",
            "desc" => '<a href="' . THEME_DIR . '/framework/font-awesome.html" target="_blank" title="369 Icons list">369 icons</a>. Copy the Icon name and paste here. Your Container color will be placed in your background of icon.',
        ),
        "color" => array(
            "title" => "Icon and also Border color",
            "type" => "color",
            "default" => "#dbdbdb",
            "desc" => 'If you are not inserting the Icon then this will be changing border color',
        ),
        "top" => array(
            "title" => "Insert space top of Divider",
            "type" => "text",
            "default" => "40",
            "desc" => "",
        ),
        "bottom" => array(
            "title" => "Insert space bottom of Divider",
            "type" => "text",
            "default" => "40",
            "desc" => "",
        ),
    ),
);
