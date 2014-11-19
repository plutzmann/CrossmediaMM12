<?php
/* ================================================================================== */
/*      Sermon Shortcode
/* ================================================================================== */

if (!function_exists('shortcode_tw_sermon')) {

    function shortcode_tw_sermon($atts, $content) {
        $atts = shortcode_atts(array(
            'size'  => 'col-md-12',
            'class' => '',
            'title' => '',
            'layout' => 'col3',
            'layout_type' => 'default',
            'column' => '3',
            'layout_size' => 'col-md-12',
            'pagination' => 'simple',
            'height' => '',
            'count' => 9,
            'filter' => 'false',
            'category_ids' => '',
            'order' => 'date_desc',
            'not_in' => ''
        ), $atts);
        
        global $paged;

        if (get_query_var('paged'))
            $my_page = get_query_var('paged');
        else {
            if (get_query_var('page'))
                $my_page = get_query_var('page');
            else
                $my_page = 1;
            set_query_var('paged', $my_page);
        }
        add_action('wp_footer', 'waves_portfolio_script');
        $query = Array(
            'post_type' => 'tw-sermon',
            'posts_per_page' => $atts['count'],
        );
        if(!empty($atts['not_in'])) {
            $query['post__not_in'] = array($atts['not_in']);
        }
        if ($atts['pagination'] == "simple" || $atts['pagination'] == "infinite") {
            $query['paged'] = $my_page;
        }
        $cats = empty($atts['category_ids']) ? false : explode(",", $atts['category_ids']);
        if ($cats) {
            $query['tax_query'] = Array(Array(
                    'taxonomy' => 'sermon_cat',
                    'terms' => $cats,
                    'field' => 'slug'
                )
            );
        }
        if ($atts['order']!='date_desc') {
            switch ($atts['order']) {
                case "date_asc":
                    $query['orderby'] = 'date';
                    $query['order'] = 'ASC';                    
                    break;
                case "title_asc":
                    $query['orderby'] = 'title';
                    $query['order'] = 'ASC';                    
                    break;
                case "title_desc":
                    $query['orderby'] = 'title';
                    $query['order'] = 'DESC';
                    break;
                case "random":
                    $query['orderby'] = 'rand';
                    break;
            }
        }
        switch ($atts['layout']) {
            default :
                $atts['column'] = 3;
                $atts['width'] = 370;
                break;
            case 'col4':
                $atts['column'] = 4;
                $atts['width'] = 270;
                break;
        }
        
        $output = waves_item($atts,'waves-sermon '.$atts['layout']);
            if ($atts['filter'] == 'true') {
                $output .= '<div class="tw-filters">';
                    $output .= '<ul class="filters clearfix" data-option-key="filter">';
                        $output .= '<li><a href="#filter" data-option-value="*" class="show-all selected">'.__('Show All', 'themewaves').'</a></li>';
                        if ($cats) {
                            $filters = $cats;
                        } else {
                            $filters = get_terms('sermon_cat');
                        }
                        foreach ($filters as $category) {
                            if ($cats) {
                                $category = get_term_by('slug', $category, 'sermon_cat');
                            }
                            $output .= '<li class="hidden"><a href="#filter" data-option-value=".category-' . $category->slug . '" title="' . $category->name . '">' . $category->name . '</a></li>';
                        }
                    $output .= '</ul>';
                $output .= '</div>';
            }
            if(!is_tax()){
                query_posts($query);
            }
            $output .= '<div class="row">';
                $output .= '<div class="isotope-container" data-column="'.$atts['column'].'">';
                        while (have_posts()){ the_post();
                            $output .= call_user_func('waves_sermon_loop', $atts);
                        }
                $output .= '</div>';
            $output .= '</div>';
            ob_start();
                if($atts['pagination']=="simple"){
                    waves_pagination();
                }elseif($atts['pagination']=="infinite"){
                    waves_infinite();
                }
            $output .= ob_get_clean();
            wp_reset_query();
        $output .= '</div>';
        return $output;

    }
}

add_shortcode('tw_sermon', 'shortcode_tw_sermon');

