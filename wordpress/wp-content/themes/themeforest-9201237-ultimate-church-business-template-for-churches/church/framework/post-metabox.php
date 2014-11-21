<?php

require_once ( THEME_PATH . '/framework/post-options.php');

function metabox_render($post, $metabox) {
    $options = get_post_meta($post->ID, 'themewaves_'.strtolower(THEMENAME).'_options', true);?>
    <input type="hidden" name="themewaves_meta_box_nonce" value="<?php echo wp_create_nonce(basename(__FILE__));?>" />
    <table class="form-table tw-metaboxes">
        <tbody><?php	                              
            foreach ($metabox['args'] as $settings) {
                $settings['value'] = isset($options[$settings['id']]) ? $options[$settings['id']] : (isset($settings['std']) ? $settings['std'] : '');
                call_user_func('settings_'.$settings['type'], $settings);	
            } ?>
        </tbody>
    </table><?php 
}



add_action('save_post', 'savePostMeta');
function savePostMeta($post_id) {
    global $tw_post_settings, $tw_page_settings, $tw_comingsoon_settings, $tw_onepage_settings, $tw_blog_settings, $tw_port_settings, $tw_portfolio, $tw_event_settings, $tw_sermon_settings;

    $meta = 'themewaves_'.strtolower(THEMENAME).'_options';
    
    // verify nonce
    if (!isset($_POST['themewaves_meta_box_nonce']) || !wp_verify_nonce($_POST['themewaves_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
    }
    
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    
    if($_POST['post_type']=='post') {
        $metaboxes = $tw_post_settings;
        if(!get_post_meta($post_id, 'post_likeit', true))
            update_post_meta($post_id, 'post_likeit', 0);
        
        $count_key = 'waves_post_views_count';
        $count = get_post_meta($post_id, $count_key, true);
        if($count==''){
            update_post_meta($post_id, $count_key, 0);
        }
        
    }elseif($_POST['post_type']=='page'){
        $metaboxes = array_merge($tw_page_settings,$tw_onepage_settings,$tw_comingsoon_settings,$tw_blog_settings,$tw_port_settings);
    }elseif($_POST['post_type']=='portfolio') {
        $metaboxes = $tw_portfolio;
    }elseif($_POST['post_type']=='event'){
        $metaboxes = $tw_event_settings;
        //For Calendar Element
        if(isset($_POST['event_date'])){
            update_post_meta($post_id, 'event_date', $_POST['event_date']);
        }
        if(isset($_POST['event_upcomming'])){
            update_post_meta($post_id, 'event_upcomming', $_POST['event_upcomming']);
        }
    }elseif($_POST['post_type']=='tw-sermon'){
        $metaboxes = $tw_sermon_settings;
    }
    
    if(!empty($metaboxes)) {
        $myMeta = array();

        foreach ($metaboxes as $metabox) {
            $myMeta[$metabox['id']] = isset($_POST[$metabox['id']]) ? strip_tags($_POST[$metabox['id']], '<iframe><embed><img><a><span>') : "";
        }

        update_post_meta($post_id, $meta, $myMeta);        

    }
}



/* ================================================================================== */
/*      Save gallery images
/* ================================================================================== */

function themewaves_save_images() {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	
        if ( !isset($_POST['ids']) || !isset($_POST['nonce']) || !wp_verify_nonce( $_POST['nonce'], 'themewaves-ajax' ) ) { return; }
        
        if ( !current_user_can( 'edit_posts' ) ) { return; }
 
	$ids = strip_tags(rtrim($_POST['ids'], ','));
        
	// update thumbs
	$thumbs = explode(',', $ids);
	$gallery_thumbs = '';
	foreach( $thumbs as $thumb ) {
		$gallery_thumbs .= '<li>' . wp_get_attachment_image( $thumb, array(32,32) ) . '</li>';
	}

	echo $gallery_thumbs;

	die();
}
add_action('wp_ajax_themewaves_save_images', 'themewaves_save_images');
?>