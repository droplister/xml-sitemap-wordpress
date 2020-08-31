<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/droplister/xml-sitemap-wordpress
 * @since      1.0.0
 *
 * @package    XML_Sitemap
 * @subpackage XML_Sitemap/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    XML_Sitemap
 * @subpackage XML_Sitemap/includes
 * @author     Dan Anderson <me@dananderson.org>
 */
class XML_Sitemap_i18n {


    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            'xml-sitemap',
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );

    }



}
