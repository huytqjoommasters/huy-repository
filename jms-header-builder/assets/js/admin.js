(function($) {
    $.fn.setInputValue = function(options){
        if (this.attr('type') == 'checkbox') {
            if (options.filed == '1') {
                this.attr('checked','checked');

            }else{
                this.removeAttr('checked');
            }
        } else if(this.hasClass('input-media')){
            if(options.filed){
                $imgParent = this.parent('.media');
                console.log($imgParent);
                $imgParent.find('img.media-preview').each(function() {
                    $(this).attr('src',layoutbuilder_base+options.filed);
                });
            }
            this.val( options.filed );
        }else{
            this.val( options.filed );
        }

        if (this.data('attrname') == 'column_type'){
            if (this.val() == 'component') {
                $('.form-group.name').hide();
            }
        }
    }

    $.fn.getInputValue = function(){
        if (this.attr('type') == 'checkbox') {
            if (this.attr("checked")) {
                return '1';
            } else {
                return '0';
            }
        } else {
            return this.val();
        }
    }

    $(document).ready(function() {
        UiSort();
        item_draggable();
        $("#jms_add_row_btn").click(function (event) {
            event.preventDefault();
            var $rowClone = $('#jmsheaderbuilder-row .row').clone(true);
            $('.hb-content').append($rowClone);
        });
    });

    $(document).on('click','.row-setting',function(event) {
        event.preventDefault();
        $('.row').removeClass('row-active');
        var $parent = $(this).closest('.row');
        $parent.addClass('row-active');
        $('#layout-modal').find('.jms-modal-body').empty();
        $('#layout-modal .jms-modal-title').text('Row Settings');
        $('#layout-modal #save-settings').data('flag', 'row-setting');

        var $clone = $('.row-settings').clone(true);
        $clone = $('#layout-modal').find('.jms-modal-body').append( $clone );
        $clone.find('.addon-input').each(function(){
            var $that = $(this),
                attrValue = $parent.data( $that.data('attrname'));
            $that.setInputValue({filed: attrValue});
        });

        $('#layout-modal').modal();
    });

    $(document).on('click','#save-settings',function(event) {
        event.preventDefault();
        var flag = $(this).data('flag');
        switch(flag){
            case 'row-setting':
                $('#layout-modal').find('.addon-input').each(function(){
                    var $this = $(this),
                        $parent = $('.row-active'),
                        $attrname = $this.data('attrname');
                    $parent.removeData( $attrname );
                    if ($attrname == 'name') {
                        var nameVal = $this.val();

                        if (nameVal  !='' || $this.val() != null) {
                            $('.row-active .row-name').text($this.val());
                        }else{
                            $('.row-active .row-name').text('Row');
                        }
                    }
                    $parent.attr('data-' + $attrname, $this.getInputValue());
                });
                break;

            case 'column-setting':
                $('#layout-modal').find('.addon-input').each(function(){
                    var $this = $(this),
                        $parent = $('.column-active'),
                        $attrname = $this.data('attrname');
                    $parent.removeData( $attrname );
                    $parent.attr('data-' + $attrname, $this.getInputValue());
                    if($attrname == 'md_col') {
                        $this.updateClass('col-md-');
                    }
                    if($attrname == 'sm_col') {
                        $this.updateClass('col-sm-');
                    }
                    if($attrname == 'xs_col') {
                        $this.updateClass('col-xs-');
                    }
                });
                break;

            default:
                alert('You are doing somethings wrongs. Try again');
        }
    });

    $(document).on('click','.column-layout',function(event) {
        event.preventDefault();
        layouttype = $(this).data('layout');
        if (layouttype == 'custom') {
            column = prompt('Enter your custom layout like 2,2,2,2,2,2 as total 12 grid','2,2,2,2,2,2');
        }
        $('.column-list li').removeClass('layout-active');
        $(this).parent().addClass('layout-active');
        $('.row').removeClass('row-active');
        if (layouttype == 'custom') {
            var layout_str = column;
        } else {
            var layout_str = $(this).data('layout');
        }
        var row_box = $(this).closest('.row');
        row_box.addClass('row-active');
        row_columns = row_box.find('.row-columns');
        row_box.attr('data-layout', layout_str) ;
        var old_columns = $(row_box).find('.layout-column');
        if(layout_str == '12')
            var new_columns = ['12'];
        else
            var new_columns = layout_str.split(',');
        var n_old_columns = old_columns.length;
        var n_new_columns = new_columns.length;
        row_columns.empty();
        $.each(new_columns, function(index, value){
            var old_col_datas = old_columns.eq(index).data();
            //console.log(old_col_datas['custom_class']);
            if(index < n_old_columns) {
                var html = '<div class="layout-column col-lg-' + value;
                if(old_col_datas['md_col']) html += ' ' + old_col_datas['md_col'];
                if(old_col_datas['sm_col']) html += ' ' + old_col_datas['sm_col'];
                if(old_col_datas['xs_col']) html += ' ' + old_col_datas['xs_col'];
                html +='"';
                if(old_col_datas['background_attachment']) html += ' data-background_attachment="' + old_col_datas['background_attachment']+'"';
                if(old_col_datas['background_position']) html += ' data-background_position="' + old_col_datas['background_position']+'"';
                if(old_col_datas['background_repeat']) html += ' data-background_repeat="' + old_col_datas['background_repeat']+'"';
                if(old_col_datas['background_size']) html += ' data-background_size="' + old_col_datas['background_size']+'"';
                if(old_col_datas['background_img']) html += ' data-background_img="' + old_col_datas['background_img']+'"';
                if(old_col_datas['xs_col']) html += ' data-xs_col="' + old_col_datas['xs_col']+'"';
                if(old_col_datas['sm_col']) html += ' data-sm_col="' + old_col_datas['sm_col']+'"';
                if(old_col_datas['md_col']) html += ' data-md_col="' + old_col_datas['md_col']+'"';
                if(old_col_datas['custom_class']) html += ' data-custom_class="' + old_col_datas['custom_class']+'"';
                html += '><div class="column">' + old_columns.eq(index).find('.column').html() + '</div><div class="col-tools"><a href="#" class="column-setting pull-right label-tooltip" data-original-title="Column Setting"><i class="fa fa-cog"></i><span>Setting</span></a><a href="#" class="add-addon pull-right label-tooltip" data-original-title="Add Addons/Modules"><i class="fa fa-plus-circle"></i><span>Addons</span></a>' + '</div></div>';
            } else
                var html = '<div class="layout-column col-lg-' + value + '"><div class="column"></div><div class="col-tools"><a href="#" class="column-setting pull-right label-tooltip" data-original-title="Column Setting"><i class="fa fa-cog"></i><span>Setting</span></a><a href="#" class="add-addon pull-right label-tooltip" data-original-title="Add Addons/Modules"><i class="fa fa-plus-circle"></i><span>Addons</span></a>' + '</div></div>';
            row_columns.append(html);
        });
        if(n_old_columns > n_new_columns)
            for(i = n_new_columns; i < n_old_columns; i++)
                row_columns.find('.column').eq(n_new_columns-1).append(old_columns.eq(i).find('.column').html());

        UiSort();
        item_draggable();
    });

    $(document).on('click', '.add-addon', function(event){
        event.preventDefault();
        $('#modal-addons .addon-filter ul li').removeClass('active').first().addClass('active');
        $('.layout-column').removeClass('column-active');
        $(this).parent().parent().addClass('column-active');
        var $_html = $('.hidden .pagebuilder-addons').clone(true);
        $('#modal-addons').find('.jms-modal-body').empty();
        $('#modal-addons').find('.jms-modal-body').html( $_html );
        $('#modal-addons').modal();
    });

    //Remove Addon
    $(document).on('click', '.remove-addon', function(event){
        event.preventDefault();
        if ( confirm("Click Ok button to delete Block, Cancel to leave.") == true )
        {
            $(this).closest('.element-item').slideUp(200, function(){
                $(this).remove();
            });
        }
    });
    //Duplicate Addon
    $(document).on('click', '.duplicate-addon', function(event){
        event.preventDefault();
        var $clone = $(this).closest('.element-item').clone();
        $(this).closest('.column').append($clone);
    });

    $(document).on('click', '.duplicate-row', function(event){
        event.preventDefault();
        $('.row').removeClass('row-active');
        $(this).closest('.row').addClass('row-active');
        var $clone = $('.row-active').clone();
        $clone.removeClass('row-active');
        $('.hb-content').append($clone);
        UiSort();
        item_draggable();
    });
    $(document).on('click','.remove-row',function(event) {
        event.preventDefault();
        if ( confirm("Click Ok button to delete Row, Cancel to leave.") == true )
        {
            $(this).closest('.row').slideUp(200, function(){
                $(this).remove();
            });
        }
    });
    $(document).on('click','.column-setting',function(event) {
        event.preventDefault();
        $('.layout-column').removeClass('column-active');
        var $parent = $(this).closest('.layout-column');
        $parent.addClass('column-active');
        $('#layout-modal').find('.jms-modal-body').empty();
        $('#layout-modal .jms-modal-title').text('Column Settings');
        $('#layout-modal #save-settings').data('flag', 'column-setting');

        var $clone = $('.column-settings').clone(true);
        $clone = $('#layout-modal').find('.jms-modal-body').append( $clone );
        $clone.find('.addon-input').each(function(){
            var $that = $(this),
                attrValue = $parent.data( $that.data('attrname'));
            if($that.hasClass('jms-image')) {
                $that.next().attr('src',$('#root_url').val() + attrValue);
            }
            $that.setInputValue({filed: attrValue});
        });

        $('#layout-modal').modal();
    });

    function item_draggable() {
        var row_item = $(".hb-list-element .element-item"),
            row_sortable = $( ".layout-column .column" );
        row_item.draggable({
            connectToSortable: row_sortable,
            helper: "clone",
            revert: "invalid"
        });
        row_item.disableSelection();
    }

    function getLayout(){
        var config = [];
        var rows = $('.hb-content').find('.row');
        rows.removeClass('row-active');
        rows.each(function(index){
            var $row 		= $(this),
                rowIndex 	= index,
                rowObj 		= $row.data();
            console.log(rowObj);
            delete rowObj.sortableItem;
            var layout = 12;
            layout 	= $row.data('layout');
            config[rowIndex] = {
                'type'  	: 'row',
                'name'		: $(this).data('name'),
                'layout'	: layout,
                'settings' 	: rowObj,
                'cols'		: []
            };
            // Find Column Elements
            var columns = $row.find('.layout-column');
            columns.removeClass('column-active');
            columns.each(function(cindex) {
                var $column 	= $(this),
                    colIndex 	= cindex,
                    className 	= $column.attr('class'),
                    colObj 		= $column.data();
                delete colObj.sortableItem;
                config[rowIndex].cols[colIndex] = {
                    'type' 				: 'column',
                    'className' 		: className,
                    'settings' 			: colObj,
                    'addons'		: []
                };
                // Find Addon Elements
                var addons = $column.find('.element-item');
                addons.removeClass('addon-active');
                addons.each(function(aindex) {
                    var $addon 	= $(this),
                        addonIndex 	= aindex,
                        addonObj 		= $addon.data();
                    delete addonObj.sortableItem;
                    config[rowIndex].cols[colIndex].addons[addonIndex] = {
                        'addon_name' 				: $addon.data('item'),
                        'icon_class'                : $addon.children().attr('class')
                    };
                });
            });
        });
        return config;
    }
    function UiSort() {
        var $_rows = $(".hb-content");
        $_rows.sortable({
            opacity: 0.6,
            cursor: "move"
        });
        var $_columns = $(".row-columns");
        $_columns.sortable({
            opacity: 0.6,
            cursor: "move"
        });
        var $_addonboxs = $(".column");
        $_addonboxs.sortable({
            connectWith: '.column',
            opacity: 0.6,
            cursor: "move"
        });
    }

    $(document).on('click','#btn-save-header',function(event) {
        var param = getLayout();
        var j = JSON.stringify(param);
        $("textarea#data-header").text(j);
        $("#publish").trigger("click");
    });
})(jQuery);

