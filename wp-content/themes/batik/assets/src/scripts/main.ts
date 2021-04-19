import Vue from 'vue';
import lowerCase from 'lodash/lowerCase';
import kebabCase from 'lodash/kebabCase';

import { library } from '@fortawesome/fontawesome-svg-core';
import { faLink, faEnvelope } from '@fortawesome/free-solid-svg-icons';
import { faFacebookF, faTwitter } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

// Don't warn about using the dev version of Vue in development.
Vue.config.productionTip = process.env.NODE_ENV === 'production';

library.add(faLink);
library.add(faEnvelope);
library.add(faFacebookF);
library.add(faTwitter);
Vue.component('fa', FontAwesomeIcon);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./Sites/ExampleComponent.vue').default);
const separator = 'h';
const files = require.context('./Sites/', true, /\.vue$/i);
files.keys().map(key => {
    const a = key.split('/').pop();
    if (a) {
        Vue.component( separator + '-' + kebabCase(lowerCase(a.split('.')[0])), files(key).default);
    }
});

const app = new Vue({
    el: '#app',
    mounted() {
        // Skip Link Focus Fix
        const isIe = /(trident|msie)/i.test(navigator.userAgent);
        if (isIe && document.getElementById && window.addEventListener) {
            window.addEventListener(
                'hashchange',
                function () {
                    const id = location.hash.substring(1);

                    if (!/^[A-z0-9_-]+$/.test(id)) {
                        return;
                    }

                    const element = document.getElementById(id);

                    if (element) {
                        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
                            element.tabIndex = -1;
                        }

                        element.focus();
                    }
                },
                false
            );
        }
    },
});
