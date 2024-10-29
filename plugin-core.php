<?php

namespace planetjon\wordpress\also_in_this_series;

const SERIES_SLUG = 'also-in-this-series';
const SERIES_TAXONOMY = 'series';

function config( $key = null ) {
	$defaults = [
		'title-wrap' => 'h2',
		'title-template' => 'also-in',
		'insert-in-content' => 'append',
		'archive-sort-order' => 'asc',
		'window-series-listing' => false,
		'hide-series-listing' => false,
		'always-link-series' => false,
	];

	$config = array_merge( $defaults, get_option( SERIES_SLUG, [] ) );

	return $key !== null ? $config[$key] : $config;
}

function displaySeries( $args = [] ) {
	$fargs = wp_parse_args( $args, [
		'series-slug' => null,
		'seriesSlug' => null, // legacy param
		'use-frame' => true,
		'frame-width' => null,
		'sort-order' => null,
		'order' => null, // legacy param
		'title-wrap' => null,
		'title-template' => null,
		'hide-series-listing' => 'default',
		'always-link-series' => 'default',
	] );

	$fargs = filter_var_array( [
		'seriesslug' => $fargs['series-slug'] ?: $fargs['seriesSlug'],
		'useframe' => $fargs['use-frame'],
		'framewidth' => $fargs['frame-width'],
		'sortorder' => $fargs['sort-order'] ?: $fargs['order'],
		'titlewrap' => $fargs['title-wrap'],
		'titletemplate' => $fargs['title-template'],
		'hideserieslisting' => $fargs['hide-series-listing'],
		'alwayslinkseries' => $fargs['always-link-series'],
	], [
		'seriesslug' => [
			'filter' => FILTER_SANITIZE_STRING
		],
		'useframe' => [
			'filter' => FILTER_VALIDATE_BOOLEAN,
		],
		'framewidth' => [
			'filter' => FILTER_VALIDATE_INT,
			'options' => [ 'min_range' => 1, 'default' => config( 'window-series-listing' ) ],
		],
		'sortorder' => [
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => [ 'regexp' => '/asc|desc/i', 'default' => config( 'archive-sort-order' ) ],
		],
		'titlewrap' => [
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => [ 'regexp' => '/h1|h2|h3|span/i', 'default' => config( 'title-wrap' ) ],
		],
		'titletemplate' => [
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => [ 'regexp' => '/also-in|ordinal|none/i', 'default' => config( 'title-template' ) ],
		],
		'hideserieslisting' => [
			'filter' => FILTER_VALIDATE_BOOLEAN,
			'flags' => FILTER_NULL_ON_FAILURE,
			'options' => [ 'default' => config( 'hide-series-listing' ) ],
		],
		'alwayslinkseries' => [
			'filter' => FILTER_VALIDATE_BOOLEAN,
			'flags' => FILTER_NULL_ON_FAILURE,
			'options' => [ 'default' => config( 'always-link-series' ) ],
		]
	] );

	$seriesslug = $fargs['seriesslug'];
	$useframe = $fargs['useframe'];
	$framewidth = $fargs['framewidth'];
	$sortorder = $fargs['sortorder'];
	$titlewrap = $fargs['titlewrap'];
	$titletemplate = $fargs['titletemplate'];
	$hideserieslisting = $fargs['hideserieslisting'];
	$alwayslinkseries = $fargs['alwayslinkseries'];

	$post = get_post();
	$currentpostid = $post ? $post->ID : null;

	if( $seriesslug ) {
		$series = get_term_by( 'slug', $seriesslug, SERIES_TAXONOMY );
	}
	else {
		$post and $postseries = get_the_terms( $post->ID, SERIES_TAXONOMY ) and $series = reset( $postseries );
	}

	if( !$series ) {
		return;
	}

	$query = [
		'tax_query' => [
			[
				'taxonomy' => SERIES_TAXONOMY,
				'field' => 'id',
				'terms' => (int) $series->term_id
			]
		],
		'order' => $sortorder ?: null,
		'nopaging' => true,
	];

	$seriesposts = get_posts( $query );
	$postsinseries = count( $seriesposts );

	$currentpostrank = findCurrentPostcurrentpostrank( $seriesposts, $currentpostid, $sortorder );
	$frame = [0, $postsinseries - 1];

	$framing = $post && $useframe && $framewidth;
	if( $framing ) {
		$frame = computeFrame( $seriesposts, $framewidth, $currentpostid );
		$seriesposts = array_slice( $seriesposts, $frame[0], $frame[1] - $frame_left );
	}

	$logicalframe = [$frame[0] + 1, $frame[1] + 1];
	if( $sortorder === 'desc' ) {
		$logicalframe[0] = $postsinseries + 1 - $logicalframe[0];
		$logicalframe[1] = $postsinseries + 1 - $logicalframe[1];
	}

	switch( $titletemplate ) {
		case 'also-in':
		$title = sprintf( __( 'Also in %s', 'also-in-this-series' ), $series->name );
		break;

		case 'ordinal':
		$title = sprintf( __( 'This is part %d of %d in %s', 'also-in-this-series' ), $currentpostrank + 1, $postsinseries, $series->name );
		break;

		case 'none':
		default:
		$title = '';
	}

	$description = $series->description;

	$themeTemplate = get_template_part(
		SERIES_SLUG . '/serieslisting',
		$seriesslug,
		[
			'series' => $series,
			'seriesposts' => $seriesposts,
			'sortorder' => $sortorder,
			'logicalframe' => $logicalframe,
			'framing' => $framing,
			'titlewrap' => $titlewrap,
			'title' => $title,
			'description' => $description,
			'alwayslinkseries' => $alwayslinkseries,
			'hideserieslisting' => $hideserieslisting,
			'currentpostrank' => $currentpostrank,
		]
	);
	if( false === $themeTemplate ) {
		include apply_filters( 'alsointhisseries_template', 'views/serieslisting.php' );
	} 
}

