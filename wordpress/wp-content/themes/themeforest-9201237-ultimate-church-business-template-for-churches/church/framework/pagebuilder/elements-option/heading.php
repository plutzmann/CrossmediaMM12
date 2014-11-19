<?php
global $waves_elements;
$waves_elements["heading"] = array(
    "name" => "Heading",
    "size" => "col-md-12",
    "content" => "description",
    "settings" => array(
        "position" => array(
            "title" => "Choose Title Position",
            "type" => "select",
            "options" => array("left" => "Left","center" => "Center","right" => "Right"),
            "default" => "center",
            "description" => "",
        ),
        "description" => array(
            "title" => "Title Description",
            "type" => "textArea",
            "default" => "",
            "description" => "",
        ),
    ),
);