<?php
/* ================================================================================== */
/*      sermons Carousel Shortcode
/* ================================================================================== */
require_once (WAVES_PATH . "pagebuilder/elements-render/sermon.php");
function waves_carousel_sermons($atts, $content) {
    $atts = shortcode_atts(array(
        'size'  => 'col-md-12',
        'class' => '',
        'title' => '',
        'category_ids'  => '',
        'post_count'    => '6',
        'image_height' => '',
        'white_bg' => 'false',
        'description' => '',
        'order'     => 'date_desc',
        'auto_play' => 'false',
        'animation' => 'none',
        'animation_delay' => ''
    ), $atts);
    
    $title = $atts['title'];
    $output = $atts['title'] = '';
    $items = 3;
    $output  .= waves_item($atts,'carousel-container waves-carousel-sermon-container');
        $output .= '<div class="waves-carousel-sermon waves-sermon list_carousel carousel-anim" data-autoplay="'.$atts['auto_play'].'" data-items="'.$items.'">';
            $output .= '<div class="waves-carousel">';
                $query = Array(
                    'post_type' => 'tw-sermon',
                    'posts_per_page' => $atts['post_count'],
                );
                $cats = explode(",", $atts['category_ids']);
                if (!empty($cats[0])) {
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
                // START - LOOP
                query_posts($query);
                $atts['width'] = 380;
                $atts['height'] = !empty($atts['image_height']) ? $atts['image_height'] : 300;
                while (have_posts()){ the_post();
                    $output .= call_user_func('waves_sermon_carousel_loop', $atts);
                }
                wp_reset_query();    
                // END   - LOOP

            $output .= '</div>';        
            $output .= '<div class="clearfix"></div>';
        $output .= '</div>';
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_carousel_sermons', 'waves_carousel_sermons');

function waves_sermon_carousel_loop($atts) {
    global $post;
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

    $output = '<article class="sermon">';
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