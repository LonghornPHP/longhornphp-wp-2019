<?php
/* Template Name: Sponsors */
get_header();
?>

<div class="container">
    <div class="row">
        <main class="site-main col-sm-9 mx-sm-auto">
            <?php while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/content', 'page' );
            endwhile; ?>
        </main>
    </div>
</div>

<div class="container">
    <?php get_template_part( 'template-parts/sponsors' ); ?>
</div>

<?php
get_footer();
