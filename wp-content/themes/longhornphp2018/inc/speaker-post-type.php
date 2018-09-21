<?php

function lphp_speaker_post_type() {

    $labels = array(
        'name'                  => 'Speakers',
        'singular_name'         => 'Speaker',
        'menu_name'             => 'Speakers',
        'name_admin_bar'        => 'Speaker',
        'archives'              => 'Speaker Archives',
        'attributes'            => 'Speaker Attributes',
        'parent_item_colon'     => 'Parent Speaker:',
        'all_items'             => 'All Speakers',
        'add_new_item'          => 'Add New Speaker',
        'add_new'               => 'Add New',
        'new_item'              => 'New Speaker',
        'edit_item'             => 'Edit Speaker',
        'update_item'           => 'Update Speaker',
        'view_item'             => 'View Speaker',
        'view_items'            => 'View Speakers',
        'search_items'          => 'Search Speaker',
        'not_found'             => 'Not found',
        'not_found_in_trash'    => 'Not found in Trash',
        'featured_image'        => 'Featured Image',
        'set_featured_image'    => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image'    => 'Use as featured image',
        'insert_into_item'      => 'Insert into speaker',
        'uploaded_to_this_item' => 'Uploaded to this speaker',
        'items_list'            => 'Speakers list',
        'items_list_navigation' => 'Speakers list navigation',
        'filter_items_list'     => 'Filter speakers list',
    );
    $args = array(
        'label'                 => 'Speaker',
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
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type( 'speaker', $args );

}
add_action( 'init', 'lphp_speaker_post_type', 0 );

function lphp_speaker_type() {
    $labels = array(
        'name'                       => 'Speaker Types',
        'singular_name'              => 'Speaker Type',
        'menu_name'                  => 'Speaker Types',
        'all_items'                  => 'All Speaker Types',
        'parent_item'                => 'Parent Speaker Type',
        'parent_item_colon'          => 'Parent Speaker Type:',
        'new_item_name'              => 'New Speaker Type Name',
        'add_new_item'               => 'Add New Speaker Type',
        'edit_item'                  => 'Edit Speaker Type',
        'update_item'                => 'Update Speaker Type',
        'view_item'                  => 'View Speaker Type',
        'separate_items_with_commas' => 'Separate speaker type with commas',
        'add_or_remove_items'        => 'Add or remove speaker type',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Speaker Types',
        'search_items'               => 'Search Speaker Types',
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No speaker type',
        'items_list'                 => 'Speaker Types list',
        'items_list_navigation'      => 'Speaker Types list navigation',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'rewrite'                    => false,
    );
    register_taxonomy( 'speaker_type', array( 'speaker' ), $args );

}
add_action( 'init', 'lphp_speaker_type', 0 );
