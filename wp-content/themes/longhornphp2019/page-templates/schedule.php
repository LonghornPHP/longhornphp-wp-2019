<?php
/* Template Name: Schedule */
get_header();
?>

<div class="container schedule">
    <div class="row">
        <main class="site-main col-md-9">
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
                $room_sponsors_raw = get_field('room_sponsors', 'options');
                $room_sponsors = [];
                foreach ($room_sponsors_raw as $room_sponsor) {
                    $room_sponsors[$room_sponsor['room_name']] = $room_sponsor['sponsor'];
                }
            ?>

            <div class="day-schedule" id="tutorial-day">
                <div class="day-intro">
                    <h2>Thursday, May 2nd</h2>
                    <p><strong>Tutorial Day</strong></p>
                </div>
                <?php
                    $slots = get_slots('2019-05-02');
                    $rooms = ['Bevo', 'Longhorn', 'Stadium'];
                ?>
                <?php include get_template_directory() . '/template-parts/schedule-table.php'; ?>
            </div>

            <div class="day-schedule" id="main-day-1">
                <div class="day-intro">
                    <h2>Friday, May 3rd</h2>
                    <p><strong>Main Conference – Day 1</strong></p>
                </div>
                <?php
                    $slots = get_slots('2019-05-03');
                    $rooms = ['Big Tex', 'Balcones', 'Stadium'];
                ?>
                <?php include get_template_directory() . '/template-parts/schedule-table.php'; ?>
            </div>

            <div class="day-schedule" id="main-day-2">
                <div class="day-intro">
                    <h2>Saturday, May 4th</h2>
                    <p><strong>Main Conference – Day 2</strong></p>
                </div>
                <?php
                    $slots = get_slots('2019-05-04');
                    $rooms = ['Big Tex', 'Balcones', 'Stadium'];
                ?>
                <?php include get_template_directory() . '/template-parts/schedule-table.php'; ?>
            </div>

            <div class="section-register">
                <div class="container">
                    <h2 class="text-center">Register</h2>
                    <?php the_field('registration_embed_code', 'options'); ?>
                </div>
            </div>

        </main>

        <sidebar class="sponsors-sidebar mt-5 mt-md-0 col-md-3">
            <?php get_sidebar(); ?>
        </sidebar>
    </div>
</div>

<?php
get_footer();
