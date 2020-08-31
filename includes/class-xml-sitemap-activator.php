<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/droplister/xml-sitemap-wordpress
 * @since      1.0.0
 *
 * @package    XML_Sitemap
 * @subpackage XML_Sitemap/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    XML_Sitemap
 * @subpackage XML_Sitemap/includes
 * @author     Dan Anderson <me@dananderson.org>
 */
class XML_Sitemap_Activator {

    /**
     * Activate plugin.
     *
     * @since    1.0.0
     */
    public static function activate() {
        global $wp_rewrite;

        // Sitemap.xml
        add_filter( 'redirect_canonical', array( __CLASS__, 'prevent_trailing_slash' ) );
        add_filter( 'rewrite_rules_array', array( __CLASS__, 'register_redirect_rules' ) );

        // Flush Rules
        $wp_rewrite->flush_rules( false );
    }

    /**
     * Register rewrite rule for sitemap.xml.
     *
     * @since    1.0.0
     * @param    array    $redirect_rules    Array of existing rewrite rules.
     * @return   array    Updated array with new redirect rules.
     */
    public static function register_redirect_rules( $redirect_rules ) {
        // Sitemap.xml rule
        $new_rules = array( 'sitemap\.xml$' => 'index.php?xml-sitemap=xml' );

        return array_merge( $new_rules, $redirect_rules );
    }

    /**
     * Prevent sitemap with trailing slash.
     *
     * @since    1.0.0
     * @param    string    $redirect_url    Canonical redirect URL.
     * @return   mixed    Redirect or don't to prevent slash.
     */
    public static function prevent_trailing_slash( $redirect_url ) {
        // Catch sitemap.xml
        if ( (bool) get_query_var( 'xml-sitemap' ) ) {
            return false;
        }

        return $redirect_url;
    }

}
