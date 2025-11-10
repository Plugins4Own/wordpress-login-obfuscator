=== Login Obfuscator ===
Contributors: pascal.sikora
Tags: security, login, brute-force
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: login-obfuscator

Enhance your site's security with Login Obfuscator.

== Description ==

Login Obfuscator makes your login responses more unpredictable to brute-force bots. It adds a subtle security layer by sending an HTTP 403 Forbidden status on failed login attempts, confusing automated attacks that expect standard 200 or 302 responses.

This plugin is simple and silent:
* No configuration required
* No user interface
* Works automatically on activation

Why it works:
* Bots rely on predictable responses (200 = fail, 302 = success)
* A 403 status confuses many automated scripts
* Some bots slow down or stop attacking altogether

== Installation ==
1. Upload the plugin files to the `/wp-content/plugins/login-obfuscator` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Done — there are no settings or UI.

== Screenshots ==
1. screenshot-1.png - How it works.
1. screenshot-2.png - Example of a failed login HTTP 403 response (shown in browser dev tools).

== Changelog ==
= 1.2 =
* Minor fixes and code cleanup

= 1.0 =
* Initial release: sends HTTP 403 on failed login attempts

== Upgrade Notice ==
= 1.2 =
Minor bugfix, safe to update