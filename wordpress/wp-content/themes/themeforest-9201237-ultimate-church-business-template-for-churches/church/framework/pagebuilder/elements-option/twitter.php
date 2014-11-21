<?php
global $waves_elements;
$waves_elements["twitter"] = array(
    "name" => "Twitter",
    "size" => "col-md-4",
    "help" => "http://support.themewaves.com/knowledgebase/twitter-element-tutorial/",
    "settings" => array(
        "username" => array(
            "title" => "Insert Twitter Username",
            "type" => "text",
            "holder" => "",
            "default" => "themewaves",
            "desc" => "Only twitter username.",
        ),
        "tweetstoshow" => array(
            "title" => "Count",
            "type" => "select",
            "options" => array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10"),
            "default" => "3",
            "desc" => "",
        ),
        "cachetime" => array(
            "title" => "Cache Tweets in every * hours",
            "type" => "text",
            "holder" => "",
            "default" => "1",
            "desc" => "",
        ),
    ),
);

$waves_elements["twitter_carousel"] = array(
    "name" => "Twitter Carousel",
    "size" => "col-md-12",
    "help" => "http://support.themewaves.com/knowledgebase/twitter-carousel-element-tutorial/",
    "settings" => array(
        "auto_play" => array(
            "title" => "Auto Play ?",
            "type" => "checkbox",
            "default" => "false",
        ),
        "style" => array(
            "title" => "Layout style ?",
            "type" => "select",
            "options" => array('style_1'=>'Style 1', 'style_2'=>'Style 2'),
            "default" => "style_1",
            "desc" => "",
        ),
        "username" => array(
            "title" => "Insert Twitter Username",
            "type" => "text",
            "holder" => "",
            "default" => "themewaves",
            "desc" => "Only twitter username.",
        ),
        "tweetstoshow" => array(
            "title" => "Count",
            "type" => "select",
            "options" => array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10"),
            "default" => "3",
            "desc" => "",
        ),
        "cachetime" => array(
            "title" => "Cache Tweets in every * hours",
            "type" => "text",
            "holder" => "",
            "default" => "1",
            "desc" => "",
        ),
    ),
);