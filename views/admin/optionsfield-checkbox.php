<?php foreach( $values as $index => $value ) : ?>
	<input type="checkbox" id="<?php echo "{$id}_$index" ?>" name="<?php echo $name ?>" value="<?php echo $value ?>" <?php  echo $checked[$index] ?>/>

	<?php if( isset( $labels[$index] ) ) : ?>
	<label for="<?php echo "{$id}_$index" ?>"><?php echo $labels[$index] ?></label>
	<?php endif ?>
<?php endforeach ?>