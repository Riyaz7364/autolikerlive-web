import '../css/game.css'
import '../css/fb-base.css'
import '../css/fb-games.css'
import '../css/fb-editor.css'
import { createApp } from 'vue';
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import ExampleComponent from './components/ExampleComponent.vue';

const app = createApp({});
app.component('example-component', ExampleComponent);
app.mount('#app');
