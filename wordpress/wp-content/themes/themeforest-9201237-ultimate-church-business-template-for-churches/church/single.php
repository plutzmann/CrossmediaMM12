<?php get_header(); ?>


<?php
the_post();
global $post;
$size = 'col-md-8';
switch (get_metabox("layout")){
    case 'full' : $klas = 'full'; $size = 'col-md-12'; break;
    case 'left' : $klas = 'left';break;
    case 'right' : $klas = 'right';break;
}
if (empty($klas)) {
    switch (tw_option('post_layout')){
        case 'full' : $klas = 'full'; $size = 'col-md-12';break;
        case 'left' : $klas = 'left';break;
        default : $klas = 'right';
    }
}
$feature = false;
if (get_metabox("feature_show") == "true") {
    $feature = true;
} else if (get_metabox("feature_show") != "false") {
    if (tw_option("feature_show")) {
        $feature = true;
    }
}
$format = get_post_format() == "" ? "standard" : get_post_format();
$media = waves_entry_media($post, $format, false);

    if($format == "image" && $feature && !post_password_required()) {
                if($media){
                    echo $media;
                    $feature = false;
                }
        echo '</div>';
        echo '<div class="waves-container container">';
    } ?>
    <div class="row">
        <?php if ($klas == "left") { get_sidebar(); } ?>
        <div class="waves-main <?php echo $size;?>"><?php
            if(post_password_required()){
                the_content();
            }else{
                if ($feature) {
                    if($media){
                        echo $media;
                    } else {
                        echo waves_standard_media($post, false);        
                    }
                }
                ?>
                <article <?php post_class('single'); ?>>                 
                    <div class="entry-content">
                        <?php the_content(); ?>
                        <?php wp_link_pages(); ?>
                        <div class="clear"></div>
                    </div>
                    <div class="nextprev-postlink clearfix">                        
                        <div class="next-post-link">
                            <?php next_post_link('<h3 class="post-link-title">%link</h3>', '<i class="fa fa-arrow-right"></i>');?>
                        </div>
                        <div class="prev-post-link">
                            <?php previous_post_link('<h3 class="post-link-title">%link</h3>', '<i class="fa fa-arrow-left"></i>');?>
                        </div>
                    </div>
                </article>
                <?php comments_template('', true);
            } ?>
        </div>
        <?php if ($klas == "right") { get_sidebar(); } ?>
    </div>
<?php get_footer(); ?>