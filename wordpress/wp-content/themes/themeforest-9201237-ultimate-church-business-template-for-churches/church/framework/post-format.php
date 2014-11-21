<?php

$tw_image = array(
        array( "name" => __('Upload images',  'themewaves' ),
                        "desc" => __('Select the images that should be upload to this gallery',  'themewaves' ),
                        "id" => "gallery_image_ids",
                        "type" => 'gallery'
                ),
        array( "name" => __('Image height',  'themewaves' ),
                        "desc" => __('Slider height',  'themewaves' ),
                        "id" => "format_image_height",
                        "type" => 'text'
                )
);

$tw_audio = array(
        array( "name" => __('MP3 File URL', 'themewaves' ),
                        "desc" => __('The URL to the .mp3 audio file', 'themewaves' ),
                        "id" => "format_audio_mp3",
                        "type" => "text",
                        'std' => ''
                ),
        array( "name" => __('Embeded Code', 'themewaves' ),
                        "desc" => __('The embed code', 'themewaves' ),
                        "id" => "format_audio_embed",
                        "type" => "textarea",
                        'std' => ''
        )
);

$tw_video = array(
        array( "name" => __('M4V File URL', 'themewaves' ),
                        "desc" => __('The URL to the .m4v video file', 'themewaves' ),
                        "id" => "format_video_m4v",
                        "type" => "text",
                        'std' => ''
                ),
        array( "name" => __('Video Thumbnail Image', 'themewaves' ),
                        "desc" => __('The preivew image.', 'themewaves' ),
                        "id" => "format_video_thumb",
                        "type" => "text",
                        'std' => ''
                ),
        array( "name" => __('Embeded Code', 'themewaves' ),
                        "desc" => __('If you\'re not using self hosted video then you can include embeded code here.', 'themewaves' ),
                        "id" => "format_video_embed",
                        "type" => "textarea",
                        'std' => ''
        )	
);

$tw_quote = array(
        array( "name" => __('The Quote', 'themewaves' ),
                        "desc" => __('Write your quote in this field.', 'themewaves' ),
                        "id" => "format_quote_text",
                        "type" => "textarea",
                        'std' => ''
        ),
        array( "name" => __('The Author', 'themewaves' ),
                        "desc" => __('Write your author name of this.', 'themewaves' ),
                        "id" => "format_quote_author",
                        "type" => "text",
                        'std' => ''
        )
);

$tw_link = array(
        array( "name" => __('The URL', 'themewaves' ),
                        "desc" => __('Insert the URL you wish to link to.', 'themewaves' ),
                        "id" => "format_link_url",
                        "type" => "text",
                        'std' => ''
        )	
);

$tw_status = array(
        array( "name" => __('The URL', 'themewaves' ),
                        "desc" => __('Insert the status URL.', 'themewaves' ),
                        "id" => "format_status_url",
                        "type" => "text",
                        'std' => ''
        )	
);


/* ================================================================================== */
/*      Add Metabox
/* ================================================================================== */

add_action('admin_init', 'tw_post_format_add_box');
if (!function_exists('tw_post_format_add_box')) {
    function tw_post_format_add_box() { 
        global $tw_quote, $tw_image, $tw_link, $tw_audio, $tw_video, $tw_status;
        add_meta_box('tw-format-quote', __('Quote Settings', 'themewaves'), 'post_format_metabox', 'post', 'normal', 'high', $tw_quote);
        add_meta_box('tw-format-gallery', __('Gallery Settings', 'themewaves'), 'post_format_metabox', 'post', 'normal', 'high', $tw_image);
        add_meta_box('tw-format-link', __('Link Settings', 'themewaves'), 'post_format_metabox', 'post', 'normal', 'high', $tw_link);
        add_meta_box('tw-format-audio', __('Audio Settings', 'themewaves'), 'post_format_metabox', 'post', 'normal', 'high', $tw_audio);
        add_meta_box('tw-format-video', __('Video Settings', 'themewaves'), 'post_format_metabox', 'post', 'normal', 'high', $tw_video);
        add_meta_box('tw-format-status', __('Status Settings', 'themewaves'), 'post_format_metabox', 'post', 'normal', 'high', $tw_status);
    }
}


/* ================================================================================== */
/*      Callback function to show fields in meta box
/* ================================================================================== */
if (!function_exists('post_format_metabox')) {
    function post_format_metabox($post, $metabox) {
        global $post; ?>
	<input type="hidden" name="themewaves_postformat_box_nonce" value="<?php echo wp_create_nonce(basename(__FILE__));?>" />
        <table class="form-table tw-metaboxes">
            <tbody>
                    <?php	                              
                    foreach ($metabox['args'] as $settings) {
                        $options = get_post_meta($post->ID, $settings['id'], true);
                        
                        $settings['value'] = !empty($options) ? $options : (isset($settings['std']) ? $settings['std'] : '');
                        call_user_func('settings_'.$settings['type'], $settings);	
                    }
                    ?>
            </tbody>
        </table><?php
    }
}


/* ================================================================================== */
/*      Save post data
/* ================================================================================== */

add_action('save_post', 'postformat_save_postdata');
if (!function_exists('postformat_save_postdata')) {
    function postformat_save_postdata($post_id) {
            global $tw_image, $tw_audio, $tw_video, $tw_quote, $tw_link, $tw_status;

            // verify nonce
            if (!isset($_POST['themewaves_postformat_box_nonce']) || !wp_verify_nonce($_POST['themewaves_postformat_box_nonce'], basename(__FILE__))) {
                    return $post_id;
            }

            // check autosave
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                    return $post_id;
            }

            // check permissions
            if (!current_user_can('edit_post', $post_id)) {
                    return $post_id;
            }

            $metaboxes = array_merge($tw_link, $tw_quote, $tw_audio, $tw_image, $tw_video, $tw_status);
            foreach ($metaboxes as $metabox) {
                    $value = ( isset($_POST[$metabox['id']]) ) ? $_POST[$metabox['id']] : false; 
                    update_post_meta($post_id, $metabox['id'], stripslashes(htmlspecialchars($value)));
            }
    }
}
?>