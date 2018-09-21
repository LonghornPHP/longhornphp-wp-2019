<?php

function lphp_session_post_type() {

    $labels = array(
        'name'                  => 'Sessions',
        'singular_name'         => 'Session',
        'menu_name'             => 'Sessions',
        'name_admin_bar'        => 'Session',
        'archives'              => 'Session Archives',
        'attributes'            => 'Session Attributes',
        'parent_item_colon'     => 'Parent Session:',
        'all_items'             => 'All Sessions',
        'add_new_item'          => 'Add New Session',
        'add_new'               => 'Add New',
        'new_item'              => 'New Session',
        'edit_item'             => 'Edit Session',
        'update_item'           => 'Update Session',
        'view_item'             => 'View Session',
        'view_items'            => 'View Sessions',
        'search_items'          => 'Search Session',
        'not_found'             => 'Not found',
        'not_found_in_trash'    => 'Not found in Trash',
        'featured_image'        => 'Featured Image',
        'set_featured_image'    => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image'    => 'Use as featured image',
        'insert_into_item'      => 'Insert into session',
        'uploaded_to_this_item' => 'Uploaded to this session',
        'items_list'            => 'Sessions list',
        'items_list_navigation' => 'Sessions list navigation',
        'filter_items_list'     => 'Filter sessions list',
    );
    $args = array(
        'label'                 => 'Session',
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
    register_post_type( 'session', $args );

}
add_action( 'init', 'lphp_session_post_type', 0 );

function lphp_session_type() {
    $labels = array(
        'name'                       => 'Session Types',
        'singular_name'              => 'Session Type',
        'menu_name'                  => 'Session Types',
        'all_items'                  => 'All Session Types',
        'parent_item'                => 'Parent Session Type',
        'parent_item_colon'          => 'Parent Session Type:',
        'new_item_name'              => 'New Session Type Name',
        'add_new_item'               => 'Add New Session Type',
        'edit_item'                  => 'Edit Session Type',
        'update_item'                => 'Update Session Type',
        'view_item'                  => 'View Session Type',
        'separate_items_with_commas' => 'Separate session type with commas',
        'add_or_remove_items'        => 'Add or remove session type',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Session Types',
        'search_items'               => 'Search Session Types',
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No session type',
        'items_list'                 => 'Session Types list',
        'items_list_navigation'      => 'Session Types list navigation',
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
    register_taxonomy( 'session_type', array( 'session' ), $args );

}
add_action( 'init', 'lphp_session_type', 0 );

function lphp_session_level() {
    $labels = array(
        'name'                       => 'Session Levels',
        'singular_name'              => 'Session Level',
        'menu_name'                  => 'Session Levels',
        'all_items'                  => 'All Session Levels',
        'parent_item'                => 'Parent Session Level',
        'parent_item_colon'          => 'Parent Session Level:',
        'new_item_name'              => 'New Session Level Name',
        'add_new_item'               => 'Add New Session Level',
        'edit_item'                  => 'Edit Session Level',
        'update_item'                => 'Update Session Level',
        'view_item'                  => 'View Session Level',
        'separate_items_with_commas' => 'Separate session level with commas',
        'add_or_remove_items'        => 'Add or remove session level',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Session Levels',
        'search_items'               => 'Search Session Levels',
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No session level',
        'items_list'                 => 'Session Levels list',
        'items_list_navigation'      => 'Session Levels list navigation',
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
    register_taxonomy( 'session_level', array( 'session' ), $args );

}
add_action( 'init', 'lphp_session_level', 0 );
