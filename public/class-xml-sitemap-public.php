<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/droplister/xml-sitemap-wordpress
 * @since      1.0.0
 *
 * @package    XML_Sitemap
 * @subpackage XML_Sitemap/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    XML_Sitemap
 * @subpackage XML_Sitemap/public
 * @author     Dan Anderson <me@dananderson.org>
 */
class XML_Sitemap_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $plugin_name    The name of the plugin.
     * @param    string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register query vars for redirect rules.
     *
     * @since    1.0.0
     * @param    array    $query_vars    Array of existing query_vars.
     * @return   array    Updated array with new query_vars.
     */
    public function register_query_vars( $query_vars ) {
        // Add XML Sitemap
        array_push( $query_vars, 'xml-sitemap' );

        return $query_vars;
    }

    /**
     * Register template redirect for sitemap.
     *
     * @since    1.0.0
     */
    public function register_template_redirect() {
        global $wp_query;

        // Listen for sitemap
        if( isset($wp_query->query_vars['xml-sitemap']) ) {
            // Update state
            $wp_query->is_404 = false;

            // Store format
            $format = $wp_query->query_vars['xml-sitemap'];

            // Fetch results
            $results = $this->fetch_results();

            // Format results
            $content = $this->format_results( $results, $format );

            // Return sitemap
            return $this->return_sitemap( $content, $format );
        }
    }

    /**
     * XML format matching query results.
     *
     * @since    1.0.0
     * @param    array    $query    Pre-built query to run.
     */
    private function fetch_results( $limit = 5000 ) {

        // Build WP Query
        $query = new WP_Query( array(
            'post_type' => ['page', 'post'],
            'orderby' => ['type', 'title'],
            'order' => 'DESC',
            'limit' => $limit,
        ) );

        // Results Array
        $results = array();

        // Build Results
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                // Scope
                $query->the_post();
                // Array
                array_push( $results, array(
                    'loc' => get_permalink(),
                    'lastmod' => get_the_modified_time( 'Y-m-d' ),
                ) );
            }
        }

        return $results;
    }

    /**
     * Load content into selected format.
     *
     * @since    1.0.0
     * @param    array    $results    Array of published posts.
     * @param    string    $format    Requested sitemap format.
     */
    private function format_results( $results, $format = 'xml' ) {

        // Format results
        switch ( $format ) {
            case 'xml':
                return $this->xml_format( $results );
        }

    }

    /**
     * XML format matching query results.
     *
     * @since    1.0.0
     * @param    array    $results    Pre-built query to run.
     */
    private function xml_format( $results ) {

        $content = "<?xml version='1.0' encoding='UTF-8'?>\n";
        $content .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";

        foreach ( $results as $result ) {
            $content .= "<url>\n";
            $content .= "<loc>{$result['loc']}</loc>";
            $content .= "<lastmod>{$result['lastmod']}</lastmod>";
            $content .= "<changefreq>monthly</changefreq>";
            $content .= "<priority>0.8</priority>";
            $content .= "</url>\n";
        }

        $content .= "</urlset>\n";

        return $content;
    }

    /**
     * Return sitemap with right headers.
     *
     * @since    1.0.0
     * @param    array    $content    Content of the sitemap.
     * @param    string    $format    Format of the sitemap.
     */
    private function return_sitemap( $content, $format ) {

        header("Content-Type: text/{$format}; charset=utf-8");

        exit($content);

    }
}
