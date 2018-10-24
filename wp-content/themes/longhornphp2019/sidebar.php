<?php $tiers = ['diamond', 'platinum', 'gold', 'silver']; ?>

<h2 class="text-center mb-4">Sponsors</h2>

<?php foreach ($tiers as $tier) : ?>
    <?php $sponsors = new WP_Query(lphp_get_sponsorship_tier_query($tier)); ?>
    <?php if ($sponsors->have_posts()) : ?>
        <div class="sponsorship-tier text-center">
            <h3 class="tier-title"><?php echo ucfirst($tier); ?></h3>
            <?php while ($sponsors->have_posts()) : $sponsors->the_post(); ?>
                <div class="sponsor">
                    <?php $link = get_post_meta( get_the_ID(), 'sponsor_link', true ); ?>
                    <?php if ($link) : ?>
                    <a target="_blank" href="<?php echo get_post_meta( get_the_ID(), 'sponsor_link', true ); ?>">
                    <?php endif; ?>
                        <strong class="sponsor-title"><?php the_title(); ?></strong>
                        <?php if (has_post_thumbnail() && $tier !== 'kickstarter') : ?>
                            <?php the_post_thumbnail(); ?>
                        <?php endif; ?>
                    <?php if ($link) : ?>
                    </a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
    <?php unset($sponsors); ?>
<?php endforeach; ?>

<div class="text-center">
    <a class="btn btn-default" href="<?php the_field('sponsors_page', 'options'); ?>">View All Sponsors</a>
</div>