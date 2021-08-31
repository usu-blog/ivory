import classNames from 'classnames'

const { registerBlockType } = wp.blocks;
const { Fragment } = wp.element;
const { InspectorControls, RichText, BlockControls, AlignmentToolbar, PanelColorSettings } = wp.editor;
const { PanelBody, SelectControl, TextControl, RadioControl } = wp.components;
const { __ } = wp.i18n;

registerBlockType( 'gutenberg-extention-4536/point', {

    title: __('ポイント'),

    icon: 'yes',

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
      label: {
        type: 'string',
        selector: 'span',
        default: 'POINT',
      },
      icon: {
        type: 'string',
        default: 'fa-check',
      },
      fontColor: {
        type: 'string',
      },
    },

    edit( { attributes, className, setAttributes } ) {

      const { content, alignment, label, icon, fontColor } = attributes;

      return (
        <Fragment>
          <BlockControls>
            <AlignmentToolbar
              value={ alignment }
              onChange={ ( value ) => setAttributes({ alignment: value }) }
            />
          </BlockControls>
          <InspectorControls>
            <PanelBody title={ __('オプション') }>
              <RadioControl
                label={ __('アイコン') }
                onChange={ ( value ) => setAttributes({ icon: value }) }
                selected={ icon }
                options={[
                  {
                    label: <i class="fas fa-check"></i>,
                    value: 'fa-check',
                  },
                  {
                    label: <i class="fas fa-check-double"></i>,
                    value: 'fa-check-double',
                  },
                  {
                    label: <i class="fas fa-check-circle"></i>,
                    value: 'fa-check-circle',
                  },
                  {
                    label: <i class="fas fa-check-square"></i>,
                    value: 'fa-check-square',
                  },
                ]}
              />
              <TextControl
                label={ __('タイトル') }
                value={ label }
                onChange={ (value) => setAttributes({ label: value }) }
              />
            </PanelBody>
            <PanelColorSettings
              title={ __( '色設定' ) }
              colorSettings={[
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
          <div className={ classNames('frame', 'frame-blue') }>
            <div className={ classNames('frame-title', 'one-point') }>
              <i className={ classNames('fas', icon) }></i>
              <span>{ label }</span>
            </div>
            <RichText
                key="editable"
                tagName="p"
                style={ { color: fontColor } }
                value={ content }
                onChange={ ( value ) => setAttributes({ content: value }) }
            />
          </div>
        </Fragment>
      );
    },

    save( { attributes } ) {

      const { content, alignment, label, icon, fontColor } = attributes;

      return (
        <div className={ classNames('frame', 'frame-blue') }>
          <div className={ classNames('frame-title', 'one-point') }>
            <i className={ classNames('fas', icon) }></i>
            <span>{ label }</span>
          </div>
          <RichText.Content
            style={ { color: fontColor } }
            value={ content }
            tagName="p"
          />
        </div>
      );
    },
} );
