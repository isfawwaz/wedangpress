<?php

namespace Batik\Metaboxes;

class PageLayoutMetabox {

    public function register() {
        global $pagenow;

        // Add action
        add_action('add_meta_boxes', [ $this, 'add' ]);
        add_action('save_post', [ $this, 'save' ]);

        // Enqueue Script for Media Upload
        if ( ( isset($_GET['post_type']) && $_GET['post_type'] == 'page' ) || ( 'post.php' === $pagenow && isset($_GET['post']) && 'page' === get_post_type( $_GET['post'] ) ) ) {
            add_action('admin_enqueue_scripts', [ $this, 'admin_scripts' ], 10, 1 );
        }
    }

    public function admin_scripts() {
        wp_register_script( 'admin-page', mixin('js/admin.js'), array( 'jquery' ) );
        wp_enqueue_script( 'admin-page' );
        wp_enqueue_style( 'admin', mixin('css/admin.css'), [], false, 'all' );
    }

    public function add()
    {
        $screens = ['page'];
        foreach ($screens as $screen) {
            add_meta_box(
                'gragas_page_layout_box',          // Unique ID
                'Layout Option', // Box title
                [$this, 'html'],   // Content callback, must be of type callable
                $screen,                // Post type
                'side'
            );
        }
    }

    public function save( $post_id ) {
        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */
 
        // Check if our nonce is set.
        if ( ! isset( $_POST['metabox_page_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['metabox_page_nonce'];
 
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'metabox_page_layout' ) ) {
            return $post_id;
        }
 
        /*
         * If this is an autosave, our form has not been submitted,
         * so we don't want to do anything.
         */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
 
        // Check the user's permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
 
        /* OK, it's safe for us to save the data now. */
 
        // Sanitize the user input.
        $switch = sanitize_text_field( $_POST['use-jumbotron'] );
        $header = sanitize_text_field( $_POST['header-style'] );
 
        // Update the meta field.
        update_post_meta( $post_id, 'gragas_page_jumbotron', $switch );
        update_post_meta( $post_id, 'gragas_page_header_style', $header );
    }

    public function html($post)
    {
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'metabox_page_layout', 'metabox_page_nonce' );

        $switch = get_post_meta( $post->ID, 'gragas_page_jumbotron', true );
        $header = get_post_meta( $post->ID, 'gragas_page_header_style', true );

        $checked = $switch == 1 ? ' checked="checked"' : '';
        $enableClass = $switch == 1 ? 'primary' : 'secondary';
        $disableClass = !empty($switch) ? 'secondary' : 'primary';

        $selectedBox = empty($header) || $header == 'boxed' ? ' selected' : '';
        $selectedTransparet = $header == 'transparent' ? ' selected' : '';
        ?>
        <div class="admin-form-item admin-form-item-block">
            <label for="field-header-style" class="form-label"><?php _e( 'Header style', 'gragas' );?></label>
            <select name="header-style" id="field-header-style">
                <option value="boxed"<?php echo $selectedBox;?>>Style 1 - Boxed</option>
                <option value="transparent"<?php echo $selectedTransparet;?>>Style 2 - Transparent</option>
            </select>
        </div>
        <div class="admin-form-item admin-form-item-block">
            <label class="form-label"><?php _e( 'Jumbotron style', 'gragas' );?></label>
            <div class="field-switch">
                <input name="use-jumbotron" type="checkbox" id="use-jumbotron" value="1"<?php echo $checked;?>>
                <span class="button button-<?php echo $enableClass;?>">Enabled</span>
                <span class="button button-<?php echo $disableClass;?>">Disabled</span>
            </div>
            <p class="description">Show jumbotron or not</p>
        </div>
        <?php
    }
    
}