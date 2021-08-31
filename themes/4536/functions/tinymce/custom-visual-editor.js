(function() {
  tinymce.create( 'tinymce.plugins.original_tinymce_button', {
    init: function( ed, url ) {

        ed.addButton( 'balloon_left', {
        title: '左からの吹き出し',
        image: url + '/img/balloon-left.png',
        cmd: 'balloon_left_cmd'
        });
        ed.addCommand( 'balloon_left_cmd', function() {
        var selected_text = ed.selection.getContent(),
            return_text = '<div class="balloon"><figure class="balloon-image-left"><img src="' + $("#visual-editor-avatar-left").data("avatarLeft") + '" width="160" height="160" ><figcaption class="balloon-image-description">' + $("#visual-editor-user-name-left").data("userNameLeft") + '</figcaption></figure><div class="balloon-text-right"><p>' + selected_text + '</p></div></div>';
        ed.execCommand( 'mceInsertContent', 0, return_text );
        });

        ed.addButton( 'balloon_right', {
        title: '右からの吹き出し',
        image: url + '/img/balloon-right.png',
        cmd: 'balloon_right_cmd'
        });
        ed.addCommand( 'balloon_right_cmd', function() {
        var selected_text = ed.selection.getContent(),
            return_text = '<div class="balloon"><figure class="balloon-image-right"><img src="' + $("#visual-editor-avatar-right").data("avatarRight") + '" width="160" height="160" ><figcaption class="balloon-image-description">' + $("#visual-editor-user-name-right").data("userNameRight") + '</figcaption></figure><div class="balloon-text-left"><p>' + selected_text + '</p></div></div>';
        ed.execCommand( 'mceInsertContent', 0, return_text );
        });

        ed.addButton( 'balloon_think_left', {
        title: '左からの考え事風の吹き出し',
        image: url + '/img/balloon-think-left.png',
        cmd: 'balloon_think_left_cmd'
        });
        ed.addCommand( 'balloon_think_left_cmd', function() {
        var selected_text = ed.selection.getContent(),
            return_text = '<div class="balloon think"><figure class="balloon-image-left"><img src="' + $("#visual-editor-avatar-left").data("avatarLeft") + '" width="160" height="160" ><figcaption class="balloon-image-description">' + $("#visual-editor-user-name-left").data("userNameLeft") + '</figcaption></figure><div class="balloon-text-right"><p>' + selected_text + '</p></div></div>';
        ed.execCommand( 'mceInsertContent', 0, return_text );
        });

        ed.addButton( 'balloon_think_right', {
        title: '右からの考え事風の吹き出し',
        image: url + '/img/balloon-think-right.png',
        cmd: 'balloon_think_right_cmd'
        });
        ed.addCommand( 'balloon_think_right_cmd', function() {
        var selected_text = ed.selection.getContent(),
            return_text = '<div class="balloon think"><figure class="balloon-image-right"><img src="' + $("#visual-editor-avatar-right").data("avatarRight") + '" width="160" height="160" ><figcaption class="balloon-image-description">' + $("#visual-editor-user-name-right").data("userNameRight") + '</figcaption></figure><div class="balloon-text-left"><p>' + selected_text + '</p></div></div>';
        ed.execCommand( 'mceInsertContent', 0, return_text );
        });

        ed.addButton( 'point', {
        title: 'ワンポイント',
        image: url + '/img/point.png',
        cmd: 'point_cmd'
        });
        ed.addCommand( 'point_cmd', function() {
        var selected_text = ed.selection.getContent(),
            return_text = '<div class="frame border-blue"><div class="frame-title one-point"><i class="fab fa-check-circle-o"></i>POINT</div><p>' + selected_text + '</p></div>';
        ed.execCommand( 'mceInsertContent', 0, return_text );
        });

        ed.addButton( 'caution', {
        title: '注意書き',
        image: url + '/img/caution.png',
        cmd: 'caution_cmd'
        });
        ed.addCommand( 'caution_cmd', function() {
        var selected_text = ed.selection.getContent(),
            return_text = '<div class="frame border-red"><div class="frame-title caution"><i class="fab fa-exclamation-triangle"></i>CAUTION</div><p>' + selected_text + '</p></div>';
        ed.execCommand( 'mceInsertContent', 0, return_text );
        });

    },
    createControl : function( n, cm ) {
      return null;
    },
  });
  tinymce.PluginManager.add( 'original_tinymce_button_plugin', tinymce.plugins.original_tinymce_button );
})();