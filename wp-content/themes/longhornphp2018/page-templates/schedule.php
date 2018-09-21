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

            <?php foreach (['thursday', 'friday', 'saturday'] as $day) : ?>
                <?php $rooms = get_field($day . '_schedule_room_names', 'options'); ?>

                <?php if (have_rows($day . '_schedule_sessions', 'options')) : ?>

                    <div class="day-schedule">
                        <div class="day-intro">
                            <?php the_field($day . '_schedule_intro', 'options'); ?>
                        </div>

                        <div class="table-responsive-md">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="start-end align-middle">Start / End</th>
                                    <th style="text-align: center;" colspan="<?php echo count($rooms); ?>">
                                    Room Name</th>
                                </tr>
                                <tr>
                                    <?php foreach ($rooms as $room) : ?>
                                        <th>
                                            <?php echo esc_html( $room['room_name'] ); ?>
                                        </th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while (have_rows($day . '_schedule_sessions', 'options')) : the_row(); ?>
                                    <tr>
                                        <td class="start-end">
                                            <?php the_sub_field('start_time'); ?><br>
                                            <?php the_sub_field('end_time'); ?>
                                        </td>
                                        <?php if (have_rows('tracks')) : ?>
                                            <?php while (have_rows('tracks')) : the_row(); ?>
                                                <?php if (get_sub_field('event_type') === 'Custom') : ?>
                                                    <td
                                                        <?php if (get_sub_field('fills_block')) : ?>
                                                            colspan="<?php echo count($rooms); ?>"
                                                            align="center"
                                                            style="vertical-align: middle;"
                                                        <?php endif; ?>
                                                        >
                                                        <?php the_sub_field('event_name'); ?>
                                                    </td>
                                                <?php else : ?>
                                                    <?php $session = get_sub_field('session'); ?>
                                                    <td
                                                        <?php if (get_sub_field('fills_block')) : ?>
                                                            colspan="<?php echo count($rooms); ?>"
                                                            align="center"
                                                            style="vertical-align: middle;"
                                                        <?php endif; ?>
                                                        >
                                                        <a href="<?php the_field('sessions_page', 'options'); ?>#<?php echo esc_attr( $session->post_name ); ?>">
                                                            <?php echo esc_html($session->post_title); ?>
                                                        </a>
                                                        <?php $speakers = get_field('speaker_session_relationship', $session->ID); ?>
                                                        <?php if (!empty($speakers)) : ?>
                                                            <br>
                                                            <?php $speakers = array_values($speakers); ?>
                                                            <small>by <a href="<?php the_field('speakers_page', 'options'); ?>#<?php echo esc_attr( $speakers[0]->post_name ); ?>">
                                                                <?php echo esc_html($speakers[0]->post_title); ?>
                                                            </a></small>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        </div>
                    </div><!-- day-schedule -->
                <?php endif; ?>

            <?php endforeach; ?>

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
