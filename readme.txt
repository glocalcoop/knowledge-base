=== Knowledge_Base ===
Contributors: misfist
Tags: resources
Requires at least: 4.4
Tested up to: 4.4.1
Stable tag: 0.1-alpha
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A simple plugin that creates a knowledge base with related taxonomies.

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

