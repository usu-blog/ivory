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

//var name = 'toolbar/inline-font-color-4536';
//var title = '文字色を赤にする';

registerFormatType( 'toolbar/inline-font-color-4536', {
    
    title: '文字色を赤にする',

    tagName: 'span',
    
    className: 'color-red-4536',

    edit( props ) {

        var value = props.value,
            isActive = props.isActive;

        var onToggle = function() {
            return props.onChange(
                toggleFormat( value, { type : 'toolbar/inline-font-color-4536' } )
            );
        };

        return (
            el( Fragment, null,
               el( RichTextToolbarButton, {
                    icon: el( 'svg', { width: 20, height: 20, viewBox: '0 0 1000 1000' },
                             el( 'path',
                                { d: 'M300.36,683.924H696.816l90.521,237.187c8.02,21.77,26.354,32.083,46.979,32.083a64.864,64.864,0,0,0,20.624-3.438c22.917-5.729,41.25-22.916,41.25-45.833a40.49,40.49,0,0,0-4.583-19.479L579.942,99.552C565.046,60.594,535.254,45.7,498.588,45.7c-35.521,0-64.166,14.9-79.062,53.854L107.86,882.153a58.214,58.214,0,0,0-3.437,19.479c0,21.77,17.187,41.249,40.1,46.979a79.421,79.421,0,0,0,22.917,3.437c19.479,0,36.666-9.167,44.687-32.083Zm34.374-96.249,129.479-332.29c13.75-34.375,25.208-71.042,35.521-110,10.312,38.958,22.916,75.625,35.52,108.854L662.441,587.675H334.734Z',
                                 fill: 'red'
                                }
                               )
                            ),
                    title: '文字色を赤にする',
                    onClick: onToggle,
                    isActive: isActive,
                }
              )
            )
        );
    },
    
});
