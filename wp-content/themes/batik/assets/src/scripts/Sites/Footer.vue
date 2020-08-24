<template>
    <footer>
        <div class="footer-top">
            <div class="container mx-auto">
                <div class="site-info-section">
                    <div class="info-phone site-info__content">
                        <slot name="phone" />
                    </div>
                    <div class="info-logo site-info__content">
                        <a :href="home" rel="no-follow" class="logo-link-footer unanimation">
                            <slot name="logo" />
                        </a>
                    </div>
                    <div class="info-email site-info__content">
                        <slot name="email" />
                    </div>
                </div>
                <div class="site-social-section" v-if="!isEmpty(facebook) || !isEmpty(twitter) || !isEmpty(instagram) || !isEmpty(youtube)">
					<a :href="facebook" class="sosmed-item sosmed-facebook" target="_blank" v-if="!isEmpty(facebook)">
						<i class="icon fa fa-facebook"></i>
					</a>
					<a :href="twitter" class="sosmed-item sosmed-twitter" target="_blank" v-if="!isEmpty(twitter)">
						<i class="icon fa fa-twitter"></i>
					</a>
					<a :href="instagram" class="sosmed-item sosmed-instagram" target="_blank" v-if="!isEmpty(instagram)">
						<i class="icon fa fa-instagram"></i>
					</a>
					<a :href="youtube" class="sosmed-item sosmed-youtube" target="_blank" v-if="!isEmpty(youtube)">
						<i class="icon fa fa-youtube-play"></i>
					</a>
				</div>
            </div>
        </div>
        <div class="copyright">
			<p><span>Wahaha Hotel &amp; Entertainment</span> &copy; 2020. All Rights Reserved. Site by <a href="http://paperplane.id" target="_blank">Paper Plane</a></p>
		</div>
    </footer>
</template>

<script>
import isEmpty from 'lodash/isEmpty';

export default {
    props: {
        home: String,
        facebook: {
            type: String,
            default: null
        },
        twitter: {
            type: String,
            default: null
        },
        instagram: {
            type: String,
            default: null
        },
        youtube: {
            type: String,
            default: null
        }
    },

    methods: {
        isEmpty(val) {
            return isEmpty(val)
        }
    }
}
</script>