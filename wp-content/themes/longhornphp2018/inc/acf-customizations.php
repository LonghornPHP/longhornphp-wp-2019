<?php

// Adapted from: https://www.advancedcustomfields.com/resources/bidirectional-relationships/
function speaker_session_relationship( $value, $post_id, $field  ) {
	$field_name = $field['name'];
	$field_key = $field['key'];
	$global_name = 'is_updating_' . $field_name;

	if( !empty($GLOBALS[ $global_name ]) ) {
		return $value;
	}
	$GLOBALS[ $global_name ] = 1;

	if( is_array($value) ) {
		foreach( $value as $post_id2 ) {
			$value2 = get_field($field_name, $post_id2, false);

			if( empty($value2) ) {
				$value2 = array();
			}

			if( in_array($post_id, $value2) ) {
				continue;
			}

			$value2[] = $post_id;

			update_field($field_key, $value2, $post_id2);
		}
	}


	$old_value = get_field($field_name, $post_id, false);

	if( is_array($old_value) ) {
		foreach( $old_value as $post_id2 ) {
			if( is_array($value) && in_array($post_id2, $value) ) {
				continue;
			}
			$value2 = get_field($field_name, $post_id2, false);

			if( empty($value2) ) {
				continue;
			}

			$pos = array_search($post_id, $value2);
			unset( $value2[ $pos] );

			update_field($field_key, $value2, $post_id2);
		}
	}

	$GLOBALS[ $global_name ] = 0;

	return $value;
}

add_filter('acf/update_value/name=speaker_session_relationship', 'speaker_session_relationship', 10, 3);
