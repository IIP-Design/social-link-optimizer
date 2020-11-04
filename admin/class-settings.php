<?php
/**
 * Registers the Settings class.
 *
 * @package SLO\Settings
 * @since 0.0.1
 */

namespace SLO;

/**
 * Add plugin settings.
 *
 * The Settings class adds a settings page allowing site admins to configure the plugin.
 *
 * @package SLO\Settings
 * @since 0.0.1
 */
class Settings {
  /**
   * Adds a settings page to social links sub-menu where the plugin can be configured.
   *
   * @since 0.0.1
   */
  public function add_settings_page() {
    add_submenu_page(
      'edit.php?post_type=gpalab-social-link',
      'Social Links Settings',
      'Settings',
      'manage_options',
      'gpalab-slo-settings',
      function() {
        return $this->create_admin_page();
      },
      null
    );
  }

  /**
   * Generates the markup for the plugin's settings page.
   *
   * @since 0.0.1
   */
  private function create_admin_page() {
    ?>
    <div class="wrap">
      <h2><?php esc_html_e( 'Social Link Settings', 'gpalab-slo' ); ?></h2>
      <?php settings_errors(); ?>

      <form method="post" action="options.php">
        <?php
          settings_fields( 'gpalab-slo' );
          do_settings_sections( 'gpalab-slo' );
        ?>
        <button class="button button-secondary" id="slo-add-mission" type="button" >
          Add Mission
        </button>
        <?php
          submit_button();
        ?>
      </form>
    </div>
    <?php
  }

  /**
   * Adds the mission settings.
   *
   * @since 0.0.1
   */
  public function populate_settings_page() {
    register_setting(
      'gpalab-slo',
      'gpalab-slo-settings'
    );

    add_settings_section(
      'gpalab-slo-settings',
      __( 'Manage Mission Social Link Pages:', 'gpalab-slo' ),
      function() {
        return $this->populate_tabbed_container();
      },
      'gpalab-slo'
    );
  }

