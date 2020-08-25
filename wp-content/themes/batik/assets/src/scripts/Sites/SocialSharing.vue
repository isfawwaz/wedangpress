<template>
    <div class="social-sharing">
        <a 
            class="twitter popup"
            title="Share in Twitter"
            :href="twitterLink"
            @click.prevent="openPopup">
            <i class="icon fa fa-twitter" aria-hidden="true"></i>
        </a>
        <a 
            class="facebook popup"
            title="Share in Facebook"
            :href="facebookLink"
            @click.prevent="openPopup">
            <i class="fa fa-facebook" aria-hidden="true"></i>
        </a>
        <a 
            class="email popup"
            title="Share via email"
            :href="mailLink"
            @click.prevent="openPopup">
            <i class="fa fa-envelope" aria-hidden="true"></i>
        </a>
        <a 
            :href="link"
            class="url popup"
            title="Copy link"
            @click.prevent="copyLink">
            <i class="fa fa-link" aria-hidden="true"></i>
        </a>
    </div>
</template>

<script>
import isEmpty from 'lodash/isEmpty';

export default {
    props: {
        title: String,
        link: String,
        excerpt: {
            type: String,
            default: null
        }
    },

    computed: {
        twitterLink() {
            let text = '"' + this.title + '" - ' + this.link;
            let link = "https://twitter.com/intent/tweet?text=" + encodeURIComponent( text );
            return link;
        },

        facebookLink() {
            let link = "http://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(this.link);
            return link;
        },

        mailLink() {
            let link = "mailto:?subject=" + encodeURIComponent( this.title + "&body=" + this.link );
            return link;
        }
    },

    methods: {
        copyLink(e) {
            let target = e.currentTarget,
                link = target.getAttribute('href');

            const el = document.createElement('textarea');
            el.value = link;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            alert('Copied to clipboard');
        },

        popupCenter(url) {
            let w = 500;
            let h = 500;

            const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

            const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
            const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft;
            const top = (height - h) / 2 / systemZoom + dualScreenTop;

            const newWindow = window.open(url, '_blank', 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);  

            if (window.focus) newWindow.focus();
        },

        openPopup(e) {
            let target = e.currentTarget,
                link = target.getAttribute('href');

            if( !isEmpty(link) ) {
                link = decodeURIComponent( link );
            }

            this.popupCenter( link );
        }
    }
}
</script>