<?php get_header( 'opening' ); ?>

<header class="site-header" role="banner">
	<nav class="navbar navbar-expand-md navbar-dark">
		<?php $logo = get_field('header_logo', 'options'); ?>
		<?php if ($logo) : ?>
			<a class="navbar-brand logo-wrap" href="/">
				<?php echo wp_get_attachment_image( $logo, 'medium' ); ?>
			</a>
		<?php endif; ?>
		<button class="navbar-toggler menu-btn ml-auto" type="button" data-target="#primaryMenuItems" aria-controls="primaryMenuItems" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div id="primaryMenuItems" class="menu-container navbar-collapse pushy pushy-right">
			<div class="close-side-menu text-right mt-3 d-md-none"><span class="pushy-link"><i class="fas fa-times-circle" aria-hidden="true"></i></span></div>
			<?php wp_nav_menu( array(
				'theme_location'    => 'primary',
				'depth'             => 2,
				'container'         => 'ul',
				'menu_class'        => 'navbar-nav ml-auto pushy-content',
				'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
				'walker'            => new WP_Bootstrap_Navwalker(),
			) ); ?>
		</div>
	</nav>
</header>

<div id="content" class="site-content">
