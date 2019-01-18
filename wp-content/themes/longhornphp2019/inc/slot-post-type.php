<?php

function lphp_slot_post_type() {

    $labels = array(
        'name'                  => 'Slots',
        'singular_name'         => 'Slot',
        'menu_name'             => 'Slots',
        'name_admin_bar'        => 'Slot',
        'archives'              => 'Slot Archives',
        'attributes'            => 'Slot Attributes',
        'parent_item_colon'     => 'Parent Slot:',
        'all_items'             => 'All Slots',
        'add_new_item'          => 'Add New Slot',
        'add_new'               => 'Add New',
        'new_item'              => 'New Slot',
        'edit_item'             => 'Edit Slot',
        'update_item'           => 'Update Slot',
        'view_item'             => 'View Slot',
        'view_items'            => 'View Slots',
        'search_items'          => 'Search Slot',
        'not_found'             => 'Not found',
        'not_found_in_trash'    => 'Not found in Trash',
        'featured_image'        => 'Featured Image',
        'set_featured_image'    => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image'    => 'Use as featured image',
        'insert_into_item'      => 'Insert into slot',
        'uploaded_to_this_item' => 'Uploaded to this slot',
        'items_list'            => 'Slots list',
        'items_list_navigation' => 'Slots list navigation',
        'filter_items_list'     => 'Filter slots list',
    );
    $args = array(
        'label'                 => 'Slot',
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
        'taxonomies'            => ['category']
    );
    register_post_type( 'slot', $args );

}
add_action( 'init', 'lphp_slot_post_type', 0 );
