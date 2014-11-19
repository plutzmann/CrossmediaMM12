<?php
global $tw_socials;
$tw_socials = array(
    'facebook' => array(
        'name' => 'facebook_username',
        'link' => 'http://www.facebook.com/*',
    ),
    'flickr' => array(
        'name' => 'flickr_username',
        'link' => 'http://www.flickr.com/photos/*'
    ),
    'gplus' => array(
        'name' => 'googleplus_username',
        'link' => 'https://plus.google.com/u/0/*'
    ),
    'twitter' => array(
        'name' => 'twitter_username',
        'link' => 'http://twitter.com/*',
    ),
    'instagram' => array(
        'name' => 'instagram_username',
        'link' => 'http://instagram.com/*',
    ),
    'pinterest' => array(
        'name' => 'pinterest_username',
        'link' => 'http://pinterest.com/*',
    ),
    'skype' => array(
        'name' => 'skype_username',
        'link' => 'skype:*'
    ),
    'vimeo' => array(
        'name' => 'vimeo_username',
        'link' => 'http://vimeo.com/*',
    ),
    'youtube' => array(
        'name' => 'youtube_username',
        'link' => 'http://www.youtube.com/user/*',
    ),
    'dribbble' => array(
        'name' => 'dribbble_username',
        'link' => 'http://dribbble.com/*',
    ),
    'linkedin' => array(
        'name' => 'linkedin_username',
        'link' => '*'
    ),
    'soundcloud' => array(
        'name' => 'soundcloud_username',
        'link' => '*'
    ),
    'rss' => array(
        'name' => 'rss_username',
        'link' => 'http://*/feed'
    )
);
global $waves_customizer;
$waves_customizer = false;
if (isset($_POST['customized'])) {
    $waves_customizer = json_decode(stripslashes($_POST['customized']), true);
}

function tw_option($index1, $index2 = false) {
    global $smof_data, $waves_customizer;
    // Customize Preview
    if ($waves_customizer && isset($waves_customizer[$index1])) {
        return $waves_customizer[$index1];
    }
    // =============================
    if ($index2) {
        $output = isset($smof_data[$index1][$index2]) ? $smof_data[$index1][$index2] : false;
        return $output;
    }
    $output = isset($smof_data[$index1]) ? $smof_data[$index1] : false;
    return $output;
}

// Page, Post custom metaboxes
//=======================================================
function get_metabox($name) {
    global $post;
    if ($post) {
        $metabox = get_post_meta($post->ID, 'themewaves_' . strtolower(THEMENAME) . '_options', true);
        return isset($metabox[$name]) ? $metabox[$name] : "";
    }
    return false;
}

function set_metabox($name, $val) {
    global $post;
    if ($post) {
        $metabox = get_post_meta($post->ID, 'themewaves_' . strtolower(THEMENAME) . '_options', true);
        $metabox[$name] = $val;
        return update_post_meta($post->ID, 'themewaves_' . strtolower(THEMENAME) . '_options', $metabox);
    }
    return false;
}

// Print menu
//=======================================================
function tw_menu() {
    $nav_menu = get_metabox('onepage_menu');
    if ($nav_menu) {
        wp_nav_menu(array(
            'container' => false,
            'menu' => $nav_menu,
            'menu_id' => 'menu',
            'menu_class' => 'sf-menu clearfix',
            'fallback_cb' => 'tw_no_menu')
        );
    } else {
        wp_nav_menu(array(
            'walker' => new waves_custom_menu(),
            'container' => false,
            'menu_id' => 'menu',
            'menu_class' => 'sf-menu clearfix',
            'fallback_cb' => 'tw_no_menu',
            'theme_location' => 'main'
        ));
    }
}

function tw_no_menu() {
    echo "<ul id='menu' class='sf-menu clearfix'>";
    wp_list_pages(array('title_li' => ''));
    echo "</ul>";
}

