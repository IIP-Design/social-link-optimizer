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
   * Enqueue plugin's styles and scripts.
   *
   * @since 0.0.1
   */
  public function gpalab_slo_styles_scripts() {
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

    // Scripts.
    if ( ! $is_slo_template ) {
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
      'posts_per_page' => 18,
      'paged'          => $paged,
    );
    // phpcs:enable

    $the_query = new \WP_Query( $args );

    $script_asset = require GPALAB_SLO_DIR . 'public/build/gpalab-slo-public.asset.php';

    wp_register_script(
      'gpalab-slo-load-more',
      GPALAB_SLO_URL . 'public/build/gpalab-slo-public.js',
      $script_asset['dependencies'],
      $script_asset['version'],
      true
    );

    wp_localize_script(
      'gpalab-slo-load-more',
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

    wp_enqueue_script( 'gpalab-slo-load-more' );
  }

  /**
   * Wrap some string or HTML element in a link.
   *
   * @param string $element   The element to be placed within a link.
   * @param string $url       The wrapping url.
   */
  private function linkify( $element, $url ) {
    return '<a href="' . esc_url( $url ) . '">' . $element . '</a>';
  }

  /**
   * Create the list item markup for displaying social links.
   *
   * @param string $layout      The display setting for a selected mission.
   * @param int    $post_id     The id of the current post.
   */
  public function get_social_link_item( $layout, $post_id ) {
    $is_grid = 'grid' === $layout;

    // Retrieve the item title.
    $item_title = $is_grid
      ? get_the_title( $post_id )
      : $this->linkify( get_the_title( $post_id ), get_permalink() );

    // Retrieve the item photo.
    $thumbnail = get_the_post_thumbnail(
      $post_id,
      'post-thumbnail',
      array( 'class' => 'gpalab-slo-thumbnail' )
    );

    $item_photo = $this->linkify( $thumbnail, get_permalink() );

    $hide_visually_class = $is_grid ? 'hide-visually' : '';

    // Cobble together the HTML for a link item.
    $item  = '<li>';
    $item .= '<h3 class="title ' . $hide_visually_class . '">' . wp_kses( $item_title, 'post' ) . '</h3>';
    $item .= $is_grid ? wp_kses( $item_photo, 'post' ) : '';
    $item .= '</li>';

    // Sanitize the HTML returned onto the page.
    echo wp_kses( $item, 'post' );
  }

  /**
   * Load more social links AJAX handler.
   *
   * @since 0.0.1
   */
  public function gpalab_slo_load_more() {
    check_ajax_referer( 'gpalab-slo-nonce', 'security' );

    $paged      = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 0;
    $query      = isset( $_POST['query'] ) ? sanitize_text_field( wp_unslash( $_POST['query'] ) ) : '';
    $mission_id = isset( $_POST['mission'] ) ? sanitize_text_field( wp_unslash( $_POST['mission'] ) ) : '';

    // phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_key
    // phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_value
    $args = array(
      'meta_key'       => 'gpalab_slo_mission',
      'meta_value'     => $mission_id,
      'meta_compare'   => '=',
      'post_type'      => 'gpalab-social-link',
      'post_status'    => 'publish',
      'posts_per_page' => 18,
      'paged'          => $paged ? $paged + 1 : 1,
      'query'          => json_decode( $query, true ),
    );
    // phpcs:enable
    $wp_query = new \WP_Query( $args );

    if ( $wp_query->have_posts() ) {

      $slo_settings  = get_option( 'gpalab-slo-settings' );
      $settings_key  = array_search( $mission_id, array_column( $slo_settings, 'id' ), true );
      $page_settings = is_numeric( $settings_key ) ? $slo_settings[ $settings_key ] : array();
      $layout        = ( isset( $page_settings['type'] ) && '' !== $page_settings['type'] )
        ? $page_settings['type']
        : 'grid';

      while ( $wp_query->have_posts() ) {
        $wp_query->the_post();
        $current_post = get_the_ID();

        $this->get_social_link_item( $layout, $current_post );
      }
    }

    wp_reset_postdata();
    wp_die();
  }
}
