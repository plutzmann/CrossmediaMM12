</div>
</section>
<?php
if (!get_metabox("hide_footer")) {
    

if (tw_option("footer_fixed") && tw_option('responsive') !== '0') {
    echo '<div class="fixed-footer">';
}
?>
<!-- End Main --><?php if (tw_option("footer_widget")) { ?>
    <div id="bottom" class="waves-bottom">
        <!-- Start Container-->
        <div class="container">
            <div class="row">
                <?php
                $grid = tw_option('footer_layout') ? tw_option('footer_layout') : '3-3-3-3';
                $i = 1;
                foreach (explode('-', $grid) as $g) {
                    echo '<div class="col-md-' . $g . ' col-' . $i . '">';
                    dynamic_sidebar("footer-sidebar-$i");
                    echo '</div>';
                    $i++;
                }
                ?>
            </div>
        </div>
        <!-- End Container -->
    </div><?php
}

if (tw_option('footer_text')) {
    ?>
    <footer id="footer">
        <!-- Start Container -->
        <div class="container">
            <p class="copyright"><?php echo stripslashes(tw_option('copyright_text')); ?></p>
        </div>
        <!-- End Container -->
    </footer><?php
}
if (tw_option("footer_fixed") && tw_option('responsive') !== '0') {
    echo '</div>';
}
}
?>
</div>
<?php
/* Google Analytics Code */
echo stripslashes(tw_option('tracking_code'));

//$gotop = __('Scroll to top', 'themewaves');
//echo '<a id="scrollUp" title="' . $gotop . '"><i class="fa fa-chevron-up"></i></a>';
?>
<?php wp_footer(); ?>
</body>
</html>