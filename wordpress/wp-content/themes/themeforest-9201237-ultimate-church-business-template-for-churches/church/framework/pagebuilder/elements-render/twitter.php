<?php

/* ================================================================================== */
/*      Twitter Shortcode
  /* ================================================================================== */

function waves_twitter_build($atts) {
    require_once (WAVES_PATH . "twitteroauth.php");
    $atts = shortcode_atts(array(
        'size' => 'col-md-3',
        'class' => '',
        'title' => '',
        'consumerkey' => tw_option('consumerkey'),
        'consumersecret' => tw_option('consumersecret'),
        'accesstoken' => tw_option('accesstoken'),
        'accesstokensecret' => tw_option('accesstokensecret'),
        'cachetime' => '1',
        'username' => 'themewaves',
        'tweetstoshow' => '10',
            ), $atts);
    //check settings and die if not set
    if (empty($atts['consumerkey']) || empty($atts['consumersecret']) || empty($atts['accesstoken']) || empty($atts['accesstokensecret']) || !isset($atts['cachetime']) || empty($atts['username'])) {
        return '<div class="'.$atts['size'].'"><p class="no-bottom">' . __('Due to Twitter API changed you must insert Twitter APP. Check Our theme Options there you have Option for FB Twitter API, insert the Keys One Time', 'themewaves') . '</p></div>';
    }
    //check if cache needs update
    $tw_twitter_last_cache_time = get_option('tw_twitter_last_cache_time_' . $atts['username']);
    $diff = time() - $tw_twitter_last_cache_time;
    $crt = $atts['cachetime'] * 3600;

    //yes, it needs update			
    if ($diff >= $crt || empty($tw_twitter_last_cache_time)) {
        $connection = new TwitterOAuth($atts['consumerkey'], $atts['consumersecret'], $atts['accesstoken'], $atts['accesstokensecret']);
        $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $atts['username'] . "&count=10");
        if(!$tweets){
            return __('Couldn\'t retrieve tweets! Wrong username?', 'themewaves');
        }
        if (!empty($tweets->errors)) {
            if ($tweets->errors[0]->message == 'Invalid or expired token') {
                return '<strong>' . $tweets->errors[0]->message . '!</strong><br />You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!';
            } else {
                return '<strong>' . $tweets->errors[0]->message . '</strong>';
            }
            return;
        }
        $tweets_array = array();
        for ($i = 0; is_array($tweets) && $i <= count($tweets); $i++) {
            if (!empty($tweets[$i])) {
                $tweets_array[$i]['created_at'] = $tweets[$i]->created_at;
                $tweets_array[$i]['text'] = $tweets[$i]->text;
                $tweets_array[$i]['status_id'] = $tweets[$i]->id_str;
            }
        }
        //save tweets to wp option 		
        update_option('tw_twitter_tweets_' . $atts['username'], rawUrlEncode(serialize($tweets_array)));
        update_option('tw_twitter_last_cache_time_' . $atts['username'], time());
        echo '<!-- twitter cache has been updated! -->';
    }
    //convert links to clickable format
    if (!function_exists('convert_links')) {

        function convert_links($status, $targetBlank = true, $linkMaxLen = 250) {
            // the target
            $target = $targetBlank ? " target=\"_blank\" " : "";
            // convert link to url
            $status = preg_replace("/((http:\/\/|https:\/\/)[^ )]+)/e", "'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status);
            // convert @ to follow
            $status = preg_replace("/(@([_a-z0-9\-]+))/i", "<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>", $status);
            // convert # to search
            $status = preg_replace("/(#([_a-z0-9\-]+))/i", "<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>", $status);
            // return the status
            return $status;
        }

    }
    //convert dates to readable format
    if (!function_exists('relative_time')) {

        function relative_time($a) {
            //get current timestampt
            $b = strtotime("now");
            //get timestamp when tweet created
            $c = strtotime($a);
            //get difference
            $d = $b - $c;
            //calculate different time values
            $minute = 60;
            $hour = $minute * 60;
            $day = $hour * 24;
            $week = $day * 7;
            if (is_numeric($d) && $d > 0) {
                //if less then 3 seconds
                if ($d < 3)
                    return "right now";
                //if less then minute
                if ($d < $minute)
                    return floor($d) . " seconds ago";
                //if less then 2 minutes
                if ($d < $minute * 2)
                    return "about 1 minute ago";
                //if less then hour
                if ($d < $hour)
                    return floor($d / $minute) . " minutes ago";
                //if less then 2 hours
                if ($d < $hour * 2)
                    return "about 1 hour ago";
                //if less then day
                if ($d < $day)
                    return floor($d / $hour) . " hours ago";
                //if more then day, but less then 2 days
                if ($d > $day && $d < $day * 2)
                    return "yesterday";
                //if less then year
                if ($d < $day * 365)
                    return floor($d / $day) . " days ago";
                //else return more than a year
                return "over a year ago";
            }
        }

    }
    $tw_twitter_tweets = maybe_unserialize(rawUrlDecode(get_option('tw_twitter_tweets_' . $atts['username'])));
    return $tw_twitter_tweets;
}

