<?php get_header(); ?>
<?php
the_post();
global $post;
require_once (WAVES_PATH . "pagebuilder/elements-render/sermon.php");
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('single-sermon'); ?>><?php
    if(post_password_required()){
        the_content();
    } else { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="media-container"><?php
                        $image='';
                        $imageLrg='';
                        if(get_metabox('format_video_thumb')){
                            $image = get_metabox('format_video_thumb');
                        }else{
                            $image = waves_image(0,0, true);
                        }
                        if(waves_image(0, 0, true)){
                            $imageLrg = waves_image(0, 0, true);
                        }else{
                            $imageLrg = get_metabox('format_video_thumb');
                        }
                        if(get_metabox('format_audio_mp3')){
                            add_action('wp_footer', 'waves_jplayer_script');
                            echo '<img src="'.$image.'" />';
                            waves_sermon_jplayer_audio($post->ID,get_metabox('format_audio_mp3'));
                        }elseif(get_metabox('format_video_embed')){
                            echo apply_filters("the_content", htmlspecialchars_decode(get_metabox('format_video_embed')));
                        }elseif(get_metabox('format_video_m4v')){
                            add_action('wp_footer', 'waves_jplayer_script');
                            waves_sermon_jplayer_video($post->ID,get_metabox('format_video_m4v'),$image);
                        }else{
                            echo '<img src="'.$imageLrg.'" />';
                        } ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="sermon-content">
                        <?php the_content(); ?>
                    </div>
                </div><!-- .col-md-8 -->
                <div class="col-md-4">
                    <div class="sermon-meta">
                        <?php
                            if(get_metabox('sermon_author')!=''){
                                echo '<div><i class="icon-microphone"></i><span>'.get_metabox('sermon_author').'</span></div>';
                            }
                            if(get_metabox('sermon_date')!=''){
                                echo '<div><i class="icon-calendar"></i><span>'.date("F j, Y", strtotime(get_metabox('sermon_date'))).'</span></div>';
                            }
                            if(get_metabox('sermon_location')){
                                echo '<div><i class="icon-pointer"></i><span>'.get_metabox('sermon_location').'</span></div>';
                            }
                            if(get_metabox('sermon_duration')!=''){
                                echo '<div><i class="icon-clock"></i><span>'.get_metabox('sermon_duration').'</span></div>';
                            }
                            if(get_metabox('sermon_down_video')!=''||get_metabox('sermon_down_audio')!=''){
                                echo '<div><i class="fa fa-download"></i><span>';
                                echo __('download:','waves');
                                $sep='';
                                if(get_metabox('sermon_down_audio')!=''){echo '<a href="'.get_metabox('sermon_down_audio').'">'.__('audio','waves').'</a>';$sep=',';}
                                if(get_metabox('sermon_down_video')!=''){echo $sep.'<a href="'.get_metabox('sermon_down_video').'">'.__('video','waves').'</a>';}
                                echo '</span></div>';
                            }
                        ?>
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
if (!tw_option('sermon_related')) {
    tw_related_sermons();
}
?>

<?php get_footer(); ?>