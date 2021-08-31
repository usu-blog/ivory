<?php

class WidgetClone4536 {
	function __construct() {
		add_action( 'admin_head-widgets.php', [$this, 'widget_clone'] );
	}
    function widget_clone() { ?>
        <script>
            jQuery(function() {
                function clone_button() {
                    $('.widget-control-actions').each(function() {
                        var button = $( '<input>' );
                        button.addClass( 'clone button' )
                            .attr({
                                'type' : 'button',
                                'value' : '複製'
                            })
                            .css({
                                'margin-right':'5px'
                            });
                        button.prependTo( $(this).find('.alignright') );
                    });
                }
                function clone(e) {
                    var original = $(this).parents('.widget');
                    var widget = original.clone(true);
                    var id_base = widget.find('input[name="id_base"]').val();
                    var number = widget.find('input[name="widget_number"]').val();
                    var i = 0;
                    $('input.widget-id[value|="' + id_base + '"]').each(function() {
                        var match = this.value.match(/-(\d+)$/);
                        if(match && parseInt(match[1]) > i) i = parseInt(match[1]);
                    });
                    var new_number = i + 1;
                    widget.find('.widget-content').find('input,select,textarea,label,div').each(function() {
                        if($(this).attr('name')) $(this).attr('name', $(this).attr('name').replace(number, new_number));
                        if($(this).attr('id')) $(this).attr('id', $(this).attr('id').replace(number, new_number));
                        if($(this).attr('for')) $(this).attr('for', $(this).attr('for').replace(number, new_number));
                    });
                    var i = 0;
                    $('.widget').each(function() {
                        var match = this.id.match(/^widget-(\d+)/);
                        if(match && parseInt(match[1]) > i) i = parseInt(match[1]);
                    });
                    var newid = i + 1;
                    widget[0].id = 'widget-' + newid + '_' + id_base + '-' + new_number;
                    widget.find('input.widget-id').val(id_base+'-'+new_number);
                    widget.find('input.widget_number').val(new_number);
                    widget.find('input.widget-control-save').removeAttr('disabled').val('保存');
                    widget.hide();
                    original.after(widget);
                    widget.fadeIn();
                    widget.find('.multi_number').val(new_number);
                    wpWidgets.save(widget, 0, 0, 1);
                    e.stopPropagation();
                    e.preventDefault();
                }
            clone_button();
            $('body').on('click', '.widget .clone', clone);
        });
    </script>
    <?php }
}

new WidgetClone4536();