function tw_mobile_menu() {
    $nav_menu = get_metabox('onepage_menu');
    if ($nav_menu) {
        wp_nav_menu(array(
            'container' => false,
            'menu' => $nav_menu,
            'menu_id' => '',
            'menu_class' => 'clearfix',
            'fallback_cb' => 'tw_no_mobile')
        );
    } else {
        wp_nav_menu(array(
            'container' => false,
            'menu_id' => '',
            'menu_class' => 'clearfix',
            'fallback_cb' => 'tw_no_mobile',
            'theme_location' => 'main')
        );
    }
}

function tw_no_mobile() {
    echo "<ul class='clearfix'>";
    wp_list_pages(array('title_li' => ''));
    echo "</ul>";
}

// Print logo
//=======================================================
function tw_logo($hidemenu) {
    echo '<div class="tw-logo">';
    if($hidemenu){ ?>
        <div class="show-main-menu clearfix">
            <a id="show-main-menu" class="mobile-menu-icon" href="#">
                <span></span><span></span><span></span>
            </a>
        </div><?php
    }    
    if (tw_option("theme_logo") == "") {
        echo '<h1 class="site-name">';
        echo '<a class="logo" href="' . home_url() . '">';
        bloginfo('name');
        echo '</a>';
        echo '</h1>';
    } else {
        $classes = get_body_class();
        echo '<a class="logo" href="' . home_url() . '">';
        if (in_array('header-light', $classes)) {
            echo '<img class="logo-img" src="' . tw_option("theme_logo_light") . '" alt="' . get_bloginfo('name') . '"/>';
        } else if (tw_option("logo_retina")) {
            echo '<img class="logo-img" src="' . tw_option("theme_logo_retina") . '" style="width:' . tw_option('logo_width') . 'px" alt="' . get_bloginfo('name') . '"/>';
        } else {
            echo '<img class="logo-img" src="' . tw_option("theme_logo") . '" alt="' . get_bloginfo('name') . '"/>';
        }
        echo '</a>';
    }

    echo '</div>';
}

// Get featured text
//=======================================================
function get_featuredtext() {
    global $post;

    if (is_singular()) {
        $return = $post->post_title;
        return $return;
    } elseif (is_category()) {
        $return = __("Category", "waves") . " : " . single_cat_title("", false);
        return $return;
    } elseif (is_tax('portfolio_cat')) {
        $return = __("Portfolio", "waves") . " : " . single_cat_title("", false);
        return $return;
    } elseif (is_tag()) {
        $return = __("Tag", "waves") . " : " . single_tag_title("", false);
        return $return;
    } elseif (is_404()) {
        $return = __("Nothing Found!", "waves");
        return $return;
    } elseif (is_author()) {
        global $author;
        $userdata = get_userdata($author);
        $return = __("Author", "waves") . " : " . $userdata->display_name;
        return $return;
    } elseif (is_archive()) {
        if (is_day()) {
            $return = __("Daily Archives", "waves") . " : " . get_the_date();
        } elseif (is_month()) {
            $return = __("Monthly Archives", "waves") . " : " . get_the_date("F Y");
        } elseif (is_year()) {
            $return = __("Yearly Archives", "waves") . " : " . get_the_date("Y");
        } else {
            $return = __("Blog Archives", "waves");
        }
        return $return;
    } elseif (is_search()) {
        $return = __("Search results for", "waves") . " : " . get_search_query();
        return $return;
    }
}

if (!function_exists("current_title")) {

    function current_title() {
        global $page, $paged;
        echo "<title>";
        wp_title('|', true, 'right');
        bloginfo('name');
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && ( is_home() || is_front_page() ))
            echo " | $site_description";
        if ($paged >= 2 || $page >= 2)
            echo ' | ' . sprintf(__('Page %s', 'themewaves'), max($paged, $page));
        echo "</title>";
    }

}

