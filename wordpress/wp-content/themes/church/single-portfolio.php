<?php get_header(); ?>
<?php
the_post();
global $post;
$layout = get_metabox('portfolio_single_sytle');
if (empty($layout) || $layout == 'default') {
    $layout = tw_option('port_single_layout') == 'Style Full' ? 'full' : 'half';
} ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('single-portfolio single-portfolio-'.$layout); ?>><?php
    if(post_password_required()){
        the_content();
    } else {
        if(get_metabox('subtitle')!='') {
            echo do_shortcode('[tw_heading text="'.get_metabox('subtitle').'"]');
        }
        if ($layout == 'full') {
            $width = 1170;
        } else {
            $width = 770;
            echo '<div class="row" style="position:relative;margin-top: -30px;">';
            echo '<div class="col-md-8">';
        } ?>
            <div class="media-container"><?php
                $ids = get_metabox('gallery_image_ids');
                $video_embed = get_metabox('format_video_embed');
                if ($ids != "false" && $ids != "") {
                    $height = get_metabox('gallery_height');
                    echo '<div class="image-slide-container list_carousel clearfix">';
                        echo '<div class="waves-carousel">';
                            foreach (explode(',', $ids) as $id) {
                                if (!empty($id)) {
                                    $imgurl0 = aq_resize(wp_get_attachment_url($id), $width, $height, true);
                                    $imgurl = !empty($imgurl0) ? $imgurl0 : wp_get_attachment_url($id);
                                    $imagelink = is_single() ? (wp_get_attachment_url($id).'" rel="prettyPhoto[gallery]') : get_permalink();
                                    echo '<div class="tw-owl-item">';
                                        echo '<a href="' . $imagelink . '"><img src="' . $imgurl . '" alt="' . get_the_title() . '"></a>';
                                    echo '</div>';
                                }
                            }
                        echo '</div>';
                    echo '</div>';
                } elseif (!empty($video_embed)) {
                    echo '<div class="entry-video">';
                        echo apply_filters("the_content", ($video_embed));
                    echo '</div>';
                } else {
                    the_post_thumbnail();
                } ?>
            </div><?php
        if ($layout == 'full') {
            echo '<h2 class="portfolio-title">'.get_the_title().'</h2>';
            echo '<div class="row" style="position:relative;">';
            echo '<div class="col-md-8">';        
        }else{
            echo '</div><!-- .col-md-8 half -->';
            echo '<div class="col-md-4">';
            echo '<h2 class="portfolio-title">'.get_the_title().'</h2>';
        }
        
        the_content();
        
        if ($layout == 'full') {
            echo '</div><!-- .col-md-8 full -->';
            echo '<div class="col-md-4">';
        }
            echo '<div class="portfolio-meta">';
            echo '<div class="meta-date">'.__('Date Published', 'waves').': <b>';the_time('F j.Y');echo '</b></div>';
            
            $tags = get_the_term_list($post->ID, 'portfolio_tag', '', ', ', '' );
            $cats = get_the_term_list( $post->ID, 'portfolio_cat', '<b>', ', ', '</b>' );
            if ($cats) {
                echo '<div class="meta-cats">'.__('Category', 'waves').': '.$cats.'</div>';
            }
            if (get_metabox("port_client") != "") {
                echo '<div class="meta-client">'.__('Client', 'waves').': <b>'.get_metabox("port_client").'</b></div>';
            }
            if ($tags) {
                echo '<div class="meta-tags">'.__('Skills', 'waves').': <b>'.strip_tags($tags).'</b></div>';
            }
            if (get_metabox("preview_url") != "") {
                echo '<div class="meta-preview">'.__('Check the work', 'waves').': <b><a href="'.esc_url(get_metabox("preview_url")).'" target="_blank">'.get_metabox("preview_url").'</a></b></div>';
            }
        echo '</div><!-- .col-md-4 --></div><!-- .row -->';
    } ?>
</article>
<div class="nextprev-postlink clearfix">
    <div class="prev-post-link">
        <?php previous_post_link('<h3 class="post-link-title">%link</h3>', __('previous post', 'waves'));?>
    </div>
    <div class="home-link">
        <a href="<?php home_url();?>"><?php echo __('home', 'waves');?></a>
    </div>
    <div class="next-post-link">
        <?php next_post_link('<h3 class="post-link-title">%link</h3>', __('next post', 'waves'));?>
    </div>
</div>

<?php
if (!tw_option('port_related')) {
    tw_related_portfolios();
}
?>

<?php get_footer(); ?>