<?php
/**
 * Plugin Name: Login Obfuscator
 * Plugin URI:  https://plugins4.own.pl/wordpress/login-obfuscator
 * Description: Makes your login responses more unpredictable to brute-force bots. Adds a subtle security layer by sending an HTTP 403 Forbidden status on failed login attempts. This simple trick confuses brute-force bots that expect a 200 or 302 response and often makes them give up immediately.
 * Version:     1.2
 * Author:      Plugins4.OWN.pl
 * Author URI:  https://plugins4.own.pl
 * License:     GPL-2.0-or-later
 * Icon:        icon.png
 * Text Domain: login-obfuscator
 */

if (!defined('ABSPATH')) exit;

/**
 * Login Obfuscator
 * -------------------
 * WordPress normally returns HTTP 200 OK on failed login attempts,
 * which makes it easy for brute-force bots to detect success or failure.
 *
 * This plugin changes that behavior — when a login fails, the server
 * responds with HTTP 403 Forbidden instead of 200 OK.
 *
 * Why it works:
 * - Bots rely on predictable responses (200 = fail, 302 = success).
 * - A 403 status confuses many automated tools and brute-force scripts.
 * - Some bots will slow down or stop attacking altogether.
 *
 * In short:
 * This tiny plugin makes your login behavior appear "unusual"
 * and therefore less attractive to automated attacks.
 *
 * No configuration. No UI. Just install and activate.
 * Smart, silent protection through deception.
 */

function login_obfuscator_failed($username, $action) {
    // Send HTTP 403 Forbidden instead of default 200 OK
    status_header(403);

    // Prevent caching by CDNs or reverse proxies
    nocache_headers();

    // Add extra headers to confuse automated scanners
    header('X-Auth-Status: denied');
    header('X-Login-Attempt: failed');
    header('Retry-After: 60'); // Suggest bots to "wait" before retrying

    

    // Optional: log failed attempts for debugging
    if (defined('WP_DEBUG') && WP_DEBUG) {
        
        $clientIp = login_obfuscator_get_client_ip();
        $httpReferer = isset($_SERVER['HTTP_REFERER']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_REFERER'])) : '';

        error_log(sprintf(
            'LoginObfuscator "%s" failed for user "%s" from IP %s referer "%s"',
            $action,
            $username,
            $clientIp,
            $httpReferer
        ));
    }
}

/**
 * Get the real client IP, taking into account X-Forwarded-For 
 *
 * @return string IP address
 */
function login_obfuscator_get_client_ip() {
    $ip = '';

    // X-Forwarded-For - first IP from the list
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {        
        $forwarded_for = wp_unslash($_SERVER['HTTP_X_FORWARDED_FOR']);
        $ips = explode(',', $forwarded_for);

        foreach ($ips as $xip) {
            $xip = trim($xip);
            $sanitized_xip = sanitize_text_field($xip);
            if (filter_var($sanitized_xip, FILTER_VALIDATE_IP)) {
                $ip = $sanitized_xip;
                break;
            }
        }
    }

    // Fallback do REMOTE_ADDR
    if (empty($ip) && !empty($_SERVER['REMOTE_ADDR'])) {
        $remote_addr = wp_unslash($_SERVER['REMOTE_ADDR']);
        $ip = sanitize_text_field($remote_addr);
    }

    return $ip ?: 'unknown';
}

/**
 * WP native login failures
 */
add_action('wp_login_failed', function($username) {
    login_obfuscator_failed($username, '[wp login]');
}, 10, 1);
