---
title: Installing the Plugin
---

## Basic Install

To install this plugin, you can copy the files into the plugins directory of your WordPress install. An easy way to do this is to clone the repository from GitHub:

```txt
$ cd my-site/wp-content/plugins
$ git clone https://github.com/IIP-Design/social-link-optimizer.git
```

## Composer Install

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

## Activation

Once the plugin is installed, you can go to the installed plugins in the WordPress admin panel and click on the `Activate` link under the Social Link Optimizer plugin.

Activation of the plugin will add an entry for the plugin settings to the site's options table. It will create the custom capabilities that will be used to manage the plugin (form more information see the [section on permissions]({{ '/technical#permissions' | relative_url }})).

## Uninstall

To deactivate the plugin go to the installed plugins in the WordPress admin panel and click on the `Deactivate` link under the Social Link Optimizer plugin.

To completely removed the plugin, first deactivate the plugin. Once deactivated, you should see the `Deactivate` link replaced with a `Delete` link. [Note that on a multisite installation, you can only delete a plugin from the network admin.]

Please note that deleting the plugin runs a series of uninstall hooks to clean up the database. These hooks will:

1. Delete the plugin settings saved in the options table,
1. Delete the custom capabilities created by the plugin to manage permissions,
1. Delete the metadata saved to social link pages,
1. Change the page template on all social link pages from `Social Link Optimizer` to `Default`, and
1. Delete all added social links.

These **deletions are irreversible** so please only delete the plugin if you are certain that you no longer want to use this data and/or that you have backed up your database.