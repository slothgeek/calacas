<?php
remove_action('woocommerce_single_product_summary','woocommerce_template_single_title', 5);

add_action('woocommerce_before_single_product_summary','woocommerce_template_single_title', 5);

add_action('woocommerce_single_product_summary', 'add_extra_info_custom_field', 25);
function add_extra_info_custom_field(){
    global $post;
    $extra_info = get_post_meta($post->ID, 'woocommerce_extra_info', true);
    ?>
    <p style="margin-bottom: 20px">
        <b><?php echo esc_html('Información adicional: ', 'bf')?></b><?php echo __($extra_info)?>
    </p>
    <?php
}