<?php

/**
 * This file contain the Gravity Form hooks.
 * @since 1.0.0
 */

/**
 * Change the Gravity Form error message.
 * @since 1.0.0
 */
add_filter( "gform_validation_message", "mccain_change_message", 10, 2 );
function mccain_change_message($message, $form) {
	return '<div class="validation_error">' . __( 'Please correct errors.', 'mccain' ) . '</div>';
}