<?php
/**
 * Loads data for a given SLO page.
 *
 * Requires a $selected_mission value to be listed above where it is pulled in.
 *
 * @package GPALAB_SLO
 * @since 0.0.1
 */

// Get all mission settings.
$slo_settings = get_option( 'gpalab-slo-settings' );

// Search for selected mission among the mission sessions and return it's data.
$settings_key  = array_search( $selected_mission, array_column( $slo_settings, 'id' ), true );
$page_settings = is_numeric( $settings_key ) ? $slo_settings[ $settings_key ] : array();

// Determine the page layout (i.e., grid or list).
$layout = ( isset( $page_settings['type'] ) && '' !== $page_settings['type'] )
  ? $page_settings['type']
  : 'grid';

$is_grid    = 'grid' === $layout;
$page_theme = ( isset( $page_settings['theme'] ) && '' !== $page_settings['theme'] )
  ? $page_settings['theme']
  : 'mwp-redesign';
