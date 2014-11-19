<?php
global $waves_elements;
$waves_elements["chart_graph"] = array(
    "name" => "Chart Graph",
    "size" => "col-md-3",
    "content" => "items",
    "help" => "http://support.themewaves.com/knowledgebase/chart-graph-element-tutorial/",
    "settings" => array(
        "add_item" => array(
            "title" => "",
            "type" => "button",
            "data" => array("item" => "chart_graph", "settings" => "items"),
            "default" => "Add Chart Item",
            "desc" => "",
        ),
        "item_height" => array(
            "title" => "Height",
            "type" => "text",
            "holder" => "Example: 100px",
            "default" => "",
            "desc" => "Note: Only Digits works",
        ),
        "type" => array(
            "title" => "Chart Type",
            "type" => "select",
            "options" => array('Line' => 'Line', 'Bar' => 'Bar', 'Radar' => 'Radar'),
            "default" => "Line",
            "desc" => "All chart types and more information <a href='http://www.chartjs.org/docs/' target='_blank'>here</a>.",
        ),
        "begin_at_zero" => array(
            "title" => "Begin At Zero",
            "type" => "checkbox",
            "default" => "false",
            "desc" => "Whether the scale should start at zero, or an order of magnitude down from the lowest value",
        ),
        "labels" => array(
            "title" => "Chart Labels",
            "type" => "text",
            "holder" => "",
            "default" => "January , February , March , April",
            "desc" => "Insert your custom Label names here",
        ),
        "items" => array(
            "title" => "Items",
            "type" => "container",
            "container_type" => "toggle",
            "title_as" => "datas",
            "add_button" => "add_item",
            "default" => array(
                array(
                    "datas" => array(
                        "title" => "Datas",
                        "type" => "text",
                        "holder" => "",
                        "default" => "40,45,50,60",
                        "desc" => "Example: 40,45,50,60. Note: Digits only",
                    ),
                    "fill_color" => array(
                        "title" => "Fill Color",
                        "type" => "color",
                        "holder" => "#6DAEB7",
                        "default" => "#6DAEB7",
                        "desc" => "Fill Color",
                    ),
                    "fill_text" => array(
                        "title" => "Chart Label Title",
                        "type" => "text",
                        "holder" => "",
                        "default" => "",
                        "desc" => "If you want to display Label Title then insert it here",
                    ),
                )
            ),
            "desc" => "Items",
        ),
    ),
);