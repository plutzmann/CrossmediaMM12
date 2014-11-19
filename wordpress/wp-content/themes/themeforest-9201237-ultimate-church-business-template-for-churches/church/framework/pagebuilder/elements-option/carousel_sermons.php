<?php
global $waves_elements, $waves_element_options;
$waves_elements["carousel_sermons"] = array(
    "name" => "Sermons Carousel",
    "size" => "col-md-12",
    "only" => "builder",
    "min-size" => "col-md-12",
    "help" => "http://support.themewaves.com/knowledgebase/carousel/",
    "settings" => array(
        "auto_play" => array(
            "title" => "Auto Play ?",
            "type" => "checkbox",
            "default" => "false",
        ),
        "category" => array(
            "title" => "Seremon category",
            "type" => "category",
            "options" => $waves_element_options['cat']['tw-sermon'],
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
        "order" => array(
            "title" => "Order",
            "type" => "select",
            "options" => $waves_element_options['order'],
            "default" => "date_desc",
            "desc" => "",
        ),
    ),
);