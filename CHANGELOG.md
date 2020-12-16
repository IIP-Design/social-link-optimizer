# Change Log

**All notable changes to this project will be documented in this file.**

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased](https://github.com/IIP-Design/social-link-optimizer/compare/v1.0.0...HEAD)

_This sections lists changes committed since most recent release_

### Added:
- A load more social links button that appends the next page's content
- A back to top link

## [v1.0.0](https://github.com/IIP-Design/social-link-optimizer/releases/tag/v1.0.0) - 2020.11 (Initial Release)

### Added:

- A social link custom post type that can be populated with an image, a redirect URL, and associated with a given mission
- A settings page where multiple missions can be added to the site to enable grouping of social links
- A custom social link page template to display all of the social links for a particular mission
- Two social link page layouts to display the social links as either a grid of linked images or a list of links
- A mission identity header on the social link page template to present mission-specific avatar, website, and social property links
- Custom user capabilities to help control access to the plugin's administrative options
- Seamless integration with the User Role Editor plugin
- Backwards compatibility for WordPress sites not utilizing the Gutenberg editor
- An uninstall script to clean up the database after when the plugin is uninstall
- Link to the plugin's settings page directly from the plugin listing on the Installed Plugins page
- JavaScript and PHP linting using ESLint and PHP Code Sniffer respectively
- WordPress scripts package to compile and minify the plugin's JavaScript bundle
