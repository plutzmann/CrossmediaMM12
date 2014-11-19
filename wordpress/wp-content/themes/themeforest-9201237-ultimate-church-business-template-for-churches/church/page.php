<?php get_header();
the_post();
global $post;

if(tw_option('pagebuilder') && get_post_meta($post->ID, 'waves_metabox_shortcode', true)&&!post_password_required()){
    the_content();
}else{
    echo '<div class="waves-container container">';
            $klas = 'full';
            $size = 'col-md-12';
            switch (get_metabox("layout")){                    
                    case 'left' : $klas = 'left';$size = 'col-md-8';break;
                    case 'right' : $klas = 'right';$size = 'col-md-8';break;
            }
            
            if ($klas == "left") { get_sidebar(); }
            echo "<div class='waves-main $size'>";
                echo '<div class="entry-content default-page">';
                    the_content();
                echo '</div>';
                wp_link_pages();
                comments_template('', true);
            echo "</div>";
            if ($klas == "right") { get_sidebar(); }
            
    echo "</div>";
}
get_footer(); ?>