<?php
/**
 * A helper function validate input data
 * return the validated input or error log
 *
 * @since    0.0.3
 *
 */
class ValidationForm{
    /**
     * @param $input
     * @return mixed
     * function validate input data
     * @todo make mix type with switch
     */

    public function validationHelper( $input)  {

		$input_type = gettype($input);
		switch ($input_type) {
			case 'array':
				$array_with_inputs = array();
				foreach($input as $single) {
					$single = $single ? strlen($single) > 1 : $single;
					$single = trim($single);
					$single = stripslashes($single);
					$single = htmlspecialchars($single);
					array_push($array_with_inputs, $single);
				}
				return($array_with_inputs);
				break;
			case 'string' :
				$input = trim($input);
				$input = stripslashes($input);
				$input = htmlspecialchars($input);
				return $input;
				break;
			default:
				return $input;

		}
    }
}