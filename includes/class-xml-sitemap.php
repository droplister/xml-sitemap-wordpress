<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/droplister/xml-sitemap-wordpress
 * @since      1.0.0
 *
 * @package    XML_Sitemap
 * @subpackage XML_Sitemap/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    XML_Sitemap
 * @subpackage XML_Sitemap/includes
 * @author     Dan Anderson <me@dananderson.org>
 */
class XML_Sitemap {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      XML_Sitemap_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if ( defined( 'XML_SITEMAP_VERSION' ) ) {
            $this->version = XML_SITEMAP_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'xml-sitemap';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - XML_Sitemap_Loader. Orchestrates the hooks of the plugin.
     * - XML_Sitemap_i18n. Defines internationalization functionality.
     * - XML_Sitemap_Admin. Defines all hooks for the admin area.
     * - XML_Sitemap_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the filters of the core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-xml-sitemap-loader.php';

        /**
         * The class responsible for defining internationalization functionality.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-xml-sitemap-i18n.php';

        /**
         * The class responsible for defining all the admin-facing filters.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-xml-sitemap-admin.php';

        /**
         * The class responsible for defining all the public-facing filters.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-xml-sitemap-public.php';

        $this->loader = new XML_Sitemap_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the XML_Sitemap_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new XML_Sitemap_i18n();

        $this->loader->add_filter( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new XML_Sitemap_Admin( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_filter( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_filter( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new XML_Sitemap_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_filter( 'query_vars', $plugin_public, 'register_query_vars' );
        $this->loader->add_filter( 'template_redirect', $plugin_public, 'register_template_redirect' );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    XML_Sitemap_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
