<?php
$class = '';
$class2 = '';
if (get_metabox("bg_dark") == "true") {
    $class2 = ' class="light"';
} else if (get_metabox("bg_dark") != "false") {
    if (tw_option("title_bg_dark")) {
        $class2 = ' class="light"';
    }
}

if (is_home()) {
        $title = "<h1>" . apply_filters('widget_title', tw_option('blog_title')) . "</h1>";
        $subtitle = tw_option('blog_subtitle') != "" ? ('<p>' . apply_filters('widget_title', tw_option("blog_subtitle")) . '</p>') : '';
} elseif(is_singular('post')){
        $title = "<h1>" . get_the_title() . "</h1>";
        $subtitle = '';
} elseif(is_singular('portfolio')){
        $title = "<h1>" . apply_filters('widget_title', tw_option('port_title')) . "</h1>";
        $subtitle = tw_option('port_subtitle') != "" ? ('<p>' . apply_filters('widget_title', tw_option("port_subtitle")) . '</p>') : '';
} else {
    $subtitle = "";
    if (is_page()) {
        $title = "<h1>" . get_featuredtext() . "</h1>";
        if (get_metabox("subtitle") != "") {
            $subtitle = "<p>" . apply_filters('widget_text', get_metabox("subtitle")) . "</p>";
        }
        if (get_metabox("title_bg_image") != "") {
            $bgimage = get_metabox("title_bg_image");
        }
        if (get_metabox("title_prllx")) {
            $class = ' class="bg-parallax"';
        }
    } else {
        $title = "<h1>" . get_featuredtext() . "</h1>";
    }
}

$background = isset($bgimage) ? $bgimage : tw_option('title_bg_image');
$style1 = !empty($background) ? (' style="background-image: url(' . $background . ')"') : '';

if (isset($title)) {
    ?>
    <!-- Start Feature -->
    <section id="page-title"<?php echo $class . $class2 . $style1; ?>>
        <!-- Start Container -->
        <div class="container">
            <?php
                echo $title . $subtitle;
            ?>            
        </div>
        <!-- End Container -->
    </section>
    <!-- End Feature -->
    <?php
}
?>