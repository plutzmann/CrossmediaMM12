<?php
global $waves_elements, $waves_element_options;
$waves_elements["callout"] = array(
    "name" => "Callout",
    "size" => "col-md-12",
    "min-size" => "col-md-12",
    "help" => "http://support.themewaves.com/knowledgebase/callout-element-tutorial/",
    "settings" => array(
        "text" => array(
            "title" => "Callout Big Title",
            "type" => "textArea",
            "default" => '<b>CRAFT</b> is all about business and gaining great opportunities so dont hesitate',
        ),
        "callout_style" => array(
            "title" => "Callout Layout",
            "type" => "select",
            "options" => array('style1' => 'style 1', 'style2' => 'style 2'),
            "default" => "style1",
            "desc" => "",
        ),
        "btn_text" => array(
            "title" => "",
            "type" => "text",
            "default" => "Buy now",
            "desc" => "Call out Button",
        ),
        "btn_url" => array(
            "title" => "",
            "type" => "text",
            "default" => "#",
            "desc" => "Button Link",
        ),
        "btn_target" => array(
            "title" => "",
            "type" => "select",
            "options" => $waves_element_options['target'],
            "default" => "_blank",
            "desc" => "Blank will open new window, self will open current",
        ),
    ),
);