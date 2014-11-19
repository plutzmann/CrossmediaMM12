<?php
global $waves_elements;
$waves_elements["chart_pie"] = array(
    "name" => "Chart Pie",
    "size" => "col-md-3",
    "content" => "items",
    "help" => "http://support.themewaves.com/knowledgebase/chart-pie-element-tutorial/",
    "settings" => array(
        "add_item" => array(
            "title" => "",
            "type" => "button",
            "data" => array("item" => "chart_pie", "settings" => "items"),
            "default" => "Add Chart Item",
            "desc" => "",
        ),
        "type" => array(
            "title" => "Chart Type",
            "type" => "select",
            "options" => array( 'Doughnut' => 'Doughnut', 'PolarArea' => 'Polar Area', 'Pie' => 'Pie'),
            "hide"    => array( 'Doughnut' => 'begin_at_zero', 'PolarArea' => 'none', 'Pie' => 'begin_at_zero'),
            "default" => "Doughnut",
            "desc" => "All chart types and more information <a href='http://www.chartjs.org/docs/' target='_blank'>here</a>.",
        ),
        "begin_at_zero" => array(
            "title" => "Begin At Zero",
            "type" => "checkbox",
            "default" => "false",
            "desc" => "Whether the scale should start at zero, or an order of magnitude down from the lowest value",
        ),
        "label_list" => array(
            "title" => "Show Label Lists",
            "type" => "checkbox",
            "default" => "false",
            "desc" => "",
        ),
        "items" => array(
            "title" => "Items",
            "type" => "container",
            "container_type" => "toggle",
            "title_as" => "value",
            "add_button" => "add_item",
            "default" => array(
                array(
                    "value" => array(
                        "title" => "",
                        "type" => "text",
                        "holder" => "100",
                        "default" => "100",
                        "desc" => "Note: Only Digit",
                    ),
                    "color" => array(
                        "title" => "",
                        "type" => "color",
                        "holder" => "#6DAEB7",
                        "default" => "#6DAEB7",
                        "desc" => "Choose color",
                    ),
                    "fill_text" => array(
                        "title" => "",
                        "type" => "text",
                        "holder" => "",
                        "default" => "",
                        "desc" => "Chart Title",
                    ),
                )
            ),
            "desc" => "Items",
        ),
    ),
);