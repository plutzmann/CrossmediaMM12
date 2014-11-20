<?php
global $waves_elements, $waves_element_options;
$waves_elements["sidebar"] = array(
    "name" => "Sidebar",
    "size" => "col-md-3",
    "only" => "builder",
    "help" => "http://support.themewaves.com/knowledgebase/sidebar-element-tutorial/",
    "settings" => array(
        "name" => array(
            "title" => "",
            "type" => "select",
            "options" => $waves_element_options['sidebars'],
            "default" => "Default sidebar",
            "desc" => "Please create your own Sidebar in Theme Options Sidebar Creater then Choose here.",
        ),
    ),
);