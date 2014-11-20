<?php
global $tw_isArchive, $size;
$tw_isArchive = true;
	
get_header();
$size = 'col-md-8';
$klas = 'right';
switch (tw_option('category_layout')){
    case 'full' : $klas = 'full'; $size = 'col-md-12';break;
    case 'left' : $klas = 'left';break;
}
?>

<div class="row">
    <?php if ($klas == "left") { get_sidebar(); } ?>
    <div class="waves-main <?php echo $size;?>">
        <section class="content">
                <?php get_template_part("loop");?>
        </section>
    </div>
    <?php if ($klas == "right") { get_sidebar(); } ?>
</div>

<?php get_footer();?>