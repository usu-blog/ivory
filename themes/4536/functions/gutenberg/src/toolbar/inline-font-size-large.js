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

registerFormatType( 'toolbar/inline-font-size-large-4536', {
    
    title: '文字を大きくする',

    tagName: 'span',
    
    className: 'has-large-font-size',

    edit( props ) {

        var value = props.value,
            isActive = props.isActive;

        var onToggle = function() {
            return props.onChange(
                toggleFormat( value, { type : 'toolbar/inline-font-size-large-4536' } )
            );
        };

        return (
            el( Fragment, null,
               el( RichTextToolbarButton, {
                    icon: el('svg',{ width: 20, height: 20, viewBox: '0 0 1000 1000' },
                             el('path',
                                { d: 'M148.657,375.346H350.488L396.571,496.1c4.083,11.083,13.417,16.333,23.916,16.333a33.022,33.022,0,0,0,10.5-1.75c11.667-2.916,21-11.666,21-23.333a20.608,20.608,0,0,0-2.333-9.916L290.989,77.849c-7.584-19.833-22.75-27.416-41.417-27.416-18.083,0-32.666,7.583-40.249,27.417L50.657,476.262a29.63,29.63,0,0,0-1.75,9.917c0,11.083,8.75,21,20.416,23.916a40.408,40.408,0,0,0,11.667,1.75c9.917,0,18.667-4.667,22.75-16.333Zm17.5-49,65.916-169.166a484.7,484.7,0,0,0,18.084-56A562.131,562.131,0,0,0,268.239,156.6l64.749,169.749H166.156Z' }
                               ),
                             el('path',
                                { d: 'M430.074,715.262h346l79,207c7,19,23,28,41,28a56.625,56.625,0,0,0,18-3c20-5,36-20,36-40a35.333,35.333,0,0,0-4-17l-272-685c-13-34-39-47-71-47-31,0-56,13-69,47l-272,683a50.792,50.792,0,0,0-3,17c0,19,15,36,35,41a69.292,69.292,0,0,0,20,3c17,0,32-8,39-28Zm30-84,113-290c12-30,22-62,31-96a963.876,963.876,0,0,0,31,95l111,291h-286Z' }
                               )
                            ),
                    title: '文字を大きくする',
                    onClick: onToggle,
                    isActive: isActive,
                }
              )
            )
        );
    },
    
});
