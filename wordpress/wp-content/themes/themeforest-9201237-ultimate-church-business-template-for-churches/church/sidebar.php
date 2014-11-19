<div class="waves-sidebar col-md-4">
    <section id="sidebar" class="clearfix">
        <?php
        if(!dynamic_sidebar(get_metabox("custom_sidebar")!="" ? get_metabox("custom_sidebar") : 'default-sidebar')) {
            print 'There is no widget. You should add your widgets into <strong>';
            print 'Default';
            print '</strong> sidebar area on <strong>Appearance => Widgets</strong> of your dashboard. <br/><br/>';
        ?>
            <aside id="archives" class="widget">
                <div class="tw-widget-title-container">
                    <h3 class="widget-title"><?php _e('Archives', 'themewaves'); ?></h3>
                    <span class="tw-title-border"></span>
                </div>
                <ul class="side-nav">
                    <?php wp_get_archives(array('type' => 'monthly')); ?>
                </ul>
            </aside>
        <?php } ?>
    </section>
</div>