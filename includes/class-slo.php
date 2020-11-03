<?php
/**
 * Registers the SLO class.
 *
 * @package SLO
 * @since 0.0.1
 */

 /**
  * Register all hooks to be run by the plugin.
  *
  * @package SLO
  */
class SLO {

  /**
   * The loader that's responsible for maintaining and registering all hooks that power the plugin.
   *
   * @var SLO_Loader $loader    Maintains and registers all hooks for the plugin.
   *
   * @access protected
   * @since 0.0.1
   */

  protected $loader;

  /**
   * The unique identifier and version of this plugin.
   *
   * @var string $plugin_name
   *
   * @access protected
   * @since 0.0.1
   */
  protected $plugin_name;

  /**
   * The version of this plugin.
   *
   * @var string $version
   *
   * @access protected
   * @since 0.0.1
   */
  protected $version;

  /**
   * Define the core functionality of the plugin.
   *
   * Set the plugin name and the plugin version that can be used throughout the plugin.
   * Load the dependencies and set the hooks for the admin area and
   * the public-facing side of the site.
   *
   * @since 0.0.1
   */
  public function __construct() {
    $this->plugin_name = 'social-link-optimizer';
    $this->version     = '0.0.1';
    $this->load_dependencies();
    $this->define_admin_hooks();
    $this->define_public_hooks();
  }

  /**
   * Load the required dependencies for this plugin.
   *
   * Include the following files that make up the plugin:
   *
   * - SLO\Loader. Orchestrates the hooks of the plugin.
   * - SLO\Admin. Defines all hooks for the admin area.
   * - SLO\Frontend. Defines all hooks for the public side of the site.
   *
   * Create an instance of the loader which will be used to register the hooks with WordPress.
   *
   * @access private
   * @since 0.0.1
   */
  private function load_dependencies() {
    // The class responsible for orchestrating the actions and filters of the core plugin.
    require_once GPALAB_SLO_DIR . 'includes/class-loader.php';

    // The class responsible for defining all actions that occur in the admin area.
    require_once GPALAB_SLO_DIR . 'admin/class-cpt.php';
    require_once GPALAB_SLO_DIR . 'admin/class-settings.php';

    // The class responsible for defining all actions that occur in the public-facing side of the site.
    require_once GPALAB_SLO_DIR . 'public/class-frontend.php';
    require_once GPALAB_SLO_DIR . 'public/class-template.php';

    $this->loader = new SLO\Loader();
  }

  /**
   * Register all of the hooks related to the admin area functionality of the plugin.
   *
   * @since 0.0.1
   */
  private function define_admin_hooks() {
    $plugin_cpt      = new SLO\CPT( $this->get_plugin_name(), $this->get_version() );
    $plugin_settings = new SLO\Settings( $this->get_plugin_name(), $this->get_version() );

    // Custom post type hooks.
    $this->loader->add_action( 'init', $plugin_cpt, 'gpalab_slo_cpt', 0 );
    $this->loader->add_action( 'add_meta_boxes', $plugin_cpt, 'gpalab_slo_custom_meta' );
    $this->loader->add_action( 'save_post', $plugin_cpt, 'gpalab_slo_meta_save' );
    $this->loader->add_action( 'do_meta_boxes', $plugin_cpt, 'gpalab_slo_image_meta_box' );
    $this->loader->add_filter( 'post_type_link', $plugin_cpt, 'gpalab_slo_filter_permalink', 10, 2 );

    // Settings page hooks.
    $this->loader->add_action( 'admin_menu', $plugin_settings, 'gpalab_slo_settings_add_plugin_page' );
    $this->loader->add_action( 'admin_init', $plugin_settings, 'gpalab_slo_settings_page_init' );
  }

  /**
   * Register all of the hooks related to the public-facing functionality
   *
   * @since 0.0.1
   */
  private function define_public_hooks() {
    $plugin_frontend = new SLO\Frontend( $this->get_plugin_name(), $this->get_version() );
    $plugin_template = new SLO\Template( $this->get_plugin_name(), $this->get_version() );

    // Frontend hooks.
    $this->loader->add_action( 'wp_enqueue_scripts', $plugin_frontend, 'gpalab_slo_stylesheets' );

    // Add a filter to the attributes metabox to inject template into the cache.
    if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
      // 4.6 and older
      $this->loader->add_filter( 'page_attributes_dropdown_pages_args', $plugin_template, 'register_project_templates' );
    } else {
      // Add a filter to the wp 4.7 version attributes metabox.
      $this->loader->add_filter( 'theme_page_templates', $plugin_template, 'add_new_template' );
    }
    // Add a filter to the save post to inject out template into the page cache.
    $this->loader->add_filter( 'wp_insert_post_data', $plugin_template, 'register_project_templates' );
    // Add a filter to the template include to determine if the page has our
    // template assigned and return it's path.
    $this->loader->add_filter( 'template_include', $plugin_template, 'view_project_template' );
  }

  /**
   * Run the loader to execute all of the hooks with WordPress.
   *
   * @since 0.0.1
   */
  public function run() {
    $this->loader->run();
  }

  /**
   * The reference to the class that orchestrates the hooks with the plugin.
   *
   * @return SLO_Loader    Orchestrates the hooks of the plugin.
   *
   * @since 0.0.1
   */
  public function get_loader() {
    return $this->loader;
  }

  /**
   * Retrieve the name of the plugin.
   *
   * @since 0.0.1
   */
  public function get_plugin_name() {
    return $this->plugin_name;
  }

  /**
   * Retrieve the version number of the plugin.
   *
   * @since 0.0.1
   */
  public function get_version() {
    return $this->version;
  }
}
