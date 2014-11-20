<?php
global $waves_elements;
$waves_elements["contact"] = array(
    "name" => "Contact",
    "size" => "col-md-12",
    "content" => "contact_desc",
    "settings" => array(
        "thumb" => array(
            "title" => "Thumbnail Image",
            "type" => "text",
            "holder" => "",
            "default" => "",
            "desc" => "The preivew image.",
        ),
        "add_thumb" => array(
            "title" => "",
            "type" => "button",
            "save_to" => "thumb",
            "default" => "Upload",
            "desc" => "",
        ),
        "sub_title" => array(
            "title" => "Sub Title",
            "type" => "text",
            "holder" => "",
            "default" => "Ultimate Church LTD",
        ),
        "info" => array(
            "title" => "Info",
            "type" => "text",
            "holder" => "",
            "default" => "SAN JOSE CS 92926 4601 <br/> +1-354-895-4592 OR +1-745-442-2708",
        ),
        "location" => array(
            "title" => "Location",
            "type" => "text",
            "holder" => "",
            "default" => "Soroca, Moldova",
        ),
        "map_url" => array(
            "title" => "Map Link URL",
            "type" => "text",
            "holder" => "",
            "default" => "https://www.google.com/maps?ll=-37.817373,144.935615&z=15&t=m&hl=en-US&gl=US&mapclient=embed&cid=13153204942596594449",
        ),
        "custom_margin" => array(
            "title" => "Custom Margin Top",
            "type" => "text",
            "holder" => "",
            "default" => "",
        ),
        "custom_height" => array(
            "title" => "Custom Height for Header",
            "type" => "text",
            "holder" => "",
            "default" => "",
        ),
        "contact_desc" => array(
            "title" => "Embeded Code",
            "type" => "textArea",
            "holder" => "",
            "default" => "",
            "desc" => "",
        ),
    ),
);