( function( editor, components, i18n, element ) {


    var el = wp.element.createElement,
        Fragment = wp.element.Fragment,
        registerBlockType = wp.blocks.registerBlockType,
        RichText = wp.editor.RichText,
        MediaUpload = wp.editor.MediaUpload,
        InspectorControls = wp.editor.InspectorControls,
        BlockControls = wp.editor.BlockControls,
        AlignmentToolbar = wp.editor.AlignmentToolbar;

    registerBlockType( 'text/ex', {

        title: i18n.__('吹き出し'),

        icon: 'admin-comments',

        category: 'custom-block-4536',

        attributes: {
            alignment: {
                type: 'string',
            },
            balloonForm: {
                type: 'string',
                default: 'balloon',
            },
            mediaURL: {
                type: 'string',
                source: 'attribute',
                selector: 'img',
                attribute: 'src',
                default: document.getElementById("gutenberg-balloon-avatar").getAttribute("data-balloon-avatar"),
            },
            avatarName: {
                type: 'string',
                source: 'text',
                selector: 'figcaption',
                default: document.getElementById("gutenberg-balloon-avatar-name").getAttribute("data-balloon-avatar-name"),
            },
            balloonAvatar: {
                type: 'string',
                default: 'balloon-image-left',
            },
            content: {
                type: 'string',
                source: 'html',
                selector: 'p',
            },
        },

        edit: function( props ) {
            var attributes = props.attributes,
                balloonForm = props.attributes.balloonForm,
                balloonAvatar = props.attributes.balloonAvatar,
                avatarName = props.attributes.avatarName,
                balloonContent = balloonAvatar==='balloon-image-left' ? 'balloon-text-right' : 'balloon-text-left',
                content = props.attributes.content,
                alignment = props.attributes.alignment,
                onSelectImage = ( media ) => {
                    props.setAttributes({
                        mediaURL: media.url,
//                        mediaID: media.id,
                    });
                };

            return (
                el(
                    Fragment,
                    null,
                    el(
                        BlockControls,
                        null,
                        el(
                            AlignmentToolbar,
                            {
                                value: alignment,
                                onChange: function ( newAlignment ) {
                                    props.setAttributes( { alignment: newAlignment } );
                                },
                            }
                        )
                    ),
                    el( InspectorControls, { key: 'inspector' },
                       el( components.PanelBody, {
                            title: '吹き出しオプション',
                            className: 'balloon-options',
                            initialOpen: true,
                        },
                          el( components.SelectControl, {
                                label: '吹き出しの向き',
                                value: balloonAvatar,
                                options: [
                                    {
                                        value: 'balloon-image-left',
                                        label: '左からの吹き出し',
                                    },
                                    {
                                        value: 'balloon-image-right',
                                        label: '右からの吹き出し',
                                    },
                                ],
                                onChange: function( value ) {
                                    props.setAttributes( { balloonAvatar: value } );
                                },
                            },),
                          el( components.SelectControl, {
                                label: '吹き出しの形状',
                                value: balloonForm,
                                options: [
                                    {
                                        value: 'balloon',
                                        label: '通常の吹き出し',
                                    },
                                    {
                                        value: 'balloon think',
                                        label: '考え事風の吹き出し',
                                    },
                                ],
                                onChange: function( value ) {
                                    props.setAttributes( { balloonForm: value } );
                                },
                            },)
					   )
                    ), //--InspectorControls
                    el( //wrap
                        'div',
                        { className: balloonForm },
                        el( 'figure', { className: balloonAvatar },
                            el( MediaUpload, {
                                    onSelect: onSelectImage,
                                    type: 'image',
//                                    value: attributes.mediaID,
                                    render: function( obj ) {
                                        return el( 'img', {
                                            src: attributes.mediaURL,
                                            onClick: obj.open,
                                        });
                                     },
                                }
                            ), //--MediaUpload
                            el( RichText, { //figcaption
                                    key: 'editable',
                                    tagName: 'figcaption',
                                    className: 'balloon-image-description',
                                    onChange: function( newAvatarName ) {
                                        props.setAttributes( { avatarName: newAvatarName } );
                                    },
                                    value: avatarName,
                                    keepPlaceholderOnFocus: false,
                                    placeholder: '名前',
                                }
                            ) //--figcaption
                        ), //--figure
                        el( //content wrap
                            'div', {
                                className: balloonContent,
//                                onChange: function( className ) {
//                                    props.setAttributes( { balloonContent: className } );
//                                },
                            },
                            el( //content
                                RichText, {
                                    key: 'editable',
                                    tagName: 'p',
                                    onChange: function( newContent ) {
                                        props.setAttributes( { content: newContent } );
                                    },
                                    value: content,
                                    keepPlaceholderOnFocus: true,
                                    placeholder: 'ここにテキストが入ります。',
                                }
                            ) //--content
                        ) //--content-wrap
                    ) //--wrap
                )
            );
        },

        save: function( props ) {
            var attributes = props.attributes,
                avatarName = props.attributes.avatarName,
                balloonAvatar = props.attributes.balloonAvatar,
                balloonContent = balloonAvatar==='balloon-image-left' ? 'balloon-text-right' : 'balloon-text-left',
                balloonForm = props.attributes.balloonForm,
                mediaURL = props.attributes.mediaURL,
                content = props.attributes.content,
                alignment = props.attributes.alignment;

            return (
                    el( //wrap
                        'div', { className: balloonForm },
                        el( //figure
                            'figure', { className: balloonAvatar },
                            el( //image
                                'img', {
                                    src: mediaURL
                                }
                            ), //--image
                            el( //figcaption
                                RichText.Content, {
                                    tagName: 'figcaption',
                                    className: 'balloon-image-description',
                                    value: avatarName,
                                }
                            ) //--figcaption
                        ), //--figure
                        el( //content wrap
                            'div', { className: balloonContent },
                            el( //content
                                RichText.Content, {
                                    tagName: 'p',
                                    value: content,
                                }
                            ) //--content
                        ) //--content-wrap
                    ) //--wrap
            )
        },
    } );


} )(
	window.wp.editor,
	window.wp.components,
	window.wp.i18n,
	window.wp.element,
);
