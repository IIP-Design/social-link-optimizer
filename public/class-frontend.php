<?php
/**
 * Registers the Frontend class.
 *
 * @package SLO\Frontend
 * @since 0.0.1
 */

namespace SLO;

/**
 * Registers the scripts and styles for the frontend template.
 *
 * @package SLO\Frontend
 * @since 0.0.1
 */
class Frontend {

  /**
   * Initializes the class with the plugin name and version.
   *
   * @param string $plugin     The plugin name.
   * @param string $version    The plugin version number.
   *
   * @since 0.0.1
   */
  public function __construct( $plugin, $version ) {
    $this->plugin  = $plugin;
    $this->version = $version;
  }

  /**
   * Enqueue styles plugin's scripts and styles.
   *
   * @since 0.0.1
   */
  public function gpalab_slo_stylesheets() {
    $wp_styles       = wp_styles();
    $is_slo_template = is_page_template( 'archive-gpalab-social-link.php' );
    $is_slo_preview  = is_singular( 'gpalab-social-link' );

    if ( $is_slo_template || $is_slo_preview ) {
      foreach ( $wp_styles->registered as $wp_style ) {
        $handle              = $wp_style->handle;
        $src                 = $wp_style->src;
        $is_theme_stylesheet = is_int( strpos( $src, '/themes/' ) );

        if ( ! $is_theme_stylesheet ) {
          continue;
        }

        wp_dequeue_style( $handle );
      }

      wp_enqueue_style(
        'social-bio-links',
        GPALAB_SLO_URL . 'public/css/gpalab-slo-front.css',
        array(),
        $this->version
      );
    }
  }

  /**
   * Load more scripts.
   *
   * @since 0.0.1
   */
  public function gpalab_slo_scripts() {
    if ( ! is_page_template( 'archive-gpalab-social-link.php' ) ) {
      return;
    }

    $paged   = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $mission = get_post_meta( get_the_ID(), '_gpalab_slo_mission_select', true );
    // phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_key
    // phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_value
    $args = array(
      'post_type'      => 'gpalab-social-link',
      'meta_key'       => 'gpalab_slo_mission',
      'meta_value'     => $mission,
      'meta_compare'   => '=',
      'posts_per_page' => 3,
      'paged'          => $paged,
    );
    // phpcs:enable

    $the_query = new \WP_Query( $args );

    $script_asset = require GPALAB_SLO_DIR . 'admin/build/gpalab-slo-mission-plugin.asset.php';

    wp_register_script(
      'gpalab-slo-load-more-js',
      GPALAB_SLO_URL . 'public/js/gpalab-slo-scripts.js',
      array(),
      $script_asset['version'],
      true
    );

    wp_localize_script(
      'gpalab-slo-load-more-js',
      'gpalabSloLoadMore',
      array(
        'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
        'social_links'  => wp_json_encode( $the_query->query_vars ),
        'current_page'  => $paged,
        'max_num_pages' => $the_query->max_num_pages,
        'mission'       => $mission,
        'nonce'         => wp_create_nonce( 'gpalab-slo-nonce' ),
      )
    );

     wp_enqueue_script( 'gpalab-slo-load-more-js' );
  }
}
