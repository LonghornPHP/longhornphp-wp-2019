<?php

function speaker_session_relationship( $post_id, $talk, $update ) {
	global $wpdb;

	if ($talk->post_type === 'session') {
		$speaker = get_field('speaker_session_relationship', $talk->ID)[0];

		$wpdb->delete(
			$wpdb->prefix . 'sessions',
			['talk_id' => $talk->ID],
			['%d']
		);

		if ($speaker) {
			$wpdb->insert(
				$wpdb->prefix . 'sessions',
				['speaker_id' => $speaker->ID, 'talk_id' => $talk->ID],
				['%d', '%d']
			);
		}
	}
}

add_action('save_post', 'speaker_session_relationship', 20, 3);

add_action('acf/init', 'lphp_register_about_organizers_block');
function lphp_register_about_organizers_block() {
	if( function_exists('acf_register_block') ) {
		acf_register_block([
			'name'				=> 'organizers_gallery',
			'title'				=> 'Organizers Gallery',
			'description'		=> 'A gallery of conference organizers with names and images.',
			'render_callback'	=> 'lphp_render_organizers_gallery',
			'category'			=> 'formatting',
			'icon'				=> 'format-gallery',
			'keywords'			=> ['organizers', 'gallery'],
		]);
	}
}

function lphp_render_organizers_gallery($block) {
	// include a template part from within the "template-parts/block" folder
	if( file_exists(STYLESHEETPATH . "/template-parts/blocks/organizers-gallery.php") ) {
		include STYLESHEETPATH . "/template-parts/blocks/organizers-gallery.php";
	}
}