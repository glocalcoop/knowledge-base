=== Knowledge Base ===
Contributors: misfist
Tags: resources
Requires at least: 4.4
Tested up to: 4.4.1
Stable tag: 0.1.2
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A plugin that creates a knowledge base with related taxonomies.

== Description ==

This plugin enables you to maintain a hierarchically categorized knowledge base.

== Useage == 

Use the shortcode within content areas by adding it within the editor `[knowledge-base]`.

Use the shortcode in your theme by adding `<?php echo do_shortcode( "[knowledge-base]" ); ?>`

= Options =

* 'hide_empty' - Hide categories that have no posts associated with them ( default is `1`)
* 'title_li' - Display a title before the list (default is none)
* 'show_count' - Display number of posts for each category (default is `1`)

Example:
`[knowledge-base hide_empty=0 title_li=Topics show_count=0]`

== Revisions ==

= 0.1.2 - July 12, 2016 =
* [Feature #1430] - Added options page with rewrite settings the post type and taxonomy. Note: Permalinks (Settings > Permalinks) must be reset in order for this to take effect.

= 0.1.1-alpha = 
* Added post type labels
* Fixed taxonomy hierarchy
* Changed order of require so taxonomy is registered first
* Added `child_of` attribute to shortcode
* Updated readme

