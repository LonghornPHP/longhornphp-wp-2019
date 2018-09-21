<?php
/* Template Name: Sessions */
get_header();
?>

<div class="container archive speakers">
    <div class="row">
        <main class="site-main col-sm-12">
            <?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <hr>
                </header>

                <?php while ( have_posts() ) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                        <div class="legend">
                            <span class="session-level badge badge-pill badge-light entry">
                                <i class="fas fa-star"></i>
                            </span>
                            <span class="session-level badge badge-pill badge-light intermediate">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </span>
                            <span class="session-level badge badge-pill badge-light advanced">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </span>
                            - Entry, Intermediate, Advanced
                        </div>
                    </article>

                <?php endwhile;

            endif; ?>

            <?php
                $keynotes = get_sessions_by_type(['keynote']);
                $keynotes = fill_sessions_with_speakers($keynotes);
                $tutorials = get_sessions_by_type(['tutorial']);
                $tutorials = fill_sessions_with_speakers($tutorials);
                $regulars = get_sessions_by_type(['regular']);
                $regulars = fill_sessions_with_speakers($regulars);
            ?>

            <div class="session-list keynotes">
                <h2>Keynotes</h2>
                <?php the_field('keynotes_description'); ?>
                <div class="list-group">
                    <?php foreach ($keynotes as $session) : ?>
                        <?php include get_template_directory() . '/template-parts/session-card.php'; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="session-list tutorials">
                <h2>Tutorials</h2>
                <?php the_field('tutorials_description'); ?>
                <div class="list-group">
                    <?php foreach ($tutorials as $session) : ?>
                        <?php include get_template_directory() . '/template-parts/session-card.php'; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="session-list talks">
                <h2>Talks</h2>
                <?php the_field('talks_description'); ?>
                <div class="list-group">
                    <?php foreach ($regulars as $session) : ?>
                        <?php include get_template_directory() . '/template-parts/session-card.php'; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>

    <div class="sponsors-list text-center mt-5">
        <h2 class="mb-4">Sponsors</h2>
        <?php get_template_part( 'template-parts/sponsors' ); ?>
    </div>
</div>

<?php
get_footer();
