<?php
global $waves_elements, $waves_element_options;
$waves_elements["sermon"] = array(
    "name" => "Sermon",
    "size" => "col-md-12",
    "min-size" => "col-md-12",
    "row-type" => "row",
    "only" => "builder",
    "help" => "http://support.themewaves.com/knowledgebase/sermon/",
    "settings" => array(
        "layout" => array(
            "title" => "Layout type?",
            "type" => "select",
            "options" => array('col3' => '3 Columns', 'col4' => '4 Columns'),
            "default" => "col3",
        ),
        "category" => array(
            "title" => "Choose Sermon Category",
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
        "count" => array(
            "title" => "Count",
            "type" => "text",
            "default" => "12",
            "desc" => "",
        ),
        "height" => array(
            "title" => "Height",
            "type" => "text",
            "holder" => "300",
            "default" => "",
            "desc" => "This min height",
        ),
        "filter" => array(
            "title" => "Display Filter?",
            "type" => "select",
            "options" => $waves_element_options['yesno'],
            "default" => "true",
            "desc" => "",
        ),
        "pagination" => array(
            "title" => "Display Pagination?",
            "type" => "select",
            "options" => array('none' => 'None', 'simple' => 'Simple pagination', 'infinite' => 'Infinite scroll'),
            "default" => "simple",
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