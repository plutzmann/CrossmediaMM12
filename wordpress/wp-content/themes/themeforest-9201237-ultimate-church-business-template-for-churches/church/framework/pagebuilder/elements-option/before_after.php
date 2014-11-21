<?php
global $waves_elements;
$waves_elements["before_after"] = array(
    "name" => "Before After",
    "size" => "col-md-4",
    "settings" => array(
        "before" => array(
            "title" => "Before Image",
            "type" => "text",
            "holder" => "",
            "default" => "",
            "desc" => "This element will helps you compare the two images between. Please insert the before image here.",
        ),
        "add_before" => array(
            "title" => "",
            "type" => "button",
            "save_to" => "before",
            "default" => "Upload",
            "desc" => "",
        ),
        "after" => array(
            "title" => "After Image",
            "type" => "text",
            "holder" => "",
            "default" => "",
            "desc" => "Please insert the after image here.",
        ),
        "add_after" => array(
            "title" => "",
            "type" => "button",
            "save_to" => "after",
            "default" => "Upload",
            "desc" => "",
        ),
    ),
);