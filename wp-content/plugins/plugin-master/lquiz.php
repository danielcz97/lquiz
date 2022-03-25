<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              l-quiz
 * @since             0.0.1
 * @package           l-quiz
 *
 * @wordpress-plugin
 * Plugin Name:       l-quiz
 * Plugin URI:        l-quiz
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           0.0.1
 * Author:            Daniel
 * Author URI:        l-quiz
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       l-quiz
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
require_once __DIR__ . '/vendor/autoload.php';
define( 'CD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'CD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
/*
|--------------------------------------------------------------------------
| Helper functions
|--------------------------------------------------------------------------
*/

/**
 * Dump variable.
 */
if ( ! function_exists('d') ) {

    function d() {
        call_user_func_array( 'dump' , func_get_args() );
    }

}

/**
 * Dump variables and die.
 */
if ( ! function_exists('dd') ) {

    function dd() {
        call_user_func_array( 'dump' , func_get_args() );
        die();
    }

}
/**
 * Currently plugin version.
 * Start at version 0.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'l-quiz_VERSION', '0.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lquiz-activator.php
 */
function activate_lquiz() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lquiz-activator.php';
	lquiz_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lquiz-deactivator.php
 */
function deactivate_lquiz() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lquiz-deactivator.php';
	lquiz_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lquiz' );
register_deactivation_hook( __FILE__, 'deactivate_lquiz' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-lquiz.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function run_lquiz() {

	$plugin = new lquiz();
	$plugin->run();

}
run_lquiz();