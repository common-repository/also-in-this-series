<select id="<?php echo $id ?>" name="<?php echo $name ?>">
<?php foreach( $values as $index => $value ) : ?>
	<option value="<?php echo $value ?>" <?php echo $selected[$index] ?>><?php echo isset( $labels[$index] ) ? $labels[$index] : '' ?></option>
<?php endforeach ?>
</select>
