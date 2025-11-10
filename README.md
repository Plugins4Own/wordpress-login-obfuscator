#  Wordpress Login Obfuscator

This **WordPress plugin** adds an extra layer of security to your site by setting a `403 Forbidden` header whenever a login attempt fails. While this won't change the experience for legitimate users, it helps *deter certain brute-force attack methods* by signaling that access is explicitly denied.

### Features:

- Sends a 403 Forbidden header on every login request.

- Makes it harder for bots to distinguish between valid and invalid credentials.

- Lightweight and easy to use – just activate and protect your login page.

### Installation:

- Upload the plugin files to the /wp-content/plugins/ directory or install it via the WordPress plugin manager or git clone this repository

- Activate the plugin through the 'Plugins' menu in WordPress.

- The protection works automatically – no configuration needed!

I personally found this plugin incredibly useful when I was facing a significant number of attacks on my WordPress site. By triggering a 403 response on failed login attempts, it discouraged attackers from continuing their attempts, thesame header after correct login can eliminate some bots. It’s a simple, effective solution to reduce the risk of unauthorized access.

Hope it helps you as much as it helped me.