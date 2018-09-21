<div class="speaker-card card mb-4 rounded-0" id="<?php echo esc_attr( $speaker->post_name ); ?>">
    <div class="card-body">
        <div class="row">
            <div class="col-12 <?php echo (empty($speaker->sessions) ? '' : 'col-lg-7'); ?>">
                <?php if (has_post_thumbnail( $speaker->ID )) : ?>
                    <div class="float-left mr-3 mb-2">
                        <?php echo get_the_post_thumbnail( $speaker->ID, 'thumbnail' ); ?>
                    </div>
                <?php endif; ?>

                <h5 class="card-title"><?php echo esc_html( $speaker->post_title ); ?></h5>
                <?php if ($is_keynoter) : ?>
                    <h6>Keynote Speaker</h6>
                <?php endif; ?>

                <div class="meta">
                    <?php if ($twitter = get_post_meta( $speaker->ID, 'speaker_twitter', true )) : ?>
                        <p class="twitter-link">
                            <i class="fab fa-twitter-square"></i>&nbsp;
                            <a target="_blank" href="https://www.twitter.com/<?php echo esc_attr( $twitter ); ?>">
                                @<?php echo esc_html( $twitter ); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                    <?php if ($company = get_post_meta( $speaker->ID, 'speaker_company', true )) : ?>
                        <p class="company">
                            <i class="fas fa-briefcase"></i>
                            &nbsp;<?php echo esc_html( $company ); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <p class="card-text"><?php echo apply_filters('lphp_post_content', $speaker->post_content); ?></p>
            </div>
            <?php if (!empty($speaker->sessions)) : ?>
                <div class="col-12 col-lg-5">
                    <p><strong>Sessions:</strong></p>
                    <ul class="list-unstyled">
                        <?php foreach ($speaker->sessions as $session) : ?>
                            <li class="d-flex align-items-start border-bottom border-light mb-3 pb-2">
                                <a
                                    href="<?php the_field('sessions_page', 'options'); ?>#<?php echo esc_attr( $session->post_name ); ?>"
                                    class="mr-2">
                                    <?php echo esc_html( $session->post_title ); ?>
                                </a>
                                <?php $type = get_the_terms( $session->ID, 'session_type' ); ?>
                                <?php if (!empty($type)) : ?>
                                    <span class="badge badge-light badge-pill ml-auto">
                                        <?php echo esc_html( $type[0]->name ); ?>
                                    </span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div> <!-- col-sm-9 / col -->
            <?php endif; ?>
        </div><!-- row -->
    </div>
</div>