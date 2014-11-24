<?php
define('THEME_PATH', get_template_directory());
define('THEME_DIR', get_template_directory_uri());
define('STYLESHEET_PATH', get_stylesheet_directory());
define('STYLESHEET_DIR', get_stylesheet_directory_uri());

require_once (THEME_PATH . "/admin/index.php");
require_once (THEME_PATH . "/framework/index.php");
require_once (THEME_PATH . "/framework/waves_custom_menu.php");
require_once (THEME_PATH . "/framework/theme_functions.php");
require_once (THEME_PATH . "/framework/sidebar_generator.php");
require_once (THEME_PATH . "/framework/post-type.php");
require_once (THEME_PATH . "/framework/googlefonts.php");

if (is_admin()) {
    require_once (THEME_PATH . "/framework/metabox-render.php");
    require_once (THEME_PATH . "/framework/post-metabox.php");
    require_once (THEME_PATH . "/framework/post-format.php");

    require_once (THEME_PATH . "/framework/plugins/install-plugin.php");
}


require_once (THEME_PATH . "/framework/widget/recent_posts_widget.php");
require_once (THEME_PATH . "/framework/widget/recent_portfolios_widget.php");
require_once (THEME_PATH . "/framework/widget/dribbble_widget.php");
require_once (THEME_PATH . "/framework/widget/flickr_widget.php");
require_once (THEME_PATH . "/framework/widget/social_links_widget.php");
require_once (THEME_PATH . "/framework/widget/twitter_widget.php");
require_once (THEME_PATH . "/framework/widget/contact_widget.php");
require_once (THEME_PATH . "/framework/theme_css.php");




/* ================================================================================== */
/*      Register menu
  /* ================================================================================== */

register_nav_menus(array(
    'main' => 'Main Menu'// EX   'right' => 'Right Menu'
));


/* ================================================================================== */
/*      Theme Supports
  /* ================================================================================== */

add_action('after_setup_theme', 'themewaves_setup');
if (!function_exists('themewaves_setup')) {

    function themewaves_setup() {
        add_editor_style();
        add_theme_support('post-thumbnails');
        add_theme_support('post-formats', array('aside', 'video', 'audio', 'gallery', 'image', 'quote', 'status', 'link'));
        add_theme_support('automatic-feed-links');
        add_theme_support('woocommerce');
        load_theme_textdomain('themewaves', THEME_PATH . '/languages/');
    }

}
if (!isset($content_width))
    $content_width = 1140;



/* ================================================================================== */
/*      Enqueue Scripts
  /* ================================================================================== */

add_action('wp_enqueue_scripts', 'themewaves_scripts');

