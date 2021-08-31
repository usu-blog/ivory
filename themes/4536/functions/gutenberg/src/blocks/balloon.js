const { registerBlockType } = wp.blocks;
const { Fragment } = wp.element;
const { InspectorControls, RichText, BlockControls, AlignmentToolbar, PanelColorSettings, MediaUpload } = wp.editor;
const { PanelBody, SelectControl, RadioControl, TextControl } = wp.components;
const { __ } = wp.i18n;

registerBlockType( 'gutenberg-extention-4536/balloon', {

    title: __('吹き出し'),

    icon: 'admin-comments',

    category: 'custom-block-4536',

    attributes: {
      content: {
        type: 'string',
        source: 'html',
        selector: 'p',
      },
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
      // backgroundColor: {
      //   type: 'string',
      // },
      fontColor: {
        type: 'string',
      },
    },

    edit( { attributes, className, setAttributes } ) {

      const { content, alignment, balloonForm, balloonAvatar, avatarName, fontColor, mediaURL } = attributes;
      const balloonContent = balloonAvatar==='balloon-image-left' ? 'balloon-text-right' : 'balloon-text-left';

      return (
        <Fragment>
          <BlockControls>
            <AlignmentToolbar
              value={ alignment }
              onChange={ ( value ) => setAttributes({ alignment: value }) }
            />
          </BlockControls>
          <InspectorControls>
            <PanelBody title={ __('吹き出しオプション') } initialOpen={ true }>
              <RadioControl
                label={ __('吹き出しの向き') }
                selected={ balloonAvatar }
                options={[
                  {
                    value: 'balloon-image-left',
                    label: '左からの吹き出し',
                  },
                  {
                    value: 'balloon-image-right',
                    label: '右からの吹き出し',
                  },
                ]}
                onChange={ (value) => setAttributes({ balloonAvatar: value }) }
              />
              <RadioControl
                label={ __('吹き出しの形状') }
                selected={ balloonForm }
                options={[
                  {
                    value: 'balloon',
                    label: '通常の吹き出し',
                  },
                  {
                    value: 'balloon think',
                    label: '考え事風の吹き出し',
                  },
                ]}
                onChange={ (value) => setAttributes({ balloonForm: value }) }
              />
            </PanelBody>
            <PanelColorSettings
              title={ __( '色設定' ) }
              colorSettings={[
                // {
                //   label: __( '吹き出しの色' ),
                //   value: backgroundColor,
                //   onChange: (value) => setAttributes({ backgroundColor: value }),
                // },
                {
                  label: __( '文字色' ),
                  value: fontColor,
                  onChange: (value) => setAttributes({ fontColor: value }),
                },
              ]}
              initialOpen={ false }
              disableCustomColors={ true }
            />
          </InspectorControls>
          <div className={ balloonForm }>
            <figure className={ balloonAvatar }>
              <MediaUpload
                onSelect={ ( media ) => setAttributes({ mediaURL: media.url }) }
                type='image'
                render={ ( obj ) => {
                  return ( <img src={ mediaURL } onClick={ obj.open } /> );
                }}
              />
              <RichText
                key='editable'
                tagName='figcaption'
                className='balloon-image-description'
                value={ avatarName }
                onChange={ ( value ) => setAttributes({ avatarName: value }) }
                keepPlaceholderOnFocus={ false }
                placeholder='名前'
              />
            </figure>
            <div className={ balloonContent }>
              <RichText
                key='editable'
                tagName='p'
                style={ { color: fontColor } }
                value={ content }
                onChange={ ( value ) => setAttributes({ content: value }) }
                keepPlaceholderOnFocus={ true }
                placeholder='ここにテキストが入ります。'
              />
            </div>
          </div>
        </Fragment>
      );
    },

    save( { attributes } ) {

      const { content, alignment, balloonForm, balloonAvatar, avatarName, fontColor, mediaURL } = attributes;
      const balloonContent = balloonAvatar==='balloon-image-left' ? 'balloon-text-right' : 'balloon-text-left';

      return (
        <div className={ balloonForm }>
          <figure className={ balloonAvatar }>
            <img alt='' src={ mediaURL } />
            <RichText.Content
              tagName='figcaption'
              className='balloon-image-description'
              value={ avatarName }
            />
          </figure>
          <div className={ balloonContent }>
            <RichText.Content
              tagName='p'
              style={ { color: fontColor } }
              value={ content }
            />
          </div>
        </div>
      );
    },

} );
