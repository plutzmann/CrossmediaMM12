<?php

global $waves_elements, $waves_element_options;
$waves_elements["milestones"] = array(
    "name" => "Milestones",
    "size" => "col-md-4",
    "settings" => array(
        "animation" => array(
            "title" => "Animation",
            "type" => "select",
            "options" => $waves_element_options['animations'],
            "default" => "none",
            "desc" => "Animation.",
        ),
        "animation_delay" => array(
            "title" => "Animation Delay",
            "type" => "text",
            "holder" => "Example:300",
            "desc" => "",
        ),
        "milsetone_type" => array(
            "title" => "Choose Milestone type",
            "type" => "select",
            "options" => array('style_3' => 'Default', 'style_2' => 'Icon(FL) + Title + Desc','style_1' => 'Centered'),
            "default" => "style_3",
            "desc" => "FL means Icons Floated Left.",
        ),
        "thumb_type" => array(
            "title" => "Choose Thumb type",
            "type" => "select",
            "options" => array("image" => "Image", "fi" => "Font Icon"),
            "hide" => array("image" => "fi", "fi" => "image,add_image"),
            "default" => "fi",
            "desc" => "Chosen type will be displayed.",
        ),
        // Image
        "image" => array(
            "title" => "Thumbnail Image",
            "type" => "text",
            "holder" => "",
            "default" => "",
            "desc" => "The preivew image.",
        ),
        "add_image" => array(
            "title" => "",
            "type" => "button",
            "save_to" => "image",
            "default" => "Upload",
            "desc" => "",
        ),
        // Font Icon
        "fi" => array(
            "title" => "Add Icon",
            "type" => "fi",
            "holder" => "",
            "default" => "",
            "desc" => "",
        ),
        "fi_size" => array(
            "need_fi" => "true",
            "title" => "Size",
            "type" => "hidden",
            "holder" => "",
            "default" => "25",
            "desc" => "Size.",
        ),
        "fi_padding" => array(
            "title" => "Padding",
            "type" => "hidden",
            "holder" => "",
            "default" => "15",
            "desc" => "Padding.",
        ),
        "fi_color" => array(
            "title" => "Color",
            "type" => "hidden",
            "holder" => "",
            "default" => "#6DAEB7",
            "desc" => "Color.",
        ),
        "fi_bg_color" => array(
            "title" => "Background Color",
            "type" => "hidden",
            "holder" => "",
            "default" => "",
            "desc" => "Background Color.",
        ),
        "fi_border_color" => array(
            "title" => "Border Color",
            "type" => "hidden",
            "holder" => "",
            "default" => "#6DAEB7",
            "desc" => "Border Color.",
        ),
        "fi_rounded" => array(
            "title" => "Border Size",
            "type" => "hidden",
            "holder" => "",
            "default" => "0",
            "desc" => "Border Size.",
        ),
        "fi_rounded_size" => array(
            "title" => "Border Rounded Size",
            "type" => "hidden",
            "holder" => "",
            "default" => "3",
            "desc" => "Border Rounded Size.",
        ),
        "fi_icon" => array(
            "title" => "Icon",
            "type" => "hidden",
            "holder" => "",
            "default" => "icon-fire",
            "desc" => "Icon.",
        ),
        // -----------------------
        "mile_title" => array(
            "title" => "",
            "type" => "text",
            "default" => "Our Customers",
            "desc" => "Insert your Milestone",
        ),
        "count" => array(
            "title" => "",
            "type" => "text",
            "default" => "1500",
            "desc" => "Count Number. Note: Only Digit",
        ),
    ),
);