function themewaves_scripts() {
    wp_enqueue_style('mmenu', THEME_DIR . '/assets/css/mmenu.css');
    wp_enqueue_style('waves-bootstrap', THEME_DIR . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('waves-prettyphoto', THEME_DIR . '/assets/css/prettyPhoto.css');
    wp_enqueue_style('waves-animate', THEME_DIR . '/assets/css/animate.css');
    wp_enqueue_style('waves-fa', THEME_DIR . '/assets/css/font-awesome.min.css');
    wp_enqueue_style('themewaves', STYLESHEET_DIR . '/style.css');
	wp_enqueue_style('themewaves', STYLESHEET_DIR . '/custom.css');
    wp_enqueue_style('waves-responsive', THEME_DIR . '/assets/css/responsive.css');


    $protocol = is_ssl() ? 'https' : 'http';
    global $tw_simplefonts;
    $tw_googlefonts = array(
        tw_option('body_text_font', 'face'),
        tw_option('page_title', 'face'),
        tw_option('element_title', 'face'),
        tw_option('sidebar_widgets_title', 'face'),
        tw_option('menu_font', 'face'),
        tw_option('footer_widgets_title', 'face'),
        tw_option('heading_font'),
    );
    $googlefont = '';
    foreach ($tw_googlefonts as $font) {
        if (!in_array($font, $tw_simplefonts)) {
            $googlefont = str_replace(' ', '+', $font) . ':' . tw_option('google_font_weight') . '|' . $googlefont;
        }
    }
    if ($googlefont != '')
        wp_enqueue_style('google-font', "$protocol://fonts.googleapis.com/css?family=" . substr_replace($googlefont, "", -1) . "&subset=" . tw_option('google_font_subset'));

    wp_enqueue_script('jquery');

    wp_localize_script('jquery', 'waves_script_data', array(
        'pageloader'=> tw_option('pageloader')
    ));

    wp_enqueue_script('waves-scripts', THEME_DIR . '/assets/js/scripts.js', false, false, true);
    wp_enqueue_script('waves-script', THEME_DIR . '/assets/js/waves-script.js', false, false, true);

    if (is_single() && comments_open())
        wp_enqueue_script('comment-reply');
    if (tw_option('smooth_scroll'))
        wp_enqueue_script('tw_scroll', THEME_DIR . '/assets/js/smoothscroll.js', false, false, true);

    if (tw_option('pageloader'))
        wp_enqueue_script('tw_pageloader', THEME_DIR . '/assets/js/pace.min.js', false, false, true);

    wp_enqueue_script('themewaves', THEME_DIR . '/assets/js/themewaves.js', false, false, true);
    
    
    if (preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']))
        wp_enqueue_script('tw_swipe', THEME_DIR . '/assets/js/jquery.touchSwipe.min.js', false, false, true);
}

/* ================================================================================== */
/*      Register Widget Sidebar
  /* ================================================================================== */

if (!function_exists('theme_widgets_init')) {

    function theme_widgets_init() {

        register_sidebar(array(
            'name' => 'Default sidebar',
            'id' => 'default-sidebar',
            'before_widget' => '<aside class="widget %2$s" id="%1$s">',
            'after_widget' => '</aside>',
            'before_title' => '<div class="waves-title"><h3 class="widget-title">',
            'after_title' => '</h3></div>',
        ));

        register_sidebar(array(
            'name' => 'Top widget',
            'id' => 'top-widget',
            'before_widget' => '<div class="tw-top-widget" id="%1$s">',
            'after_widget' => '</div>',
            'before_title' => '<span class="top-widget-title">',
            'after_title' => '</span>',
        ));

        /* footer sidebar */
        $grid = tw_option('footer_layout') != "" ? tw_option('footer_layout') : '3-3-3-3';
        $i = 1;
        foreach (explode('-', $grid) as $g) {
            register_sidebar(array(
                'name' => __("Footer sidebar ", "themewaves") . $i,
                'id' => "footer-sidebar-$i",
                'description' => __('The footer sidebar widget area', 'themewaves'),
                'before_widget' => '<aside class="widget %2$s" id="%1$s">',
                'after_widget' => '</aside>',
                'before_title' => '<div class="tw-widget-title-container"><h3 class="widget-title">',
                'after_title' => '</h3></div>',
            ));
            $i++;
        }
    }

}
add_action('widgets_init', 'theme_widgets_init');
add_filter('widget_text', 'do_shortcode');


add_filter('body_class', 'waves_class');

function waves_class($classes) {
    global $post;
    if (is_page() && tw_option('pagebuilder') && get_post_meta($post->ID, 'waves_metabox_shortcode', true)) {
        $classes[] = 'waves-pagebuilder';
    }
    
    if(get_metabox("menu_position")=="fixed") {
        $classes[] = 'menu-fixed';
    } elseif(get_metabox("menu_position")!="top") {
        if(tw_option('menu_position') == 'fixed') {
            $classes[] = 'menu-fixed';
        }
    }
    
    if (get_metabox("header_transparent") == "true") {
        $classes[] = 'transparent-header';
    } else if (get_metabox("header_transparent") != "false") {
        if (tw_option("header_transparent")) {
            $classes[] = 'transparent-header';
        }
    }
    
    $boxed = false;
    if(get_metabox("theme_layout")=="boxed") {
        $boxed = true;
    } else if(get_metabox("theme_layout")!="fullwidth") {
        if(tw_option("theme_layout")=="boxed") {
            $boxed = true;
        }
    }
    if ($boxed) {
        $classes[] = 'theme-boxed';
    } else {
        $classes[] = 'theme-full';
    }
    
    if (get_metabox("header_color") == "light") {
        $classes[] = 'header-light';
    } else if (get_metabox("header_color") == "dark") {
        $classes[] = 'header-dark';
    } else if (tw_option("header_color") == "light") {
            $classes[] = 'header-light';
    } else if (tw_option("header_color") == "dark") {
            $classes[] = 'header-dark';
    }
    return $classes;
}

/* ================================================================================== */
/*      Exclude pages from search
  /* ================================================================================== */

if (!function_exists('exclude_pages_from_search')) :

    function exclude_pages_from_search($query) {
        if ($query->is_search) {
            $query->set('post_type', array('post', 'tw-sermon', 'page', 'event'));
        }
        return $query;
    }

    add_filter('pre_get_posts', 'exclude_pages_from_search');
endif;





/* ================================================================================== */
/*      Support upload .ico file
  /* ================================================================================== */

if (!function_exists('custom_upload_mimes')) {
    add_filter('upload_mimes', 'custom_upload_mimes');

    function custom_upload_mimes($existing_mimes = array()) {
        $existing_mimes['ico'] = "image/x-icon";
        $existing_mimes['mp4'] = "audio/mp4";
        return $existing_mimes;
    }

}



/* ================================================================================== */
/*      ThemeWaves Search Form Customize
  /* ================================================================================== */

function my_search_form() {

    $form = '<form role="search" method="get" id="searchform" action="' . home_url('/') . '" >
    <div class="input">
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __('Search Here', 'themewaves') . '" />
        <i class="button-search fa fa-search"></i>
    </div>
    </form>';

    return $form;
}

add_filter('get_search_form', 'my_search_form');

/* Wordpress Edit Gallery */
add_filter('use_default_gallery_style', '__return_false');
add_filter('wp_get_attachment_link', 'tw_pretty_gallery', 10, 5);
function tw_pretty_gallery($content, $id, $size = 'large', $permalink) {
    if (!$permalink)
        $content = preg_replace("/<a/", "<a rel=\"prettyPhoto[gallery]\"", $content, 1);
        $content = preg_replace("/<\/a/", "<div class=\"image-overlay\"></div></a", $content, 1);
    return $content;
}
function tw_gallery_atts( $out, $pairs, $atts ) {
    $atts = shortcode_atts( array(
        'columns' => '3',
        'size' => 'large',
         ), $atts );

    $out['columns'] = $atts['columns'];
    $out['size'] = $atts['size'];

    return $out;
}
add_filter( 'shortcode_atts_gallery', 'tw_gallery_atts', 10, 3 );

/* Facebook Open Graph Meta */

function facebookOpenGraphMeta() {
    global $post;
    if (!empty($post->ID)) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
        $image = isset($image[0]) ? $image[0] : '';
        if (!$image) {
            $image = tw_option("theme_logo");
        };
        if (is_single()) {
            ?>
            <meta property="og:url" content="<?php the_permalink() ?>"/>
            <meta property="og:title" content="<?php single_post_title(''); ?>" />
            <meta property="og:description" content="<?php echo strip_tags(get_the_excerpt()); ?>" />
            <meta property="og:type" content="article" />
            <meta property="og:image" content="<?php echo $image; ?>" /><?php
        } else {
            if (!is_page() && tw_option("theme_logo") !== '') {
                $image = tw_option("theme_logo");
            }
            ?>
            <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />  
            <meta property="og:description" content="<?php bloginfo('description'); ?>" />  
            <meta property="og:type" content="website" />  
            <meta property="og:image" content="<?php echo $image; ?>" /> <?php
        }
    }
} ?>