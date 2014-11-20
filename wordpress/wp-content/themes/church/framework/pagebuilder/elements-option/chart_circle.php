<?php

global $waves_elements;
$waves_elements["chart_circle"] = array(
    "name" => "Chart Circle",
    "size" => "col-md-4",
    "help" => "http://support.themewaves.com/knowledgebase/chart-circle-element-tutorial/",
    "settings" => array(
        "chart_circle_pos" => array(
            "title" => "Chart Circle Position",
            "type" => "select",
            "options" => array('style_1' => 'Centered', 'style_2' => 'Floated Left'),
            "default" => "style_1",
            "desc" => "",
        ),
        "cc" => array(
            "title" => "Edit Chart",
            "type" => "cc",
            "holder" => "",
            "default" => "",
            "desc" => "",
        ),
        "cc_type" => array(
            "title" => "Type",
            "type" => "select",
            "options" => array('text' => 'Text', 'fi' => 'Font Icon'),
            "default" => "text",
            "desc" => "",
        ),
        "cc_line_cap" => array(
            "title" => "Line Style",
            "type" => "select",
            "options" => array('butt' => 'Butt', 'round' => 'Round'),
            "default" => "round",
            "desc" => "",
        ),
        "cc_line_width" => array(
            "title" => "Line Width",
            "type" => "hidden",
            "holder" => "",
            "default" => "14",
            "desc" => "",
        ),
        "cc_text" => array(
            "title" => "Text",
            "type" => "hidden",
            "holder" => "",
            "default" => "80%",
            "desc" => "",
        ),
        "cc_percent" => array(
            "title" => "Percent",
            "type" => "hidden",
            "holder" => "",
            "default" => "80",
            "desc" => "",
        ),
        "cc_size" => array(
            "title" => "Size",
            "type" => "hidden",
            "holder" => "",
            "default" => "150",
            "desc" => "",
        ),
        "cc_font_size" => array(
            "title" => "Font Size",
            "type" => "hidden",
            "holder" => "",
            "default" => "30",
            "desc" => "",
        ),
        "cc_font_color" => array(
            "title" => "Font Color",
            "type" => "hidden",
            "holder" => "",
            "default" => "#6DAEB7",
            "desc" => "",
        ),
        "cc_color" => array(
            "title" => "Color",
            "type" => "hidden",
            "holder" => "",
            "default" => "#6DAEB7",
            "desc" => "",
        ),
        "cc_track_color" => array(
            "title" => "Track Color",
            "type" => "hidden",
            "holder" => "",
            "default" => "#f5f5f5",
            "desc" => "",
        ),
        "cc_icon" => array(
            "title" => "Icon",
            "type" => "hidden",
            "holder" => "",
            "default" => "fa-star",
            "desc" => "",
        ),
    ),
);