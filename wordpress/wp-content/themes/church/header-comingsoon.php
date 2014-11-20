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
        <!--[if IE 7]><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/font-awesome/font-awesome-ie7.min.css"><![endif]-->
        <?php
        facebookOpenGraphMeta();
        global $tw_end;
        $tw_start = $tw_end = '';
        $bg = waves_image(0, 0, true);
        wp_head(); ?>
    </head>
    <body <?php body_class(); echo !empty($bg) ? (' style="background:url('.$bg.'); background-size:cover;"') : '';?>>
        <?php echo $tw_start; ?>
        <!-- Start Main -->
        <section id="main">
            <div <?php echo is_page() ? 'id="page"' : 'class="container"'; ?>>