<?php
/* ================================================================================== */
/*      Portfolio Shortcode
/* ================================================================================== */

if (!function_exists('shortcode_tw_event')) {

    function shortcode_tw_event($atts, $content) {
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
        
        if($atts['layout'] == 'upcoming') {
                        $query = Array(
                            'post_type' => 'event',
                            'posts_per_page' => 1,
                        );
                        $cats = empty($atts['category_ids']) ? false : explode(",", $atts['category_ids']);
                        if ($cats) {
                            $query['tax_query'] = Array(Array(
                                    'taxonomy' => 'event_cat',
                                    'terms' => $cats,
                                    'field' => 'slug'
                                )
                            );
                        }
                        $output = waves_item($atts,'waves-event '.$atts['layout']);
                            query_posts($query);
                                $output .= '<div class="upcoming-event">';
                                        while (have_posts()){ the_post();
                                            $output .= '<div class="event-title"><i class="icon-calendar"></i><span>'.__('Upcoming event', 'waves').': </span>';
                                            $output .= '<h2><a href="'.get_permalink().'">'.get_the_title().'</a></h2></div>';
    //                                        $output .= '<div class="event-author"><span></span></div>';
                                            if(get_metabox('event_date')!=''){
                                                $output .= '<div class="event-date"><span>'.date("F j, Y", strtotime(get_metabox('event_date'))).'</span></div>';
                                            }
                                            if(get_metabox('event_author')!=''){
                                                $output .= '<div class="event-author"><span>'.get_metabox('event_author').'</span></div>';
                                            }
                                            $output .= '<div class="event-like"><iframe src="//www.facebook.com/plugins/like.php?href='.get_permalink().'&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" style="border:none; overflow:hidden; height:21px;"></iframe></div>';
                                        }
                                $output .= '</div>';
                        $output .= '</div>';
                        return $output;
        } else {
        
        
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
            'post_type' => 'event',
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
        $atts['column'] = 3;
        $atts['width'] = 380;
        if ($atts['layout'] === 'col2') {
                $atts['column'] = 2;
        }
        
        $output = waves_item($atts,'waves-event '.$atts['layout']);
            if ($atts['filter'] == 'true') {
                $output .= '<div class="tw-filters">';
                    $output .= '<ul class="filters clearfix" data-option-key="filter">';
                        $output .= '<li><a href="#filter" data-option-value="*" class="show-all selected">'.__('Show All', 'themewaves').'</a></li>';
                        if ($cats) {
                            $filters = $cats;
                        } else {
                            $filters = get_terms('event_cat');
                        }
                        foreach ($filters as $category) {
                            if ($cats) {
                                $category = get_term_by('slug', $category, 'event_cat');
                            }
                            $output .= '<li class="hidden"><a href="#filter" data-option-value=".category-' . $category->slug . '" title="' . $category->name . '">' . $category->name . '</a></li>';
                        }
                    $output .= '</ul>';
                $output .= '</div>';
            }
            if(!is_tax())
            query_posts($query);
                $output .= '<div class="row">';
                    $output .= '<div class="isotope-container" data-column="'.$atts['column'].'">';
                            while (have_posts()){ the_post();
                                $output .= call_user_func('waves_event_loop', $atts);
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
}

add_shortcode('tw_event', 'shortcode_tw_event');







function waves_event_loop($atts) {
    global $post;
    $artClass='not-inited';
    $image = waves_image($atts['width'], $atts['height'], true);
    if($image){
        $cats = wp_get_post_terms($post->ID, 'event_cat');
        foreach ($cats as $catalog) {
            $artClass .= " category-" . $catalog->slug;
        }
        $height = !empty($atts['height']) ? (' style="min-height: '.$atts['height'].'px;"') : '';

            $content = '<h2 class="event-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
            $content .= '<div class="event-meta">';
            if(get_metabox('event_date')!=''){
                $content .= '<div><i class="icon-calendar"></i><span>'.get_metabox('event_date').'</span></div>';
            }
            if(get_metabox('event_location')!=''){
                $content .= '<div><i class="icon-pointer"></i><span>'.get_metabox('event_location').'</span></div>';
            }
            $content .= '</div><a class="more-link" href="'.get_permalink().'">'.__('More information', 'waves').'</a>';
        
        $output = '<article class="event '.$artClass.'">';
                $output .= '<div class="event-block clearfix"'.$height.'>';
                    $output .= '<div class="event-image" style="background-image:url('.$image.');">';
                    $output .= '</div>';    
                    $output .= '<div class="event-content">';
                        $output .= $content;
                    $output .= '</div>';    
                $output .= '</div>';    
        $output .= '</article>';
        return $output;
    }
}