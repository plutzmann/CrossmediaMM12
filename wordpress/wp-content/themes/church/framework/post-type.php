<?php

add_action("manage_posts_custom_column", "tw_posttype_custom_columns");
function tw_posttype_custom_columns($column) {
    global $post;
    switch ($column) {
        case "portfolio_cat":
            echo get_the_term_list($post->ID, 'portfolio_cat', '', ', ', '');
            break;
        case "event_cat":
            echo get_the_term_list($post->ID, 'event_cat', '', ', ', '');
            break;
        case "sermon_cat":
            echo get_the_term_list($post->ID, 'sermon_cat', '', ', ', '');
            break;
    }
}

/* * *********************** */
/* Custom post type: Portfolio */
/* * *********************** */

add_action('init', 'tw_portfolio_register');
function tw_portfolio_register() {
    $slug = tw_option('translate_portfolio') ? tw_option('translate_portfolio') : 'gallery';
    $labels = array(
        'name' => $slug,
        'singular_name' => $slug,
        'add_new' => __('Add New', 'waves'),
        'add_new_item' => __('Add New Gallery', 'waves'),
        'edit_item' => __('Edit Gallery', 'waves'),
        'new_item' => __('New Gallery', 'waves'),
        'all_items' => __('All Galleries', 'waves'),
        'view_item' => __('View Gallery', 'waves'),
        'search_items' => __('Search Galleries', 'waves'),
        'not_found' =>  __('No Gallery found', 'waves'),
        'not_found_in_trash' => __('No Gallery found in Trash', 'waves'),
        'menu_name' => __('Gallery', 'waves')
    );    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'hierarchical' => false,

        'menu_icon' => THEME_DIR . '/framework/images/portfolio.png',
        'rewrite' => array( 'slug' => $slug),
        'supports' => array('title','page-attributes','thumbnail','custom-fields','revisions')
    );
    register_post_type('portfolio', $args);
    register_taxonomy("portfolio_cat", array("portfolio"), array("hierarchical" => true, "label" => __("Categories", "waves"), "singular_label" => __("Gallery Category", "waves"), 'rewrite' => array( 'slug' => $slug.'_category')));
//    register_taxonomy("portfolio_tag", array("portfolio"), array("hierarchical" => true, "label" => __("Tags", "waves"), "singular_label" => __("Portfolio Tag", "waves"), 'rewrite' => array( 'slug' => $slug.'_tag')));
    flush_rewrite_rules();
}


add_filter('manage_edit-portfolio_columns', 'tw_portfolio_edit_columns');
function tw_portfolio_edit_columns($columns){	
    $newcolumns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => __("Gallery Title", "waves"),
        "portfolio_cat" => __("Categories", "waves"),
    );
    $columns= array_merge($newcolumns, $columns);
    return $columns;
}




/* * *********************** */
/* Custom post type: Event */
/* * *********************** */

add_action('init', 'tw_event_register');
function tw_event_register() {
    $slug = tw_option('translate_event') ? tw_option('translate_event') : 'event';
    $labels = array(
        'name' => $slug,
        'singular_name' => $slug,
        'add_new' => __('Add New', 'waves'),
        'add_new_item' => __('Add New Event', 'waves'),
        'edit_item' => __('Edit Event', 'waves'),
        'new_item' => __('New Event', 'waves'),
        'all_items' => __('All Events', 'waves'),
        'view_item' => __('View Event', 'waves'),
        'search_items' => __('Search Events', 'waves'),
        'not_found' =>  __('No Event found', 'waves'),
        'not_found_in_trash' => __('No Event found in Trash', 'waves'),
        'menu_name' => __('Events', 'waves')
    );    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'hierarchical' => false,

        'menu_icon' => THEME_DIR . '/framework/images/portfolio.png',
        'rewrite' => array( 'slug' => $slug),
        'supports' => array('title', 'editor','page-attributes','thumbnail','custom-fields','revisions')
    );
    register_post_type('event', $args);
    register_taxonomy("event_cat", array("event"), array("hierarchical" => true, "label" => __("Categories", "waves"), "singular_label" => __("Event Category", "waves"), 'rewrite' => array( 'slug' => $slug.'_category')));
    flush_rewrite_rules();
}


add_filter('manage_edit-event_columns', 'tw_event_edit_columns');
function tw_event_edit_columns($columns){	
    $newcolumns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => __("Event Title", "waves"),
        "event_cat" => __("Categories", "waves"),
    );
    $columns= array_merge($newcolumns, $columns);
    return $columns;
}



/* * *********************** */
/* Custom post type: Sermon */
/* * *********************** */

add_action('init', 'tw_sermon_register');
function tw_sermon_register() {
    $slug = tw_option('translate_sermon') ? tw_option('translate_sermon') : 'sermon';
    $labels = array(
        'name' => $slug,
        'singular_name' => $slug,
        'add_new' => __('Add New', 'waves'),
        'add_new_item' => __('Add New sermon', 'waves'),
        'edit_item' => __('Edit sermon', 'waves'),
        'new_item' => __('New sermon', 'waves'),
        'all_items' => __('All sermons', 'waves'),
        'view_item' => __('View sermon', 'waves'),
        'search_items' => __('Search sermons', 'waves'),
        'not_found' =>  __('No sermon found', 'waves'),
        'not_found_in_trash' => __('No sermon found in Trash', 'waves'),
        'menu_name' => __('Sermons', 'waves')
    );    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'hierarchical' => false,

        'menu_icon' => THEME_DIR . '/framework/images/portfolio.png',
        'rewrite' => array( 'slug' => $slug),
        'supports' => array('title','editor','page-attributes','thumbnail','custom-fields','revisions')
    );
    register_post_type('tw-sermon', $args);
    register_taxonomy("sermon_cat", array("tw-sermon"), array("hierarchical" => true, "label" => __("Categories", "waves"), "singular_label" => __("Sermon Category", "waves"), 'rewrite' => array( 'slug' => $slug.'_category')));
    flush_rewrite_rules();
}


add_filter('manage_edit-tw-sermon_columns', 'tw_sermon_edit_columns');
function tw_sermon_edit_columns($columns){	
    $newcolumns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => __("sermon Title", "waves"),
        "sermon_cat" => __("Categories", "waves"),
    );
    $columns= array_merge($newcolumns, $columns);
    return $columns;
}