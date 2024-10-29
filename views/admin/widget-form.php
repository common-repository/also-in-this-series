<div class="also-in-this-series-widget-form">
	<p>
		<label><?php _e( 'Select series', 'also-in-this-series' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'series-slug' ) ?>" name="<?php echo $this->get_field_name( 'series-slug' ) ?>">
			<option value=""><?php _e( 'Use Current Post Series', 'also-in-this-series' ) ?></option>
			<optgroup label="<?php _e( 'Available Series', 'also-in-this-series' ) ?>">
			<?php foreach( $series as $s ) : ?>
				<option value="<?php echo esc_attr( $s->slug ) ?>" <?php selected( $s->slug, $seriesslug ) ?>><?php echo esc_html( $s->name ) ?></option>
			<?php endforeach ?>
			</optgroup>
		</select>
	</p>
	<p>
		<label><?php _e( 'Title wrap', 'also-in-this-series' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'series-title-wrap' ) ?>" name="<?php echo $this->get_field_name( 'series-title-wrap' ) ?>">
			<option value=""><?php _e( 'Default', 'also-in-this-series' ) ?></option>
			<option value="h1" <?php selected( $titlewrap, 'h1' ) ?>><?php _e( 'h1', 'also-in-this-series' ) ?></option>
			<option value="h2" <?php selected( $titlewrap, 'h2' ) ?>><?php _e( 'h2', 'also-in-this-series' ) ?></option>
			<option value="h3" <?php selected( $titlewrap, 'h3' ) ?>><?php _e( 'h3', 'also-in-this-series' ) ?></option>
			<option value="span" <?php selected( $titlewrap, 'span' ) ?>><?php _e( 'span', 'also-in-this-series' ) ?></option>
		</select>
	</p>
	<p>
		<label><?php _e( 'Title template', 'also-in-this-series' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'series-title-template' ) ?>" name="<?php echo $this->get_field_name( 'series-title-template' ) ?>">
			<option value=""><?php _e( 'Default', 'also-in-this-series' ) ?></option>
			<option value="also-in" <?php selected( $titletemplate, 'also-in' ) ?>><?php _e( 'Also In Series Name', 'also-in-this-series' ) ?></option>
			<option value="ordinal" <?php selected( $titletemplate, 'ordinal' ) ?>><?php _e( 'This is part n of m in Series Name', 'also-in-this-series' ) ?></option>
			<option value="none" <?php selected( $titletemplate, 'none' ) ?>><?php _e( 'No Title', 'also-in-this-series' ) ?></option>
		</select>
	</p>
	<p>
		<label><?php _e( 'Window series listing?', 'also-in-this-series' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'series-use-frame' ) ?>" name="<?php echo $this->get_field_name( 'series-use-frame' ) ?>">
			<option value=""><?php _e( 'Default', 'also-in-this-series' ) ?></option>
			<option value="yes" <?php selected( $useframe, 'yes' ) ?>><?php _e( 'yes' ) ?></option>
			<option value="no" <?php selected( $useframe, 'no' ) ?>><?php _e( 'no' ) ?></option>
		</select>
	</p>
	<p>
		<label><?php _e( 'Set window size', 'also-in-this-series' ) ?></label>
		<input
			type="number"
			id="<?php echo $this->get_field_id( 'series-frame-width' ) ?>"
			name="<?php echo $this->get_field_name( 'series-frame-width' ) ?>"
			value="<?php echo esc_attr( $framewidth ) ?>"
			placeholder="Leave blank for default setting"
			min="1"
		/>
	</p>
	<p>
		<label><?php _e( 'Series listing order', 'also-in-this-series' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'series-sort-order' ) ?>" name="<?php echo $this->get_field_name( 'series-sort-order' ) ?>">
			<option value=""><?php _e( 'Default', 'also-in-this-series' ) ?></option>
			<option value="asc" <?php selected( $sortorder, 'asc' ) ?>><?php _e( 'Oldest to newest', 'also-in-this-series' ) ?></option>
			<option value="desc" <?php selected( $sortorder, 'desc' ) ?>><?php _e( 'Newest to oldest', 'also-in-this-series' ) ?></option>
		</select>
	</p>
	<p>
		<label><?php _e( 'Display series listing?', 'also-in-this-series' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'series-hide-listing' ) ?>" name="<?php echo $this->get_field_name( 'series-hide-listing' ) ?>">
			<option value="default"><?php _e( 'Default', 'also-in-this-series' ) ?></option>
			<option value="no" <?php selected( $hideserieslisting, 'no' ) ?>><?php _e( 'yes' ) ?></option>
			<option value="yes" <?php selected( $hideserieslisting, 'yes' ) ?>><?php _e( 'no' ) ?></option>
		</select>
	</p>
	<p>
		<label><?php _e( 'Always show series link?', 'also-in-this-series' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'series-always-link' ) ?>" name="<?php echo $this->get_field_name( 'series-always-link' ) ?>">
			<option value="default"><?php _e( 'Default', 'also-in-this-series' ) ?></option>
			<option value="yes" <?php selected( $alwayslinkseries, 'yes' ) ?>><?php _e( 'yes' ) ?></option>
			<option value="no" <?php selected( $alwayslinkseries, 'no' ) ?>><?php _e( 'no' ) ?></option>
		</select>
	</p>
</div>
