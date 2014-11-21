</div>
</section>
<!-- End Main -->
<?php
global $tw_end;
echo $tw_end;
?>
<?php
/* Google Analytics Code */
echo stripslashes(tw_option('tracking_code'));

$gotop = __('Scroll to top', 'themewaves');
echo '<a id="scrollUp" title="'.$gotop.'"><i class="fa fa-chevron-up"></i></a>';
?>
<?php wp_footer(); ?>
</body>
</html>