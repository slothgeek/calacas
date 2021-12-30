<?php

class BF_Evento{

    public function __construct()
    {
        $this->sg_hooks();
    }

    public function sg_hooks()
    {
        add_action( 'init', array( $this, 'custom_post_type') );
    }

    public function custom_post_type(){
        register_post_type('evento',
            array(
                'labels'      => array(
                    'name'          => __( 'Eventos', 'bf' ),
                    'singular_name' => __( 'Evento', 'bf' ),
                    'all_items'             => __( 'Lista de Eventos', 'bf' ),
                    'add_new'               => __( 'Añadir Evento', 'bf' ),
                    'add_new_item'          => __( 'Añadiendo nuevo Evento', 'bf' ),
                ),
                'public'      => true,
                'has_archive' => true,
                'rewrite'     => array( 'slug' => 'eventos' ),
            )
        );
    }
}

new BF_Evento();