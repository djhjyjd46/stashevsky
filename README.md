# Stashevsky Art Gallery Theme (WordPress + Tailwind CSS)

> **Custom Production WordPress Theme** crafted for the Stashevsky Art Gallery & Museum space. Engineered with **ACF Pro JSON synchronization**, **Vite / Tailwind CSS asset pipeline**, and **modular repeaters**.

[![WordPress](https://img.shields.io/badge/WordPress-6.x-21759B.svg?logo=wordpress)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4.svg?logo=php)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-3.x-38B2AC.svg?logo=tailwind-css)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-5.x-646CFF.svg?logo=vite)](https://vitejs.dev)
[![ACF Pro](https://img.shields.io/badge/ACF%20Pro-Synchronized%20JSON-brightgreen.svg)](https://advancedcustomfields.com)

---

## 🎨 Theme Highlights

- **Dynamic Repeater Architecture:** Built on Advanced Custom Fields (ACF Pro) repeaters for flexible exhibition timelines, artist spotlights, and event management.
- **Bi-Directional ACF JSON Sync:** All field definitions version-controlled in `/acf-json` for zero-configuration database migration.
- **Centralized Options Panel:** Global configuration for gallery operating hours, dynamic modal popups, header subtitles, and contact metadata.
- **Vite Asset Pipeline:** Hot Module Replacement (HMR) during local development and optimized minified production assets.
- **Zero-Layout Shift Typography:** Custom typography and variable font loading ensuring high Core Web Vitals scores.

---

## 📂 Architecture & Directory Structure

```
stashevsky/
├── acf-json/           # Synced ACF field group schema files
├── inc/                # Modular PHP theme includes & helper functions
├── src/                # Uncompiled CSS and JavaScript source assets
├── dist/               # Production compiled bundle
├── functions.php       # Enqueue scripts, theme supports, and options pages
├── header.php          # Accessible semantic header with navigation
├── footer.php          # Gallery footer with dynamic requisites
├── index.php           # Front page layout template with repeaters
├── tailwind.config.js  # Theme colors, fonts, and container geometries
└── vite.config.js      # Build automation config
```

---

## 📦 Setup & Deployment

1. **Activate Theme:**  
   Place the theme in `wp-content/themes/stashevsky` and activate it in **Appearance > Themes**.
2. **ACF Field Synchronization:**  
   Navigate to **Custom Fields > Tools** and sync the imported JSON field groups.
3. **Configure Options:**  
   Set gallery information, contacts, and exhibition modal triggers under **Theme Settings**.
4. **Development:**  
   ```bash
   npm install
   npm run dev    # Start Vite dev server
   npm run build  # Build production assets
   ```

---
*Developed by [Egor Voronov](https://github.com/djhjyjd46)*
