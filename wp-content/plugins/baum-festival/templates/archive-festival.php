<?php
$args = array(
    'post_type'      => 'festival',
    'posts_per_page' => 100,
);

$loop = new WP_Query($args);

get_header();

?>

<div class="festival">

    <div class="festival-inner">
        <h1><?php echo __('Festivales', 'bf')?></h1>
        <ul>
            <?php
            while ( $loop->have_posts() ) :
                $loop->the_post();
                $url = get_post_permalink($post->ID);
                $logo = wp_get_attachment_image_url(get_post_meta($post->ID, 'bf_festival_logo', true), 'medium');
                $image = wp_get_attachment_image_url(get_post_meta($post->ID, 'bf_festival_image', true), 'medium');
                $startdate = get_post_meta($post->ID, 'bf_festival_start_date', true);
                $enddate = get_post_meta($post->ID, 'bf_festival_end_date', true);
                $location = get_post_meta($post->ID, 'bf_festival_location', true);

                $eventos = BF_Festival::get_eventos($post->ID);

                ?>
                <li>
                    <div class="item">
                        <a href="<?php echo esc_attr($url)?>">
                            <img src="<?php echo esc_attr($logo)?>" alt="<?php the_title(); ?>" width="300" height="300">
                        </a>
                        <div class="info">
                            <h2><?php the_title(); ?></h2>
                            <p><?php echo __('Fecha de Inicio:', 'bf') . ' ' .$startdate; ?></p>
                            <p><?php echo __('Fecha de Fin:', 'bf') . ' ' .$enddate; ?></p>
                            <?php if(!empty($eventos)):?>
                                <hr style="margin: 10px 0" />
                                <div>
                                    <h3><?php echo __('Eventos', 'bf')?></h3>
                                    <ul>
                                        <?php
                                        foreach ($eventos as $e){
                                            $e_url = get_post_permalink($e->ID);
                                            $e_title = $e->post_title;
                                            echo '<li><a href="'.esc_attr($e_url).'">'.esc_html($e_title).'</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php endif;?>
                        </div>
                        <a href="<?php echo esc_attr($url)?>" class="action"><?php echo __('¡Ingresar Ahora!', 'bf')?></a>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>

    </div>

</div>


<?php get_footer(); ?>