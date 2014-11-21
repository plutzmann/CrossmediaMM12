<?php
global $waves_elements, $waves_element_options;
$waves_elements["event"] = array(
    "name" => "Event",
    "size" => "col-md-12",
    "min-size" => "col-md-12",
    "row-type" => "row",
    "only" => "builder",
    "help" => "http://support.themewaves.com/knowledgebase/portfolio/",
    "settings" => array(
        "layout" => array(
            "title" => "Layout type?",
            "type" => "select",
            "options" => array('col2' => '2 Columns', 'col3' => '3 Columns', 'upcoming' => 'Upcoming'),
            "hide"    => array('col2' => 'none', 'col3' => 'none', 'upcoming' => 'count,height,filter,pagination,order'),
            "default" => "col3",
        ),
        "category" => array(
            "title" => "Choose Event category",
            "type" => "category",
            "options" => $waves_element_options['cat']['event'],
            "default" => "",
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