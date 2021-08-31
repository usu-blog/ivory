var el = wp.element.createElement,
    Fragment = wp.element.Fragment,
    registerBlockType = wp.blocks.registerBlockType,
    registerFormatType = wp.richText.registerFormatType,
    toggleFormat = wp.richText.toggleFormat,
    RichTextToolbarButton = wp.editor.RichTextToolbarButton,
    RichText = wp.editor.RichText,
    MediaUpload = wp.editor.MediaUpload,
    InspectorControls = wp.editor.InspectorControls,
    BlockControls = wp.editor.BlockControls,
    DropdownMenu = wp.components.DropdownMenu,
    AlignmentToolbar = wp.editor.AlignmentToolbar;

//var name = 'toolbar/inline-code-4536';

registerFormatType( 'toolbar/inline-code-4536', {
    
        title: 'コードタグで囲む',

        tagName: 'code',

        className: 'wp-inline-code-4536',

        edit( props ) {

            var value = props.value,
                isActive = props.isActive;

            var onToggle = function() {
                return props.onChange(
                    toggleFormat( value, { type : 'toolbar/inline-code-4536' } )
                );
            };

            return (
                el( Fragment, null,
                   el( RichTextToolbarButton, {
                        icon: 'editor-code',
                        title:  'コードタグで囲む',
                        onClick: onToggle,
                        isActive: isActive,
                    }
                  )
                )
            );
        },
    
});
