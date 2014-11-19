<?php get_header(); ?>
<?php
the_post();
global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('single-event'); ?>><?php
    if(post_password_required()){
        the_content();
    } else { ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="media-container">
                        <?php the_post_thumbnail(); ?>
                    </div>
                </div><!-- .col-md-8 half -->
                <div class="col-md-4">
                    <div class="event-meta">
                        <?php
                            if(get_metabox('event_author')!=''){
                                echo '<div><i class="icon-microphone"></i><span>'.get_metabox('event_author').'</span></div>';
                            }
                            if(get_metabox('event_date')!=''){
                                echo '<div><i class="icon-calendar"></i><span>'.date("F j, Y", strtotime(get_metabox('event_date'))).'</span></div>';
                            }
                            if(get_metabox('event_location')){
                                echo '<div><i class="icon-pointer"></i><span>'.get_metabox('event_location').'</span></div>';
                            }
                            if(get_metabox('event_duration')!=''){
                                echo '<div><i class="icon-clock"></i><span>'.get_metabox('event_duration').'</span></div>';
                            }
                        ?>
                    </div>
                    <div class="event-content">
                        <?php the_content(); ?>
                    </div>
                    <div class="nextprev-postlink clearfix">
                        <div class="next-post-link">
                            <?php next_post_link('<h3 class="post-link-title">%link</h3>', '<i class="icon-arrow-right"></i>');?>
                        </div>
                        <div class="prev-post-link">
                            <?php previous_post_link('<h3 class="post-link-title">%link</h3>', '<i class="icon-arrow-left"></i>');?>
                        </div>
                    </div>
                </div><!-- .col-md-4 -->
            </div><!-- .row -->
    <?php } ?>
</article>

<?php
if (!tw_option('event_related')) {
    tw_related_events();
}
?>

<?php get_footer(); ?>