<?php

// Register Custom Post Type
function lphp_invoice_post_type() {

    $labels = array(
        'name'                  => 'Invoices',
        'singular_name'         => 'Invoice',
        'menu_name'             => 'Invoices',
        'name_admin_bar'        => 'Invoice',
        'archives'              => 'Invoice Archives',
        'attributes'            => 'Invoice Attributes',
        'parent_item_colon'     => 'Parent Invoice:',
        'all_items'             => 'All Invoices',
        'add_new_item'          => 'Add New Invoice',
        'add_new'               => 'Add New',
        'new_item'              => 'New Invoice',
        'edit_item'             => 'Edit Invoice',
        'update_item'           => 'Update Invoice',
        'view_item'             => 'View Invoice',
        'view_items'            => 'View Invoices',
        'search_items'          => 'Search Invoice',
        'not_found'             => 'Not found',
        'not_found_in_trash'    => 'Not found in Trash',
        'featured_image'        => 'Featured Image',
        'set_featured_image'    => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image'    => 'Use as featured image',
        'insert_into_item'      => 'Insert into invoice',
        'uploaded_to_this_item' => 'Uploaded to this invoice',
        'items_list'            => 'Invoices list',
        'items_list_navigation' => 'Invoices list navigation',
        'filter_items_list'     => 'Filter invoices list',
    );
    $rewrite = array(
        'slug'                  => 'invoices',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => 'Invoice',
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor' ),
        'taxonomies'            => array( 'sponsorship_tier' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'rewrite'               => $rewrite,
        'capability_type'       => 'page',
    );
    register_post_type( 'lphp_invoice', $args );

}
add_action( 'init', 'lphp_invoice_post_type', 0 );