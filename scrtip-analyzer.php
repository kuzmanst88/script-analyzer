<?php
/**
 * Plugin Name: Custom Script Handle
 * Description: Adds script-handle attribute to all enqueued scripts, logs all handles in the browser console, and categorizes them by type.
 * Version: 2.2
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Add script-handle attribute to all enqueued scripts
add_filter('script_loader_tag', 'csh_add_script_handle', 10, 3);
function csh_add_script_handle($tag, $handle, $src) {
    return str_replace('<script', sprintf('<script script-handle="%1$s"', esc_attr($handle)), $tag);
}

// Enqueue a script to log handles in the browser console, grouped by type
add_action('wp_footer', 'csh_print_script_handles', 100);
function csh_print_script_handles() {
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let scripts = document.querySelectorAll('script');
            let wpScripts = [], pluginScripts = [], themeScripts = [], inlineScripts = [], otherScripts = [];

            scripts.forEach(script => {
                let handle = script.getAttribute('script-handle') || "(No Handle)";
                let src = script.src;
                let label = "";
                let displayText = `${handle}`;

                if (src) { // External scripts
                    if (src.includes("wp-admin") || src.includes("wp-includes")) {
                        // label = " (WordPress)"; // removing this for now because the WP цоре handles have their own tab
                        wpScripts.push(`${displayText}${label} - ${src}`);
                    } else if (src.includes("wp-content/plugins/")) {
                        let match = src.match(/wp-content\/plugins\/([^\/]+)/);
                        if (match) {
                            label = ` (${match[1]})`; // Extract plugin name
                        }
                        pluginScripts.push(`${displayText}${label} - ${src}`);
                    } else if (src.includes("wp-content/themes/")) {
                        let match = src.match(/wp-content\/themes\/([^\/]+)/);
                        if (match) {
                            label = ` (${match[1]})`; // Extract theme name
                        }                        themeScripts.push(`${displayText}${label} - ${src}`);
                    } else {
                        otherScripts.push(`${displayText} - ${src}`);
                    }
                } else { // Inline script
                    let content = script.textContent.trim().replace(/\s+/g, " "); // Remove extra spaces
                    let preview = content.length > 100 ? content.substring(0, 100) + "..." : content;
                    inlineScripts.push(`(Inline Script)\n  ${preview}`);
                }
            });

            console.log("%cJS Handles", "color: blue; font-weight: bold; font-size: 18px");

            if (wpScripts.length) {
                console.groupCollapsed("%cWordPress Core Scripts:", "color: green; font-weight: bold;");
                wpScripts.forEach(script => console.log(script));
                console.groupEnd();
            }

            if (pluginScripts.length) {
                console.groupCollapsed("%cPlugin Scripts:", "color: green; font-weight: bold;");
                pluginScripts.forEach(script => console.log(script));
                console.groupEnd();
            }

            if (themeScripts.length) {
                console.groupCollapsed("%cTheme Scripts:", "color: green; font-weight: bold;");
                themeScripts.forEach(script => console.log(script));
                console.groupEnd();
            }

            if (otherScripts.length) {
                console.groupCollapsed("%cOther Scripts:", "color: green; font-weight: bold;");
                otherScripts.forEach(script => console.log(script));
                console.groupEnd();
            }

            if (inlineScripts.length) {
                console.groupCollapsed("%cInline Scripts:", "color: green; font-weight: bold;");
                inlineScripts.forEach(script => console.log(script));
                console.groupEnd();
            }
        });
    </script>
    <?php
}
