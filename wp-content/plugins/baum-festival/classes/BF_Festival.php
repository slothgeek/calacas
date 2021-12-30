<?php

class BF_Festival{

    public function __construct()
    {
        $this->sg_hooks();
    }

    public function sg_hooks()
    {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets'), 10);
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets'), 10);
        add_action( 'init', array( $this, 'custom_post_type') );
        add_filter( 'single_template', array( $this, 'single_template') );
        add_filter( 'template_include', array( $this, 'archive_template') );

        add_action( 'add_meta_boxes', array($this, 'custom_fields'));
        add_action( 'save_post', array( $this, 'save_custom_fields'));
    }

    public function enqueue_admin_assets(){
        wp_enqueue_style(
            'bf-back-css',
            BF_URL.'assets/css/back.css',
            array(),
            '1.0'
        );

        wp_enqueue_script(
            'bf-back-js',
            BF_URL . 'assets/javascript/back.js', array('jquery'),
            '1.0',
            true
        );

    }

    public function enqueue_assets(){

        wp_enqueue_script(
            'bf-front-js',
            BF_URL . 'assets/javascript/front.js', array('jquery'),
            '1.0',
            true
        );

        wp_enqueue_style(
            'bf-front-css',
            BF_URL.'assets/css/front.css',
            array(),
            '1.0'
        );
    }

    public function custom_post_type(){
        register_post_type('festival',
            array(
                'labels'      => array(
                    'name'          => __( 'Festivales', 'bf' ),
                    'singular_name' => __( 'Festival', 'bf' ),
                    'all_items'             => __( 'Lista de Festivales', 'bf' ),
                    'add_new'               => __( 'Añadir Festival', 'bf' ),
                    'add_new_item'          => __( 'Añadiendo nuevo Festival', 'bf' ),
                ),
                'public'      => true,
                'has_archive' => true,
                'rewrite'     => array( 'slug' => 'festivales' ),
            )
        );
    }

    public function archive_template( $template ) {
        if ( is_post_type_archive('festival') ) {
            $theme_files = array('archive-festival.php', 'baum-festival/archive-festival.php');
            $exists_in_theme = locate_template($theme_files, false);
            if ( $exists_in_theme != '' ) {
                return $exists_in_theme;
            } else {
                return BF_PATH. 'templates/archive-festival.php';
            }
        }
        return $template;
    }

    public function single_template($single) {
        global $post;

        if ( $post->post_type == 'festival' ) {
            if ( file_exists( BF_PATH. 'templates/single-festival.php' ) ) {
                return BF_PATH. 'templates/single-festival.php';
            }
        }

        return $single;

    }

    public function custom_fields(){
        add_meta_box(
            'bf-festival-logo',
            __( 'Logo', 'bf' ),
            array($this, 'cf_logo'),
            'festival',
            'side'
        );

        add_meta_box(
            'bf-festival-image',
            __( 'Imagen del evento', 'bf' ),
            array($this, 'cf_image'),
            'festival',
            'side'
        );

        add_meta_box(
            'bf-festival-info',
            __( 'Información del festival', 'bf' ),
            array($this, 'cf_information'),
            'festival',
            'side'
        );
    }

    public function cf_logo($post){
        $description = __('Seleccione una imagen para el logo del festival', 'bf');
        $this->image_uploader_field( 'bf_festival_logo', get_post_meta($post->ID, 'bf_festival_logo', true), $description );
    }

    public function cf_image($post){
        $description = __('Seleccione una imagen para el festival', 'bf');
        $this->image_uploader_field( 'bf_festival_image', get_post_meta($post->ID, 'bf_festival_image', true), $description );
    }

    public function cf_information($post){
        $location = get_post_meta($post->ID, 'bf_festival_location', true);
        $start_date = get_post_meta($post->ID, 'bf_festival_start_date', true);
        $end_date = get_post_meta($post->ID, 'bf_festival_end_date', true);
        ?>

        <p>
            <label for="bf_festival_location"><?php echo __('Ubicación:', 'bf')?></label>
            <input type="text" id="bf_festival_location" name="bf_festival_location" value="<?php echo esc_attr($location)?>">
        </p>
        <p>
            <label for="bf_festival_start_date"><?php echo __('Inicio:', 'bf')?></label>
            <input type="date" id="bf_festival_start_date" name="bf_festival_start_date" value="<?php echo esc_attr($start_date)?>">
        </p>
        <p>
            <label for="bf_festival_end_date"><?php echo __('Fin:', 'bf')?></label>
            <input type="date" id="bf_festival_end_date" name="bf_festival_end_date" value="<?php echo esc_attr($end_date)?>">
        </p>
        <?php
    }

    public function image_uploader_field( $name, $value = '', $description = '') {
        $image = ' button">Subir imagen';
        $image_size = 'thumbnail';
        $display = 'none';

        if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {

            $image = '"><img src="' . $image_attributes[0] . '" style="max-width:95%;display:block;" />';
            $display = 'inline-block';

        }

        ?>
        <?php echo $description; ?>
        <div style="margin: 10px 0;">

            <a href="#" class="button bg-upload-image<?php echo $image; ?></a>
            <input type="hidden" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo $value; ?>" />

            <a href="#" class="button bg-remove-image" style="display:inline-block;display:<?php echo $display; ?>"><?php echo __('Borrar imagen', 'bf')?></a>
        </div>
        <?php
    }

    public function save_custom_fields($post_id){
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        if( !current_user_can( 'edit_post' ) ) return;

        if( isset( $_POST['bf_festival_logo'] ) )
            update_post_meta( $post_id, 'bf_festival_logo', $_POST['bf_festival_logo'] );

        if( isset( $_POST['bf_festival_image'] ) )
            update_post_meta( $post_id, 'bf_festival_image', $_POST['bf_festival_image'] );

        if( isset( $_POST['bf_festival_location'] ) )
            update_post_meta( $post_id, 'bf_festival_location', $_POST['bf_festival_location'] );

        if( isset( $_POST['bf_festival_start_date'] ) )
            update_post_meta( $post_id, 'bf_festival_start_date', $_POST['bf_festival_start_date'] );

        if( isset( $_POST['bf_festival_end_date'] ) )
            update_post_meta( $post_id, 'bf_festival_end_date', $_POST['bf_festival_end_date'] );

    }
}

new BF_Festival();