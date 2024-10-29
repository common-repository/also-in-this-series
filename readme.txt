=== Also In This Series ===
Contributors: jweathe
Donate link: https://planetjon.ca
Tags: related posts, series, posts, SEO, internal links, widget
Requires at least: 4.6
Requires PHP: 5.5
Tested up to: 5.9.0
Stable tag: 2.0.1
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Group related posts in a post series and automatically list all of the posts in the series as part of the content.

== Description ==

Group related posts in a series. Automatically insert a list of all posts in the series as part of the content.

Manually embed a series listing with the provided shortcode and widget. Override the series template with a custom template.

A great [rundown of the plugin](https://planetjon.ca/4823/making-a-blog-series-with-also-in-this-series "How to use Also In This Series") is available on the Planetjon blog.

== How To Use ==

Create new Series terms from the Series manager under Posts. Add posts to series either through the quick edit screen or through the full edit screen.

Also In This Series can be configured to automatically insert a series listing in posts belonging to a series.

To do so, navigate to Also In This Series settings under the settings option.

=== Settings ===

* **Title heading level** sets the HTML tag that will wrap the series title in series inserted automatically, with shortcodes, and with widgets.
* **Title template** picks from a list of title presets for displaying the title, including a presetfor no title.
* **Automatically display series listing on post** allows for automatic listing insertion in posts that belong to a series.
* **Order of series display** controls the order of posts (newest first or oldest first) in series listings.
* **Window series listing display** creates a window around the current post in a series listing. This is useful for large series where it is cumbersome to show the entire listing at once.
* **Do not display series listing** prevents the series listing from being shown. When checked, a link to the series is always shown.
* **Always show series link** forces a link to the series archive regardless of windowing. When unchecked, a link to the seriess will not be shown when the entire series listing is visible.

=== Shortcode ===

To manually insert the series listing of a post within a series as part of the content, use the shortcode [alsointhisseries].

This will have no effect if the post isn't in a series.

To manually insert a specific series, use the series-slug attribute with the shortcode like [alsointhisseries series-slug="your-series-slug"].


The shortcode attributes are

* series-slug="slug"
* use-frame="yes|no"
* frame-width="number"
* sort-order="asc|desc"
* title-wrap="h1|h2|h3|span"
* title-template="also-in|ordinal|none"
* hide-series-listing="yes|no"
* always-link-series="yes|no"

=== Widget ===

A widget that exposes all of the above options is available.

=== Custom Template ===

If you'd like to use your own series listing template, there are two options available.

* Place a template file `also-in-this-series/serieslisting.php` in your theme.
* Use the alsointhisseries_template filter to provide an absolute path to a template file.

== Installation ==

1. Unpack the plugin zip and upload the contents to the /wp-content/plugins/ directory. Alternatively, upload the plugin zip via the install screen within the WordPress Plugins manager
2. Activate the plugin through the Plugins manager in WordPress

== Screenshots ==

1. Create a Series in the Series manager found under posts. Add a description if desired.
2. Add posts to a Series. You can do so in the quick edit or full edit screens.
3. How the Series is displayed in a post. By default, full listing of the posts in the Series are appended to posts in the Series.
4. Configure how you want Series listings automatically inserted, if at all.

== Changelog ==

= 2.0.1 =
* Finesse: Bring series links into whitespace consistency. 

= 2.0 =
* New: Limited control over series title wrapping tag
* New: Preset title templates
* New: Control over visibility of series display
* New: Control over showing link to entire series archive
* Update: Bumped minimum PHP version to 5.5 (please PLEASE update to 7.0+)
* Fixed: Theme-level templates now receive template variables
* Fixed: Series listing now correctly displays series indices when in newest-first order
