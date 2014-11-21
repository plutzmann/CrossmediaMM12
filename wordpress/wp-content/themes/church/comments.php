<?php

if (comments_open ()) { ?>
    <div id="comments" class="comment-section"><?php
        if (tw_option('facebook_comment')) { ?>
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo tw_option('facebook_app_id'); ?>";
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            </script>
            <div class="fb-comments" data-href="<?php the_permalink(); ?>" data-num-posts="<?php echo get_option('comments_per_page'); ?>" data-width="770"></div><?php
        } else {
            if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])){
                die('Please do not load this page directly. Thanks!');
            }
            if (post_password_required ()) { ?>
                <p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'themewaves'); ?></p><?php
                return;
            }
            
            if (have_comments ()) { ?>
                <div class="comment-title-container">
                    <h4 class="comment-title">
                        <?php printf(
                            _n(__('One Comment Published', 'themewaves'),
                            '%1$s ' . __('Comments Published', 'themewaves'),
                            get_comments_number()),
                            number_format_i18n(get_comments_number())
                            ); ?>                        
                    </h4>
                </div>
                <div class="comment-list clearfix">
                    <?php wp_list_comments(array('style' => 'div', 'callback' => 'tw_comment_block')); ?>
                </div>
                <div class="navigation">
                    <div class="left"><?php previous_comments_link() ?></div>
                    <div class="right"><?php next_comments_link() ?></div>
                </div><?php
            }


            $fields[ 'comment_notes_before' ]=$fields[ 'comment_notes_after' ] = '';
            $fields[ 'label_submit' ] = __('Submit', 'themewaves');
            $fields[ 'comment_field' ] = 
                '<div class="comment-form-comment">'.
                    '<textarea name="comment" placeholder="'.__('Comment', 'themewaves').'" id="comment" class="required" rows="7" tabindex="4"></textarea>'.
                '</div><div class="clearfix"></div>';
            $fields[ 'title_reply' ] = '</h3><div class="comment-title-container"><h4 id="reply-title">'.__('Leave a Comment', 'themewaves').'</h4></div><h3 id="reply-title" class="comment-reply-title">';
            $fields[ 'title_reply_to' ] = '</h3><div class="comment-title-container"><h4 id="reply-title">'.__('Leave a Reply to %s', 'themewaves').'</h4></div><h3 id="reply-title" class="comment-reply-title">';

            comment_form($fields);
            
        } ?>
    </div><?php
}