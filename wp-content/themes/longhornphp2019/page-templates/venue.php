<?php
/* Template Name: Venue */
get_header();
?>

<div class="container">
    <main class="site-main">
        <?php
        while ( have_posts() ) : the_post();

            get_template_part( 'template-parts/content', 'page' );

        endwhile;
        ?>
    </main>

    <div class="row">
        <div class="col-md-4 col-xl-3">
            <nav id="venue-nav" class="venue-nav list-group sticky-top">
                <?php if ( have_rows('venue_sections') ): ?>
                    <?php while ( have_rows('venue_sections') ): the_row(); ?>
                        <a
                            class="list-group-item list-group-item-action"
                            href="#section-<?php echo sanitize_title(get_sub_field('menu_name')); ?>">
                            <?php the_sub_field('menu_name'); ?>
                        </a>
                    <?php endwhile; ?>
                <?php endif; ?>
            </nav>
        </div>
        <div class="venue-sections col-md-8 col-xl-9">
            <?php if ( have_rows('venue_sections') ): ?>
                <?php while ( have_rows('venue_sections') ): the_row(); ?>
                    <section id="section-<?php echo sanitize_title(get_sub_field('menu_name')); ?>">
                        <h2><?php the_sub_field('menu_name'); ?></h2>
                        <?php the_sub_field('content'); ?>
                    </section>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
get_footer();
