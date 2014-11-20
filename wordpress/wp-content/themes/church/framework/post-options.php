<?php

add_action('admin_init', 'tw_postoptions_init');
function tw_postoptions_init(){

    global $tw_post_settings, $tw_page_settings, $tw_comingsoon_settings, $tw_onepage_settings, $tw_blog_settings, $tw_port_settings;
    $selectsidebar = $topsidebar = array();
    $topsidebar["Top widget"] = "Top widget";
    $selectsidebar["Default sidebar"] = "Default sidebar";
    $sidebars = get_option('sbg_sidebars');
    if (!empty($sidebars)) {
        foreach ($sidebars as $sidebar) {
            $selectsidebar[$sidebar] = $sidebar;
            $topsidebar[$sidebar] = $sidebar;
        }
    }
    $topsidebar["None"] = "None";
    $selectlayout = array('default' => 'Default', 'left' => 'Left Sidebar', 'right' => 'Right Sidebar', 'full' => 'Fullwidth');
    //Post Catigories
    $categories = get_categories("hide_empty=0");
    $cats = array("0" => "Select Category");
    if(!empty($categories)) {
        foreach ($categories as $category) {
            $cats[$category->slug] = $category->name;
        }
    }
    //Portfolio Catigories
    $portfolios = get_terms('portfolio_cat', 'hide_empty=0');
    $port_cats = array("0" => "Select Category");
    if(!empty($portfolios)) {
        foreach ($portfolios as $portfolio) {
            $port_cats[$portfolio->slug] = $portfolio->name;
        }
    }


    $header_type = array(
        'subtitle'=>'Title and Subtitle',
        'slider'=>'Slider',
        'image'=>'Featured Image',
        'map'=>'Google Map',
        'none'=>'None');
    $years = array('2013'=>'2013','2014'=>'2014','2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018');
    $months = array('01'=>__('January','themewaves'),'02'=>__('February','themewaves'),'03'=>__('March','themewaves'),
        '04'=>__('April','themewaves'),'05'=>__('May','themewaves'),'06'=>__('June','themewaves'),
        '07'=>__('July','themewaves'),'08'=>__('August','themewaves'),'09'=>__('Septempber','themewaves'),
        '10'=>__('October','themewaves'),'11'=>__('November','themewaves'),'12'=>__('December','themewaves'));
    $days = array(
        '01' => '1','02' => '2','03' => '3','04' => '4','05' => '5',
        '06' => '6','07' => '7','08' => '8','09' => '9','10' => '10',
        '11' => '11','12' => '12','13' => '13','14' => '14','15' => '15',
        '16' => '16','17' => '17','18' => '18','19' => '19','20' => '20',
        '21' => '21','22' => '22','23' => '23','24' => '24','25' => '25',
        '26' => '26','27' => '27','28' => '28','29' => '29','30' => '30','31' => '31',
    );
    $hours = array(
        '00' => '0','01' => '1','02' => '2','03' => '3','04' => '4',
        '05' => '5','06' => '6','07' => '7','08' => '8','09' => '9',
        '10' => '10','11' => '11','12' => '12','13' => '13','14' => '14',
        '15' => '15','16' => '16','17' => '17','18' => '18','19' => '19',
        '20' => '20','21' => '21','22' => '22','23' => '23'
    );
    /* * *********************** */
    /* Post options */
    /* * *********************** */
    $tw_post_settings = Array(
        Array(
            'name' => __('Sub Title', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'subtitle',
            'type' => 'text'),
        Array(        
            'name' => __('Post Author Show?', 'waves'),
            'desc' => __('Default setting will take from theme options.', 'waves'),
            'id' => 'post_authorr',
            'std' => 'default',
            'type' => 'selectbox'),
        Array(        
            'name' => __('Featured Media Show?', 'waves'),
            'desc' => __('Default setting will take from theme options.', 'waves'),
            'id' => 'feature_show',
            'std' => 'default',
            'type' => 'selectbox'),
        Array(        
            'name' => __('Featured Image Height?', 'waves'),
            'desc' => __('Image height (px).', 'waves'),
            'id' => 'image_height',
            'std' => '350',
            'type' => 'text'),
        Array(        
            'name' => __('Choose Post Layout?', 'waves'),
            'desc' => __('', 'themewaves'),
            'id' => 'layout',
            'options' => $selectlayout,
            'std' => 'default',
            'type' => 'select'),
        Array(        
            'name' => __('Choose Sidebar ?', 'waves'),
            'desc' => __('', 'themewaves'),
            'id' => 'sidebar',
            'options' => $selectsidebar,
            'std' => 'Default sidebar',
            'type' => 'select')
    );


    /* * *********************** */
    /* Page options */
    /* * *********************** */
    $tw_page_settings = Array(
        Array(
            'name' => __('Header type ?', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'header_type',
            'std' => 'subtitle',
            'options' => $header_type,
            'type' => 'select'),
        Array(
            'name' => __('Select Slideshow', 'waves'),
            'desc' => __('All of your created sliders will be included here.', 'waves'),
            'id' => 'slider_id',
            'type' => 'slideshow'),
        Array(
            'name' => __('Sub Title', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'subtitle',
            'type' => 'text'),
        Array(
            'name' => __('Page Title Padding', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'pt_padding',
            'type' => 'text'),
        Array(
            'name' => __('Background image of page title', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'title_bg_image',
            'type' => 'file'),
        Array(
            'name' => __('Background Image Dark?', 'waves'),
            'desc' => __('Page Title color will be white', 'waves'),
            'id' => 'bg_dark',
            'std' => 'default',
            'type' => 'selectbox'),
        Array(
            'name' => __('Parallax', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'title_prllx',
            'type' => 'checkbox'),
        Array(
            'name' => __('Google Map', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'googlemap',
            'type' => 'textarea'),
        Array(
            'name' => __('Hide Menu?', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'hide_menu',
            'std' => 'default',
            'type' => 'selectbox'),
        Array(
            'name' => __('Hide Footer?', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'hide_footer',
            'type' => 'checkbox'),
        Array(
            'name' => __('Top sidebar ?', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'top_sidebar',
            'std' => '',
            'options' => $topsidebar,
            'type' => 'select'),
        Array(
            'name' => __('Theme layout', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'theme_layout',
            'std' => 'default',
            'options' => array('default' => 'Default', 'fullwidth' => 'Fullwidth','boxed' => 'Boxed'),
            'type' => 'select'),
        Array(
            'name' => __('Background color', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'bg_color',
            'type' => 'color'),
        Array(
            'name' => __('Background image', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'bg_image',
            'type' => 'file'),
        Array(
            'name' => __('Background Image Repeat', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'bg_image_repeat',
            'std' => 'repeat',
            'options' => array('stretch' => 'Strech Image','fixed' => 'Fixed Image', 'repeat' => 'Repeat','no-repeat' => 'No Repeat','repeat-y' => 'Repeat-Y','repeat-x' => 'Repeat-X'),
            'type' => 'select'),
        Array(
            'name' => __('Margin top and bottom', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'margin_top_bottom',
            'std' => '60',
            'type' => 'text'),
    );
    $tw_onepage_settings = Array(
        Array(
            'name' => __('Menu', 'waves'),
            'desc' => __('Choose One Page Menu', 'themewaves'),
            'id'   => 'onepage_menu',
            'type' => 'menu'
        ),
        Array(
            'name' => __('Header type', 'themewaves'),
            'desc' => __('', 'themewaves'),
            'id' => 'onepage_header',
            'options' => array('image' => 'Featured image', 'slideshow' => 'Slideshow', 'video' => 'Video'),
            'type' => 'select'),
        Array(
            'name' => __('Select Slideshow', 'themewaves'),
            'desc' => __('All of your created sliders will be included here.', 'themewaves'),
            'id' => 'onepage_slider',
            'type' => 'slideshow'),
        Array( 
            "name" => __('Upload images', 'themewaves'),
            "desc" => __('Select the images that should be upload to this gallery', 'themewaves'),
            "id" => "gallery_image_ids",
            "type" => 'gallery'),
        Array( 
            "name" => __('M4V File URL', 'themewaves' ),
            "desc" => __('The URL to the .m4v video file', 'themewaves' ),
            "id" => "onepage_video_m4v",
            "type" => "text",
            ),
    );  

    $tw_comingsoon_settings = Array(
        Array(
            'name' => __('Years', 'themewaves'),
            'desc' => __('', 'themewaves'),
            'id'   => 'coming_years',
            'std'  => '2014',
            'options' => $years,
            'type' => 'select'
        ),
        Array(
            'name' => __('Months', 'themewaves'),
            'desc' => __('', 'themewaves'),
            'id'   => 'coming_months',
            'std'  => '01',
            'options' => $months,
            'type' => 'select'
        ),
        Array(
            'name' => __('Days', 'themewaves'),
            'desc' => __('', 'themewaves'),
            'id'   => 'coming_days',
            'std'  => '01',
            'options' => $days,
            'type' => 'select'
        ),
        Array(
            'name' => __('Hours', 'themewaves'),
            'desc' => __('', 'themewaves'),
            'id'   => 'coming_hours',
            'std'  => '00',
            'options' => $hours,
            'type' => 'select'
        ),
        Array(
            'name' => __('Your Feedburner Title', 'themewaves'),
            'desc' => __('If empty, Subscribe form none', 'themewaves'),
            'id'   => 'coming_link',
            'std'  => '',
            'type' => 'text'
        ),
    );
    if(!tw_option("pagebuilder")){
        $tw_page_settings[] = Array(
            'name' => __('Page Layout ?', 'themewaves'),
            'desc' => __('Choose the Layout', 'themewaves'),
            'id'   => 'layout',
            'std'  => 'full',
            'type' => 'layout'
        );
        $tw_page_settings[] = Array(
            'name' => __('Sidebar ?', 'themewaves'),
            'desc' => __('Choose your Sidebar', 'themewaves'),
            'id'   => 'custom_sidebar',
            'options' => $selectsidebar,
            'std'  => 'Default sidebar',
            'type' => 'select'
        );
    }
    //Blog Page Template
    $tw_blog_settings=array(
        Array(
            'name' => __('Show Filter ?', 'themewaves'),
            'desc' => __('Show Filter', 'themewaves'),
            'id'   => 'show_filter',
            'options'=> array('true'=>'Show','false'=>'Hide'),
            'std'  => 'true',
            'type' => 'select'),
        Array(
            'name' => __('Filter Type ?', 'themewaves'),
            'desc' => __('Select Filter Type', 'themewaves'),
            'id'   => 'filter_type',
            'options'=> array('single'=>'Single','multi'=>'Multi'),
            'std'  => 'single',
            'type' => 'select'),
        Array(
            'name' => __('Pagination Type ?', 'themewaves'),
            'desc' => __('Default setting will take from theme options.', 'themewaves'),
            'id'   => 'pagination_type',
            'options'=> array('none'=>'None','simple'=>'Simple','infinite'=>'Infinite'),
            'std'  => 'none',
            'type' => 'select'),
        Array(
            'name' => __('Order', 'themewaves'),
            'id'   => 'blog_order',
            'options' => array('date_desc'=>'Date Desc','date_asc' =>'Date Asc','title_desc'=>'Title Desc','title_asc' =>'Title Asc','random'=>'Random',),
            'std'  => 'date_desc',
            'type' => 'select'),
        Array(
            'name' => __('Excerpt count', 'themewaves'),
            'desc' => __('', 'themewaves'),
            'id'   => 'excerpt_count',
            'type' => 'text'),
        Array(
            'name' => __('Custom Read More', 'themewaves'),
            'desc' => __('', 'themewaves'),
            'id'   => 'more_text',
            'type' => 'text'),
        Array(
            'name' => __('Post count', 'themewaves'),
            'desc' => __('', 'themewaves'),
            'id'   => 'post_count',
            'type' => 'text'),
        Array(
            'name' => __('Select Category ?', 'themewaves'),
            'desc' => __('', 'themewaves'),
            'id'   => 'blog_page_category',
            'std'  => '0',
            'options'=> $cats,
            'type' => 'select'),
        Array(
            'name' => __('Category IDs', 'themewaves'),
            'desc' => __('', 'themewaves'),
            'id'   => 'blog_page_category_ids',
            'type' => 'text')
    );
    //Portfolio Page Template
    $tw_port_settings=array(
        Array(
            'name' => __('Show Filter ?', 'themewaves'),
            'desc' => __('Show Filter', 'themewaves'),
            'id'   => 'port_show_filter',
            'options'=> array('true'=>'Show','false'=>'Hide'),
            'std'  => 'true',
            'type' => 'select'),
        Array(
            'name' => __('Filter Type ?', 'themewaves'),
            'desc' => __('Select Filter Type', 'themewaves'),
            'id'   => 'filter_type',
            'options'=> array('single'=>'Single','multi'=>'Multi'),
            'std'  => 'single',
            'type' => 'select'),
        Array(
            'name' => __('Pagination Type ?', 'themewaves'),
            'desc' => __('Default setting will take from theme options.', 'themewaves'),
            'id'   => 'port_pagination_type',
            'options'=> array('none'=>'None','simple'=>'Simple','infinite'=>'Infinite'),
            'std'  => 'none',
            'type' => 'select'),
        Array(
            'name' => __('Order', 'themewaves'),
            'id'   => 'port_order',
            'options' => array('date_desc'=>'Date Desc','date_asc' =>'Date Asc','title_desc'=>'Title Desc','title_asc' =>'Title Asc','random'=>'Random',),
            'std'  => 'date_desc',
            'type' => 'select'),
        Array(
            'name' => __('Post count', 'themewaves'),
            'desc' => __('', 'themewaves'),
            'id'   => 'port_post_count',
            'type' => 'text'),
        Array(
            'name' => __('Select Category ?', 'themewaves'),
            'desc' => __('', 'themewaves'),
            'id'   => 'port_page_category',
            'std'  => '0',
            'options'=> $port_cats,
            'type' => 'select'),
        Array(
            'name' => __('Category IDs', 'themewaves'),
            'desc' => __('', 'themewaves'),
            'id'   => 'port_page_category_ids',
            'type' => 'text')
    );
    
    
    global $tw_portfolio;//, $tw_portfolio_gallery, $tw_portfolio_video;

    /* * *********************** */
    /* Portfolio options */
    /* * *********************** */

    $tw_portfolio = Array(
        Array(
            'name' => __('Gallery Layout', 'waves'),
            'desc' => __('', 'waves'),
            'id'   => 'gallery_layout',
            'std'  => 'small',
            'options' => array('small'=>'Small','large'=>'Large'),
            'type' => 'select'
        ),
        Array(
            'name' => __('Preview url', 'waves'),
            'desc' => __('', 'waves'),
            'id' => 'preview_url',
            'type' => 'text'),
    );
//    $tw_portfolio_gallery = array(
//        array( 
//            "name" => __('Upload images', 'waves'),
//            "desc" => __('Select the images that should be upload to this gallery', 'waves'),
//            "id" => "gallery_image_ids",
//            "type" => 'gallery'),
//        array(
//            'name' => __('Gallery height', 'waves'),
//            'desc' => __('', 'waves'),
//            'id' => 'gallery_height',
//            'type' => 'text'),
//    );
//    $tw_portfolio_video = array(
//            array( "name" => __('Embeded Code','waves'),
//                            "desc" => __('If you\'re not using self hosted video then you can include embeded code here.','waves'),
//                            "id" => "format_video_embed",
//                            "type" => "textarea",
//                            'std' => ''
//            ),
//    );
    
    
    global $tw_event_settings;

    /* * *********************** */
    /* Event options */
    /* * *********************** */
    
    $tw_event_settings = array(
            array( "name" => __('Author name','waves'),
                "desc" => __('','waves'),
                "id" => "event_author",
                "type" => "text",
                'std' => ''
            ),
             Array(
                'name' => __('Location', 'waves'),
                'desc' => __('', 'waves'),
                'id' => 'event_location',
                'type' => 'text'
            ),
            array( "name" => __('Duration time','waves'),
                "desc" => __('2h 30 minutes (etc)','waves'),
                "id" => "event_duration",
                "type" => "text",
                'std' => ''
            ),
            array( "name" => __('Start time','waves'),
                "desc" => __('','waves'),
                "id" => "event_date",
                "type" => "date",
                'std' => ''
            ),
    );
    
    
    global $tw_sermon_settings;

    /* * *********************** */
    /* Sermon options */
    /* * *********************** */
    
    $tw_sermon_settings = array(
        array( "name" => __('Author name','waves'),
            "desc" => __('','waves'),
            "id" => "sermon_author",
            "type" => "text",
            'std' => ''
        ),
        array( "name" => __('Duration time','waves'),
            "desc" => __('2h 30 minutes (etc)','waves'),
            "id" => "sermon_duration",
            "type" => "text",
            'std' => ''
        ),
        array( "name" => __('Location','waves'),
            "desc" => __('','waves'),
            "id" => "sermon_location",
            "type" => "text",
            'std' => ''
        ),
        array( "name" => __('Start time','waves'),
            "desc" => __('','waves'),
            "id" => "sermon_date",
            "type" => "date",
            'std' => ''
        ),
        array( "name" => __('Audio Download URL','waves'),
            "desc" => __('','waves'),
            "id" => "sermon_down_audio",
            "type" => "text",
            'std' => ''
        ),
        array( "name" => __('Video Download URL','waves'),
            "desc" => __('','waves'),
            "id" => "sermon_down_video",
            "type" => "text",
            'std' => ''
        ),
        array( "name" => __('MP3 File URL', 'waves' ),
            "desc" => __('The URL to the .mp3 audio file', 'waves' ),
            "id" => "format_audio_mp3",
            "type" => "text",
            'std' => ''
        ),
        array(  "name" => __('Thumbnail Image', 'waves' ),
            "desc" => __('The preivew image.', 'waves' ),
            "id" => "format_video_thumb",
            "type" => "text",
            'std' => ''
        ),
        array(  "name" => __('Embeded Code', 'waves' ),
            "desc" => __('If you\'re not using self hosted video or audio then you can include embeded code here.', 'waves' ),
            "id" => "format_video_embed",
            "type" => "textarea",
            'std' => ''
        ),
        array(  "name" => __('M4V File URL', 'waves' ),
            "desc" => __('The URL to the .m4v video file', 'waves' ),
            "id" => "format_video_m4v",
            "type" => "text",
            'std' => ''
        ),
    );
    
    
    
    add_meta_box('post_meta_settings',__( 'Post settings', 'waves' ),'metabox_render','post','normal','high',$tw_post_settings);
    
    add_meta_box('page_meta_settings',__( 'Page settings', 'waves' ),'metabox_render','page','normal','high',$tw_page_settings);
    add_meta_box('onepage_meta_settings',__( 'Onepage settings', 'waves' ),'metabox_render','page','normal','high',$tw_onepage_settings);
    add_meta_box('blog_meta_settings',__( 'Blog page settings', 'waves' ),'metabox_render','page','normal','high',$tw_blog_settings);
    add_meta_box('port_meta_settings',__( 'Portfolio page settings', 'waves' ),'metabox_render','page','normal','high',$tw_port_settings);
    add_meta_box('comingsoon_meta_settings',__( 'ComingSoon page settings', 'waves' ),'metabox_render','page','normal','high',$tw_comingsoon_settings);
    
    add_meta_box('portfolio_meta_settings',__( 'Portfolio settings', 'waves'),'metabox_render','portfolio','normal','high',$tw_portfolio);
//    add_meta_box('portfolio_gallery_settings',__( 'Portfolio gallery settings', 'waves'),'metabox_render','portfolio','normal','high',$tw_portfolio_gallery);
//    add_meta_box('portfolio_video_settings',__( 'Portfolio video settings', 'waves'),'metabox_render','portfolio','normal','high',$tw_portfolio_video);
    
    add_meta_box('event_meta_settings',__( 'Event item settings', 'waves'),'metabox_render','event','normal','high',$tw_event_settings);
    add_meta_box('sermon_meta_settings',__( 'Sermon item settings', 'waves'),'metabox_render','tw-sermon','normal','high',$tw_sermon_settings);
}