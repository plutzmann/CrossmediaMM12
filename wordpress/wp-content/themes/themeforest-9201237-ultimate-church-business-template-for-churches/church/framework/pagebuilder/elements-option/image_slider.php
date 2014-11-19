<?php
global $waves_elements, $waves_element_options;
$waves_elements["image_slider"] = array(
    "name"    => "Image Slider",
    "size"    => "col-md-4",
    "settings" => array(
        "add_gallery" => array(
            "title" => "",
            "type" => "button",
            "save_to" => "gallery_list",
            "default" => "Edit Gallery",
            "desc" => "",
        ),
        "gallery_list" => array(
            "title" => "",
            "type" => "gallery",
            "holder" => "",
            "default" => "",
            "desc" => "",
        ),
    ),
);