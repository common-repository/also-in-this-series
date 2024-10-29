<?php

namespace planetjon\wordpress\also_in_this_series;

const SERIES_SETTINGS_PAGE = 'also-in-this-series-settings';

class AlsoInThisSeriesAdmin {
	private static $registeredfields = [];

	// To be hooked into admin_init
	static function admin_init() {
		register_setting( SERIES_SLUG, SERIES_SLUG, [ __CLASS__, 'validateFields' ] );
		self::addSection( 'general-settings-section', __( 'General Settings', 'also-in-this-series' ) );

		// Add theme options here
		self::addField( 'select', 'title-wrap', __( 'Title heading level', 'also-in-this-series' ), [ 'h1', 'h2', 'h3', 'span' ], [ 'h1', 'h2', 'h3', 'span' ] );
		self::addField( 'select', 'title-template', __( 'Title template', 'also-in-this-series' ), [ 'also-in', 'ordinal', 'none' ], [ 'Also In Series Name', 'This is part n of m in Series Name', 'No Title' ] );
		self::addField( 'radiobutton', 'insert-in-content', __( 'Automatically display series listing on post?', 'also-in-this-series' ), [ '', 'append', 'prepend' ], [ 'No', 'After Content', 'Before Content' ] );
		self::addField( 'radiobutton', 'archive-sort-order', __( 'Order of series display', 'also-in-this-series' ), [ '', 'asc', 'desc' ], [ 'Default', 'Oldest First', 'Newest First' ] );
		self::addField( 'textfield', 'window-series-listing', __( 'Window series listing display', 'also-in-this-series' ), '^[[:digit:]]*$', 'number of surrounding posts' );
		self::addField( 'checkbox', 'hide-series-listing', __( 'Do not display series listing', 'also-in-this-series' ), 'yes', 'If checked, the series listing will not be shown.' );
		self::addField( 'checkbox', 'always-link-series', __( 'Always show series link', 'also-in-this-series' ), 'yes', 'If unchecked, a link to the series will only be shown when windowing is active.' );
	}

	// To be hooked into admin_menu.
	static function admin_menu() {
		$pagehook = add_options_page(
			__( 'Also In This Series settings', 'also-in-this-series' ),
			__( 'Also In This Series', 'also-in-this-series' ),
			'manage_options',
			SERIES_SETTINGS_PAGE,
			[ __CLASS__, 'showPluginSettings' ]
		);
	}

	// Use this for adding sections to the admin page.
	static function addSection( $id, $title ) {
		add_settings_section( $id, $title,[ __CLASS__, 'sectionHeader' ], SERIES_SETTINGS_PAGE );
	}

	// Use this for adding theme options to the admin page. See code below for available types (renderers).
	static function addField( $type, $id, $title, $value = 1, $label = null, $args = [], $section = 'general-settings-section' ) {
		self::_addFieldFilter( $type, $id, $title, $value, $args );
		add_settings_field( $id, $title, [ __CLASS__, $type . 'Renderer' ], SERIES_SETTINGS_PAGE, $section, compact( 'type', 'id', 'value', 'label', 'args', 'section' ) );
	}

	// Callback for loading the admin view.
	static function showPluginSettings() {
		include 'views/admin/settings.php';
	}

	// Callback for displaying a section header.
	static function sectionHeader( $args ) {

	}

	// Renders a textfield.
	static function textfieldRenderer( $args ) {
		$setting = config( $args['id'] );

		$id = SERIES_SLUG . '_' . $args['id'];
		$name = SERIES_SLUG . "[{$args['id']}]";
		$value = $setting;
		$label = $args[ 'label' ];

		self::_fieldRenderer( 'textfield', compact( 'id', 'name', 'value', 'label' ) );
	}

