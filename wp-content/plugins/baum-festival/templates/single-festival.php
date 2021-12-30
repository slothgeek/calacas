<?php
get_header();

while (have_posts()) :
    the_post();
    $location = get_post_meta($post->ID, 'bf_festival_location', true);
    $start_date = get_post_meta($post->ID, 'bf_festival_start_date', true);
    $end_date = get_post_meta($post->ID, 'bf_festival_end_date', true);
    $logo = wp_get_attachment_image_url(get_post_meta($post->ID, 'bf_festival_logo', true), 'thumbnail');
    $image = wp_get_attachment_image_url(get_post_meta($post->ID, 'bf_festival_image', true), 'full');

    $eventos = BF_Festival::get_eventos($post->ID);

    ?>
    <div class="festival">
        <a class="btn" href="<?php echo esc_attr(get_home_url().'/festivales')?>">
            <span class="dashicons dashicons-arrow-left-alt"></span>
            <?php echo __('Festivales')?></a>
        <h1 style="text-align: center">
            <img src="<?php echo esc_attr($logo)?>" alt="<?php the_title(); ?>">
            <?php the_title() ?></h1>
        <div class="festival-info">
            <div class="info-data"><span><?php echo __('Ubicación: ', 'bf')?></span><?php echo esc_html($location)?></div>
            <div class="info-data"><span><?php echo __('Fecha de inicio: ', 'bf')?></span><?php echo esc_html($start_date)?></div>
            <div class="info-data"><span><?php echo __('Fecha de cierre: ', 'bf')?></span><?php echo esc_html($end_date)?></div>
        </div>
        <?php if(!empty($image)):?>
            <div class="banner">
                <img src="<?php echo esc_attr($image)?>" alt="<?php the_title(); ?>">
            </div>
        <?php endif;?>
        <div class="description">
            <?php the_content(); ?>
        </div>

        <?php if(!empty($eventos)):?>
            <div class="eventos">
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


<?php
endwhile;
get_footer();
