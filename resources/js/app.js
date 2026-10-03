/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import '../css/tailwind.css'
import '../css/styles.css'
import '../css/fb-base.css'
import '../css/fb-games.css'
import '../css/fb-editor.css'

// NOTE (CWV 2026-09): Vue/ExampleComponent intentionally NOT bundled here —
// no Blade view mounts a Vue app (no #app element anywhere). Loading the
// ~108KB runtime on every page cost ~500ms+ main-thread time on mobile lab
// tests. If a page ever needs Vue, add a dedicated per-page entry instead.

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// (Vue auto-mount removed — see note above. No #app element exists.)
