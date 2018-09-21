<?php

function lphp_sponsor_post_type() {

	$labels = array(
		'name'                  => 'Sponsors',
		'singular_name'         => 'Sponsor',
		'menu_name'             => 'Sponsors',
		'name_admin_bar'        => 'Sponsor',
		'archives'              => 'Sponsor Archives',
		'attributes'            => 'Sponsor Attributes',
		'parent_item_colon'     => 'Parent Sponsor:',
		'all_items'             => 'All Sponsors',
		'add_new_item'          => 'Add New Sponsor',
		'add_new'               => 'Add New',
		'new_item'              => 'New Sponsor',
		'edit_item'             => 'Edit Sponsor',
		'update_item'           => 'Update Sponsor',
		'view_item'             => 'View Sponsor',
		'view_items'            => 'View Sponsors',
		'search_items'          => 'Search Sponsor',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into sponsor',
		'uploaded_to_this_item' => 'Uploaded to this sponsor',
		'items_list'            => 'Sponsors list',
		'items_list_navigation' => 'Sponsors list navigation',
		'filter_items_list'     => 'Filter sponsors list',
	);
	$args = array(
		'label'                 => 'Sponsor',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'sponsor', $args );

}
add_action( 'init', 'lphp_sponsor_post_type', 0 );

function lphp_sponsorship_tier() {
	$labels = array(
		'name'                       => 'Sponsorship Tiers',
		'singular_name'              => 'Sponsorship Tier',
		'menu_name'                  => 'Sponsorship Tiers',
		'all_items'                  => 'All Sponsorship Tiers',
		'parent_item'                => 'Parent Sponsorship Tier',
		'parent_item_colon'          => 'Parent Sponsorship Tier:',
		'new_item_name'              => 'New Sponsorship Tier Name',
		'add_new_item'               => 'Add New Sponsorship Tier',
		'edit_item'                  => 'Edit Sponsorship Tier',
		'update_item'                => 'Update Sponsorship Tier',
		'view_item'                  => 'View Sponsorship Tier',
		'separate_items_with_commas' => 'Separate sponsorship tiers with commas',
		'add_or_remove_items'        => 'Add or remove sponsorship tiers',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Sponsorship Tiers',
		'search_items'               => 'Search Sponsorship Tiers',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No sponsorship tiers',
		'items_list'                 => 'Sponsorship Tiers list',
		'items_list_navigation'      => 'Sponsorship Tiers list navigation',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => false,
	);
	register_taxonomy( 'sponsorship_tier', array( 'sponsor' ), $args );

}
add_action( 'init', 'lphp_sponsorship_tier', 0 );
