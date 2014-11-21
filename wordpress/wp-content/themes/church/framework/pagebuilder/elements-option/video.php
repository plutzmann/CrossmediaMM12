<?php
global $waves_elements;
$waves_elements["video"] = array(
    "name" => "Video",
    "size" => "col-md-12",
    "content" => "video_embed",
    "help" => "http://support.themewaves.com/knowledgebase/video/",
    "settings" => array(
        "type" => array(
            "title" => "Choose Post type",
            "type" => "select",
            "options" => array("background" => "Background", "embed" => "Embed", "url" => "URL"),
            "hide" => array("background" => "video_m4v,add_video,video_thumb,add_thumb,video_embed", "url" => "video_embed,video_text_first,video_text_direction,video_text_last", "embed" => "video_m4v,add_video,video_thumb,add_thumb,video_text_first,video_text_direction,video_text_last"),
            "default" => "background",
            "desc" => "Background video will works with your Container Video Section. This will display Full Widht Video on Sinlge Container.",
        ),
        "video_text_direction" => array(
            "title" => "Choose Video Text Direction",
            "type" => "select",
            "options" => array("vertical" => "Vertical", "horizontal" => "Horizontal"),
            "default" => "vertical",
        ),
        "video_text_first" => array(
            "title" => "Video Text First",
            "type" => "text",
            "holder" => "",
            "default" => "",
            "desc" => "Full Width Video Button First Text",
        ),
        "video_text_last" => array(
            "title" => "Video Text Last",
            "type" => "text",
            "holder" => "",
            "default" => "",
            "desc" => "Full Width Video Button Last Text",
        ),
        "video_embed" => array(
            "title" => "Embeded Code",
            "type" => "textArea",
            "holder" => "",
            "default" => "",
            "desc" => "",
        ),
        "video_m4v" => array(
            "title" => "M4V File URL",
            "type" => "text",
            "holder" => "",
            "default" => "",
            "desc" => "The URL to the .m4v video file.",
        ),
        "add_video" => array(
            "title" => "",
            "type" => "button",
            "save_to" => "video_m4v",
            "default" => "Upload",
            "desc" => "",
        ),
        "video_thumb" => array(
            "title" => "Video Thumbnail Image",
            "type" => "text",
            "holder" => "",
            "default" => "",
            "desc" => "The preivew image.",
        ),
        "add_thumb" => array(
            "title" => "",
            "type" => "button",
            "save_to" => "video_thumb",
            "default" => "Upload",
            "desc" => "",
        ),
    ),
);