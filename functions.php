<?php
/**
 * Theme functions and definitions
 *
 * @package MCCAIN
 */
define( 'MCCAIN', '1.0.0' );
define( 'MCCAIN_DIR', trailingslashit( get_stylesheet_directory() ) );
define( 'MCCAIN_DIR_URI', trailingslashit( get_stylesheet_directory_uri() ) );
define( 'MCCAIN_INC_DIR', MCCAIN_DIR . 'includes/' );

/**
 * Include a theme file.
 * @since 1.0.0
 */
require_once MCCAIN_INC_DIR . 'theme.php';

/**
 * Include a wp-hooks file.
 * @since 1.0.0
 */
require_once MCCAIN_INC_DIR . 'wp-hooks.php';

/**
 * Include a general functions file.
 * @since 1.0.0
 */
require_once MCCAIN_INC_DIR . 'general-functions.php';

/**
 * Include a gravity forms file.
 * @since 1.0.0
 */
require_once MCCAIN_INC_DIR . 'gravity-forms.php';

/**
 * Include a shortcode file.
 * @since 1.0.0
 */
require_once MCCAIN_INC_DIR . 'shortcodes.php';

/**
 * Include a pagination file.
 * @since 1.0.0
 */
require_once MCCAIN_INC_DIR . 'pagination.php';

/**
 * Include a admin-column file.
 * @since 1.0.0
 */
// require_once MCCAIN_INC_DIR . 'admin-column.php';