function waves_twitter($atts, $content) {
    $tw_twitter_tweets = waves_twitter_build($atts);
    if (is_array($tw_twitter_tweets)) {
        $output = waves_item($atts, 'waves-twitter');
        $output .= '<ul class="jtwt">';
        $fctr = '1';
        foreach ($tw_twitter_tweets as $tweet) {
            $output.='<li><span>' . convert_links($tweet['text']) . '</span><br /><a class="twitter_time" target="_blank" href="http://twitter.com/' . $atts['username'] . '/statuses/' . $tweet['status_id'] . '">' . relative_time($tweet['created_at']) . '</a></li>';
            if ($fctr == $atts['tweetstoshow']) {
                break;
            }
            $fctr++;
        }
        $output .= '</ul>';
        $output .= '<div class="twitter-follow"><a class="btn btn-border btn-small" target="_blank" href="http://twitter.com/' . $atts['username'] . '" style="color: #707377">' . __('Follow', 'themewaves') . ' ' . $atts['username'] . '<span></span></a></div>';
        $output .= '</div>';
        return $output;
    } else {
        return $tw_twitter_tweets;
    }
}

add_shortcode('tw_twitter', 'waves_twitter');

function waves_twitter_carousel($atts, $content) {
    $tw_twitter_tweets = waves_twitter_build($atts);
    if (is_array($tw_twitter_tweets)) {
        $class=empty($atts['style'])?'style_1':$atts['style'];
        $output = waves_item($atts, 'waves-twitter');
            $output .= '<div class="carousel-container">';
                $output .= '<div class="waves-carousel-twitter list_carousel '.$class.'" data-autoplay="'.$atts['auto_play'].'">';
                    $output .= '<div class="twitter-icon">';
                        $output .= '<i class="icon-social-twitter"></i><span>'.__('Tweets','themewaves').': </span>';
                    $output .= '</div>';
                    $output .= '<div class="jtwt waves-carousel">';
                        $fctr = '1';
                        foreach ($tw_twitter_tweets as $tweet) {
                            $output.='<div class="tw-owl-item"><p>' . convert_links($tweet['text']) . '<span class="twitter_time">'.relative_time($tweet['created_at']).'</span></p></div>';
                            if ($fctr == $atts['tweetstoshow']) {
                                break;
                            }
                            $fctr++;
                        }
                    $output .= '</div>';
                    $output .= '<div class="twitter-follow"><a target="_blank" href="http://twitter.com/' . $atts['username'] . '">' . __('Follow Us', 'themewaves'). ' - @' . $atts['username'] . '</a></div>';
                $output .= '</div>';
            $output .= '</div>';
        $output .= '</div>';
        return $output;
    } else {
        return $tw_twitter_tweets;
    }
}

add_shortcode('tw_twitter_carousel', 'waves_twitter_carousel');
