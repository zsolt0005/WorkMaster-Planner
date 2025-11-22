import axios from 'axios';
import { Translator } from './Components/Translator.js';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.translator = new Translator();
