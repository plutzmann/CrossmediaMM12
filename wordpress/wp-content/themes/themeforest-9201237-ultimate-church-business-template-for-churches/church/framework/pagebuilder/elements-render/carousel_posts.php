<?php
/* ================================================================================== */
/*      Recent Posts Shortcode
/* ================================================================================== */

function waves_carousel_posts($atts, $content) {
    global $tw_isshortcode, $post;
    $tw_isshortcode='true';
    $atts = shortcode_atts(array(
        'size'  => 'col-md-3',
        'class' => '',
        'title' => '',
        'category_ids'  => '',
        'post_count'    => '6',
        'layout_type'    => '3',
        'ex_count'    => '15',
        'image_height' => '',
        'order'     => 'date_desc',
        'auto_play' => 'true',
        'scroll'     => 'arrow',
        'animation' => 'none',
        'animation_delay' => '',
    ), $atts);
    $output = waves_item($atts,'carousel-container');
        $output .= '<div class="waves-carousel-post list_carousel carousel-anim" data-autoplay="'.$atts['auto_play'].'" data-items="'.$atts['layout_type'].'">';
            $output .= '<div class="waves-carousel">';
                $query = Array(
                    'post_type' => 'post',
                    'posts_per_page' => $atts['post_count'],
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
                // START - LOOP
                query_posts($query);
                while (have_posts()){ the_post();            
                    $output .= '<div class="tw-owl-item">';
                    $format = get_post_format() == "" ? "standard" : get_post_format();
                        $output .= '<div class="carousel-block format-'.$format.'">';
                        $media = '';
                            if(has_post_thumbnail()){
                                ob_start();
                                $width = 380;
                                $height = $atts['image_height'];
                                echo '<div class="carousel-thumbnail waves-thumbnail">';
                                    echo waves_image($width, $height);
                                echo '</div>';
                                $media = ob_get_clean();
                            } else {
                                if($format == 'video' || $format == 'audio' || $format == 'image' || $format == 'gallery') {
                                    $media = waves_entry_media($post, $format, $atts);
                                }                                
                            }
                            if(empty($media)){
                                    ob_start();
                                    echo '<div class="carousel-content no-media">';
                                    echo '<h2 class="carousel-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
                                    echo '<span class="entry-author">'. __('By:', 'waves').' '; the_author_posts_link(); echo '</span>';
                                    echo '<div class="entry-content clearfix">';
                                        $atts['excerpt_count'] = 20;
                                        waves_blogcontent($atts);
                                    echo '</div>';
                                    echo '</div>';
                                    $output .= ob_get_clean();
                            } else {
                                $output .= $media;
                                $output .= '<div class="carousel-content">';
                                    $output .= '<span class="entry-date"><span class="date">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></span>';
                                    $output .= '<h2 class="carousel-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
                                    $output .= '<span class="entry-author">'. __('By:', 'waves').' '.get_the_author_link().'</span>';
                                $output .= '</div>';
                            }
                        $output .= '</div>';
                    $output .= '</div>';
                }
                wp_reset_query();
                // END   - LOOP
            $output .= '</div>';
            $output .= '<div class="clearfix"></div>';
        $output .= '</div>';    
    $output .= '</div>';
    $tw_isshortcode='false';
    return $output;
}
add_shortcode('tw_recent_posts', 'waves_carousel_posts');