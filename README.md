# Social Link Optimizer

This plugin seeks to resolve an problem presented by by Instagram's decision to disallow users from adding links to individual posts. this design choice prevents users from adding additional context to their posts. As a result, many Instagram users create customized landing pages with the additional context that would like to convey, and use the link to this landing page as the solitary link in their bio.

This plugin allows for WordPress users to easily create such landing pages where users can and populate them with a list of links/grid of linked images. A full list of the plugin's features and technical specifications can be found on the plugin's [documentation page](https://iip-design.github.io/social-link-optimizer/).

## Installation

### Basic

To install this plugin, you can copy the files into the plugins directory of your WordPress install. An easy way to do this is to clone the repository from GitHub:

```bash
$ cd my-site/wp-content/plugins
$ git clone https://github.com/IIP-Design/social-link-optimizer.git
```

### Composer

If using a Composer build process, add a reference to the plugin's git repository to the repositories array of your `composer.json`. In the require section, add an entry for `gpalab/social-link-optimizer` pointing to the version of the plugin you would like to use. Your resulting `composer.json` file will look something like this:

```json
{
  "name": "sample-webroot",
  "repositories": [
    {
      "type": "git",
      "url": "git@github.com:IIP-Design/social-link-optimizer"
    },
    {
      "other repo": "..."
    }
  ],
  "require": {
    "gpalab/social-link-optimizer": "*",
    "other-dependency": "..."
  }
}
```
