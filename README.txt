=== WP Store Selector ===
Contributors: anandaage
Tags: registration, user profile, store selection, user meta
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds a store selection dropdown to WordPress registration form and allows admin to manage store options.

== Description ==

WP Store Selector is a WordPress plugin that adds a store selection field to the user registration form and allows administrators to manage store options from the WordPress dashboard.

= Features =

* Adds a store selection dropdown to the WordPress registration form
* Allows administrators to manage store options from the Settings page
* Stores the selected store in user meta data
* Displays and allows editing of store selection in user profile pages
* Fully customizable store list
* Responsive design
* WordPress coding standards compliant

= Usage =

1. Install and activate the plugin
2. Go to Settings > Store Selector to manage store options
3. The store dropdown will automatically appear on the registration form
4. Users can select their store during registration
5. Administrators can view and edit store selections in user profiles

== Installation ==

1. Upload the `wp-store-selector` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings > Store Selector to configure store options

== Frequently Asked Questions ==

= How do I add or remove stores? =

Go to Settings > Store Selector in your WordPress admin panel. You can add new stores by typing them on new lines in the textarea, and remove stores by deleting their lines. Click "Save Changes" to update the store list.

= Where can I edit a user's store selection? =

You can edit a user's store selection in two places:
1. Go to Users > All Users and click "Edit" on any user
2. Go to Users > Your Profile (for your own profile)

Look for the "Store Information" section where you can change the store selection.

= Is the store selection required during registration? =

Yes, users must select a store during registration. The form will not submit without a store selection.

== Screenshots ==

1. Store Selector Settings Page
2. Registration Form with Store Selection
3. User Profile with Store Selection

== Changelog ==

= 1.0.0 =
* Initial release
* Added store selection to registration form
* Added store management in admin settings
* Added store editing in user profiles
* Added user meta storage for store selection

== Upgrade Notice ==

= 1.0.0 =
Initial release of WP Store Selector.

== Developer Documentation ==

= Hooks and Filters =

The plugin provides the following hooks for developers:

* `wp_store_selector_before_field` - Action hook before the store field is displayed
* `wp_store_selector_after_field` - Action hook after the store field is displayed
* `wp_store_selector_store_options` - Filter hook to modify the store options array

= Example Usage =

To modify store options programmatically:

```php
add_filter('wp_store_selector_store_options', 'my_custom_store_options');
function my_custom_store_options($stores) {
    // Add or modify store options
    $stores[] = 'New Store';
    return $stores;
}
```

== Credits ==

Developed by Anand Aage

== License ==

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details. 