  /**
   * Adds a tabbed interface to the mission settings section.
   *
   * @since 0.0.1
   */
  private function populate_tabbed_container() {
    $missions = get_option( 'gpalab-slo-settings' );

    // Create the tabs for the tabbed container.
    if ( isset( $missions ) ) {
      echo '<ul class="gpalab-slo-tab-container">';

      foreach ( $missions as $mission ) {
        $tab  = '<li class="gpalab-slo-tab" ';
        $tab .= 'role="presentation" >';
        $tab .= '<a role="tab">' . esc_html( $mission['title'] ) . '</a>';
        $tab .= '</li>';

        echo wp_kses( $tab, 'post' );
      }

      echo '</ul>';
    }

    // Create the contents of the tabbed container.
    if ( isset( $missions ) ) {
      foreach ( $missions as $key => $mission ) {

        add_settings_field(
          'title_' . $key,
          __( 'Mission name:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings',
          array(
            'label_for' => 'title_' . $key,
            'key'       => $key,
            'field'     => 'title',
            'option'    => $mission,
          )
        );

        //   add_settings_field(
        //     'display_gpalab_slo_as_a_0', // id
        //     'Display social links as a:', // title
        //     array( $this, 'display_gpalab_slo_as_a_0_callback' ), // callback
        //     'gpalab-slo-settings-admin', // page
        //     'gpalab_slo_settings_setting_section' // section
        //   );

        add_settings_field(
          'facebook_' . $key,
          __( 'Facebook profile:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings',
          array(
            'label_for' => 'facebook_' . $key,
            'key'       => $key,
            'field'     => 'facebook',
            'option'    => $mission,
          )
        );

        add_settings_field(
          'instagram_' . $key,
          __( 'Instagram profile:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings',
          array(
            'label_for' => 'instagram_' . $key,
            'key'       => $key,
            'field'     => 'instagram',
            'option'    => $mission,
          )
        );

        add_settings_field(
          'linkedin_' . $key,
          __( 'LinkedIn profile:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings',
          array(
            'label_for' => 'linkedin_' . $key,
            'key'       => $key,
            'field'     => 'linkedin',
            'option'    => $mission,
          )
        );

        add_settings_field(
          'twitter_' . $key,
          __( 'Twitter profile:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings',
          array(
            'label_for' => 'twitter_' . $key,
            'key'       => $key,
            'field'     => 'twitter',
            'option'    => $mission,
          )
        );

        add_settings_field(
          'youtube_' . $key,
          __( 'YouTube profile:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings',
          array(
            'label_for' => 'youtube_' . $key,
            'key'       => $key,
            'field'     => 'youtube',
            'option'    => $mission,
          )
        );
      }
    }
  }

  /**
   * Generate an input field for tabbed container.
   *
   * @param array $args   Data used to individualize input fields and get input value.
   *
   * @since 0.0.1
   */
  public function add_input( $args ) {
    $field  = $args['field'];
    $key    = $args['key'];
    $option = $args['option'];
    $value  = isset( $option[ $field ] ) ? $option[ $field ] : '';

    // Generate the markup for the input field.
    $input .= '<input class="regular-text" type="text" ';
    $input .= 'name="gpalab-slo-settings[' . $key . '][' . $field . ']" ';
    $input .= 'id="' . $field . '_' . $key . '" ';
    $input .= 'value="' . $value . '" >';

    // Identify which HTML elements to allow.
    $elements = array(
      'input' => array(
        'class' => array(),
        'id'    => array(),
        'name'  => array(),
        'type'  => array(),
        'value' => array(),
      ),
    );

    // Sanitize the input field before rendering on the settings page.
    echo wp_kses( $input, $elements );
  }

  /**
   * Enqueue the admin scripts if on the SLO settings page.
   *
   * @param string $hook   Name of the current page.
   */
  public function enqueue_slo_admin( $hook ) {
    if ( 'gpalab-social-link_page_gpalab-slo-settings' !== $hook ) {
      return;
    }

    wp_enqueue_script( 'gpalab-slo-admin-js' );
    wp_enqueue_style( 'gpalab-slo-admin-css' );
  }

  public function gpalab_slo_settings_sanitize( $input ) {
  //   $sanitary_values = array();
  //   if ( isset( $input['display_gpalab_slo_as_a_0'] ) ) {
  //     $sanitary_values['display_gpalab_slo_as_a_0'] = $input['display_gpalab_slo_as_a_0'];
  //   }

  //   if ( isset( $input['facebook_page_1'] ) ) {
  //     $sanitary_values['facebook_page_1'] = sanitize_text_field( $input['facebook_page_1'] );
  //   }

  //   if ( isset( $input['linkedin_profile_2'] ) ) {
  //     $sanitary_values['linkedin_profile_2'] = sanitize_text_field( $input['linkedin_profile_2'] );
  //   }

  //   if ( isset( $input['twitter_feed_3'] ) ) {
  //     $sanitary_values['twitter_feed_3'] = sanitize_text_field( $input['twitter_feed_3'] );
  //   }

  //   if ( isset( $input['youtube_channel_4'] ) ) {
  //     $sanitary_values['youtube_channel_4'] = sanitize_text_field( $input['youtube_channel_4'] );
  //   }

  //   if ( isset( $input['instagram_feed_5'] ) ) {
  //     $sanitary_values['instagram_feed_5'] = sanitize_text_field( $input['instagram_feed_5'] );
  //   }

    return $input;
  }

  public function display_gpalab_slo_as_a_0_callback() {
    ?> <fieldset><?php $checked = ( isset( $this->gpalab_slo_settings_options['display_gpalab_slo_as_a_0'] ) && $this->gpalab_slo_settings_options['display_gpalab_slo_as_a_0'] === 'grid' ) ? 'checked' : '' ; ?>
    <label for="display_gpalab_slo_as_a_0-0"><input type="radio" name="gpalab_slo_settings_option_name[display_gpalab_slo_as_a_0]" id="display_gpalab_slo_as_a_0-0" value="grid" <?php echo $checked; ?>> Three column grid</label><br>
    <?php $checked = ( isset( $this->gpalab_slo_settings_options['display_gpalab_slo_as_a_0'] ) && $this->gpalab_slo_settings_options['display_gpalab_slo_as_a_0'] === 'list' ) ? 'checked' : '' ; ?>
    <label for="display_gpalab_slo_as_a_0-1"><input type="radio" name="gpalab_slo_settings_option_name[display_gpalab_slo_as_a_0]" id="display_gpalab_slo_as_a_0-1" value="list" <?php echo $checked; ?>> Vertical list</label></fieldset> <?php
  }
}
