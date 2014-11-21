<?php
global $waves_elements,$waves_element_options;
$waves_elements["blog"] = array(
    "name" => "Blog",
    "size" => "col-md-12",
    "min-size" => "col-md-12",
    "only" => "builder",
    "help" => "http://support.themewaves.com/knowledgebase/blog/",
    "settings" => array(
        "layout" => array(
            "title" => "Blog layout",
            "type" => "select",
            "options" => array('grid2' => '2 columns', 'grid3' => '3 columns'),
            "default" => "grid3",
            "desc" => "Select blog layout.",
        ),
        "category" => array(
            "title" => "Blog category",
            "type" => "category",
            "options" => $waves_element_options['cat']['post'],
            "default" => "0",
            "desc" => "If you want to display Specify category then choose.",
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
            "default" => "10",
            "desc" => "Insert how many posts will displayed in blog.",
        ),
        "image_height" => array(
            "title" => "Featured image height",
            "type" => "text",
            "holder" => "250",
            "default" => "250",
            "desc" => "Insert height(px).",
        ),
        "pagination" => array(
            "title" => "Pagination",
            "type" => "select",
            "options" => $waves_element_options['yesno'],
            "default" => "true",
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