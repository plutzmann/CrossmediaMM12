<?php
/* ================================================================================== */
/*      Portfolio Shortcode
/* ================================================================================== */

if (!function_exists('shortcode_tw_portfolio')) {
    function shortcode_tw_portfolio($atts, $content) {
        $atts = shortcode_atts(array(
            'size'  => 'col-md-12',
            'class' => '',
            'title' => '',
            'layout_type' => 'default',
            'layout' => 'col4',
            'column' => '3',
            'layout_size' => 'col-md-12',
            'pagination' => 'simple',
            'height' => '',
            'count' => 9,
            'filter' => 'false',
            'filter_type'=> 'single',
            'category_ids' => '',
            'order' => 'date_desc',
            'not_in' => ''
        ), $atts);
        global $paged,$waves_gallery_id;
        if(empty($waves_gallery_id)){
            $waves_gallery_id=1;
        }
        $atts['waves_gallery_id']=$waves_gallery_id++;

        if (get_query_var('paged')){
            $my_page = get_query_var('paged');
        }else {
            if (get_query_var('page')){
                $my_page = get_query_var('page');
            }else{
                $my_page = 1;
            }
            set_query_var('paged', $my_page);
        }
        add_action('wp_footer', 'waves_portfolio_script');
        $query = Array(
            'post_type' => 'portfolio',
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
                    'taxonomy' => 'portfolio_cat',
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
        $column = $atts['layout']=='col4' ? 4 : 3;
        
        $output = waves_item($atts,'waves-portfolio '.($atts['layout_type']==='full'?' waves-full-element':''));
            if ($atts['filter'] == 'true') {
                $output .= '<div class="tw-filters">';
                    $output .= '<ul class="filters clearfix '.$atts['filter_type'].'" data-option-key="filter">';
                        $output .= '<li><a href="#filter" data-option-value="*" class="show-all selected">'.__('Show All', 'themewaves').'</a></li>';
                        if ($cats) {
                            $filters = $cats;
                        } else {
                            $filters = get_terms('portfolio_cat');
                        }
                        foreach ($filters as $category) {
                            if ($cats) {
                                $category = get_term_by('slug', $category, 'portfolio_cat');
                            }
                            $output .= '<li class="hidden"><a href="#filter" data-option-value=".category-' . $category->slug . '" title="' . $category->name . '">' . $category->name . '</a></li>';
                        }
                    $output .= '</ul>';
                $output .= '</div>';
            }
            if(!is_tax())
            query_posts($query);
                $output .= '<div class="row">';
                    $output .= '<div class="isotope-container" data-column="'.$column.'">';

                            while (have_posts()){ the_post();
                                $output .= call_user_func('waves_portfolio_loop', $atts);
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

function waves_portfolio_script() {
    wp_enqueue_script('waves-isotope', THEME_DIR . '/assets/js/jquery.isotope.min.js', false, false, true);
}

add_shortcode('tw_portfolio', 'shortcode_tw_portfolio');







function waves_portfolio_loop($atts) {
    global $post;
    $artClass='not-inited';
    $size = get_metabox('gallery_layout')=='large' ? ' gallery-large' : ' gallery-small';
    if($atts['layout'] == 'col4'){
        $width = get_metabox('gallery_layout')=='large' ? 580 : 280;
    } else {
        $width = get_metabox('gallery_layout')=='large' ? 800 : 400;
    }
    $image = waves_image($width, $atts['height'], true);
    if($image){
        $cats = wp_get_post_terms($post->ID, 'portfolio_cat');
        foreach ($cats as $catalog) {
            $artClass .= " category-" . $catalog->slug;
        }
        
        $content = '<div class="gallery-content">';
            $content .= '<h2 class="gallery-title">';
                if(get_metabox('preview_url')){$content .= '<a href="'.get_metabox('preview_url').'">';}
                    $content .= get_the_title();
                if(get_metabox('preview_url')){$content .= '</a>';}
            $content .= '</h2>';
            $content .= '<span class="gallery-date">'.get_the_time('F j, Y').'</span>';
        $content .= '</div>';
        
        $output = '<article class="portfolio '.$artClass.$size.'">';
                $output .= '<div class="gallery-thumb">';
                    $output .= '<a href="'.$image.'" rel="prettyPhoto['.$atts['waves_gallery_id'].']"><img src="'.$image.'" /></a>';
                    $output .= '<div class="image-overlay"></div>';                    
                    $output .= $content;
                $output .= '</div>';    
        $output .= '</article>';
        return $output;
    }
}