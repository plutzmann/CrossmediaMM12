<?php
global $waves_elements, $waves_element_options;
$waves_elements["team"] = array(
    "name" => "Team",
    "size" => "col-md-4",
    "content" => "content",
    "only" => "builder",
    "help" => "http://support.themewaves.com/knowledgebase/team-element-tutorial-2/",
    "settings" => array(
            "team_title" => array(
                "type" => "text",
                "default" => "",
                "desc" => "Insert Name",
            ),
            "position" => array(
                "type" => "text",
                "default" => "",
                "desc" => "Insert Position",
            ),
            "image" => array(
                "type" => "text",
                "default" => "",
                "desc" => "Upload Image",
            ),
            "add_thumb" => array(
                "title" => "",
                "type" => "button",
                "save_to" => "image",
                "default" => "Upload",
            ),
            "facebook" => array(
                "type" => "text",
                "default" => "",
                "desc" => "Facebook Link URL(optional)",
            ),
            "google" => array(
                "type" => "text",
                "default" => "",
                "desc" => "Google Plus Link URL(optional)",
            ),
            "twitter" => array(
                "type" => "text",
                "default" => "",
                "desc" => "Twitter Link URL(optional)",
            ),
            "content" => array(
                "type" => "textArea",
                "tinyMCE" => "true",
                "default" => "",
            ),
    ),
);