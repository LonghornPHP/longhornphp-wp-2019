<?php
/* Template Name: Speakers */
get_header();
?>

<div class="container archive speakers">
    <div class="row">
        <main class="site-main col-sm-12">
            <?php if ( have_posts() ) : ?>

                <header class="page-header mb-5">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <hr>
                </header>

                <?php while ( have_posts() ) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </article>

                <?php endwhile;

            endif; ?>

            <?php
                $keynote_speakers = get_speakers_by_type(['keynote-speaker']);
                $keynote_speakers = fill_speakers_with_talks($keynote_speakers);
                $other_speakers = get_speakers_by_type(['tutorial-speaker', 'regular-speaker']);
                $other_speakers = fill_speakers_with_talks($other_speakers);
            ?>

            <?php foreach ($keynote_speakers as $speaker) : ?>
                <?php $is_keynoter = true; ?>
                <?php include get_template_directory() . '/template-parts/speaker-card.php'; ?>
            <?php endforeach; ?>

            <?php foreach ($other_speakers as $speaker) : ?>
                <?php $is_keynoter = false; ?>
                <?php include get_template_directory() . '/template-parts/speaker-card.php'; ?>
            <?php endforeach; ?>

        </main>
    </div>

    <div class="sponsors-list text-center mt-5">
        <h2 class="mb-4">Sponsors</h2>
        <?php get_template_part( 'template-parts/sponsors' ); ?>
    </div>
</div>

<?php
get_footer();
