<?php

function tw_custom_styles() {

    //This will Control the Color of Light or Dark
    function ColorLuminance($color, $percent) {
        $color = str_replace("#", "", $color);
        if (strlen($color) == 3) {
            $R = hexdec(substr($color, 0, 1) . substr($color, 0, 1));
            $G = hexdec(substr($color, 1, 1) . substr($color, 1, 1));
            $B = hexdec(substr($color, 2, 1) . substr($color, 2, 1));
        } else {
            $R = hexdec(substr($color, 0, 2));
            $G = hexdec(substr($color, 2, 2));
            $B = hexdec(substr($color, 4, 2));
        }

        $R = intval($R);
        $G = intval($G);
        $B = intval($B);

        $R = round($R * (100 + $percent) / 100);
        $G = round($G * (100 + $percent) / 100);
        $B = round($B * (100 + $percent) / 100);

        $R = (string) dechex(($R < 255) ? $R : 255);
        $G = (string) dechex(($G < 255) ? $G : 255);
        $B = (string) dechex(($B < 255) ? $B : 255);

        $RR = (strlen($R) == 1) ? ("0" . $R) : $R;
        $GG = (strlen($G) == 1) ? ("0" . $G) : $G;
        $BB = (strlen($B) == 1) ? ("0" . $B) : $B;

        return "#" . $RR . $GG . $BB;
    }

    function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        return implode(",", $rgb); // returns the rgb values separated by commas
    }
    ?>

    <style>
        body {
            font-family: <?php echo tw_option('body_text_font', 'face'); ?>, Arial, Helvetica, sans-serif;
            font-size: <?php echo tw_option('body_text_font', 'size'); ?>; 
            font-weight: <?php echo tw_option('body_text_font', 'style'); ?>; 
            color: <?php echo tw_option('body_text_font', 'color'); ?>;
            <?php
            $boxed = false;
            if (get_metabox("theme_layout") == "boxed") {
                $boxed = true;
            } else if (get_metabox("theme_layout") != "fullwidth") {
                if (tw_option("theme_layout") == "boxed") {
                    $boxed = true;
                }
            }
            if ($boxed) {
                if (tw_option('background_color') != "") {
                    echo 'background-color: ' . tw_option('background_color') . ';';
                }
                if (tw_option('background_image') != "") {
                    echo 'background-image: url(' . tw_option('background_image') . ');';
                    if (tw_option('background_repeat') != 'stretch') {
                        echo 'background-repeat: ' . tw_option('background_repeat') . ';';
                    } else {
                        echo '-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;';
                    }
                }
                echo "background-attachment: fixed;";
                echo "margin-top:" . tw_option('margin_top') . "px;";
                echo "margin-bottom:" . tw_option('margin_bottom') . "px;";
            }
            ?>
        }
        <?php ?>


        #sidebar a{
            font-family: <?php echo tw_option('body_text_font', 'face'); ?>, Arial, Helvetica, sans-serif;
        }
        #sidebar a.rsswidget{ color: <?php echo tw_option('primary_color'); ?>; }
        h1,h2,h3,h4,h5,h6,
        input[type="password"],
        input[type="submit"],
        input[type="reset"],
        input[type="button"]
        button,
        .btn,
        .accordion-heading .accordion-toggle,
        .waves-heading .heading-title,
        .pricing-top>span:first-child,
        .process-title,
        .process-number,
        .nav-tabs>li span,
        .portfolio-overlay .portfolio-meta,
        .waves-pagination ul.page-numbers{font-family: <?php echo tw_option('heading_font'); ?>;}
        h1{ font-size: <?php echo tw_option('h1_spec_font', 'size'); ?>; color: <?php echo tw_option('h1_spec_font', 'color'); ?>; }
        h2{ font-size: <?php echo tw_option('h2_spec_font', 'size'); ?>; color: <?php echo tw_option('h2_spec_font', 'color'); ?>; }
        h3{ font-size: <?php echo tw_option('h3_spec_font', 'size'); ?>; color: <?php echo tw_option('h3_spec_font', 'color'); ?>; }
        h4{ font-size: <?php echo tw_option('h4_spec_font', 'size'); ?>; color: <?php echo tw_option('h4_spec_font', 'color'); ?>; }
        h5{ font-size: <?php echo tw_option('h5_spec_font', 'size'); ?>; color: <?php echo tw_option('h5_spec_font', 'color'); ?>; }
        h6{ font-size: <?php echo tw_option('h6_spec_font', 'size'); ?>; color: <?php echo tw_option('h6_spec_font', 'color'); ?>; }


        /* Header ------------------------------------------------------------------------ */  
        #header, .header-clone { background-color: <?php echo tw_option('header_background'); ?>; }
        #page-title { background-color: <?php echo tw_option('page_title_background'); ?>; padding-top: <?php echo tw_option('pt_paddingtop'); ?>px; padding-bottom: <?php echo tw_option('pt_paddingbottom'); ?>px; }
        #page-title h1 {font-family: <?php echo tw_option('page_title', 'face'); ?>, Arial, Helvetica, sans-serif; font-size: <?php echo tw_option('page_title', 'size'); ?>; font-weight: <?php echo tw_option('page_title', 'style'); ?>; color: <?php echo tw_option('page_title', 'color'); ?>; }
        <?php if(get_metabox('pt_padding')!=''){
            echo '#page-title {padding:'.get_metabox('pt_padding').'px 0;}';
        } ?>
        /* Body BG color ------------------------------------------------------------------------ */  
        body { background: <?php echo tw_option('background_color'); ?>; }

        .tw-logo { line-height: <?php echo tw_option('header_height'); ?>px; height: <?php echo tw_option('header_height'); ?>px;}
        .tw-logo img { line-height: <?php echo tw_option('header_height'); ?>px; max-height: <?php echo tw_option('header_height'); ?>px;}
        .tw-top-widget { height: <?php echo tw_option('header_height'); ?>px;}
        
        /* Menu CSS ------------------------------------------------------------------------ */
        .sf-menu .waves-mega-menu .mega-menu-title { font-family: <?php echo tw_option('menu_font', 'face'); ?>, Arial, Helvetica, sans-serif;}
        ul.sf-menu > li a{ font-family: <?php echo tw_option('menu_font', 'face'); ?>, Arial, Helvetica, sans-serif; font-size: <?php echo tw_option('menu_font', 'size'); ?>; font-weight: <?php echo tw_option('menu_font', 'style'); ?>; color: <?php echo tw_option('menu_font', 'color'); ?>; }

        ul.sf-menu li ul li{ background-color: <?php echo tw_option('submenu_bg'); ?>;}
        ul.sf-menu > li > a:after{ color: <?php echo tw_option('submenu_bg'); ?>;}
        ul.sf-menu ul { border-color: <?php echo tw_option('menu_hover'); ?>;}
        ul.sf-menu li ul li:hover{ background-color: <?php echo tw_option('submenu_link'); ?>; border-color: <?php echo tw_option('submenu_link'); ?>; }
        ul.sf-menu ul li.current_page_item[class^="fa-"]:before, .sf-menu ul li.current_page_item[class*=" fa-"]:before,
        ul.sf-menu ul li.current_page_item[class^="icon-"]:before, .sf-menu ul li.current_page_item[class*=" icon-"]:before{
            color: <?php echo tw_option('menu_hover'); ?>; }
        ul.sf-menu > li.current_page_item > a, .sf-menu > li.current_page_ancestor >a, .sf-menu > li.current-menu-ancestor >a, .sf-menu > li.current-menu-item > a{ color: <?php echo tw_option('menu_hover'); ?>;}
        ul.sf-menu > li:hover > a{ color: <?php echo tw_option('menu_hover'); ?>; }

        /* Pagebuilder Title ----------------------------------------------------- */
        .waves-title h3{font-family: <?php echo tw_option('element_title', 'face'); ?>, Arial, Helvetica, sans-serif; font-size: <?php echo tw_option('element_title', 'size'); ?>; font-weight: <?php echo tw_option('element_title', 'style'); ?>; color: <?php echo tw_option('element_title', 'color'); ?>; }
        /* Sidebar Widget Title ----------------------------------------------------- */ 
        h3.widget-title{font-family: <?php echo tw_option('sidebar_widgets_title', 'face'); ?>, Arial, Helvetica, sans-serif; font-size: <?php echo tw_option('sidebar_widgets_title', 'size'); ?>; font-weight: <?php echo tw_option('sidebar_widgets_title', 'style'); ?>; color: <?php echo tw_option('sidebar_widgets_title', 'color'); ?>; }
        /* Footer Widget Title ----------------------------------------------------- */ 
        .waves-bottom h3.widget-title{font-family: <?php echo tw_option('footer_widgets_title', 'face'); ?>, Arial, Helvetica, sans-serif; font-size: <?php echo tw_option('footer_widgets_title', 'size'); ?>; font-weight: <?php echo tw_option('footer_widgets_title', 'style'); ?>; color: <?php echo tw_option('footer_widgets_title', 'color'); ?>; }


        /* Footer ------------------------------------------------------------------------ */  
        #bottom a:hover,#footer a:hover{ color: <?php echo tw_option('primary_color'); ?>; }

        /* General Color ------------------------------------------------------------------------ */ 

        ::selection{ background: <?php echo tw_option('primary_color'); ?>; }
        ::-moz-selection{ background: <?php echo tw_option('primary_color'); ?>; }

        /* Primary Color Changes */

        /* BG states*/

        .tw-infinite-scroll a, .tw-coming-soon .days,
        .tw-coming-soon .hours, .tw-coming-soon .minutes, .tw-coming-soon .seconds,
        .format-link .link-content,
        .tw-filters ul.filters li a.selected,
        .service-featured .tw-service-content a.more,
        .waves-portfolio .meta-link a, .waves-portfolio .meta-like,
        ul.waves-list>li>i,
        .waves-about .about-type-title>.about-title,
        .waves-about .about-type-content:hover>.about-bullet,
        .accordion-group.active .accordion-toggle,
        #scrollUp,.pricing-column.featured .pricing-top,.pricing-column.featured .pricing-footer a,
        .waves-callout .callout-container,
        .waves-thumbnail .meta-link a,
        .entry-date,
        .nav-tabs>li.active a, .waves-pagination ul.page-numbers li span.current,
        .title-seperator i.default > span,
        .waves-aboutme.aboutme-style-2 .aboutme-meta a i,
        .tw-service-content a.more:hover
        {background-color: <?php echo tw_option('primary_color'); ?>; }

        /* BG Hover states*/

        .tw-service-box:hover.style_1 .tw-font-icon, .tw-service-box:hover.style_2 .tw-font-icon,.waves-about .about-type-content>.about-content:hover:after,
        .tagcloud a:hover, #bottom .tagcloud a:hover,
        .pricing-column:hover .pricing-top, .pricing-column:hover .pricing-footer a,
        .waves-pagination ul.page-numbers li a:hover,
        .tw-service-box.style_1:hover .tw-service-content a.more
        {background-color: <?php echo tw_option('primary_color'); ?> !important; }


        /* Color states*/
        h3.error404 span, .tw-service-content a:before, 
        .sf-menu .waves-mega-menu .mega-menu-title,
        .pricing-footer a,.testimonial-meta i.fa-star,
        .tw-coming-soon>.sep,#sidebar aside.widget ul li.current-menu-item a,#sidebar aside.widget ul li.current-menu-item:before,
        .pricing-header h1,.pricing-top,
        .posts-tab-widget .nav-tabs>li.active a:after,
        .waves-pagination ul.page-numbers li a, .waves-pagination ul.page-numbers li span,
        article.single-portfolio h2.portfolio-title,
        .waves-aboutme.aboutme-style-2 h2
        {color: <?php echo tw_option('primary_color'); ?>; }

        /* Color Hover states*/

        .tw-infinite-scroll a:hover,.nav-tabs>li:hover a,
        .entry-title a:hover,div.entry-meta > span a:hover,
        aside ul li a:hover,
        button:hover, input[type="submit"]:hover, input[type="reset"]:hover, input[type="button"]:hover,
        .testimonial-author a:hover, .carousel-meta a, 
        .waves-carousel-portfolio .portfolio-meta a:hover, .waves-portfolio .portfolio-meta a:hover,
        .sf-menu ul.waves-mega-menu [class^="fa-"]:hover:before,
        .sf-menu ul.waves-mega-menu [class*=" fa-"]:hover:before,
        .sf-menu ul.waves-mega-menu .current_page_item[class^="fa-"]:before,
        .sf-menu ul.waves-mega-menu .current_page_item[class*=" fa-"]:before,
        .sf-menu ul.waves-mega-menu [class^="icon-"]:hover:before,
        .sf-menu ul.waves-mega-menu [class*=" icon-"]:hover:before,
        .sf-menu ul.waves-mega-menu .current_page_item[class^="icon-"]:before,
        .sf-menu ul.waves-mega-menu .current_page_item[class*=" icon-"]:before,
        .waves-heading .heading-title>span,
        .waves-about .about-type-content:hover .about-title,
        .tw-service-box.service-featured h3, .tw-service-box:hover.style_2 h3, .tw-service-box:hover.style_1 h3,
        .waves-team:hover .member-title h2,
        ul.sf-menu li ul.waves-mega-menu li:hover>a,
	.member-social .tw-social-icon a:hover,
        .waves-aboutme .aboutme-meta a i:hover,
        .waves-aboutme.aboutme-style-2 .aboutme-meta a i:hover
        {color: <?php echo tw_option('primary_color'); ?>; }
        .pricing-column.featured .pricing-footer a:hover,.pricing-column:hover .pricing-footer a:hover{
            color: <?php echo tw_option('primary_color'); ?> !important;
        }

        /* Border states*/
        .pricing-top,.tw-dropcap.dropcap_border,
        .nextprev-postlink .home-link a,
        .service-featured .tw-service-content a.more, .tw-infinite-scroll a, 
        .pricing-column.featured .pricing-box,.pricing-footer a,
        .nav-tabs>li.active:first-child a,.posts-tab-widget .nav-tabs>li.active a,
        .waves-pagination ul.page-numbers li,
        .tab-content,
        .waves-aboutme.aboutme-style-2 .aboutme-meta a i,
        .nextprev-postlink .prev-post-link a:before, .nextprev-postlink .next-post-link a:after,
        textarea:focus, input[type="text"]:focus, input[type="password"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="date"]:focus, input[type="month"]:focus, input[type="time"]:focus, input[type="week"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="color"]:focus
        {border-color: <?php echo tw_option('primary_color'); ?>; }

        /* Border Hover states*/

        button:hover, input[type="submit"]:hover, input[type="reset"]:hover, input[type="button"]:hover,
        #sidebar .tagcloud a:hover,#footer .tagcloud a:hover, .tw-service-content a.more:hover,
        .tw-infinite-scroll a:hover,.pricing-column:hover .pricing-box,
        .waves-about .about-type-content>.about-content:hover:after,.pricing-column.featured .pricing-footer a, .pricing-column:hover .pricing-footer a,
        .tagcloud a:hover, #bottom .tagcloud a:hover,
        .tw_post_sharebox a:hover,
        .waves-aboutme .aboutme-meta a i:hover,
        .waves-aboutme.aboutme-style-2 .aboutme-meta a i:hover,
        .tw-service-box.style_1:hover .tw-service-content a.more
        {border-color: <?php echo tw_option('primary_color'); ?>; }
        
        .member-image .image-overlay
        {background: <?php echo "rgba(" . hex2rgb(tw_option('primary_color')) . ",.8)" ?>; }

        <?php
        if (is_page() && get_metabox("theme_layout") == "boxed") {
            global $post;
            echo 'body.page-id-' . $post->ID . ' {';
            if (get_metabox('bg_color') != "") {
                echo 'background-color: ' . get_metabox('bg_color') . ';';
            }
            if (get_metabox('bg_image') != "") {
                echo 'background-image: url(' . get_metabox('bg_image') . ');';
                if (get_metabox('bg_image_repeat') != 'stretch') {
                    echo 'background-repeat: ' . get_metabox('bg_image_repeat') . ';';
                } if (get_metabox('bg_image_repeat') == 'fixed') {
                    echo 'background-attachment: ' . get_metabox('bg_image_repeat') . ';';
                } else {
                    echo '-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;';
                }
            }
            if (get_metabox('margin_top_bottom') != "") {
                echo "margin-top:" . get_metabox('margin_top_bottom') . "px;";
                echo "margin-bottom:" . get_metabox('margin_top_bottom') . "px";
            }
            echo '}';
        }
        ?>
        .pace .pace-progress{background-color: <?php echo tw_option('primary_color'); ?>;}



        /* Custom CSS */
        <?php echo tw_option('custom_css'); ?>
    </style>

    <?php
}

add_action('wp_head', 'tw_custom_styles', 100);
?>