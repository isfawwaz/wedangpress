import Vue from 'vue';
import lowerCase from 'lodash/lowerCase';

// Don't warn about using the dev version of Vue in development.
Vue.config.productionTip = process.env.NODE_ENV === 'production'

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
const files = require.context('./Sites/', true, /\.vue$/i)
files.keys().map( key => Vue.component("w" + lowerCase(key.split('/').pop().split('.')[0]), files(key).default))

const app = new Vue({
    el: document.getElementById("wahaha-site"),
    mounted() {
        // Skip Link Focus Fix
        let isIe = /(trident|msie)/i.test( navigator.userAgent );
        if ( isIe && document.getElementById && window.addEventListener ) {
            window.addEventListener( 'hashchange', function() {
                let id = location.hash.substring( 1 ),
                    element;

                if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
                    return;
                }

                element = document.getElementById( id );

                if ( element ) {
					if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
						element.tabIndex = -1;
					}

					element.focus();
				}
            }, false);
        }
    }
})