# Script Analyzer Plugin

The **Script Analyzer** plugin for WordPress adds a `script-handle` attribute to all enqueued scripts, logs all script handles in the browser console, and categorizes them by type (WordPress core scripts, plugin scripts, theme scripts, inline scripts, and other scripts). This can be particularly useful for debugging, optimizing, and managing JavaScript assets.

---

## Features

- Adds a custom `script-handle` attribute to all enqueued scripts.
- Logs all enqueued script handles in the browser console.
- Categorizes scripts into groups:
  - **WordPress Core Scripts**
  - **Plugin Scripts**
  - **Theme Scripts**
  - **Inline Scripts**
- Displays the script handles and their sources in the console for better transparency.

---

## Installation

1. Download the plugin files and place them in the `/wp-content/plugins/script-analyzer/` directory.
2. Activate the plugin through the **Plugins** menu in WordPress.

---

## Usage

Once activated, the plugin will:

1. Add a `script-handle` attribute to all enqueued scripts.
2. Log the script handles to the browser console in categorized groups (WordPress core, plugins, themes, inline, and others).
3. Provide a console output of all handles categorized for easier script management and debugging.
