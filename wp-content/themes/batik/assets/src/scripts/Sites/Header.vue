<template>
    <header id="header" :class="{'opening': isOpening, 'closing': isClosing, 'force-transition': forceTransition}">
        <div class="container mx-auto">
            <div class="flex items-center justify-between">
                <div class="w-full md:w-auto">
                    <a :href="home" rel="no-follow" class="inline-block logo-link unanimation">
						<slot name="logo" />
					</a>
                </div>
                <div class="w-full text-right md:w-auto" :class="{ 'menu-opened': menuOpened }">
                    <a 
                        href="javascript:void(0);"
                        class="block hamburger menu-toggler text-right unanimation md:hidden"
                        aria-expanded="false"
                        @click.prevent="openMenu">
						<div class="menu-burger">
							<span></span>
							<span></span>
                            <span></span>
						</div>
					</a>
                    <nav id="site-navigation" class="main-navigation-container text-right">
                        <a 
                            href="javascript:void(0);"
                            class="menu-closer block md:hidden"
                            @click.prevent="closeMenu">
							<span></span>
                            <span></span>
						</a>
                        <h3 class="block md:hidden">
                            <span v-html="menuText"></span>
                        </h3>
                        <slot name="menu" />
                        <p class="copyright block md:hidden">
							© 2020 <span v-html="copyright"></span>.
						</p>
                    </nav>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
import isEmpty from 'lodash/isEmpty';

export default {
    data() {
        return {
            menuOpened: false,
            isOpening: false,
            isClosing: false,
            forceTransition: false,
            lastScrollTop: 0
        };
    },

    props: {
        home: String,
        menuText: {
            type: String,
            default: 'Menu'
        },
        copyright: {
            type: String,
            default: 'Paper Plane Digital Lab'
        }
    },

    methods: {
        openMenu() {
            let body = document.body;
            body.classList.add( 'mobile-menu-opened' );

            this.isOpening = true;
            this.menuOpened = true;

            let header = document.getElementById('site-navigation');
            let adminBar = document.getElementById('wpadminbar');

            let windowHeight = window.innerHeight;

            if( adminBar !== undefined ) {
                windowHeight = windowHeight - adminBar.clientHeight;
            }

            header.style.height = windowHeight + "px";
        },

        closeMenu() {
            let body = document.body;
            body.classList.remove( 'mobile-menu-opened' );

            let header = document.getElementById('site-navigation');
            header.removeAttribute('style');

            this.menuOpened = false;
            setTimeout(() => {
                this.isOpening = false;
                this.isClosing = true;
                setTimeout( () => this.isClosing = false, 500);
            }, 2200);
        },

        onResize(event) {
            if( window.innerWidth > 640 ) {
                this.isClosing = false;
                this.isOpening = false;
                this.menuOpened = false;
            }

            this.forceTransition = true;
            setTimeout(() => {
                this.forceTransition = false;
            }, 300);
        },

        addCloneHeader() {
            let findClone = document.getElementsByClassName('header-clone');

            if( isEmpty(findClone) ) {
                let header = document.getElementById('header');
                let width = header.offsetWidth;
                let height = header.clientHeight;

                let clone = document.createElement('DIV');
                clone.classList.add('header-clone');
                clone.style.width = width + "px";
                clone.style.height = height + "px";
                
                // document.body.insertBefore( clone, header.childNodes[0] );
                header.before( clone );
            }
        },

        removeCloneHeader() {
            let el = document.getElementsByClassName('header-clone');
            if( !isEmpty(el) ) {
                el[0].remove();
            }
        },

        sticky() {
            if( window.innerWidth >= 720 ) {
                let maxHeaderY = 50;
                let classHeaderSticky = 'sticky';

                let supportPageOffset = window.pageXOffset !== undefined;
                let isCSS1Compat = ((document.compatMode || "") === "CSS1Compat");
                let scroll = supportPageOffset ? window.pageYOffset : isCSS1Compat ? document.documentElement.scrollTop : document.body.scrollTop;

                let body = document.body;

                if( scroll <= 10 ) {
                    body.classList.remove( classHeaderSticky );
                    body.classList.remove( 'sticky-up' );
                    this.removeCloneHeader();
                } else {
                    body.classList.add( classHeaderSticky );
                    
                    if( scroll > this.lastScrollTop ) {
                        body.classList.remove( 'sticky-up' );
                        this.removeCloneHeader();
                    } else {
                        this.addCloneHeader();
                        body.classList.add( 'sticky-up' );
                    }
                }

                this.lastScrollTop = scroll <= 0 ? 0 : scroll;
            }

            // if( scroll <= 50 ) {
            //     body.classList.remove( classHeaderSticky );
            //     this.removeCloneHeader();
            // } else {
            //     if ( scroll >= maxHeaderY ) {
            //         body.classList.remove( classHeaderSticky );
            //         this.removeCloneHeader();
            //     } else {
            //         this.addCloneHeader();
            //         body.classList.add( classHeaderSticky );
            //     }
            // }
        }
    },

    mounted() {
        // Register an event listener when the Vue component is ready
        this.sticky();
        window.addEventListener('resize', this.onResize)
        window.addEventListener('scroll', this.sticky)
    },

    beforeDestroy() {
        // Unregister the event listener before destroying this Vue instance
        window.removeEventListener('resize', this.onResize)
        window.removeEventListener('scroll', this.sticky)
    }
}
</script>