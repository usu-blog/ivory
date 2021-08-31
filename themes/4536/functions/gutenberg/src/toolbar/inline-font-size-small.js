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

//var name = 'toolbar/inline-font-size-4536';
//var title = '文字を大きくする';

registerFormatType( 'toolbar/inline-font-size-small-4536', {
    
    title: '文字を小さくする',

    tagName: 'span',
    
    className: 'has-small-font-size',

    edit( props ) {

        var value = props.value,
            isActive = props.isActive;

        var onToggle = function() {
            return props.onChange(
                toggleFormat( value, { type : 'toolbar/inline-font-size-small-4536' } )
            );
        };

        return (
            el( Fragment, null,
               el( RichTextToolbarButton, {
                    icon: el('svg',{ width: 20, height: 20, viewBox: '0 0 1000 1000' },
                             el('path',
                                { d: 'M206.9,560.849H524.067L596.484,750.6c6.416,17.417,21.083,25.667,37.583,25.667a51.916,51.916,0,0,0,16.5-2.75c18.334-4.583,33-18.333,33-36.667a32.387,32.387,0,0,0-3.667-15.583L430.566,93.347c-11.917-31.167-35.75-43.084-65.084-43.084-28.416,0-51.333,11.917-63.25,43.084L52.9,719.433a46.564,46.564,0,0,0-2.75,15.584c0,17.417,13.75,33,32.084,37.583a63.5,63.5,0,0,0,18.333,2.75c15.584,0,29.334-7.333,35.75-25.666Zm27.5-77L337.982,218.014c11-27.5,20.167-56.834,28.417-88A883.332,883.332,0,0,0,394.816,217.1l101.75,266.752H234.4Z' }
                               ),
                             el('path',
                                { d: 'M690.426,833.879h173l39.5,103.5c3.5,9.5,11.5,14,20.5,14a28.313,28.313,0,0,0,9-1.5c10-2.5,18-10,18-20a17.666,17.666,0,0,0-2-8.5l-136-342.5c-6.5-17-19.5-23.5-35.5-23.5-15.5,0-28,6.5-34.5,23.5l-136,341.5a25.4,25.4,0,0,0-1.5,8.5c0,9.5,7.5,18,17.5,20.5a34.646,34.646,0,0,0,10,1.5c8.5,0,16-4,19.5-14Zm15-42,56.5-145a415.511,415.511,0,0,0,15.5-48,481.938,481.938,0,0,0,15.5,47.5l55.5,145.5h-143Z' }
                               )
                            ),
                    title: '文字を小さくする',
                    onClick: onToggle,
                    isActive: isActive,
                }
              )
            )
        );
    },
    
});
