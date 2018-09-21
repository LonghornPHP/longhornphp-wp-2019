<?php
/* Template Name: Home */
get_header();
?>

<div class="top-section">
	<div class="container">
		<div class="row justify-content-center align-items-center">
			<div class="text-center text-sm-left col-sm-4 logo-wrap">
				<?php echo wp_get_attachment_image( get_field('logo', 'options'), 'large' ); ?>
			</div>
			<div class="text-center col-sm-8">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_nav_menu( array( 'theme_location' => 'home_buttons' ) ); ?>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</div>

<?php
	$keynoters = new WP_Query([
		'post_type' => 'speaker',
		'posts_per_page' => '-1',
		'tax_query' => [
			[
				'taxonomy' => 'speaker_type',
				'field'    => 'slug',
				'terms'    => 'keynote-speaker',
			]
		],
		'orderby' => 'rand',
	]);
?>

<?php if ($keynoters->have_posts()) : ?>

<div class="featured-speakers" id="featured-speakers">
	<div class="container">
		<h2 class="title text-center">Keynote Speakers</h2>

		<div class="row justify-content-center">
			<?php while ($keynoters->have_posts()) : $keynoters->the_post(); ?>
				<div class="col-6 col-md-4 col-lg-2">
					<div class="card">
						<?php the_post_thumbnail( 'large', ['alt' => get_the_title(get_the_ID()), 'class' => 'card-img-top'] ); ?>
						<div class="card-body">
							<h4 class="card-title"><?php the_title(); ?></h4>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>

		<div class="row">
			<div class="col-6 mx-auto">
				<?php the_field('home_speakers_content'); ?>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>

<div class="section-sponsors" id="sponsors">
	<div class="container">
		<div class="text-center mb-4">
			<h2>Sponsors</h2>
		</div>
		<div class="sponsors-list">
			<?php get_template_part( 'template-parts/sponsors' ); ?>

			<div class="text-center">
				<?php the_field('home_sponsors_intro'); ?>
			</div>
		</div>
	</div>
</div>

<div
	class="section-about lazy"
	data-src="<?php echo wp_get_attachment_image_url( get_field('home_description_image'), 'large' ); ?>"
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-lg-8 mx-auto text-center">
				<?php the_field('home_description_content'); ?>
				<?php the_field('home_description_mailchimp_embed'); ?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
