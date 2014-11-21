<?php
global $waves_elements;
$waves_elements["column"] = array(
    "name" => "Column",
    "size" => "col-md-12",
    "content" => "column_content",
    "only" => "builder",
    "help" => "http://support.themewaves.com/knowledgebase/column/",
    "settings" => array(
        "column_content" => array(
            "title" => "",
            "type" => "textArea",
            "tinyMCE" => "true",
            "holder" => "",
            "default" => "Column Content",
            "desc" => "This is your next Wordpress Core Editor",
        ),
    ),
);