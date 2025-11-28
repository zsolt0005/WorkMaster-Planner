import axios from 'axios';
import Tagify from '@yaireo/tagify'

import {Translator} from './Components/Translator.js';


window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.translator = new Translator();

// Init tagify
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('input[data-tagify-enabled="true"], textarea[data-tagify-enabled="true"]');

    inputs.forEach((input) => {
        let config = {};

        const rawConfig = input.getAttribute('data-tagify-config');
        if (rawConfig) {
            try {
                config = JSON.parse(rawConfig);
            } catch (e) {
                console.warn('Invalid JSON in data-tagify-config for element:', input, e);
            }
        }

        const url = config.url ?? null;
        const mode = config.mode ?? 'tags';
        const prefetch = config.prefetch ?? false;
        const multiple = mode === 'select'
            ? false
            : config.multiple !== undefined
                ? !!config.multiple
                : true;

        const tagifyOptions = {
            enforceWhitelist: config.enforceWhitelist ?? false,
            maxTags: multiple ? Infinity : 1,
            mode: mode,
            autocomplete: true,
            dropdown: {
                enabled: 0,
                closeOnSelect: !multiple,
            },
            whitelist: [],          // start empty, will be filled from server
        };

        const originalValue = input.value;
        const tagify = new Tagify(input, tagifyOptions);

        let controller;
        async function fetchSuggestions(query, showDropdown = true) {
            // cancel previous request (optional)
            if (controller) {
                controller.abort();
            }
            controller = new AbortController();

            try {
                const response = await fetch(url + '?q=' + encodeURIComponent(query), {
                    signal: controller.signal,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    console.error('Tagify fetch failed', response.status, response);
                    return;
                }

                // Expecting an array like: [{ value: 'Foo' }, { value: 'Bar' }]
                tagify.settings.whitelist = await response.json();

                if (showDropdown) {
                    tagify.dropdown.show.call(tagify, query); // show the suggestions
                }

            } catch (err) {
                if (err.name === 'AbortError') {
                    // request was cancelled because user kept typing
                    return;
                }
                console.error('Tagify fetch error', err);
            }
        }

        if (url) {
            if (prefetch) {
                fetchSuggestions('', false)
                    .then(() => {
                        input.value = originalValue;
                    })
            }

            tagify.on('input', async (e) => {
                const value = e.detail.value;

                // ignore short queries
                if (value.length < (config.minChars ?? 0)) {
                    return;
                }

                await fetchSuggestions(value);
            });

            tagify.on('focus', async () => {
                await fetchSuggestions('');
            })
        }
    });
});
