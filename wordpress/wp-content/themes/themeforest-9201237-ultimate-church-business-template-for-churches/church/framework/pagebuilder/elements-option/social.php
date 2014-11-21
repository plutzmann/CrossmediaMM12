<?php
global $waves_elements, $waves_element_options;
$waves_elements["social"] = array(
    "name" => "Socials",
    "size" => "col-md-12",
    "content" => "items",
    "settings" => array(
        "count" => array(
            "title" => "Count",
            "type" => "text",
            "default" => "5",
            "desc" => "",
        ),
        "add_item" => array(
            "title" => "",
            "type" => "button",
            "data" => array("item" => "social", "settings" => "items"),
            "default" => "Add Social",
        ),
        "items" => array(
            "title" => "Items",
            "type" => "container",
            "container_type" => "toggle",
            "title_as" => "title",
            "add_button" => "add_item",
            "default" => array(
                array(
                    "title" => array(
                        "title" => "Socail Title",
                        "type" => "select",
                        "options" => array("facebook"=>"facebook", "google"=>"google plus", "twitter"=>"twitter","pinterest"=>"pinterest","youtube"=>"youtube","instagram"=>"instagram","vimeo"=>"vimeo"),
                        "default" => "facebook",
                        "desc" => "",
                    ),
                    "link" => array(
                        "title" => "Link url",
                        "type" => "text",
                        "holder" => "",
                        "default" => "",
                        "desc" => "",
                    ),
                )
            ),
        ),
    ),
);