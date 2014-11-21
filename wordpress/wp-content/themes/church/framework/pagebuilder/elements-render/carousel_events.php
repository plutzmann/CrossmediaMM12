<?php
/* ================================================================================== */
/*      Recent Events Shortcode
/* ================================================================================== */

function waves_carousel_events($atts, $content) {
    $atts = shortcode_atts(array(
        'size'  => 'col-md-12',
        'class' => '',
        'title' => '',
        'layout_type' => '3',
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
    
    $output = $before = $after = '';
    $items = $atts['layout_type'];
    $class = '';
    
    if(!empty($atts['description'])){
        $items = 2;
        $title = $atts['title'];
        $atts['title'] = '';
        $class .=' with-description';
        $before = '<div class="row"><div class="col-md-4"><div class="carousel-content">';
        $before .= (!empty($title) ? ('<h3>'.rawUrlDecode($title).'</h3>') : '').'<p>'.$atts['description'].'</p>';
        $before .= '<div class="content-arrow"><i class="icon-arrow-left"></i><i class="icon-arrow-right"></i></div></div></div><div class="col-md-8">';
        $after = '</div></div>';
    }
    
    $output .= waves_item($atts,'carousel-container waves-carousel-event-container');

        if($atts['white_bg'] == 'true'){
            $class .= ' white-bg';
        }    

        $output .= $before;
        $output .= '<div class="waves-carousel-event'.$class.' waves-event list_carousel carousel-anim" data-autoplay="'.$atts['auto_play'].'" data-items="'.$items.'">';
        $output .= '<div class="waves-carousel">';
            $query = Array(
                'post_type' => 'event',
                'posts_per_page' => $atts['post_count'],
            );
            $cats = explode(",", $atts['category_ids']);
            if (!empty($cats[0])) {
                $query['tax_query'] = Array(Array(
                        'taxonomy' => 'event_cat',
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
            global $post;
            while (have_posts()){ the_post();
            
                $image = waves_image($atts['width'], $atts['height'], true);
                if(!$image){
                    $image = waves_image(0,'',true);
                }
                if($image){
                    $height = !empty($atts['height']) ? (' style="min-height: '.$atts['height'].'px;"') : '';

                        $content = '<h2 class="event-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
                        $content .= '<div class="event-meta">';
                        if(get_metabox('event_date')!=''){
                            $content .= '<div><i class="icon-calendar"></i><span>'.date("F j, Y", strtotime(get_metabox('event_date'))).'</span></div>';
                        }
                        if(get_metabox('event_location')!=''){
                            $content .= '<div><i class="icon-pointer"></i><span>'.get_metabox('event_location').'</span></div>';
                        }
                        $content .= '</div><a class="more-link" href="'.get_permalink().'">'.__('More information', 'waves').'</a>';

                    $output .= '<div class="tw-owl-item">';
                            $output .= '<div class="event-block clearfix"'.$height.'>';
                                $output .= '<div class="event-image" style="background-image:url('.$image.');">';
                                $output .= '</div>';    
                                $output .= '<div class="event-content">';
                                    $output .= $content;
                                $output .= '</div>';    
                            $output .= '</div>';    
                    $output .= '</div>';
                }
            }
            wp_reset_query();    
            // END   - LOOP

        $output .= '</div>';        
        $output .= '<div class="clearfix"></div>';
    $output .= '</div>';
    $output .= $after;
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_recent_events', 'waves_carousel_events');