=== Game Server Status ===
Contributors: steeven-th
Donate link: https://steeven-th.dev/
Tags: servers, live status, pterodactyl, game, live server status, widget, shortcodes
Requires at least: 5.8.1
Tested up to: 5.8.1
Stable tag: 1.0.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows you to see all the information of your game servers from the Pterodactyl Panel on your website !

== Description ==

With our plugin you can simply use widgets and shortcodes to display your game server's current status.

**Special Requirements**

* PHP Curl
* Pterodactyl Panel - API key server
* Pterodactyl Panel - API key client

== Translations ==

This plugin has two translations :

- English
- French

== Installation ==

Firstly make sure that your webhost supports the script's requirements and then you can continue with the installation process.

1. Download the folder `pteroq-server-status` with all plugin files
2. Place the folder on your FTP server in `wp-content/plugins/`
3. Activate the plugin in your admin panel of your Wordpress website
4. Go to the new menu `Pterodactyl server status / Settings`
5. Enter the information retrieved previously
6. To add a server, go to Add server and add the first part of the UUID. You can find it in your server settings.

== Frequently Asked Questions ==

= I can't add a server, it keeps saying it is offline but the server is actually online =

Please read the above requirements and contact your webhost provider about it.

= What games does the 'source' engine support ? =

The source engine supports games made with Source & GoldSource engine.For example: Team Fortress, Counter Strike, Rust, Left 4 Dead..etc) You can google to find an exact list of supported games.

== Changelog ==

= 1.0.1 =
* update documentation for shortcode
* fixed a bug if the curl request was null
