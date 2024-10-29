<?php

namespace planetjon\wordpress\also_in_this_series;

function init_taxonomies() {
	$taxonomy = [
		'labels' => [
			'name' => _x( 'Series', 'Series', 'also-in-this-series' ),
			'singular_name' => _x( 'Series', 'Series', 'also-in-this-series' ),
			'all_items' => __( 'All Series', 'also-in-this-series' ),
			'edit_item' => __( 'Edit Series', 'also-in-this-series' ),
			'view_item' => __( 'View Series', 'also-in-this-series' ),
			'update_item' => __( 'Update Series', 'also-in-this-series' ),
			'add_new_item' => __( 'Add New Series', 'also-in-this-series' ),
			'new_item_name' => __( 'New Series Name', 'also-in-this-series' ),
			'search_items' => __( 'Search Series', 'also-in-this-series' ),
			'popular_items' => __( 'Popular Series', 'also-in-this-series' ),
			'add_or_remove_items' => __( 'Add or remove series', 'also-in-this-series' ),
			'choose_from_most_used' => __( 'Choose from the most used series', 'also-in-this-series' ),
			'not_found' => __( 'No series found', 'also-in-this-series' )
		],
		'show_admin_column' => true,
		'hierarchical' => false,
		'show_in_rest' => true,
		'rewrite' => [ 'with_front' => false ]
	];

	register_taxonomy( SERIES_TAXONOMY, null, $taxonomy );
	register_taxonomy_for_object_type( SERIES_TAXONOMY, 'post' );
}

add_action( 'init', __NAMESPACE__ . '\init_taxonomies' );
