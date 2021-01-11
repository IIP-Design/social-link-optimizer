<?php
/**
 * Renders the mission identity header for SLO page.
 *
 * @package GPALAB_SLO
 * @since 0.0.1
 */

$url = $page_settings['website'];

if ( isset( $url ) && '' !== $url ) {
  $protocols = array( 'https://', 'http://' );
  $url_host  = rtrim( str_replace( $protocols, '', $url ), '/' );

  $markup  = '<p class="mission-website">';
  $markup .= '<a href=' . esc_html( $url ) . ' aria-labelledby="gpalab-slo-page-title">';
  $markup .= $url_host;
  $markup .= '</a>';
  $markup .= '</p>';

  echo wp_kses( $markup, 'post' );
}

// Extract the social account links from the selected mission data.
$social_accts = array(
  'facebook'  => $page_settings ['facebook'],
  'twitter'   => $page_settings ['twitter'],
  'instagram' => $page_settings ['instagram'],
  'youtube'   => $page_settings ['youtube'],
  'linkedin'  => $page_settings ['linkedin'],
  'flickr'    => $page_settings ['flickr'],
  'whatsapp'  => $page_settings ['whatsapp'],
);

// Get the path the the plugin's assets.
$assets_dir = GPALAB_SLO_URL . 'public/assets/';
?>

<!-- Set up links to social media icons -->
<aside>
<h2 id="social-accts" class="hide-visually">
  <?php esc_html_e( 'social media accounts', 'gpalab-slo' ); ?>
</h2>
<ul class="gpalab-slo-social-accts-list list-reset" aria-describedby="social-accts">
<?php
foreach ( $social_accts as $key => $value ) {

  if ( isset( $value ) && '' !== $value ) {
    ?>
    <li>
      <a href=<?php echo esc_url( $value, array( 'https' ) ); ?>>
        <img
          class="social-icon"
          src=<?php echo esc_attr( $assets_dir . $key . '.svg' ); ?>
          alt=""
          height="30"
          width="30"
        >
        <span class="hide-visually"><?php echo esc_html( $key ); ?></span>
      </a>
    </li>
    <?php
  }
}
?>
</ul>
</aside>