function pre_get_posts( $query ) {
	$sortorder = config( 'archive-sort-order' );

	if( isset( $query->query[SERIES_TAXONOMY] ) && $sortorder )
		$query->set( 'order', $sortorder );

	return $query;
}

function the_content( $content ) {
	if( !is_singular( 'post' ) || !config( 'insert-in-content' ) ) {
		return $content;
	}
	
	ob_start();
	displaySeries();
	$alsointhisseries = ob_get_contents(); 
	ob_end_clean();
	
	$before = $after = '';
	switch( config( 'insert-in-content' ) ) {
		case 'prepend' :
		$before = $alsointhisseries;
		break;

		case 'append' :
		$after = $alsointhisseries;
		break;

		default :
	}

	return $before . $content . $after;
}

function computeFrame( $seriesposts, $framewidth, $currentpostid ) {
	$pivot = 0;

	if( !$currentpostid ) {
		return [0, count( $seriespost ) - 1];
	}

	foreach( $seriesposts as $index => $seriespost ) {
		$pivot = $index;
		if( $seriespost->ID === $currentpostid ) {
			break;
		}
	}

	$frame_left = max( 0, $pivot - floor( ( $framewidth - 1 ) / 2 ) );
	$frame_right = min( count( $seriesposts ) - 1, $pivot + ceil( ( $framewidth - 1 ) / 2 ) );

	$ldiff = $frame_left - ( $pivot - floor( ( $framewidth - 1 ) / 2 ) );
	$rdiff = ( $pivot + ceil( ( $framewidth - 1 ) / 2 ) ) - $frame_right;

	if( $ldiff && !$rdiff ) {
		$frame_right = min( count( $seriesposts ) - 1, $frame_right + $ldiff );
	}
	elseif( $rdiff && !$ldiff ) {
		$frame_left = max( 0, $frame_left - $rdiff );
	}

	return [$frame_left, 1 + $frame_right];
}

function findCurrentPostcurrentpostrank( $seriesposts, $currentpostid, $order ) {
	$currentpostrank = null;

	if( !$currentpostid ) {
		return $currentpostrank;
	}

	foreach( $seriesposts as $index => $seriespost ) {
		if( $seriespost->ID === $currentpostid ) {
			$currentpostrank = $index;
			break;
		}
	}

	switch( $order ) {
		case 'desc':
		case 'DESC':
		return count( $seriesposts ) - 1 - $currentpostrank;
		break;

		case 'asc':
		case 'ASC':
		default:
		return $currentpostrank;
	}
}

add_action( 'pre_get_posts', __NAMESPACE__ . '\pre_get_posts' );
add_action( 'the_content', __NAMESPACE__ . '\the_content', 1 );
