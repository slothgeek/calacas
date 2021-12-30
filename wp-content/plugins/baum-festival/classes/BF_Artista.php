<?php

class BF_Artista{

    public function __construct()
    {
        $this->sg_hooks();
    }

    public function sg_hooks()
    {
        add_action( 'init', array( $this, 'custom_post_type') );
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
                'public'      => true,
                'has_archive' => true,
                'rewrite'     => array( 'slug' => 'artistas' ),
            )
        );
    }
}

new BF_Artista();