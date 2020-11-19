<?php
/**
 * Registers the Permissions class.
 *
 * @package SLO\Permissions
 * @since 0.0.1
 */

namespace SLO;

/**
 * Handles Permissions calls needed to persist data on the server.
 *
 * @package SLO\Permissions
 * @since 0.0.1
 */
class Permissions {
  /**
   * The capability required to edit SLO archive pages.
   *
   * @var string $edit_cap
   *
   * @since 0.0.1
   */
  protected $edit_cap;

  /**
   * Initializes the class with the plugin name and version,
   * as well as the capability required to edit SLO archive pages.
   *
   * @param string $plugin     The plugin name.
   * @param string $version    The plugin version number.
   *
   * @since 0.0.1
   */
  public function __construct( $plugin, $version ) {
    $this->plugin    = $plugin;
    $this->version   = $version;
    $this->$edit_cap = 'gpalab_slo_edit_slo_page';
  }

  /**
   * Remove the Edit link from the admin bar on the SLO archive page frontend
   * for admin users without the proper permissions.
   *
   * @since 0.0.1
   */
  public function slo_archive_remove_admin_bar_edit_link() {
    $is_gpa_slo_archive = is_page_template( 'archive-gpalab-social-link.php' );

    if ( $is_gpa_slo_archive && ! current_user_can( $this->$edit_cap ) ) {
      global $wp_admin_bar;

      $wp_admin_bar->remove_menu( 'edit' );
    }
  }

  /**
   * Removes the Edit, Quick Edit, and Trash action buttons from SLO archive
   * pages if the user doesn't have the appropriate permissions.
   *
   * @param array  $actions  List of action links.
   * @param object $post     WordPress post Object.
   *
   * @since 0.0.1
   */
  public function disable_actions( $actions = array(), $post = null ) {

    // If the current user can edit SLO archive pages, return all actions.
    if ( current_user_can( $this->$edit_cap ) ) {
      return $actions;
    }

    // If the page template is not an SLO archive page, return all actions.
    if ( 'archive-gpalab-social-link.php' !== get_post_meta( $post->ID, '_wp_page_template', true ) ) {
      return $actions;
    }

    // Remove the Edit link.
    if ( isset( $actions['edit'] ) ) {
      unset( $actions['edit'] );
    }

    // Remove the Quick Edit link.
    if ( isset( $actions['inline hide-if-no-js'] ) ) {
      unset( $actions['inline hide-if-no-js'] );
    }

    // Remove the Trash link.
    if ( isset( $actions['trash'] ) ) {
      unset( $actions['trash'] );
    }

    // Return the set of links without the Edit, Quick Edit, or Trash actions.
    return $actions;
  }

  /**
   * Disables the link to the edit page of a given SLO archive page if the user lacks adequate permissions.
   *
   * @param string $url       The edit url for a given post.
   * @param int    $post_id   The post id for a given post.
   * @param string $context   How to output the '&' character.
   *
   * @since 0.0.1
   */
  public function remove_row_title_link( $url, $post_id, $context ) {
    // If not on the page listings page abort.
    if ( 'edit-page' !== get_current_screen()->id ) {
      return $url;
    }

    $is_slo_archive = 'archive-gpalab-social-link.php' === get_post_meta( $post_id, '_wp_page_template', true );
    $has_permission = current_user_can( $this->$edit_cap );

    // If a page is using the SLO template and the user is lacking adequate permissions, disable the edit link.
    if ( $is_slo_archive && ! $has_permission ) {
      return null;
    }

    // Else return the edit URL.
    return $url;
  }
}
