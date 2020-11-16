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
 * The Settings class adds a settings page allowing site admins to configure the plugin.
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

  // }

  /**
   * Adds our template to the page dropdown for v4.7+
   *
   * @param array $posts_templates   List of available post templates.
   *
   * @since 0.0.1
   */
  public function add_new_template( $posts_templates ) {
    $posts_templates = array_merge( $posts_templates, $this->templates );

    return $posts_templates;
  }

  /**
   * Adds our template to the pages cache in order to trick WordPress
   * into thinking the template file exists where it doesn't really exist.
   *
   * @param array $atts   List of attributes.
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

  /**
   * Checks if the template is assigned to the page.
   *
   * @param string $template  The current page's template.
   *
   * @since 0.0.1
   */
  public function view_project_template( $template ) {
    // Return the search template if we're searching (instead of the template for the first result).
    if ( is_search() ) {
      return $template;
    }

    // Get global post.
    global $post;

    // Return template if post is empty.
    if ( ! $post ) {
      return $template;
    }

    // Return default template if we don't have a custom one defined.
    if ( ! isset(
      $this->templates[ get_post_meta(
        $post->ID,
        '_wp_page_template',
        true
      ) ]
    ) ) {
      return $template;
    }

    // Allows filtering of file path.
    $filepath = GPALAB_SLO_DIR . 'templates/';

    $file = $filepath . get_post_meta(
      $post->ID,
      '_wp_page_template',
      true
    );

    // Just to be safe, we check if the file exist first.
    if ( file_exists( $file ) ) {
      return $file;
    } else {
      echo esc_html( $file );
    }

    // Return template.
    return $template;
  }
}
