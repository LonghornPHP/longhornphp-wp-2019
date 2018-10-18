<?php $index = 0; ?>
<div class="row">
<?php if (have_rows('organizers')) : while (have_rows('organizers')) : the_row(); ?>
    <div class="col-sm-6 col-lg-4 mb-4 text-center">
        <div class="card">
            <?php echo wp_get_attachment_image(get_sub_field('image'), 'thumbnail', false, ['class' => 'card-img-top']); ?>
            <div class="card-body">
                <div class="card-title">
                    <?php the_sub_field('name'); ?>
                </div>
                <div class="card-text">
                    <a style="text-decoration: none;" href="https://twitter.com/<?php the_sub_field('twitter_handle'); ?>">
                        <i class="fab fa-twitter" title="Twitter Icon"></i>&nbsp; @<?php the_sub_field('twitter_handle'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $index++; ?>
<?php endwhile; endif; ?>
</div>