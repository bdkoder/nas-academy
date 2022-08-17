<?php
/**
 * @package AlecadddPlugin
 */
namespace Inc\Api\Callbacks;

use \Inc\Base\BaseController;

class ManagerCallbacks extends BaseController{

	 public function checkboxSanitize( $input ){
	 	// return filter_var( $input, FILTER_SANITIZE_NUMBER_INT );
	 	// return ( isset( $input ) ? true : false );
	 	$output = array();
	 	foreach ( $this->managers as $key => $value ) {

	 		// $output[$key] = isset( $input[$key] ) ? true : false ;
	 		$output[$key] = ( isset( $input[$key] ) && $input[$key] == 1 ) ? true : false;
	 	}

	 	return $output;
	 } 

	 public function adminSectionManager(){
	 	echo "Activate the sections and features of this plugin by activating from the following list.";
	 }

	 public function checkboxField($args){
	 	// var_dump($args);
	 /*	$name = $args['label_for'];
	 	$classes = $args['class'];
	 	$option_name = $args['option_name'];
	 	$checkbox = get_option( $option_name );
	 	$checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;

	 	echo '<div class="'.$classes.'"><input type="checkbox" id="' . $name . '" name="'.$option_name.'[' . $name . ']"value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';
*/
	 	// for sky
	 		// var_dump($args);
	 	$name = $args['label_for'];
	 	$classes = $args['class'];
	 	$option_name = $args['option_name'];
	 	$checkbox = get_option( $option_name );
	 	//$checked = ($args['default'] == 'on') ? true : false;
	 	$checked = (isset($checkbox[$name]) ? ($checkbox[$name]==1 ? true : false) : ($args['default'] == 'on')) ? true : false;


	 	echo '<div class="'.$classes.'"><input type="checkbox" id="' . $name . '" name="'.$option_name.'[' . $name . ']"value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';

	 }
}
 