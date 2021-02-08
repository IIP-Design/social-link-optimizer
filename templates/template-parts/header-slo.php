<?php
/**
 * Header file for GPALab SLO.
 *
 * @package GPALAB_SLO
 * @since 0.0.1
 */

?><!DOCTYPE html>

<html class="no-js <?php echo esc_attr( $page_theme ); ?>" <?php language_attributes(); ?>>

  <head>

    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >

    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>

  </head>

  <body <?php body_class(); ?> id="gpalab-slo" tabindex="-1">
    <a href="#instagram-posts" class="skip-to-content" role="navigation" aria-label="skip to instagram content">
      <?php echo esc_html__( 'Skip to Instagram content', 'gpalab-slo' ); ?>
    </a>

    <header id="gpalab-slo-site-header" role="banner">

      <p class="gpalab-slo-site-title hide-visually">
        <?php echo bloginfo( 'name' ); ?>
      </p><!-- .gpalab-slo-site-title -->

    </header><!-- #gpalab-slo-site-header -->
