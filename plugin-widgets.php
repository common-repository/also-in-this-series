<?php

namespace planetjon\wordpress\also_in_this_series;

use \WP_Widget;

class SeriesWidget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'alsointhisseries_widget',
			__( 'Also In This Series', 'also-in-this-series' ),
			[ 'description' => __( 'Feature your series anywhere that a widget can go.', 'also-in-this-series' ) ]
		);
	}

	public function widget( $widget, $fields ) {
		$ffields = apply_filters( 'alsointhisseries_widget_fields', $fields, $widget );

		$config = [
			'series-slug' => $ffields['series-slug'],
			'use-frame' => $ffields['series-use-frame'],
			'frame-width' => $ffields['series-frame-width'],
			'sort-order' => $ffields['series-sort-order'],
			'title-wrap' => $ffields['series-title-wrap'],
			'title-template' => $ffields['series-title-template'],
			'hide-series-listing' => $ffields['series-hide-listing'],
			'always-link-series' => $ffields['series-always-link'],
		];

		ob_start();
		displaySeries( $config );
		$serieslisting = ob_get_contents();
		ob_end_clean();

		include 'views/widget-view.php';
	}

	public function form( $fields ) {
		$seriesslug = $fields['series-slug'];
		$useframe = $fields['series-use-frame'];
		$framewidth = $fields['series-frame-width'];
		$sortorder = $fields['series-sort-order'];
		$titlewrap = $fields['series-title-wrap'];
		$titletemplate = $fields['series-title-template'];
		$hideserieslisting = $fields['series-hide-listing'];
		$alwayslinkseries = $fields['series-always-link'];

		$series = get_terms( SERIES_TAXONOMY );

		include 'views/admin/widget-form.php';
	}

	public function update( $new_fields, $old_fields ) {
		$fields = [];
		$fields['series-slug'] = !empty( $new_fields['series-slug'] ) ? sanitize_text_field( $new_fields['series-slug'] ) : '';
		$fields['series-use-frame'] = !empty( $new_fields['series-use-frame'] ) ? sanitize_text_field( $new_fields['series-use-frame'] ) : '';
		$fields['series-frame-width'] = !empty( $new_fields['series-frame-width'] ) ? sanitize_text_field( $new_fields['series-frame-width'] ) : '';
		$fields['series-sort-order'] = !empty( $new_fields['series-sort-order'] ) ? sanitize_text_field( $new_fields['series-sort-order'] ) : '';
		$fields['series-title-wrap'] = !empty( $new_fields['series-title-wrap'] ) ? sanitize_text_field( $new_fields['series-title-wrap'] ) : '';
		$fields['series-title-template'] = !empty( $new_fields['series-title-template'] ) ? sanitize_text_field( $new_fields['series-title-template'] ) : '';
		$fields['series-hide-listing'] = !empty( $new_fields['series-hide-listing'] ) ? sanitize_text_field( $new_fields['series-hide-listing'] ) : '';
		$fields['series-always-link'] = !empty( $new_fields['series-always-link'] ) ? sanitize_text_field( $new_fields['series-always-link'] ) : '';

		return $fields;
	}
}

function widgets_init() {
	register_widget( SeriesWidget::class );
}

add_action( 'widgets_init', __NAMESPACE__ . '\widgets_init' );
