jQuery(document).ready(function ($) {
    $(document).on("click", ".upload-image-button", function(e) {
        e.preventDefault(); // デフォルトイベント制御
        var $button = $(this);
        // 画像選択画面作成
        var file_frame = wp.media.frames.file_frame = wp.media({
            title: 'メディアを追加',
            library: { // remove these to show all
                type: 'image' // specific mime
            },
            button: {
                text: '決定'
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });
        // When an image is selected, run a callback.
        file_frame.on('select', function () {
            // We set multiple to false so only get one image from the uploader
            var attachment = file_frame.state().get('selection').first().toJSON();
            $button.siblings('input').val(attachment.url).change();
            $button.siblings('img').attr('src', attachment.url).change();
        });
        // Finally, open the modal
        file_frame.open();
    });
    $(document).on("click", ".delete-image-button", function(e) {
        e.preventDefault();
        var $button = $(this);
        $button.siblings('input').val('').change();
        $button.siblings('img').removeAttr('src').change();
    });
});