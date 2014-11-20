<?php 
/*
Template Name: One page
*/
get_header();
the_post();

if(tw_option('pagebuilder') && get_post_meta($post->ID, 'waves_metabox_shortcode', true)&&!post_password_required()){
    the_content();
}else{
    echo '<div class="container">';
        echo '<div class="row">';
            if(get_metabox('layout') == "left" || get_metabox('layout') == "right"){
                get_sidebar();
                echo "<div class='col-md-9'>";
                    the_content();
                    wp_link_pages();
                    comments_template('', true);
                echo "</div>";
            }else{
                echo "<div class='col-md-12'>";
                    the_content();
                    wp_link_pages();
                    comments_template('', true);
                echo "</div>";
            }
        echo "</div>";
    echo "</div>";
}
get_footer(); ?>