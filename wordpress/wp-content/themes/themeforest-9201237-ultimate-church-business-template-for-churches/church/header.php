<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<html <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- Mobile Specific Metas
        ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <?php current_title(); ?>
        <?php tw_favicon(); ?>
        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <?php facebookOpenGraphMeta(); ?>
        <?php wp_head(); ?>
    </head>
    <body <?php if(is_page_template('template-onepage.php')) {echo ' id="one-page-home" ';} body_class(tw_option('pageloader')?'loading':''); ?>>
        <?php if(tw_option('pageloader')){echo '<div id="waves-loader"></div>';} ?>
        <div id="theme-layout">
                    <!-- Start Header -->
                    <header class="header-container">
                        <div class="container">
                            <?php
                            $hidemenu = false;
                            if (get_metabox("hide_menu") == "true") {
                                $hidemenu = true;
                            } else if (get_metabox("hide_menu") != "false") {
                                if (tw_option("hide_menu")) {
                                    $hidemenu = true;
                                }
                            }
                            if(get_metabox('top_sidebar')!=''){
                                ob_start();
                                dynamic_sidebar(get_metabox('top_sidebar'));
                                $topwidget = ob_get_clean();
                            } else {
                                ob_start();
                                dynamic_sidebar('top-widget');
                                $topwidget = ob_get_clean();
                            } ?>

                            <?php
                            $logo_class = '';
                            if(empty($topwidget)){
                                    $logo_class = ' logo-center';
                            }else{
                                    echo '<div class="top-widget"><div class="tw-top-widget">'.$topwidget.'</div></div>';
                            }
                            echo '<div class="logo-container'.$logo_class.'">';
                                tw_logo($hidemenu);
                                echo '<div class="show-mobile-menu'.$logo_class.' clearfix">';
                                echo '<a href="#mobile-menu" class="mobile-menu-icon">';
                                    echo '<span></span><span></span><span></span>';
                                echo '</a>';
                            echo '</div>';
                            echo '</div>';
                            ?>            
                        </div>
                        <nav id="mobile-menu"><?php tw_mobile_menu(); ?></nav>
                    </header>
                    <div class="menu-container<?php if($hidemenu){echo' hidden-menu';} ?>">
                        <div class="container">
                            <nav class="waves-menu-container">                                
                                <?php tw_menu();?>
                            </nav>                                            
                        </div>
                    </div>
            <!-- End Header -->
            <?php
            if (!is_page_template('page-onepage.php')) {
                get_template_part('slider');
            } ?>
            <!-- Start Main -->
            <section id="main">
                    <div <?php echo is_page() ? 'id="page"' : 'class="waves-container container"'; ?>>