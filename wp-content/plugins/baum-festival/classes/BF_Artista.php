<?php

class BF_Artista{

    public function __construct()
    {
        $this->sg_hooks();
    }

    public function sg_hooks()
    {
        add_action( 'init', array( $this, 'custom_post_type') );

        add_action( 'add_meta_boxes', array($this, 'custom_fields'));
        add_action( 'save_post', array( $this, 'save_custom_fields'));

        add_action( 'rest_api_init', array( $this, 'register_endpoint') );

    }

    public function custom_post_type(){
        register_post_type('artista',
            array(
                'labels'      => array(
                    'name'          => __( 'Artistas', 'bf' ),
                    'singular_name' => __( 'Artista', 'bf' ),
                    'all_items'             => __( 'Lista de Artistas', 'bf' ),
                    'add_new'               => __( 'Añadir Artista', 'bf' ),
                    'add_new_item'          => __( 'Añadiendo nuevo Artista', 'bf' ),
                ),
                'supports' => array( 'title'),
                'public'      => true,
                'has_archive' => true,
                'rewrite'     => array( 'slug' => 'artistas' ),
                'map_meta_cap' => true
            )
        );
    }

    public function custom_fields(){

        add_meta_box(
            'bf-artista-info',
            __( 'Información del Artista', 'bf' ),
            array($this, 'cf_information'),
            'artista',
        );

    }

    public function cf_information($post){
        $email = get_post_meta($post->ID, 'bf_artista_email', true);
        $tel = get_post_meta($post->ID, 'bf_artista_tel', true);
        $info = get_post_meta($post->ID, 'bf_artista_info', true);
        ?>

        <p>
            <label for="bf_artista_email"><?php echo __('Correo electrónico:', 'bf')?></label>
            <input type="email" id="bf_artista_email" name="bf_artista_email" value="<?php echo esc_attr($email)?>">
        </p>
        <p>
            <label for="bf_artista_tel"><?php echo __('Teléfono:', 'bf')?></label>
            <input type="tel" id="bf_artista_tel" name="bf_artista_tel" value="<?php echo esc_attr($tel)?>">
        </p>
        <p>
            <label for="bf_artista_info"><?php echo __('Información adicional:', 'bf')?></label>
            <textarea id="bf_artista_info" name="bf_artista_info" rows="4" cols="50"><?php echo esc_attr($info)?></textarea>
        </p>
        <?php
    }

    public function save_custom_fields($post_id){
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        if( !current_user_can( 'edit_post' ) ) return;

        if( isset( $_POST['bf_artista_email'] ) )
            update_post_meta( $post_id, 'bf_artista_email', $_POST['bf_artista_email'] );

        if( isset( $_POST['bf_artista_tel'] ) )
            update_post_meta( $post_id, 'bf_artista_tel', $_POST['bf_artista_tel'] );

        if( isset( $_POST['bf_artista_info'] ) )
            update_post_meta( $post_id, 'bf_artista_info', $_POST['bf_artista_info'] );

    }

    public function artistas_endpoint( $data ) {
        $posts = get_posts( array(
            'post_type' => 'artista',
            'post_status' => 'publish'
        ) );

        if ( empty( $posts ) ) {
            return null;
        }

        if(isset($data['evento'])){
            $artista = get_post_meta($data['evento'], 'bf_evento_artista', true);
            $posts = get_posts(array(
                'post_type' => 'artista',
                'post__in' => array_map('intval', $artista)
            ));
        }

        return $posts;
    }

    public function register_endpoint(){

        register_rest_route( 'baum-festival/v1', '/artistas(?:/(?P<evento>\d+))?', array(
            'methods' => 'GET',
            'callback' => array($this, 'artistas_endpoint'),
        ) );
    }
}

new BF_Artista();