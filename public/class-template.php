<?php
/**
 * Registers the Template class.
 *
 * @package SLO\Template
 * @since 0.0.1
 */

namespace SLO;

/**
 * Adds the page template for the social link archive page.
 *
 * The Template class adds the SLO archive page to the list of page template options.
 *
 * @package SLO\CPT
 * @since 0.0.1
 * @see https://www.wpexplorer.com/wordpress-page-templates-plugin/
 */
class Template {

  /**
   * The array of templates that this plugin tracks.
   *
   * @var array $templates
   *
   * @since 0.0.1
   */
  protected $templates;

  /**
   * Initializes the class with the plugin name and version.
   *
   * @param string $plugin     The plugin name.
   * @param string $version    The plugin version number.
   *
   * @since 0.0.1
   */
  public function __construct( $plugin, $version ) {
    $this->plugin    = $plugin;
    $this->version   = $version;
    $this->templates = array(
      'archive-gpalab-social-link.php' => 'Social Link Optimizer',
    );
  }

  /**
   * Checks if the template is assigned to the page.
   *
   * @param string $template_path  The name of the current page's template.
   * @return string                The page template that should be rendered.
   *
   * @since 0.0.1
   */
  public function include_custom_templates( $template_path ) {
    if ( 'gpalab-social-link' === get_post_type() && is_single() ) {
      $theme_file = locate_template( array( 'base-gpalab-social-link.php' ) );

      if ( $theme_file ) {
        $template_path = $theme_file;
      } else {
        $template_path = GPALAB_SLO_DIR . 'templates/base-gpalab-social-link.php';
      }
    } else {
      global $post;

      $current_template = get_post_meta( $post->ID, '_wp_page_template', true );

      if ( isset( $this->templates[ $current_template ] ) ) {
        $template_path = GPALAB_SLO_DIR . 'templates/base-gpalab-social-link.php';
      }
    }

    return $template_path;
  }

  /**
   * Bypass the Sage base.php file for plugin custom post type.
   *
   * @param array $templates   List of available templates.
   * @return array             Updated list of templates.
   *
   * @since 1.1.0
   */
  public function sage_wrap_base_cpts( $templates ) {
    $cpt = get_post_type();

    if ( 'gpalab-social-link' === $cpt ) {
      array_unshift( $templates, 'base-' . $cpt . '.php' );
    }

    return $templates;
  }

  /* DEPRECATED FUNCTIONS */

  /**
   * Adds our template to the page dropdown for v4.7+
   *
   * @param array $posts_templates   List of available post templates.
   * @return array                   Updated list of available page templates
   *
   * @deprecated Removed since mission page is autogenerated, to re-instate, hook into the 'theme_page_templates' filter.
   *
   * @since 0.0.1
   */
  public function add_new_template( $posts_templates ) {
    if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<=' ) ) {
      return;
    }

    // If the user lacks the proper permission return the standard list of templates.
    if ( ! current_user_can( 'gpalab_slo_add_slo_page' ) ) {
      return $posts_templates;
    }

    $posts_templates = array_merge( $posts_templates, $this->templates );

    return $posts_templates;
  }

  /**
   * Adds our template to the pages cache in order to trick WordPress
   * into thinking the template file exists where it doesn't really exist.
   *
   * @param array $atts   List of attributes.
   *
   * @deprecated Removed since mission page is autogenerated, to re-instate, hook into the 'wp_insert_post_data' filter.
   *
   * @since 0.0.1
   */
  public function register_project_templates( $atts ) {

    // Create the key used for the themes cache.
    $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

    // Retrieve the cache list.
    // If it doesn't exist, or it's empty prepare an array.
    $templates = wp_get_theme()->get_page_templates();
    if ( empty( $templates ) ) {
      $templates = array();
    }

    // New cache, therefore remove the old one.
    wp_cache_delete( $cache_key, 'themes' );

    // Now add our template to the list of templates by merging our templates
    // with the existing templates array from the cache.
    $templates = array_merge( $templates, $this->templates );

    // Add the modified cache to allow WordPress to pick it up for listing.
    // available templates.
    wp_cache_add( $cache_key, $templates, 'themes', 1800 );

    return $atts;
  }
}
