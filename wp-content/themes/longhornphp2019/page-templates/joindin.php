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

            endif; ?>
            
            <?php
            $eventId = 7021;
            $comments = json_decode(file_get_contents('https://api.joind.in/v2.1/events/'.$eventId.'/talk_comments?resultsperpage=9999'), true)['comments'];

            $users = [];
            foreach ($comments as $comment) {
                $users[$comment['user_display_name'] . ' (' . $comment['username'] . ')'] = true;
            }

            uksort($users, function($a, $b) { return strcasecmp($a, $b); });
            ?>

            <ol>
            <?php foreach (array_keys($users) as $user): ?>
            <li><?= $user ?></li>
            <?php endforeach; ?>
            </ol>
        </main>
    </div>

    <div class="sponsors-list text-center mt-5">
        <h2 class="mb-4">Sponsors</h2>
        <?php get_template_part( 'template-parts/sponsors' ); ?>
    </div>
</div>

<?php
get_footer();