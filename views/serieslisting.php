<aside id="<?php echo "series-{$series->slug}" ?>" class="also-in-this-series">
<?php if( $title ) : ?>
<div class="series-title">
	<<?php echo $titlewrap ?>><?php echo $title ?></<?php echo $titlewrap ?>>
</div>
<?php endif ?>
<?php if( $description ) : ?>
	<div class="series-description"><?php echo $description ?></div>
<?php endif ?>

<?php if( !$hideserieslisting ) : ?>
	<ol start="<?php echo $logicalframe[0] ?>" <?php echo $sortorder === 'desc' ? 'reversed' : '' ?>>
	<?php foreach( $seriesposts as $index => $seriespost ) : ?>
		<?php if( !is_single() || $seriespost->ID !== $post->ID ) : ?>
			<li class="series-post">
				<a href="<?php echo get_permalink( $seriespost->ID ) ?>"
				><?php echo get_the_title( $seriespost->ID ) ?></a>
			</li>
		<?php else : ?>
			<li class="series-post current">
				<strong><?php echo get_the_title( $seriespost->ID ) ?></strong>
			</li>
		<?php endif ?>
	<?php endforeach ?>
	</ol>
<?php endif ?>

<?php if( $hideserieslisting || $framing || $alwayslinkseries ) : ?>
<div class="series-link">
	<a href="<?php echo get_term_link( $series ) ?>"><?php _e( 'View the entire series', 'also-in-this-series' ) ?></a>
</div>
<?php endif ?>
</aside>
