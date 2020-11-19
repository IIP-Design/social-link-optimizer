<?php
/**
 * Registers the Uninstall class.
 *
 * @package SLO\Activator
 * @since 0.0.1
 */

namespace SLO;

/**
 * Register all hooks to be run when the plugin is uninstalled.
 *
 * @package SLO/Uninstall
 * @since 0.0.1
 */
class Uninstall {

  /**
   * Run cleanup to delete plugin data upon uninstall.
   *
   * @since 0.0.1
   */
  public function uninstall() {

    // Ensure user has the proper permissions.
    if ( ! current_user_can( 'delete_plugins' ) ) {
      return;
    }

    if ( ! is_multisite() ) {

      self::remove_options();
      self::remove_capabilities();
      self::delete_slo_page_meta();
      self::reset_slo_page_templates();
      self::delete_slo_cpts();

    } else {

      // For a multisite you have to iterate through all the blogs to run uninstall hooks.
      $sites_query_args = array(
        'fields' => 'ids',
      );

      $blog_ids     = get_sites( $sites_query_args );
      $current_blog = get_current_blog_id();

      // Iterate through all blogs running deactivation hooks.
      foreach ( $blog_ids as $id ) {
        switch_to_blog( $id );

        self::remove_options();
        self::remove_capabilities();
        self::delete_slo_page_meta();
        self::reset_slo_page_templates();
        self::delete_slo_cpts();
      }

      unset( $id );

      // Switch back to .
      switch_to_blog( $current_blog );
    }
  }

  /**
   * Delete the plugin's options from the options table in the database.
   *
   * @since 0.0.1
   */
  private static function remove_options() {
    delete_option( 'gpalab-slo-settings' );
  }

  /**
   * Remove the custom capabilities added by the plugin.
   *
   * @since 0.0.1
   */
  private static function remove_capabilities() {
    $custom_caps = array(
      'gpalab_slo_manage_settings',
      'gpalab_slo_add_slo_page',
      'gpalab_slo_edit_slo_page',
      'gpalab_slo_edit_links',
      'gpalab_slo_edit_others_links',
      'gpalab_slo_edit_private_links',
      'gpalab_slo_edit_published_links',
      'gpalab_slo_delete_links',
      'gpalab_slo_delete_others_links',
      'gpalab_slo_delete_private_links',
      'gpalab_slo_delete_published_links',
      'gpalab_slo_read_private_links',
      'gpalab_slo_delete_links',
    );

    $editable = get_editable_roles();

    foreach ( $custom_caps as $cap ) {

      foreach ( wp_roles()->role_objects as $key => $role ) {

        if ( isset( $editable[ $key ] ) && $role->has_cap( $cap ) ) {
          $role->remove_cap( $cap );
        }

        unset( $role );
      }
    }

    unset( $cap );
  }

  /**
   * Find all pages with an associated SLO mission and remove that meta value.
   *
   * @since 0.0.1
   */
  private static function delete_slo_page_meta() {
    $posts_per_page = -1;

    // Running plugin clean function can be slow.
    // phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_key
    $query_args = array(
      'post_type'      => 'page',
      'fields'         => 'ids',
      'no_found_rows'  => true,
      'posts_per_page' => $posts_per_page,
      'meta_key'       => '_gpalab_slo_mission_select',
    );
    // phpcs:enable

    $query = new \WP_Query( $query_args );

    if ( $query->posts ) {
      foreach ( $query->posts as $key => $post ) {
        delete_post_meta( $post, '_gpalab_slo_mission_select' );
      }

      unset( $post );
    }
  }

  /**
   * Find all pages with using the SLO page template and reset them as default pages.
   *
   * @since 0.0.1
   */
  private static function reset_slo_page_templates() {
    $posts_per_page = -1;

    // Running plugin clean function can be slow.
    // phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_key
    // phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_value
    $query_args = array(
      'post_type'      => 'page',
      'fields'         => 'ids',
      'no_found_rows'  => true,
      'posts_per_page' => $posts_per_page,
      'meta_key'       => '_wp_page_template',
      'meta_value'     => 'archive-gpalab-social-link.php',
      'meta_compare'   => '=',
    );
    // phpcs:enable

    $query = new \WP_Query( $query_args );

    if ( $query->posts ) {
      foreach ( $query->posts as $key => $post ) {
        update_post_meta( $post, '_wp_page_template', 'default' );
      }

      unset( $post );
    }
  }

  /**
   * Find and delete social link custom post types generated by the plugin.
   *
   * @since 0.0.1
   */
  private function delete_slo_cpts() {

    $posts_per_page = -1;

    $query_args = array(
      'fields'         => 'ids',
      'no_found_rows'  => true,
      'post_type'      => 'gpalab-social-link',
      'posts_per_page' => $posts_per_page,
    );

    $posts = get_posts( $query_args );

    foreach ( $posts as $post ) {
      wp_delete_post( $post );
    }

    unset( $post );
  }
}
