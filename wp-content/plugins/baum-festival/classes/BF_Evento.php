<?php

class BF_Evento{

    public function __construct()
    {
        $this->sg_hooks();
    }

    public function sg_hooks()
    {
        add_action( 'init', array( $this, 'custom_post_type') );
        add_filter( 'single_template', array( $this, 'single_template') );

        add_action( 'add_meta_boxes', array($this, 'custom_fields'));
        add_action( 'save_post', array( $this, 'save_custom_fields'));
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
                //'supports' => array( 'title', 'editor', 'custom-fields' )
            )
        );
    }

    public function single_template($single) {
        global $post;

        if ( $post->post_type == 'evento' ) {
            if ( file_exists( BF_PATH. 'templates/single-evento.php' ) ) {
                return BF_PATH. 'templates/single-evento.php';
            }
        }

        return $single;

    }

    public function custom_fields(){

        add_meta_box(
            'bf-evento-festival',
            __( 'Festival', 'bf' ),
            array($this, 'cf_festival'),
            'evento',
            'side'
        );

        add_meta_box(
            'bf-evento-artista',
            __( 'Artista', 'bf' ),
            array($this, 'cf_artista'),
            'evento',
            'side'
        );

        add_meta_box(
            'bf-evento-info',
            __( 'Información del evento', 'bf' ),
            array($this, 'cf_information'),
            'evento',
            'side'
        );


    }

    public function cf_festival($post){
        $festival = get_post_meta($post->ID, 'bf_evento_festival', true);

        $festivals = get_posts([
            'post_type' => 'festival',
            'post_status' => 'publish',
            'numberposts' => -1
        ]);
        //echo json_encode($festivals)
        ?>
        <p>
            <select name="bf_evento_festival" id="bf_evento_festival" style="width: 100%">
                <option value="-1"><?php echo __('Seleccione uno', 'bf')?></option>
                <?php
                foreach ($festivals as $f){
                    echo '<option value="'.$f->ID.'" '.selected( $festival, $f->ID ).' >'.$f->post_title.'</option>';
                }
                ?>
            </select>
        </p>
        <?php

    }

    public function cf_artista($post){
        $artista = get_post_meta($post->ID, 'bf_evento_artista', true);

        $artistas = get_posts([
            'post_type' => 'artista',
            'post_status' => 'publish',
            'numberposts' => -1
        ]);
        ?>
        <p>
            <select name="bf_evento_artista[]" id="bf_evento_artista[]" style="width: 100%" multiple>
                <option value="-1"><?php echo __('Seleccione uno', 'bf')?></option>
                <?php
                foreach ($artistas as $a){
                    $selected = in_array( $a->ID, $artista ) ? ' selected="selected" ' : '';

                    echo '<option value="'.$a->ID.'" '.$selected.' >'.$a->post_title.'</option>';
                }
                ?>
            </select>
        </p>
        <?php

    }

    public function cf_information($post){
        $date = get_post_meta($post->ID, 'bf_evento_date', true);
        $start = get_post_meta($post->ID, 'bf_evento_start', true);
        $end = get_post_meta($post->ID, 'bf_evento_end', true);
        ?>

        <p>
            <label for="bf_evento_date"><?php echo __('Día:', 'bf')?></label>
            <input type="date" id="bf_evento_date" name="bf_evento_date" value="<?php echo esc_attr($date)?>">
        </p>
        <p>
            <label for="bf_evento_start"><?php echo __('Inicio:', 'bf')?></label>
            <input type="text" id="bf_evento_start" name="bf_evento_start" value="<?php echo esc_attr($start)?>">
        </p>
        <p>
            <label for="bf_evento_end"><?php echo __('Fin:', 'bf')?></label>
            <input type="text" id="bf_evento_end" name="bf_evento_end" value="<?php echo esc_attr($end)?>">
        </p>
        <?php
    }


    public function save_custom_fields($post_id){
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        if( !current_user_can( 'edit_post' ) ) return;

        if( isset( $_POST['bf_evento_date'] ) )
            update_post_meta( $post_id, 'bf_evento_date', $_POST['bf_evento_date'] );

        if( isset( $_POST['bf_evento_start'] ) )
            update_post_meta( $post_id, 'bf_evento_start', $_POST['bf_evento_start'] );

        if( isset( $_POST['bf_evento_end'] ) )
            update_post_meta( $post_id, 'bf_evento_end', $_POST['bf_evento_end'] );

        if( isset( $_POST['bf_evento_festival'] ) )
            update_post_meta( $post_id, 'bf_evento_festival', $_POST['bf_evento_festival'] );

        if( isset( $_POST['bf_evento_artista'] ) )
            update_post_meta( $post_id, 'bf_evento_artista', $_POST['bf_evento_artista'] );

    }

}

new BF_Evento();