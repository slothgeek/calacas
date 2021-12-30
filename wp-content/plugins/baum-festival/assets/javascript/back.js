jQuery(document).ready(function($){
    console.log('Backend script');

    $('body').on('click', '.bg-upload-image', function(e){
        e.preventDefault();

        var button = $(this),
            custom_uploader = wp.media({
                title: 'Insert image',
                library : {
                    type : 'image'
                },
                button: {
                    text: 'Use this image'
                },
                multiple: false
            }).on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $(button).removeClass('button').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:95%;display:block;" />').next().val(attachment.id).next().show();
            })
                .open();
    });

    $('body').on('click', '.bg-remove-image', function(){
        $(this).hide().prev().val('').prev().addClass('button').html('Subir image');
        return false;
    });
});