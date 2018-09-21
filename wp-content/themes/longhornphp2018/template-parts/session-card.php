<li class="list-group-item session-card" id="<?php echo esc_attr( $session->post_name ); ?>">
    <div class="d-sm-flex align-items-sm-start collapsed" data-toggle="collapse" data-target="#<?php echo esc_attr( $session->post_name ); ?>-description" aria-expanded="false" aria-controls="<?php echo esc_attr( $session->post_name ); ?>-description">

        <div class="meta">
            <?php $has_thumbnail = count($session->speakers) && has_post_thumbnail( $session->speakers[0]->ID ); ?>
            <?php if ($has_thumbnail) : ?>
                <div class="float-left img-wrap mr-2 mb-2 mr-sm-0 mb-sm-0">
                    <?php echo get_the_post_thumbnail( $session->speakers[0]->ID, 'thumbnail' ); ?>
                </div>
            <?php endif; ?>

            <div class="title <?php echo $has_thumbnail ? 'pl-sm-3 float-sm-right' : ''; ?>">
                <h4><?php echo esc_html( $session->post_title ); ?></h4>

                <?php if (count($session->speakers)) : ?>
                    <h5>
                        <a href="<?php the_field('speakers_page', 'options'); ?>#<?php echo esc_attr( $session->speakers[0]->post_name ); ?>">
                            <?php echo esc_html( $session->speakers[0]->post_title ); ?>
                        </a>
                    </h5>
                <?php endif; ?>

                <?php $categories = get_the_terms( $session->ID, 'category' ) ?: []; ?>
                <div class="categories">
                    <?php foreach ($categories as $category) : ?>
                        <span class="badge badge-pill badge-secondary">
                            <?php echo esc_html($category->name); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php $level = get_the_terms( $session->ID, 'session_level' ); ?>
        <div class="badges ml-sm-auto text-left text-sm-right">
            <?php if (!empty($level)) : ?>
                <span class="session-level badge badge-pill badge-light <?php echo esc_html( $level[0]->slug ); ?>">
                    <?php echo lphp_get_stars_for_level($level[0]->slug); ?>
                </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="collapse description" id="<?php echo esc_attr( $session->post_name ); ?>-description">
        <?php echo apply_filters('lphp_post_content', $session->post_content); ?>
    </div>
</li>