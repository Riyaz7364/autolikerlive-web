import '../css/game.css'
import '../css/fb-base.css'
import '../css/fb-games.css'

// NOTE (CWV 2026-09): Vue/ExampleComponent intentionally NOT bundled — no
// Blade view mounts a Vue app. Keeps ~108KB of runtime off every page.
// NOTE (CWV 2026-09-29): axios + fb-editor.css removed from this entry.
// Game-layout pages (homepage, games hub/show) use native fetch and never
// touch window.axios, so bundling the ~47KB axios chunk on every homepage
// view cost main-thread time on mobile for nothing. Downloader pages that
// need axios use layouts.master (resources/js/app.js -> bootstrap.js).
// fb-editor.css is editor/admin-only and unused on public game pages.
