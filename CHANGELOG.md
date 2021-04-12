## Change Log

**All notable changes to this project will be documented in this file.**

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

### [Unreleased](https://github.com/IIP-Design/social-link-optimizer/compare/v1.0.0...HEAD)

_This sections lists changes committed since most recent release_

#### Added:

- Use the mission name (if set) to populate the SLO page title when saving page settings or updating permalink
- Added documentation for social media managers (non-admin users)

#### Changed:

- Hide edit link in admin bar for all users (rather than just non-admin users) and on the preview page as well as SLO page
- Increase the specificity of frontend CSS to override inherit styles
- Change the save button text for archived posts
- Hide AddThis share bar on mobile as well as desktop

### [v1.1.0](https://github.com/IIP-Design/social-link-optimizer/compare/v1.0.0...v1.1.0) - 2021.02.24

#### Added:

- Theme toggle that allows use to chose between new or legacy MWP styling
- Confirmation dialogue when deleting a mission page
- Thumbnail image preview on the link listing page
- Link to the selected mission archive page from within the edit social link screen
- Disable Yoast and custom MWP metaboxes for social link pages
- Hide AddThis share bar on the social link pages front end

#### Changed:

- Adjusted plugin UI copy to clarify/simply labels and instructional text
- Enqueue a stylesheet for the social link edit screen
- Updated ESLint configuration

#### Fixed:

- Improperly initialized custom capability variable in the Permissions class

### [v1.0.0](https://github.com/IIP-Design/social-link-optimizer/releases/tag/v1.0.0) - 2021.01.27 (Initial Release)

#### Added:

- A social link custom post type that can be populated with an image, a redirect URL, and associated with a given mission
- A settings page where multiple missions can be added to the site to enable grouping of social links
- A custom social link page template to display all of the social links for a particular mission
- Two social link page layouts to display the social links as either a grid of linked images or a list of links
- A mission identity header on the social link page template to present mission-specific avatar, website, and social property links
- A load more social links button that appends the next page's content and back to top link on the social link page template
- Required fields validation for title, link, and mission
- A dashboard widget to allow for users to customize the view filters on the social links listing page
- Custom user capabilities to help control access to the plugin's administrative options
- Seamless integration with the User Role Editor plugin
- An uninstall script to clean up the database after when the plugin is uninstall
- A link to the plugin's settings page directly from the plugin listing on the Installed Plugins page
- JavaScript and PHP linting using ESLint and PHP Code Sniffer respectively
- WordPress scripts package to compile and minify the plugin's JavaScript bundle
