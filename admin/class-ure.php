<?php
/**
 * Registers the URE class.
 *
 * @package SLO\URE
 * @since 0.0.1
 */

namespace SLO;

/**
 * Integrates this plugin with the User Role Editor (URE) plugin.
 *
 * The URE class configures the plugin's capability manager so that it is compatible with URE.
 *
 * @package SLO\URE
 * @since 0.0.1
 */
class URE {
  /**
   * Check whether or not the User Role Editor plugin is present and activated.
   *
   * @return bool  Whether or not URE is activated.
   *
   * @since 0.0.1
   */
  public function is_ure_active() {
    $is_active = is_plugin_active( 'user-role-editor/user-role-editor.php' );

    return $is_active;
  }

  /**
   * Add custom capabilities group the the URE role manager.
   *
   * @param array $groups   List of capability groupings listed in the URE role manager.
   * @return array          List of groups with custom group added.
   *
   * @since 0.0.1
   */
  public function add_custom_group( $groups ) {

    $groups['gpalab-slo'] = array(
      'caption' => esc_html__( 'Social Link Optimizer', 'gpalab-slo' ),
      'parent'  => 'custom',
      'level'   => 2,
    );

    return $groups;
  }

  /**
   * Place the plugin's custom capability into the Social Link Optimizer group in URE.
   *
   * @param array  $groups   List of capability groupings listed in the URE role manager.
   * @param string $cap_id   Name of capability to check against group capabilities.
   * @return array           List of groups with custom group added.
   *
   * @since 0.0.1
   */
  public function get_plugin_caps( $groups, $cap_id ) {
    $plugin_caps = array(
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

    if ( in_array( $cap_id, $plugin_caps, true ) ) {
      $groups[] = 'custom';
      $groups[] = 'gpalab-slo';
    }

    return $groups;
  }
}
