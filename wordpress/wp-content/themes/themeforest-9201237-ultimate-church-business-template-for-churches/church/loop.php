<div class="waves-blog grid3-blog">
    <div class="row blog-grid isotope">
    <?php
    add_action('wp_footer', 'waves_portfolio_script');
    if (have_posts()) {
        $atts['layout'] = 'grid2';
        $klas = 'clearfix col-md-6';
        global $size;
        if($size == 'col-md-12') {
            $atts['layout'] = 'grid3';
            $klas = 'clearfix col-md-4';
        }
        
        $atts['image_height'] = '0';
        while (have_posts()) { the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class($klas); ?>>
                
                <?php 
                if(function_exists("waves_loop_gridblog")) {
                    call_user_func('waves_loop_gridblog', $atts); 
                }
                ?>
                
            </article><?php
        }
    }
    ?>
    </div>
    <?php waves_pagination();?>
</div>