function waves_sermon_loop($atts) {
    global $post;
    $artClass='not-inited';
    $image='';
    $imageLrg='';
    if(waves_image(0, 0, true)){
        $image = waves_image($atts['width'], $atts['height'], true);
    }elseif(get_metabox('format_video_thumb')){
        $image = aq_resize(get_metabox('format_video_thumb'), $atts['width'], $atts['height'], true);
    }
    if(get_metabox('format_video_thumb')){
        $imageLrg = get_metabox('format_video_thumb');
    }else{
        $imageLrg = waves_image(0, 0, true);
    }
    
    $cats = wp_get_post_terms($post->ID, 'sermon_cat');
    foreach ($cats as $catalog) {
        $artClass .= " category-" . $catalog->slug;
    }
    $btn = 'play video';
    $media = '<textarea class="sermon-video hidden">';
        ob_start();
            the_content();
        $text = ob_get_clean();
        if(get_metabox('format_audio_mp3')){
            add_action('wp_footer', 'waves_jplayer_script');
            ob_start();
                the_post_thumbnail();
                waves_sermon_jplayer_audio($post->ID,get_metabox('format_audio_mp3'),$imageLrg);
            $media .= ob_get_clean();
            $media .= $text;
            $btn = 'play audio';
        }elseif(get_metabox('format_video_embed')){
            $media .= apply_filters("the_content", htmlspecialchars_decode(get_metabox('format_video_embed')));
            $media .= $text;
            $btn = 'play';
        }elseif(get_metabox('format_video_m4v')){
            add_action('wp_footer', 'waves_jplayer_script');
            ob_start();
                waves_sermon_jplayer_video($post->ID,get_metabox('format_video_m4v'),$imageLrg);
            $media .= ob_get_clean();
            $media .= $text;
        }else{
            $media .= '<img src="'.$imageLrg.'" />';
            $media .= $text;
            $btn = 'view';
        }
    $media .= '</textarea>';

    $content  = '<h2 class="sermon-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>';
    $content .= '<div class="sermon-meta">';
        $content .= '<span>'.get_the_date('F jS,Y').'</span>';
    $content .= '</div>';

    $output = '<article class="sermon '.$artClass.'">';
        $output .= '<div class="gallery-thumb">';
            $output .= '<img src="'.$image.'" />';
            $output .= '<div class="image-overlay"></div>';
            $output .= '<div class="sermon-hover">';
                if($btn==='view'||$btn==='play audio'){$output .= '<a href="'.get_the_permalink().'">';}
                $output .= '<span>'.$btn.'</span>';
                if($btn==='view'||$btn==='play audio'){$output .= '</a>';}
            $output .= '</div>';
        $output .= '</div>';
        $output .= '<div class="sermon-content">';
            $output .= $content;
        $output .= '</div>';
        // For sermon Modal Box
        $output .= $media;
    $output .= '</article>';
    return $output;
}
/* ================================================================================== */
/*      jPlayer Video
/* ================================================================================== */
function waves_sermon_jplayer_video($id, $url, $thumb) { ?>
    <div id="jquery_jplayer_<?php echo $id; ?>" class="jp-jplayer jp-jplayer-video" data-pid="<?php echo $id; ?>" data-m4v="<?php echo $url; ?>" data-thumb="<?php echo $thumb; ?>"></div>
    <div class="jp-video-container">
        <div class="jp-video">
            <div class="jp-type-single">
                <div id="jp_interface_<?php echo $id; ?>" class="jp-interface">
                    <ul class="jp-controls">
                        <li><div class="seperator-first"></div></li>
                        <li><div class="seperator-second"></div></li>
                        <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                        <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                        <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                        <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                    </ul>
                    <div class="jp-progress-container">
                        <div class="jp-progress">
                            <div class="jp-seek-bar">
                                <div class="jp-play-bar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="jp-volume-bar-container">
                        <div class="jp-volume-bar">
                            <div class="jp-volume-bar-value"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }


/* ================================================================================== */
/*      jPlayer Audio
/* ================================================================================== */

function waves_sermon_jplayer_audio($id, $url) { ?>
    <div id="jquery_jplayer_<?php echo $id; ?>" class="jp-jplayer jp-jplayer-audio" data-pid="<?php echo $id; ?>" data-mp3="<?php echo $url; ?>"></div>
    <div class="jp-audio-container">
        <div class="jp-audio">
            <div class="jp-type-single">
                <div id="jp_interface_<?php echo $id; ?>" class="jp-interface">
                    <ul class="jp-controls">
                        <li><div class="seperator-first"></div></li>
                        <li><div class="seperator-second"></div></li>
                        <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                        <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                        <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                        <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                    </ul>
                    <div class="jp-progress-container">
                        <div class="jp-progress">
                            <div class="jp-seek-bar">
                                <div class="jp-play-bar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="jp-volume-bar-container">
                        <div class="jp-volume-bar">
                            <div class="jp-volume-bar-value"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }