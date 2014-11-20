<?php
get_header();
?>

<div class="row">
    <div class="waves-main">
        <section class="content">
            <div id="error404-container">
                <h3 class="error404"><span><?php _e("404 ERROR", "themewaves");?></span></h3>
                <h2 class="errorh2"><?php _e("Oops! Something went wrong.<br/>
That page doesn't exist or has moved.", "themewaves");?></h2>
                <div class="tw-404-search-container">
                <?php get_search_form(); ?><div class="error4button"><a href="<?php echo home_url(); ?>" target="_blank" class="btn-small btn-hover2" style="border-color: #fff;"><?php _e("&raquo;  Go to Home Page", "themewaves");?></a></div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php
get_footer();
?>