<?php
global $waves_elements, $waves_element_options;
$waves_elements["recent_posts"] = array(
    "name" => "Post Carousel",
    "size" => "col-md-12",
    "only" => "builder",
    "help" => "http://support.themewaves.com/knowledgebase/carousel/",
    "settings" => array(
        "auto_play" => array(
            "title" => "Auto Play ?",
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
            "title" => "Choose Post category",
            "type" => "category",
            "options" => $waves_element_options['cat']['post'],
            "default" => "0",
            "desc" => ".",
        ),
        "category_ids" => array(
            "type" => "hidden",
            "selector" => "category",
            "default" => "",
        ),
        "post_count" => array(
            "title" => "Post Count",
            "type" => "text",
            "default" => "6",
            "desc" => "Insert how many posts will displayed.",
        ),
        "ex_count" => array(
            "title" => "Excerpt Count",
            "type" => "text",
            "default" => "15",
            "desc" => "Insert how many words will displayed.",
        ),
        "image_height" => array(
            "title" => "Height",
            "type" => "text",
            "default" => "250",
            "desc" => "Image height",
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