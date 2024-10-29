<div class="wrap">
	<div id="icon-themes" class="icon32"></div>
	<h2><?php _e( 'Also In This Series Settings', 'also-in-this-series' ) ?></h2>
	<form method="post" action="options.php">
	<?php settings_fields( \planetjon\wordpress\also_in_this_series\SERIES_SLUG ) ?>
	<?php do_settings_sections( \planetjon\wordpress\also_in_this_series\SERIES_SETTINGS_PAGE ) ?>    
	<?php submit_button() ?>
	</form>
</div>
