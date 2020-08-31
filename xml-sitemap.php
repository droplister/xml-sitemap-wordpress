<?php

/**
 * Bootstrap XML Sitemap Plugin
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/droplister/xml-sitemap-wordpress
 * @since             1.0.0
 * @package           XML_Sitemap
 *
 * @wordpress-plugin
 * Plugin Name:       XML Sitemap
 * Plugin URI:        https://sitemaps.info/
 * Description:       Simple XML sitemap for search engines.
 * Version:           1.0.0
 * Author:            Dan Anderson
 * Author URI:        https://dananderson.org/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       xml-sitemap
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'XML_SITEMAP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-xml-sitemap-activator.php
 */
function activate_xml_sitemap() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-xml-sitemap-activator.php';
    XML_Sitemap_Activator::activate();
}
register_activation_hook( __FILE__, 'activate_xml_sitemap' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-xml-sitemap-deactivator.php
 */
function deactivate_xml_sitemap() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-xml-sitemap-deactivator.php';
    XML_Sitemap_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_xml_sitemap' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-xml-sitemap.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_xml_sitemap() {

    $plugin = new XML_Sitemap();
    $plugin->run();

}
run_xml_sitemap();
