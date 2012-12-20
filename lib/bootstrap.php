<?php
class Bootstrap {

	public static function make_input($id, $label, $type, $value='') {
		echo '<label for="' . $id . '">' . $label . '</label> <input class="input-large" id="' . $id . '" name="' . $id . '" type="' . $type . '" value="' . $value . '"/>';

	}

}