function tw_favicon() {
    if (tw_option('theme_favicon') == "") {
        echo '<link rel="shortcut icon" href="' . THEME_DIR . '/assets/img/favicon.ico"/>';
    } else {
        echo '<link rel="shortcut icon" href="' . tw_option('theme_favicon') . '"/>';
    }
    if (tw_option('favicon_retina')) {
        echo tw_option('favicon_iphone') != "" ? ('<link rel="apple-touch-icon" href="' . tw_option('favicon_iphone') . '"/>') : '';
        echo tw_option('favicon_iphone_retina') != "" ? ('<link rel="apple-touch-icon" sizes="114x114" href="' . tw_option('favicon_iphone_retina') . '"/>') : '';
        echo tw_option('favicon_ipad') != "" ? ('<link rel="apple-touch-icon" sizes="72x72" href="' . tw_option('favicon_ipad') . '"/>') : '';
        echo tw_option('favicon_ipad_retina') != "" ? ('<link rel="apple-touch-icon" sizes="144x144" href="' . tw_option('favicon_ipad_retina') . '"/>') : '';
    }
}

if (!function_exists('tw_comment_block')) {

    function tw_comment_block($comment, $args, $depth) {

        $GLOBALS['comment'] = $comment;
        print '<div class="comment-block">';
        ?>	
        <div class="comment" id="comment-<?php comment_ID(); ?>">
            <div class="comment-author">
                <?php echo get_avatar($comment, $size = '100'); ?>
                <span class="comment-replay-link"><?php comment_reply_link(array_merge($args, array('reply_text' => '<i class="fa fa-reply" title="'.__('Reply', 'waves').'"></i>', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
            </div>
            <div class="comment-body">
                <div class="comment-meta">
                    <span class="comment-author-link">
                        <?php echo get_comment_author_link(); ?>
                    </span>                          
                    <span class="comment-date">
                        <?php echo get_comment_date('j F Y'); ?>
                    </span>
                    
                </div>
                <?php comment_text() ?>
            </div>
        </div><?php
    }

}






if (!function_exists('tw_comment_form')) {

    function tw_comment_form($fields) {
        global $id, $post_id;
        if (null === $post_id)
            $post_id = $id;
        else
            $id = $post_id;

        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $aria_req = ( $req ? " aria-required='true'" : '' );

        $fields = array(
            'author' => '<div class="comment-form-author"><p class="comment-form-name">' .
            '<input id="author" name="author" placeholder="' . __('Name', 'waves') . '" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' />' . '</p>',
            'email' => '<p class="comment-form-email">' .
            '<input id="email" name="email" placeholder="' . __('Email', 'waves') . '" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' />' . '</p>',
            'url' => '</div>',
        );
        return $fields;
    }

    add_filter('comment_form_default_fields', 'tw_comment_form');
}

function tw_related_portfolios() {
    global $post;

    $tags = wp_get_post_terms($post->ID, 'portfolio_cat', array("fields" => "ids"));

    if ($tags) {
        $rel_title = tw_option('translate_relatedportfolio') ? tw_option('translate_relatedportfolio') : __('Recent <span>Projects</span>', 'waves');
        echo do_shortcode('[tw_heading class="related-portfolio" text="' . $rel_title . '"]');
        $tag_ids = "";
        foreach ($tags as $tag) {
            $term = get_term($tag, 'portfolio_cat');
            $tag_ids .= $term->slug . ",";
        }

        echo '<div class="row"><div class="related_portfolios">';
        echo do_shortcode('[tw_portfolio category_ids="' . $tag_ids . '" count="3" not_in="' . $post->ID . '" port_column_count="3" height="' . tw_option('port_height') . '" pagination="none"]');
        echo '</div></div>';
    }
}
function tw_related_events() {
    global $post;

    $tags = wp_get_post_terms($post->ID, 'event_cat', array("fields" => "ids"));

    if ($tags) {
        $rel_title = tw_option('translate_relatedevent') ? tw_option('translate_relatedevent') : __('Other events', 'waves');
        
        $tag_ids = "";
        foreach ($tags as $tag) {
            $term = get_term($tag, 'event_cat');
            $tag_ids .= $term->slug . ",";
        }
        echo '</div>';
        echo '<div class="related-events-container">';
        echo '<div class="container">';
        echo '<div class="row">';
        echo !empty($rel_title) ? ('<h3 class="related-title">'.$rel_title.'</h3>') : '';
        echo do_shortcode('[tw_event category_ids="' . $tag_ids . '" count="3" not_in="' . $post->ID . '" column="3" height="' . tw_option('event_height') . '" pagination="none"]');
        echo '</div>';
        echo '</div>';
    }
}
function tw_related_sermons() {
    global $post;

    $tags = wp_get_post_terms($post->ID, 'sermon_cat', array("fields" => "ids"));

    if ($tags) {
        $rel_title = tw_option('translate_relatedsermon') ? tw_option('translate_relatedsermon') : __('Other sermons', 'waves');
        
        $tag_ids = "";
        foreach ($tags as $tag) {
            $term = get_term($tag, 'sermon_cat');
            $tag_ids .= $term->slug . ",";
        }
        echo '</div>';
        echo '<div class="related-sermons-container">';
        echo '<div class="container">';
        echo '<div class="row">';
        echo !empty($rel_title) ? ('<h3 class="related-title">'.$rel_title.'</h3>') : '';
        echo do_shortcode('[tw_sermon category_ids="' . $tag_ids . '" count="3" not_in="' . $post->ID . '" column="3" height="' . tw_option('sermon_height') . '" pagination="none"]');
        echo '</div>';
        echo '</div>';
    }
}

function tw_social() {
    global $tw_socials;
    foreach ($tw_socials as $key => $social) {
        if (tw_option($social['name']) != "") {
            echo '<a href="' . (str_replace('*', tw_option($social['name']), $social['link'])) . '" target="_blank" title="' . $key . '" class="' . $key . '"><span class="tw-icon-' . $key . '"></span></a>';
        }
    }
}

function tw_get_socials($socialNames = array()) {
    global $tw_socials;
    $output = '';
    foreach ($tw_socials as $key => $social) {
        if (!empty($socialNames[$social['name']])) {
            $output.='<a href="' . (str_replace('*', $socialNames[$social['name']], $social['link'])) . '" target="_blank" title="' . $key . '" class="' . $key . '"><span class="tw-icon-' . $key . '"></span></a>';
        }
    }
    return $output;
}

function waves_social_share() {
    $output = '<div class="tw_post_sharebox clearfix">';

    if (tw_option('facebook_share')) {
        $output .= '<div class="facebook-share"><a href="#" title="Share this"><i class="fa fa-facebook"></i><span class="count">'.tw_facebook_count(get_permalink()).'</span></a></div>';
    }
    if (tw_option('googleplus_share')) {
        $output .= '<div class="googleplus-share"><a href="#" title="Share this"><i class="fa fa-google-plus"></i><span class="count">'.tw_googleplus_count(get_permalink()).'</span></a></div>';
    }
    if (tw_option('twitter_share')) {
        $post_title = get_the_title();
        $output .= '<div class="twitter-share"><a href="#" title="Tweet" data-title="'.$post_title.'"><i class="fa fa-twitter"></i><span class="count">'.tw_twitter_count(get_permalink()).'</span></a></div>';
    }
    if (tw_option('pinterest_share')) {
        $post_image = waves_image(0, 0, true);
        $output .= '<div class="pinterest-share"><a href="#" title="Pin It" data-image="'.$post_image.'"><i class="fa fa-pinterest"></i><span class="count">'.tw_pinterest_count(get_permalink()).'</span></a></div>';
    }
    if (tw_option('linkedin_share')) {
        $output .= '<div class="linkedin_share"><a href="https://www.linkedin.com/cws/share?url='.get_permalink().'&title='.get_the_title().'&summary='.get_the_excerpt().'" title="Linkedin Share" data-image="'.$post_image.'"><i class="fa fa-linkedin"></i></a><script type="in/share" data-url="' . get_permalink() . '" data-counter="right"></script></div>';
    }
    $output .= '</div>';

    return $output;
}

function isMobile() {
    return(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']));
}

function tw_onepage_header() {
    global $post;
    $oneContent = '';
    $args = array(
        'post_type' => 'slider',
    );
    if (get_metabox('onepage_slider_category') != '') {
        $args['tax_query'] = Array(Array(
                'taxonomy' => 'slider_cat',
                'terms' => get_metabox('onepage_slider_category'),
                'field' => 'slug'
            )
        );
    }
    $the_query = new WP_Query($args);

    // The Loop
    if ($the_query->have_posts()) {
        $oneContent .= '<div class="onepage-header-content">';
        $oneContent .= '<div class="onepage-slider-container">';
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $oneContent .= '<div class="onepage-slider-item" data-time="' . get_metabox('slider_item_time') . '">';
            if (get_post_meta($post->ID, 'waves_metabox_shortcode', true)) {
                $oneContent .= get_post_meta($post->ID, 'waves_metabox_shortcode', true);
            } else {
                $oneContent .= get_the_content();
            }
            $oneContent .= '</div>';
        }
        $oneContent .= '</div>';
        $oneContent .= '</div>';
    }

    wp_reset_postdata();
    $bgClass = 'onepage-header-bg-container';
    $output = '<div class="onepage-header-container">';
    if (get_metabox('onepage_header') == 'image') {
        $output .= '<div class="' . $bgClass . ' onepage-header-image" style="background-image:url(' . waves_image(0, 0, true) . ');"></div>';
        $output .= $oneContent;
    } elseif (get_metabox('onepage_header') == 'slide') {
        $output .= '<div class="' . $bgClass . ' onepage-header-slide-container">';
        $output .= '<div class="onepage-header-slide">';
        $ids = get_post_meta($post->ID, 'gallery_image_ids', true);
        if (!empty($ids)) {
            foreach (explode(',', $ids) as $id) {
                if (!empty($id)) {
                    $output .= '<div class="onepage-slide-item">';
                    $output .= '<img src="' . wp_get_attachment_url($id) . '">';
                    $output .= '</div>';
                }
            }
        }
        $output .= '</div>';
        $output .='</div>';
        $output .= $oneContent;
    } elseif (get_metabox('onepage_header') == 'video') {
        add_action('wp_footer', 'waves_jplayer_script');
        $output .= '<div class="' . $bgClass . ' onepage-header-video"><div class="video-mask"></div><div class="video-mask-color"></div><div class="background-video"><div id="jquery_jplayer_' . $post->ID . '" class="jp-jplayer jp-jplayer-bgvideo" data-pid="' . $post->ID . '" data-m4v="' . get_metabox('onepage_video_m4v') . '" data-thumb=""></div></div></div>';
        $output .= $oneContent;
    } else {
        $output .= get_metabox("onepage_slider");
    }
    $output .= '</div>';
    return do_shortcode($output);
}

function tw_twitter_count($url) {
    return 0;
    try {
        $contents = file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url=' . $url);
    } catch (Exception $e) {
        return 0;
    }
    if ($contents) {
        return json_decode($contents)->count;
    } else {
        return 0;
    }
}

function tw_facebook_count($url) {
    return 0;
    try {
        $contents = file_get_contents("http://graph.facebook.com/fql?q=SELECT%20url,%20total_count%20FROM%20link_stat%20WHERE%20url='" . $url . "'");
    } catch (Exception $e) {
        return 0;
    }
    if ($contents) {
        $json = json_decode($contents);
        return isset($json->data[0]->total_count) ? $json->data[0]->total_count : 0;
    } else {
        return 0;
    }
}

function tw_googleplus_count($url) {
    return 0;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://clients6.google.com/rpc?key=" . tw_option('googleplus_api'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p",
        "params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},
        "jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    $curl_results = curl_exec($ch);
    curl_close($ch);

    if ($curl_results) {
        $json = json_decode($curl_results, true);
        if (!isset($json[0]['error'])) {
            return $json[0]['result']['metadata']['globalCounts']['count'];
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

function tw_pinterest_count($url) {
    return 0;
    $contents = file_get_contents('http://api.pinterest.com/v1/urls/count.json?callback=&url=' . $url);
    if ($contents) {
        $contents = preg_replace('/.+?({.+}).+/', '$1', $contents);

        $json = json_decode($contents);
        return $json->count !== '-' ? $json->count : 0;
    } else {
        return 0;
    }
}

// jPlayer

function waves_jplayer_script() {
    wp_enqueue_script('waves_jplayer_script', THEME_DIR . '/assets/js/jquery.jplayer.min.js', false, false, true);
}

// Parallax script

function waves_parallax_script() {
    wp_enqueue_script('parallax', THEME_DIR . '/assets/js/jquery.parallax-1.1.3.js', false, false, true);
}

// Post Image Show

function waves_image($width = 0, $height = "", $returnURL = false) {
    global $post;
    $attachment = get_post(get_post_thumbnail_id($post->ID));
    if (!empty($attachment)) {
        $alt0 = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
        $alt = !empty($alt0) ? $alt0 : $attachment->post_title;
        $lrg_img = wp_get_attachment_image_src($attachment->ID, 'full');
        if ($width != 0) {
            $resize = aq_resize($lrg_img[0], $width, $height, true);
        }
        $url = !empty($resize) ? $resize : $lrg_img[0];
        if (!$returnURL) {
            return '<img src="' . $url . '" alt="' . $alt . '"/>';
        } else {
            return $url;
        }
    }
}

// ThemeWaves Pagination

function waves_pagination() {
    global $wp_query;
    $pages = $wp_query->max_num_pages;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    if (empty($pages)) {
        $pages = 1;
    }
    if (1 != $pages) {
        $big = 9999; // need an unlikely integer
        echo "<div class='waves-pagination'>";
        $pagination = paginate_links(
                array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'end_size' => 3,
                    'mid_size' => 6,
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $wp_query->max_num_pages,
                    'type' => 'list',
                    'prev_text' => __('<i class="fa fa-angle-double-left"></i>', 'waves'),
                    'next_text' => __('<i class="fa fa-angle-double-right"></i>', 'waves'),
                )
        );
        echo $pagination;
        echo "</div>";
    }
}

function waves_infinite() {
    global $wp_query;
    $pages = intval($wp_query->max_num_pages);
    $paged = (get_query_var('paged')) ? intval(get_query_var('paged')) : 1;
    if (empty($pages)) {
        $pages = 1;
    }
    if (1 != $pages) {
        echo '<div class="tw-pagination tw-infinite-scroll align-center" data-has-next="' . ($paged === $pages ? 'false' : 'true') . '">';
        echo '<a class="no-more" href="#">+</a>';
        echo '<a class="loading" href="#"><i class="fa fa-cog fa-spin"></i></a>';
        echo '<a class="next" href="' . get_pagenum_link($paged + 1) . '">VIEW MORE...</a>';
        echo '</div>';
    }
}

function waves_blogcontent($atts) {
    global $more;
    $more = 0;

    if (!empty($atts['excerpt_count'])) {
        echo apply_filters("the_excerpt", waves_excerpt(strip_shortcodes(get_the_content()), $atts['excerpt_count']));
    } elseif (has_excerpt()) {
        the_excerpt();
    } elseif (waves_has_more()) {
        the_content("");
    } else {
        echo apply_filters("the_excerpt", get_the_content(""));
    }
}

function waves_excerpt($str, $length) {
    $str = explode(" ", strip_tags($str));
    return implode(" ", array_slice($str, 0, $length));
}

function waves_has_more() {
    global $post;
    if (empty($post))
        return;
    return (bool) preg_match('/<!--more(.*?)?-->/', $post->post_content);
}

function waves_comment_count() {
    $comment_count = get_comments_number('0', '1', '%');
    return __('Comments:', 'waves') . " <a href='" . get_comments_link() . "' title='" . $comment_count . "'>" . $comment_count . "</a>";
}

function waves_item($atts, $class = '', $data = '', $style = '') {
    wp_enqueue_style('waves-animate', WAVES_DIR . 'assets/css/animate-custom.css');
    if (!empty($atts['layout_size']) && $atts['layout_size'] === 'col-md-3') {
        $atts['size'] = 'col-md-12';
    }
    if (!empty($atts['size'])) {
        $class.= ' ' . $atts['size'];
        if (!empty($atts['full_layout']) && $atts['full_layout'] === 'true' && $atts['size'] === 'col-md-12') {
            $class.= ' waves-full-element';
        }
    }
    if (!empty($atts['class'])) {
        $class.= ' ' . $atts['class'];
    }
    $animated = false;
    if (isset($atts['animation']) && $atts['animation'] !== 'none') {
        $animated = true;
        $class .= ' tw-animate-gen';
        $atts['animation_delay'] = empty($atts['animation_delay']) ? '0' : str_replace(' ', '', $atts['animation_delay']);
        $style .='opacity:0;';
        $data.='data-animation="' . $atts['animation'] . '" data-animation-delay="' . $atts['animation_delay'] . '" data-animation-offset="90%"';
    }

    $output = '<div class="tw-element ' . $class . '" style="' . $style . '" ' . $data . '>';
    if (!empty($atts['title'])) {
        $output .= '<div class="waves-title"><h3>' . rawUrlDecode($atts['title']) . '<span class="title-seperator"></span></h3></div>';
    }
    return $output;
}

add_shortcode('tw_item_title', 'waves_item_title');

function waves_item_title($atts, $content) {
    $atts = shortcode_atts(array(
        'title' => '',
            ), $atts);
    $output = '<div class="waves-title"><h3>' . rawUrlDecode($atts['title']) . '</h3></div>';
    return $output;
}

function waves_like() {
    global $post;
    $likeit = get_post_meta($post->ID, 'post_likeit', true);
    $likecount = empty($likeit) ? '0' : $likeit;
    $likedclass = 'likeit';
    if (isset($_COOKIE['likeit-' . $post->ID])) {
        $likedclass .= ' liked';
    }
    $output = '<span data-ajaxurl="' . home_url() . '" data-pid="' . $post->ID . '" class="' . $likedclass . '">';
    $output .= '<i class="fa fa-heart"></i><span>' . $likecount . (is_single() ? __(' Likes', 'themewaves') : '') . '</span>';
    $output .= '</span>';
    return $output;
}

if (isset($_REQUEST['liked_pid'])) {
    $pid = intval($_REQUEST['liked_pid']);
    $liked = get_post_meta($pid, 'post_likeit', true);
    if (!isset($_COOKIE['likeit-' . $pid])) {
        if (empty($liked)) {
            $liked = 1;
        } else {
            $liked = (intval($liked) + 1);
        }
        update_post_meta($pid, 'post_likeit', $liked);
        setcookie('likeit-' . $pid, 1);
    }
    print "<div><div id='post_liked'>$liked</div></div>";
    die;
}

add_filter('widget_tag_cloud_args', 'set_tag_cloud_sizes');

function set_tag_cloud_sizes($args) {
    $args['smallest'] = 14;
    $args['largest'] = 14;
    $args['number'] = 8;
    $args['format'] = 'flat';
    $args['unit'] = 'px';
    return $args;
}