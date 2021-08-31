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

registerFormatType( 'toolbar/inline-font-underline-4536', {
    
    title: '下線を引く',

    tagName: 'span',
    
    className: 'underline-4536',

    edit( props ) {

        var value = props.value,
            isActive = props.isActive;

        var onToggle = function() {
            return props.onChange(
                toggleFormat( value, { type : 'toolbar/inline-font-underline-4536' } )
            );
        };

        return (
            el( Fragment, null,
               el( RichTextToolbarButton, {
                    icon: el( 'svg',{ width: 20, height: 20, viewBox: '0 0 1000 1000' },
                             el( 'path',
                                { d: 'M195.245,546.032c0,201,111,304,304,304,198,0,305-106,305-304v-457c0-28-20-41-48-41s-48,13-48,41v453c0,147-72,221-210,221-135,0-207-73-207-220v-454c0-28-21-41-47-41-29,0-49,13-49,41v457Z' }
                               ),
                             el( 'rect',
                                { x: '50',
                                 width: '900',
                                 y: '950',
                                 height: '50',
                                 fill: '#282828'
                                }
                               )
                            ),
                    title: '下線を引く',
                    onClick: onToggle,
                    isActive: isActive,
                }
              )
            )
        );
    },
    
});
