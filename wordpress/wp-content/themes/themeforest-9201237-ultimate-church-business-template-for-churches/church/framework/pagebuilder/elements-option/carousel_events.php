<?php
global $waves_elements, $waves_element_options;
$waves_elements["recent_events"] = array(
    "name" => "Events Carousel",
    "size" => "col-md-12",
    "only" => "builder",
    "help" => "http://support.themewaves.com/knowledgebase/carousel/",
    "settings" => array(
        "auto_play" => array(
            "title" => "Auto Play ?",
            "type" => "checkbox",
            "default" => "false",
        ),
        "white_bg" => array(
            "title" => "White background ?",
            "type" => "checkbox",
            "default" => "false",
        ),
        "layout_type" => array(
            "title" => "Layout type?",
            "type" => "select",
            "options" => array('1' => '1 Column', '2' => '2 Columns', '3' => '3 Columns'),
            "default" => "3",
            "desc" => "",
        ),
        "category" => array(
            "title" => "Portfolio category",
            "type" => "category",
            "options" => $waves_element_options['cat']['event'],
            "default" => "0",
            "desc" => "Chosen categories will be included.",
        ),
        "category_ids" => array(
            "type" => "hidden",
            "selector" => "category",
            "default" => "",
        ),
        "post_count" => array(
            "title" => "Post Count",
            "type" => "text",
            "holder" => "10",
            "default" => "4",
            "desc" => "Insert how many posts will displayed.",
        ),
        "image_height" => array(
            "title" => "Height",
            "type" => "text",
            "holder" => "300",
            "default" => "",
            "desc" => "Image height",
        ),
        "description" => array(
            "title" => "Description",
            "type" => "textArea",
            "holder" => "",
            "default" => "",
            "desc" => "",
        ),
        "order" => array(
            "title" => "Order",
            "type" => "select",
            "options" => $waves_element_options['order'],
            "default" => "date_desc",
            "desc" => "",
        ),
    ),
);