	// Renders a checkbox. If multiple values are provided, an option group will be rendered.
	static function checkboxRenderer( $args ) {
		$multivalue = is_array( $args['value'] );
		$settings = (array) config( $args['id'] );

		$id = SERIES_SLUG . '_' . $args['id'];
		$name = SERIES_SLUG . "[{$args['id']}]" . ( $multivalue ? '[]' : '' );
		$values = array_map( 'esc_attr', (array) $args['value'] );
		$labels = (array) $args[ 'label' ];
		$checked = [];

		foreach( $settings as $index => $setting )
			$checked[$index] = checked( 1, $setting ? 1 : 0, false );

		self::_fieldRenderer( 'checkbox', compact( 'id', 'name', 'values', 'labels', 'checked' ) );
	}

	// Renders a radiobox. More than one value should be provided as an option group.
	static function radiobuttonRenderer( $args ) {
		$setting = config( $args['id'] );

		$id = SERIES_SLUG . '_' . $args['id'];
		$name = SERIES_SLUG . "[{$args['id']}]";
		$values = array_map( 'esc_attr', (array) $args['value'] );
		$labels = (array) $args[ 'label' ];
		$checked = [];

		foreach( $values as $index => $value )
			$checked[$index] = checked( $value, $setting, false );

		self::_fieldRenderer( 'radiobutton', compact( 'id', 'name', 'values', 'labels', 'checked' ) );
	}

	// Renders a radiobox. More than one value should be provided as an option group.
	static function selectRenderer( $args ) {
		$setting = config( $args['id'] );

		$id = SERIES_SLUG . '_' . $args['id'];
		$name = SERIES_SLUG . "[{$args['id']}]";
		$values = array_map( 'esc_attr', (array) $args['value'] );
		$labels = (array) $args[ 'label' ];
		$selected = [];

		foreach( $values as $index => $value )
			$selected[$index] = selected( $value, $setting, false );

		self::_fieldRenderer( 'select', compact( 'id', 'name', 'values', 'labels', 'selected' ) );
	}

	// Validates raw input from option submission.
	static function validateFields( $fields ) {
		$validated = [];

		foreach( $fields as $field => $value ) {
			if( ! $sanction = isset( self::$registeredfields[ $field ] ) ? self::$registeredfields[ $field ] : false ) {
				continue;
			}

			$valid = true;
			if( !empty( $sanction['args']['raw'] ) ) {
				;// allow raw
			}
			elseif( is_scalar( $value ) ) {
				$value = sanitize_text_field( $value );
			}
			elseif( is_array( $value ) ) {
				$value = array_map( 'sanitize_text_field', $value );
			}

			switch( $sanction['type'] ) {
				case 'textfield' :

				if( $sanction['value'] && ! preg_match( "/{$sanction['value']}/", $value ) ) {
					add_settings_error( SERIES_SLUG, 'invalid-value', "'{$sanction['title']}' <strong>Invalid input</strong>" );
					$valid = false;
					break;
				}
				break;

				case 'select':
				case 'checkbox' :
				case 'radiobox' :

				if( is_scalar( $sanction['value'] ) && $value != $sanction['value'] ) {
					$valid = false;
					add_settings_error( SERIES_SLUG, 'invalid-value', "'{$sanction['title']}' <strong>Invalid input</strong>" );
				}
				elseif( is_array( $sanction['value'] ) && array_diff( (array) $value, $sanction['value'] ) ) {
					$valid = false;
					add_settings_error( SERIES_SLUG, 'invalid-value', "'{$sanction['title']}' <strong>Invalid input</strong>" );
				}

				default :
			}

			if( $valid ) {
				$validated[ $field ] = $value;
			}
		}

		return apply_filters( 'alsointhisseries_validate_fields', $validated, $fields );
	}

	// Adds option to sanctioned list. Should be called when a field is added.
	private static function _addFieldFilter( $type, $id, $title, $value, $args ) {
		self::$registeredfields[ $id ] = compact( 'type', 'title', 'value', 'args' );
	}

	// Delegates UI rendering to the template fragment loader.
	private static function _fieldRenderer( $type, $params ) {
		extract( $params );
		include "views/admin/optionsfield-{$type}.php";
	}
}

// Register admin functionality.
add_action( 'admin_menu', [ AlsoInThisSeriesAdmin::class, 'admin_menu' ] );
add_action( 'admin_init', [ AlsoInThisSeriesAdmin::class, 'admin_init' ] );
