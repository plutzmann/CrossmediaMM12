<?php get_header(); ?>

<div class="row">
    <div class="waves-main col-md-8">
        <section class="content"><?php
        global $wp_query;
        $_GET["s"]=isset($_GET["s"])?$_GET["s"]:'';
        $query = new WP_Query(array(
            'post_type'=>array('post', 'page', 'tw-sermon', 'event'),
            'meta_key' => WAVES_SHORTCODE,
            'meta_query' => array(
                array(
                    'key' => WAVES_SHORTCODE,
                    'value' => $_GET["s"],
                    'type' => 'whatever',
                    'compare' => 'like'
                )
            ),
            'caller_get_posts' => '1'
        ));
        $wp_query->posts = array_merge( $wp_query->posts, $query->posts );
        $wp_query->post_count  = count( $wp_query->posts );
        
        if (have_posts ()) {            
            get_template_part('loop');
        } else { ?>
                <div id="error404-container">
                    <h3 class="error404"><?php _e("Sorry, but nothing matched your search criteria. Please try again with some different keywords.", "themewaves");?></h3>
                    <?php get_search_form(); ?>
                    <br/>

                    <div class="error-404-child"></div>

                    <div class="tw-404-error"><p><?php _e("For best search results, mind the following suggestions:", "themewaves");?></p>
                        <ul class="borderlist">
                            <li><?php _e("Always double check your spelling.", "themewaves");?></li>
                            <li><?php _e("Try similar keywords, for example: tablet instead of laptop.", "themewaves");?></li>
                            <li><?php _e("Try using more than one keyword.", "themewaves");?></li>
                        </ul>
                    </div>
                </div><?php
        } ?>
        </section>
    </div>
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>