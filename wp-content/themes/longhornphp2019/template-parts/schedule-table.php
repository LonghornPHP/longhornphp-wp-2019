<div class="table-responsive-md">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="start-end align-middle" rowspan="2">Start / End</th>
                <th colspan="3" style="text-align: center;">Room Name</th>
            </tr>
            <tr>
                <?php foreach ($rooms as $room) : ?>
                    <?php if (array_key_exists($room, $room_sponsors)) : ?>
                        <th style="vertical-align: middle;"><?php echo get_the_post_thumbnail( $room_sponsors[$room] ); ?></th>
                    <?php else : ?>
                        <th style="vertical-align: middle;"><?php echo $room; ?></th>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($slots as $slot) : ?>
                <tr>
                    <td class="start-end">
                        <?php the_field('start', $slot->ID); ?><br>
                        <?php the_field('end', $slot->ID); ?>
                    </td>

                    <?php if (get_field('session_type', $slot->ID) === 'Other') : ?>
                        <td align="center" colspan="3" style="vertical-align: middle;">
                            <?php $image = get_field('image', $slot->ID); ?>
                            <?php if ($image) : ?>
                                <p><strong><?php the_field('label', $slot->ID); ?></strong></p>
                                <p><em>Sponsored by:</em></p>
                                <?php echo wp_get_attachment_image( $image, 'medium' ); ?>
                            <?php else : ?>
                                <p><strong><?php the_field('label', $slot->ID); ?></strong></p>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>

                    <?php if (get_field('session_type', $slot->ID) === 'Talks') : ?>
                        <?php $sessions = fill_sessions_with_speakers(get_field('session', $slot->ID)); ?>
                        <?php foreach ($sessions as $session) : ?>
                            <td>
                                <a href="/sessions/#<?php echo $session->post_name; ?>">
                                    <?php echo $session->post_title; ?>
                                </a><br>
                                <small>by <a href="/lineup/#<?php echo $session->speakers[0]->post_name; ?>">
                                    <?php echo $session->speakers[0]->post_title; ?></a>
                                </small>
                            </td>
                        <?php endforeach; ?>
                    <?php endif; ?>



                    <?php if (get_field('session_type', $slot->ID) === 'Talk') : ?>
                        <?php $session = fill_sessions_with_speakers(get_field('session', $slot->ID))[0]; ?>
                        <td colspan="3">
                            <a href="/sessions/#<?php echo $session->post_name; ?>">
                                <?php echo $session->post_title; ?>
                            </a><br>
                            <small>by <a href="/lineup/#<?php echo $session->speakers[0]->post_name; ?>">
                                <?php echo $session->speakers[0]->post_title; ?></a>
                            </small>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>