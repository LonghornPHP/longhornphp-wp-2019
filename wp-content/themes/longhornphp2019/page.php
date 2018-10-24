<?php get_header(); ?>

<div class="container">
	<div class="row">
		<main class="site-main col-md-8">
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

			endwhile;
			?>
		</main>

        <sidebar class="sponsors-sidebar ml-auto mt-5 mt-md-0 col-md-4 col-lg-3">
            <?php get_sidebar(); ?>
        </sidebar>
	</div>
</div>

<?php
get_footer();
