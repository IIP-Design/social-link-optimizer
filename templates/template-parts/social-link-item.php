<?php
/**
 * Renders a single social link item for SLO page.
 *
 * @package GPALAB_SLO
 */

// Pull in the plugin's constant values to initialize the frontend class.
require_once GPALAB_SLO_DIR . 'class-constants.php';

$plugin_constants = new SLO\Constants();

// The class responsible for defining all actions that occur in the public-facing side of the site.
require_once GPALAB_SLO_DIR . 'public/class-frontend.php';

$plugin_frontend = new SLO\Frontend( $plugin_constants->plugin_name, $plugin_constants->version );

$plugin_frontend->get_social_link_item( $layout, $current_post );
