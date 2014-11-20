<?php
/* ================================================================================== */
/*      Blog Shortcode
/* ================================================================================== */

function waves_blog($atts, $content) {
    global $paged;
    global $tw_isshortcode;
    $tw_isshortcode='true';
    $atts = shortcode_atts(array(
        'size'  => 'col-md-12',
        'class' => '',
        'title' => '',
        'full_layout' => 'false',
        'layout'    => 'grid3',
        'post_count'    => get_option('posts_per_page'),
        'image_height'  => '0',
        'category_ids'  => '',
        'pagination'    => 'true',
        'order'          => 'date_desc',
    ), $atts);
    $output = waves_item($atts,'waves-blog '.$atts['layout'].'-blog');
    
    $start = $end = '';
//    if($atts['layout']=='grid2'||$atts['layout']=='grid3') {
        add_action('wp_footer', 'waves_portfolio_script');
        add_action('wp_footer', 'waves_jplayer_script');
        $start .= '<div class="row blog-grid">';
        $end = '</div>';
//    }
    $query = Array(
        'post_type' => 'post',
        'posts_per_page' => $atts['post_count'],
        'paged' => $paged,
    );
    $cats = empty($atts['category_ids']) ? false : explode(",", $atts['category_ids']);
    if ($cats) {
        $query['tax_query'] = Array(Array(
                'taxonomy' => 'category',
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
    ob_start();
    query_posts($query);
    if (have_posts()) {
        echo $start;        
            if($atts['layout']=='grid2') { 
                while (have_posts()) { the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('col-md-6'); ?>>
                        <?php call_user_func('waves_loop_gridblog', $atts); ?>
                    </article><?php
                }
            } else {
                while (have_posts()) { the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4'); ?>>
                        <?php call_user_func('waves_loop_gridblog', $atts); ?>
                    </article><?php
                }
            }
        echo $end;
        if ($atts['pagination'] == 'true') {
            if($atts['pagination']==='infinite'){waves_infinite();}
            else{waves_pagination();}
        }
    }
    wp_reset_query();
    $output .= ob_get_clean();
    $output .= '</div>';
    $tw_isshortcode='false';
    return $output;
}
add_shortcode('tw_blog', 'waves_blog');


function waves_loop_gridblog($atts){
    global $post;
    $format = get_post_format() == "" ? "standard" : get_post_format();
    $content = true;
    
    echo '<div class="entry-blogitem">';
    
    ob_start();
    if($format == 'standard') {
        echo waves_standard_media($post, $atts);        
    } else {
        $media = waves_entry_media($post, $format, $atts);
        if($media){
            echo $media;
            if($format=='aside' || $format=='link' || $format=='status'){
                $content = false;
            }
        } else {
            echo waves_standard_media($post, $atts);            
        }        
    }
    $entrymedia = ob_get_clean();
    echo $entrymedia;
    
    if($content) {
        if(empty($entrymedia)){
            echo '<div class="entry-block no-media">';
            echo '<h2 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
            echo '<span class="entry-author">'. __('By:', 'waves').' '; the_author_posts_link(); echo '</span>';
            echo '<div class="entry-content clearfix">';
                $atts['excerpt_count'] = 20;
                waves_blogcontent($atts);
            echo '</div>';
        } else {
            echo '<div class="entry-block">';
            echo '<span class="entry-date"><span class="date">'; the_time('d'); echo '</span><span class="month">';the_time('M'); echo '</span></span>';
            echo '<h2 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
            echo '<span class="entry-author">'. __('By:', 'waves').' '; the_author_posts_link(); echo '</span>';
        }        
        echo '</div>';
    } 
    
    echo '</div>';
}

function waves_standard_media($post, $atts){
    $output = '';
    if (has_post_thumbnail($post->ID)) {
        $output .= '<div class="entry-media">';
            $output .= '<div class="waves-thumbnail">';
                $width = $atts['layout'] == 'grid2' ? 570 : ($atts['layout'] == 'grid3' ? 370 : 870);
                $height = $atts['image_height'];
                $output .= waves_image($width, $height);
                $output .= '<div class="image-overlay"></div>';
            $output .= '</div>';
        $output .= '</div>';
    }
    return $output;
}

function waves_entry_media($post, $format, $atts) {
    $output = '';
    switch ($format) {
        
        case 'image':
            
            $ids = get_post_meta($post->ID, 'gallery_image_ids', true);
            $height = $atts['image_height'];
            $width = $atts['layout'] == 'grid' ? 370 : 850;
            if (!empty($ids) && $ids !== 'false') {
                $output .= '<div class="entry-media image-slide-container list_carousel clearfix">';
                    $output .= '<div class="waves-carousel">';
                        foreach (explode(',', $ids) as $id) {
                            if (!empty($id)) {
                                $imgurl0 = aq_resize(wp_get_attachment_url($id), $width, $height, true);
                                $imgurl = !empty($imgurl0) ? $imgurl0 : wp_get_attachment_url($id);
                                $imagelink = is_single() ? (wp_get_attachment_url($id).'" rel="prettyPhoto[gallery]') : get_permalink();
                                $output .= '<div class="tw-owl-item">';
                                    $output .= '<a href="'.$imagelink.'"><img src="'.$imgurl.'" alt="'.get_the_title().'"></a>';
                                $output .= '</div>';
                            }
                        }
                    $output .= '</div>';
                $output .= '</div>';
            }
            break;
            
        case 'gallery':
            
            $ids = get_post_meta($post->ID, 'gallery_image_ids', true);
            $height = $atts['image_height'];
            $width = 300;
            if (!empty($ids) && $ids !== 'false') {
                $output .= '<div class="entry-media clearfix">';
                    foreach (explode(',', $ids) as $id) {
                        if (!empty($id)) {
                            $imgurl0 = aq_resize(wp_get_attachment_url($id), $width, $height, true);
                            $imgurl = !empty($imgurl0) ? $imgurl0 : wp_get_attachment_url($id);
                            $imagelink = is_single() ? (wp_get_attachment_url($id).'" rel="prettyPhoto['.$post->ID.']') : get_permalink();
                            $output .= '<div class="gallery-item">';
                                $output .= '<a href="'.$imagelink.'"><img src="'.$imgurl.'" alt="'.get_the_title().'"></a>';
                            $output .= '</div>';
                        }
                    }
                $output .= '</div>';
            }
            break;
            
        case 'video':
            
            $embed = get_post_meta($post->ID, 'format_video_embed', true);
            $thumb = get_post_meta($post->ID, 'format_video_thumb', true);
            $url = get_post_meta($post->ID, 'format_video_m4v', true);
            if(!empty($embed) || !empty($url)) {
                $output .= '<div class="entry-media">';
                    if (!empty($embed)) {
                        $output .= apply_filters("the_content", htmlspecialchars_decode($embed));
                    } else {
                        if (!empty($url)) {
                            add_action('wp_footer', 'waves_jplayer_script');
                            waves_jplayer_video($post->ID, $url, $thumb);
                        }
                    }
                $output .= '</div>';
            }
            break;
            
        case 'audio':
            
            $url = get_post_meta($post->ID, 'format_audio_mp3', true);
            $embed = get_post_meta($post->ID, 'format_audio_embed', true);

            if(!empty($embed) || !empty($url)) {                
                $output .= '<div class="entry-media">';
                    if (!empty($embed)) {                    
                        $output .= apply_filters("the_content", htmlspecialchars_decode($embed));                    
                    } else {
                        add_action('wp_footer', 'waves_jplayer_script');
                        ob_start();
                            the_post_thumbnail();
                            waves_jplayer_audio($post->ID, $url);
                        $output .= ob_get_clean();
                    }                
                $output .= '</div>';
            }
            break;
        case 'aside':
            if(!is_single()) {
                $output .= '<div class="entry-aside">';
                $output .= '<h2 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
                ob_start();
                    waves_blogcontent($atts);
                $blogcontent = ob_get_clean();
                if(!empty($blogcontent)){
                    $output .= '<div class="entry-content clearfix">';
                        $output .= $blogcontent;
                    $output .= '</div>';
                }
                $output .= '</div>';
            }
            break;
            
        case 'quote':
            
            $quote_text = get_post_meta($post->ID, 'format_quote_text', true);
            if (!empty($quote_text)) {
                $output .= '<div class="entry-media">';
                    $output .= '<blockquote>';
                    $output .= "<h2 class='quote-text'>" . $quote_text . "</h2>";
                    $output .= "</blockquote>";
                $output .= '</div>';
            }
            break;
            
        case 'link':
            
            $link_url = get_post_meta($post->ID, 'format_link_url', true);
            if(!empty($link_url)){
                    $output .= '<div class="link-content">';
                    $output .= '<h2 class="link-text"><a href="' . esc_url($link_url) . '" target="_blank">' . get_the_title() . '</a></h2>';
                    $output .= '<a href="' . esc_url($link_url) . '" target="_blank"><span class="sub-title">' . $link_url . '</span></a></div>';
            }
            break;
            
        case 'status':
            
            $status_url = get_post_meta($post->ID, 'format_status_url', true);
            if (!empty($status_url)) {
                $output .= '<div class="entry-media">';
                    $output .= apply_filters("the_content", $status_url);
                $output .= '</div>';
            }
            break;
    }
    return $output;
}





/* ================================================================================== */
/*      jPlayer Audio
/* ================================================================================== */

function waves_jplayer_audio($id, $url) { ?>
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



/* ================================================================================== */
/*      jPlayer Video
/* ================================================================================== */

function waves_jplayer_video($id, $url, $thumb) { ?>
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