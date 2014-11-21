<?php
    global $tw_isshortcode;
    $tw_isshortcode='false';
    
    // Load from theme
    define('WAVES_PATH', THEME_PATH.'/framework/');
    define('WAVES_DIR', THEME_DIR.'/framework/');
    define('WAVES_SHORTCODE'  , 'waves_metabox_shortcode');
    define('WAVES_PAGEBUILDER', 'waves_metabox_pagebuilder');
    
    
    global $waves_elementfiles;
    $waves_elementfiles = array(
        'accordion','before_after','blog','bottom','button','calendar','callout','chart_circle','chart_graph','chart_pie','column','comingsoon','contact','content',
        'divider','dropcap','event','fonticon','heading','image_slider','label','list','map','messagebox','milestones','partner','portfolio','progress',
        'carousel_events','carousel_posts','service','sermon','carousel_sermons','sidebar','slider','social','tab','team','testimonials','text_carousel','toggle','twitter','video'
    );

    if(!is_admin()){
        
        //====== Front-End Includes  ======//
        
        require_once WAVES_PATH.'aq_resizer.php';
        require_once WAVES_PATH.'pagebuilder/elements-render/layout.php';
        foreach($waves_elementfiles as $file){
            require_once (WAVES_PATH . "pagebuilder/elements-render/$file.php");
        }
        
        
        add_filter('the_content', 'waves_page_content');
        function waves_page_content($content){
            if(tw_option('pagebuilder')) {
                global $post,$tw_isshortcode;
                $waves_content = ($tw_isshortcode==='true'||!isset($post->ID))?false: get_post_meta($post->ID, WAVES_SHORTCODE, true);
                if($waves_content&&!post_password_required()){
                    return do_shortcode($waves_content);
                }
            }
            return $content;
        }
        
    } else {        
        //====== Back-End ======//
        require_once WAVES_PATH.'pagebuilder/waves-builder.php';
    }
?>