<?php
global $waves_elements;
$waves_elements["calendar"] = array(
    "name" => "Calendar",
    "size" => "col-md-12",
    "settings" => array(
        "year" => array(
            "title" => "Calendar Year",
            "type" => "number",
            "max"=>"2100",
            "min"=>"2014",
            "default" => "2014",
        ),
        "month" => array(
            "title" => "Calendar Month",
            "type" => "number",
            "max"=>"12",
            "min"=>"1",
            "default" => "10",
        ),
    ),
);