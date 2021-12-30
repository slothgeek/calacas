<?php
get_header();

while (have_posts()) :
    the_post();

    $date = get_post_meta($post->ID, 'bf_evento_date', true);
    $start = get_post_meta($post->ID, 'bf_evento_start', true);
    $end = get_post_meta($post->ID, 'bf_evento_end', true);
    $artista = get_post_meta($post->ID, 'bf_evento_artista', true);
    $festival = get_post_meta($post->ID, 'bf_evento_festival', true);


    ?>
    <div class="evento">
        <?php if($festival != '-1'):
        $post_festival = get_post($festival);
        ?>
        <a class="btn" href="<?php echo esc_attr(get_post_permalink($post_festival->ID))?>">
            <span class="dashicons dashicons-arrow-left-alt"></span>
            <?php echo esc_html($post_festival->post_title)?>
        </a>
        <?php endif;?>
        <h1 style="text-align: center"><?php the_title() ?></h1>
        <div class="evento-info">
            <div class="info-data"><span><?php echo __('Fecha del evento: ', 'bf')?></span><?php echo esc_html($date)?></div>
            <div class="info-data"><span><?php echo __('Hora de inicio: ', 'bf')?></span><?php echo esc_html($start)?></div>
            <div class="info-data"><span><?php echo __('Hora de cierre: ', 'bf')?></span><?php echo esc_html($end)?></div>
        </div>
        <div class="description">
            <?php the_content(); ?>
        </div>

        <?php if($artista != '-1'):
            $posts_artista = get_posts(array(
                'post_type' => 'artista',
                'post__in' => array_map('intval', $artista)
            ));
            ?>

        <div class="evento-artista">
            <h2><?php echo esc_html('Artistas de este evento')?></h2>
            <?php foreach ($posts_artista as $pa): ?>
                <div style="display: flex; align-items: center; justify-content: center">
                    <span class="dashicons dashicons-star-filled" style="width: 2rem; height: 2rem"></span>
                    <span><?php echo esc_html($pa->post_title)?></a></span>
                </div>
            <?php endforeach;?>
        </div>
        <?php endif;?>
    </div>


    <?php
endwhile;
get_footer();
