<?php
/**
 * Renders a single social link item for SLO page.
 *
 * @package GPALAB_SLO
 */

// The class responsible for orchestrating the actions and filters of the core plugin.
require_once GPALAB_SLO_DIR . 'includes/class-slo.php';

// The class responsible for defining all actions that occur in the public-facing side of the site.
require_once GPALAB_SLO_DIR . 'public/class-frontend.php';

$plugin_slo      = new SLO();
$plugin_frontend = new SLO\Frontend( $plugin_slo->__construct()->plugin_name, $plugin_slo->__construct()->version );

$plugin_frontend->get_social_link_item( $layout );
