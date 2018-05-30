(function ($) {
    $.fn.setInputValue = function (options) {
        if (this.attr('type') == 'checkbox') {
            if (options.filed == '1') {
                this.attr('checked', 'checked');

            } else {
                this.removeAttr('checked');
            }
        } else if (this.hasClass('input-media')) {
            if (options.filed) {
                $imgParent = this.parent('.media');
                console.log($imgParent);
                $imgParent.find('img.media-preview').each(function () {
                    $(this).attr('src', layoutbuilder_base + options.filed);
                });
            }
            this.val(options.filed);
        } else {
            this.val(options.filed);
        }

        if (this.data('attrname') == 'column_type') {
            if (this.val() == 'component') {
                $('.form-group.name').hide();
            }
        }
    }

    $.fn.getInputValue = function () {
        return this.val();
    }

    $(document).ready(function () {
        UiSort();
        item_draggable();
        $("#jms_add_row_btn").click(function (event) {
            event.preventDefault();
            var $rowClone = $('#jmsheaderbuilder-row .row').clone(true);
            $('.hb-content').append($rowClone);
        });

    });
    // Edit addon text
    $(document).on('click', '.edit-addon-text', function (event) {
        $(this).closest('.header-item').addClass('addon-active');
        var popup = $('.addon-text-settings');
        // Show Value
        var this_addon = $(this).closest('.header-item.addon-active');
        var txt_class = this_addon.find("input[name='className']").val();
        var txt_id = this_addon.find("input[name='ID']").val();
        var txt_content = this_addon.find("input[name='hb-text-content']").val();
        //$('.addon-text-settings > .seting-wrapper > .form-group .txt-class').val(txt_class);
        $('.addon-text-settings > .seting-wrapper').find("input[name='className']").val(txt_class);
        $('.addon-text-settings > .seting-wrapper').find("input[name='ID']").val(txt_id);
        //$('.addon-text-settings > .seting-wrapper > .form-group .txt-id').val(txt_id);
        tinymce.editors['text-content'].setContent(txt_content);

        get_popup(popup);
        $('.addon-text-settings #save-settings').data('flag', 'addon-text-setting');
    });
    // Edit addon sidebar
    $(document).on('click', '.edit-addon-sidebar', function (event) {
        $(this).closest('.header-item').addClass('addon-active');
        var popup = $('.addon-sidebar-settings');
        get_popup(popup);
        $('.addon-sidebar-settings #save-settings').data('flag', 'addon-sidebar-setting');
        // Show value
        var this_addon = $(this).closest('.header-item.addon-active');
        var sd_list = this_addon.find("input[name='sidebar-list']").val();
        var sd_pos = this_addon.find("input[name='sidebar-pos']").val();
        var sd_icon = this_addon.find("input[name='sidebar-icon-class']").val();

        var this_setting = $('.addon-sidebar-settings');
        this_setting.find("input[name='sidebar-icon-class']").val(sd_icon);
        this_setting.find('#sidebar-list option').each(function() {
            if ( $(this).val() == sd_list ) {
                $(this).prop('selected', true);
            }
        });
        this_setting.find('#sidebar-pos option').each(function() {
            if ( $(this).val() == sd_pos ) {
                $(this).prop('selected', true);
            }
        });
    });
    // Edit addon social
    $(document).on('click', '.edit-addon-socials', function (event) {
        $(this).closest('.header-item').addClass('addon-active');
        var popup = $('.addon-socials-settings');
        get_popup(popup);
        $('.addon-socials-settings #save-settings').data('flag', 'addon-socials-setting');
        // Show value
        var this_addon = $(this).closest('.header-item.addon-active');
        var fb_link = this_addon.find("input[name='facebook-link']").val();
        var gg_link = this_addon.find("input[name='googleplus-link']").val();
        var inst_link = this_addon.find("input[name='instagram-link']").val();
        var print_link = this_addon.find("input[name='printerest-link']").val();
        var twi_link = this_addon.find("input[name='twitter-link']").val();
        var you_link = this_addon.find("input[name='youtube-link']").val();

        var this_setting = $('.addon-socials-settings');
        this_setting.find("input[name='facebook-link']").val(fb_link);
        this_setting.find("input[name='googleplus-link']").val(gg_link);
        this_setting.find("input[name='instagram-link']").val(inst_link);
        this_setting.find("input[name='printerest-link']").val(print_link);
        this_setting.find("input[name='twitter-link']").val(twi_link);
        this_setting.find("input[name='youtube-link']").val(you_link);
    });
    //Edit addon logo
    $(document).on('click', '.edit-addon-logo', function (event) {
        $(this).closest('.header-item').addClass('addon-active');
        var popup = $('.addon-logo-settings');
        get_popup(popup);
        var this_addon = $(this).closest('.header-item.addon-active');
        var this_setting = $('.addon-logo-settings');
        // Show value
        var lg_type = this_addon.find("input[name='logo-type']").val();
        var lg_url = this_addon.find("input[name='logo-image-url']").val();
        var lg_width = this_addon.find("input[name='logo-width']").val();
        var lg_text = this_addon.find("input[name='logo-text']").val();
        var lg_color = this_addon.find("input[name='logo-color']").val();
        var lg_font_size = this_addon.find("input[name='logo-font-size']").val();
        var lg_line_height = this_addon.find("input[name='logo-line-height']").val();
        var lg_letter_spacing = this_addon.find("input[name='logo-letter-spacing']").val();
        var lg_class_name = this_addon.find("input[name='className']").val();
        var lg_id = this_addon.find("input[name='ID']").val();
        if (lg_url != "") {
            $('#logo_img').attr('src', lg_url);
        }
        this_setting.find("input[name='logo-image-url']").val(lg_url);
        this_setting.find("input[name='logo-width']").val(lg_width);
        this_setting.find("input[name='logo-text']").val(lg_text);
        this_setting.find("input[name='logo-color']").val(lg_color);
        this_setting.find("input[name='logo-font-size']").val(lg_font_size);
        this_setting.find("input[name='logo-line-height']").val(lg_line_height);
        this_setting.find("input[name='logo-letter-spacing']").val(lg_letter_spacing);
        this_setting.find("input[name='className']").val(lg_class_name);
        this_setting.find("input[name='ID']").val(lg_id);
        $(".wp-color-result").css("background-color", lg_color);
        /* ---- */
        $('.addon-logo-settings #save-settings').data('flag', 'addon-logo-setting');

        this_setting.find("input[name='logo-type']").removeAttr("checked");
        //alert(this_addon.find("input[name='logo-type']").val());
        if (this_addon.find("input[name='logo-type']").val() == 'logo') {
            this_setting.find("input[name='logo-type'][value=logo]").attr('checked', true);
            this_setting.find('.image-setting').show();
            this_setting.find('.text-setting').hide();
        } else {
            this_setting.find("input[name='logo-type'][value=text]").attr('checked', true);
            this_setting.find('.image-setting').hide();
            this_setting.find('.text-setting').show();
        }
        // Logo setting event
        $('.addon-logo-settings').find('input[name=logo-type]').on('change', function () {
            var this_setting = $('.addon-logo-settings');
            switch ($(this).val()) {
                case 'logo':
                    this_setting.find('.text-setting').hide();
                    this_setting.find('.image-setting').show();
                    break;
                case 'text':
                    this_setting.find('.image-setting').hide();
                    this_setting.find('.text-setting').show();
                    break;
            }
            ;
        });
    });

    // addon setting close
    $(document).on('click', '.hb-settings-close', function (event) {
        $(this).closest('.hb-settings-box').removeClass('show');
        $('.header-item.addon-active').removeClass('addon-active');
        $('.row.row-active').removeClass('.row-active');
        $(this).closest('.hb-settings-box').find('#logo_img').attr('src', "");
        $(this).closest('.hb-settings-box').find('#row_bg').attr('src', "");
        $(this).closest('.hb-settings-box').find('#col_bg').attr('src', "");
    });

    function get_popup(id) {
        id.addClass('show');
        var winH = $(window).height();
        var winW = $(window).width();
        var popW = winW * 30 / 100;
        var popH = id.height();
        id.css('width', popW);
        id.css('top', winH / 2 - popH / 2);
        id.css('left', winW / 2 - popW / 2);
        $(id).fadeIn(500);
    }

    // Row setting click
    $(document).on('click', '.row-setting', function (event) {
        event.preventDefault();
        $('.row').removeClass('row-active');
        var $parent = $(this).closest('.row');
        $parent.addClass('row-active');
        $('.addon-row-settings #save-settings').data('flag', 'row-setting');
        var popup = $('.addon-row-settings');
        get_popup(popup);
        var this_row = $(this).closest('.row-active');
        var row_name = this_row.data('name');
        var row_class = this_row.data('row_class');
        var row_bg = this_row.data('background_img');
        var row_bg_size = this_row.data('background_size');
        var row_bg_repeat = this_row.data('background_repeat');
        var row_bg_pos = this_row.data('background_position');
        var row_bg_attac = this_row.data('background_attachment');
        if (row_bg != "") {
            $('#row_bg').attr('src', row_bg);
        }
        var this_setting = $('.addon-row-settings');

        this_setting.find('#background-size option').each(function() {
            if ( $(this).val() == row_bg_size ) {
                $(this).prop('selected', true);
            }
        });
        this_setting.find('#background-repeat option').each(function() {
            if ( $(this).val() == row_bg_repeat ) {
                $(this).prop('selected', true);
            }
        });
        this_setting.find('#background-position option').each(function() {
            if ( $(this).val() == row_bg_pos ) {
                $(this).prop('selected', true);
            }
        });
        this_setting.find('#background-attachment option').each(function() {
            if ( $(this).val() == row_bg_attac ) {
                $(this).prop('selected', true);
            }
        });
        this_setting.find("input[name='name']").val(row_name);
        this_setting.find("input[name='row-class']").val(row_class);
        this_setting.find("input[name='background-img']").val(row_bg);
        this_setting.find("input[name='background-size']").val(row_bg_size);
        this_setting.find("input[name='background-repeat']").val(row_bg_repeat);
        this_setting.find("input[name='background-position']").val(row_bg_pos);
        this_setting.find("input[name='background-attachment']").val(row_bg_attac);
    });
    // Column setting button
    $(document).on('click', '.column-setting', function (event) {
        event.preventDefault();
        $('.layout-column').removeClass('column-active');
        var $parent = $(this).closest('.layout-column');
        $parent.addClass('column-active');
        var this_col = $(this).closest('.column-active');
        var col_class = this_col.data('custom_class');
        var md_col = this_col.data('md_col');
        var sm_col = this_col.data('sm_col');
        var xs_col = this_col.data('xs_col');
        var col_bg = this_col.data('background_img');
        var col_bg_size = this_col.data('background_size');
        var col_bg_repeat = this_col.data('background_repeat');
        var col_bg_pos = this_col.data('background_position');
        var col_bg_attac = this_col.data('background_attachment');

        var this_setting = $('.addon-column-settings');

        this_setting.find('#md-col option').each(function() {
            if ( $(this).val() == md_col ) {
                $(this).prop('selected', true);
            }
        });
        this_setting.find('#sm-col option').each(function() {
            if ( $(this).val() == sm_col ) {
                $(this).prop('selected', true);
            }
        });
        this_setting.find('#xs-col option').each(function() {
            if ( $(this).val() == xs_col ) {
                $(this).prop('selected', true);
            }
        });
        if (col_bg != "") {
            $('#col_bg').attr('src', col_bg);
        }
        this_setting.find('#background-size option').each(function() {
            if ( $(this).val() == col_bg_size ) {
                $(this).prop('selected', true);
            }
        });
        this_setting.find('#background-repeat option').each(function() {
            if ( $(this).val() == col_bg_repeat ) {
                $(this).prop('selected', true);
            }
        });
        this_setting.find('#background-position option').each(function() {
            if ( $(this).val() == col_bg_pos ) {
                $(this).prop('selected', true);
            }
        });
        this_setting.find('#background-attachment option').each(function() {
            if ( $(this).val() == col_bg_attac ) {
                $(this).prop('selected', true);
            }
        });
        this_setting.find("input[name='col-class']").val(col_class);
        this_setting.find("input[name='background-img']").val(col_bg);
        var popup = $('.addon-column-settings');
        get_popup(popup);
        $('.addon-column-settings #save-settings').data('flag', 'column-setting');

    });
    // Save setting click
    $(document).on('click', '#save-settings', function (event) {
        event.preventDefault();
        var flag = $(this).data('flag');
        switch (flag) {
            case 'row-setting':
                var val1 = $(this).closest('.seting-wrapper').find("input[name='name']").val();
                var val2 = $(this).closest('.seting-wrapper').find("input[name='row-class']").val();
                var val3 = $(this).closest('.seting-wrapper').find("input[name='background-img']").val();
                var val4 = $(this).closest('.seting-wrapper').find("#background-size").val();
                var val5 = $(this).closest('.seting-wrapper').find("#background-repeat").val();
                var val6 = $(this).closest('.seting-wrapper').find("#background-position").val();
                var val7 = $(this).closest('.seting-wrapper').find("#background-attachment").val();
                var this_row = $('.row-active');
                this_row.find("input[name='name']").val(val1);
                this_row.find("input[name='row-class']").val(val2);
                this_row.find("input[name='background-img']").val(val3);
                this_row.find("input[name='background-size']").val(val4);
                this_row.find("input[name='background-repeat']").val(val5);
                this_row.find("input[name='background-position']").val(val6);
                this_row.find("input[name='background-attachment']").val(val7);
                this_row.find("> .row-input-group .row-input").each(function(){
                    var $this = $(this);
                    var attrname = $this.data('bind');
                    this_row.removeData(attrname);
                    if (attrname == 'name') {
                        var nameVal = $this.val();
                        if (nameVal != '' || $this.val() != null) {
                            $('.row-active .row-name').text($this.val());
                        } else {
                            $('.row-active .row-name').text('Row');
                        }
                    }
                    this_row.attr('data-' + attrname, $this.getInputValue());
                });
                this_row.find('.row-input-group .row-input').each(function(){
                    var $this = $(this);
                    var attrname = $this.data('bind');
                    this_row.removeData(attrname);
                    if (attrname == 'row-name') {
                        var nameVal = $this.val();
                        if (nameVal != '' || $this.val() != null) {
                            $('.row-active .row-name').text($this.val());
                        } else {
                            $('.row-active .row-name').text('Row');
                        }
                    }
                    this_row.attr('data-' + attrname, $this.getInputValue());
                    $this.val("");
                });
                $('#row_bg').attr('src', "");
                break;
            case 'column-setting':
                var this_setting = $(this).closest('.seting-wrapper');
                var this_column = $('.column-active');
                this_setting.find('.col-input').each(function(){
                    var $this = $(this);
                    var attrname = $this.data('bind');
                    this_column.removeData(attrname);
                    if(attrname == 'md_col') {
                        $this.updateClass('col-md-');
                    }
                    if(attrname == 'sm_col') {
                        $this.updateClass('col-sm-');
                    }
                    if(attrname == 'xs_col') {
                        $this.updateClass('col-xs-');
                    }
                    this_column.attr('data-' + attrname, $this.getInputValue());
                    $this.val("");
                });
                $('#col_bg').attr('src', "");
                break;
            case 'addon-text-setting':
                var text_data = tinymce.editors['text-content'].getContent();
                $(this).closest('.seting-wrapper').find("input[name='hb-editor-hidden']").val(text_data);
                var this_addon = $('.header-item.addon-active');
                var val1 = $(this).closest('.seting-wrapper').find("input[name='hb-editor-hidden']").val();
                var val2 = $(this).closest('.seting-wrapper').find("input[name='className']").val();
                var val3 = $(this).closest('.seting-wrapper').find("input[name='ID']").val();

                this_addon.find("input[name='hb-text-content']").val(val1);
                this_addon.find("input[name='className']").val(val2);
                this_addon.find("input[name='ID']").val(val3);
                break;
            case 'addon-logo-setting':
                var this_addon = $('.header-item.addon-active');
                var val1 = $(this).closest('.seting-wrapper').find("input[name='logo-type']:checked").val();
                var val2 = $(this).closest('.seting-wrapper').find("input[name='logo-image-url']").val();
                var val3 = $(this).closest('.seting-wrapper').find("input[name='logo-width']").val();
                var val4 = $(this).closest('.seting-wrapper').find("input[name='logo-text']").val();
                var val5 = $(this).closest('.seting-wrapper').find("input[name='logo-color']").val();
                var val6 = $(this).closest('.seting-wrapper').find("input[name='logo-font-size']").val();
                var val7 = $(this).closest('.seting-wrapper').find("input[name='logo-line-height']").val();
                var val8 = $(this).closest('.seting-wrapper').find("input[name='logo-letter-spacing']").val();
                var val9 = $(this).closest('.seting-wrapper').find("input[name='className']").val();
                var val10 = $(this).closest('.seting-wrapper').find("input[name='ID']").val();
                this_addon.find("input[name='logo-type']").val(val1);
                this_addon.find("input[name='logo-image-url']").val(val2);
                this_addon.find("input[name='logo-width']").val(val3);
                this_addon.find("input[name='logo-text']").val(val4);
                this_addon.find("input[name='logo-color']").val(val5);
                this_addon.find("input[name='logo-font-size']").val(val6);
                this_addon.find("input[name='logo-line-height']").val(val7);
                this_addon.find("input[name='logo-letter-spacing']").val(val8);
                this_addon.find("input[name='className']").val(val9);
                this_addon.find("input[name='ID']").val(val10);
                $('#logo_img').attr('src', "");
                break;
            case 'addon-socials-setting':
                var this_addon = $('.header-item.addon-active');
                var val1 = $(this).closest('.seting-wrapper').find("input[name='facebook-link']:checked").val();
                var val2 = $(this).closest('.seting-wrapper').find("input[name='googleplus-link']").val();
                var val3 = $(this).closest('.seting-wrapper').find("input[name='instagram-link']").val();
                var val4 = $(this).closest('.seting-wrapper').find("input[name='printerest-link']").val();
                var val5 = $(this).closest('.seting-wrapper').find("input[name='twitter-link']").val();
                var val6 = $(this).closest('.seting-wrapper').find("input[name='youtube-link']").val();
                this_addon.find("input[name='facebook-link']").val(val1);
                this_addon.find("input[name='googleplus-link']").val(val2);
                this_addon.find("input[name='instagram-link']").val(val3);
                this_addon.find("input[name='printerest-link']").val(val4);
                this_addon.find("input[name='twitter-link']").val(val5);
                this_addon.find("input[name='youtube-link']").val(val6);
                break;
            case 'addon-sidebar-setting':
                var this_addon = $('.header-item.addon-active');
                var val1 = $(this).closest('.seting-wrapper').find("#sidebar-list").val();
                var val2 = $(this).closest('.seting-wrapper').find("#sidebar-pos").val();
                var val3 = $(this).closest('.seting-wrapper').find("input[name='sidebar-icon-class']").val();
                this_addon.find("input[name='sidebar-list']").val(val1);
                this_addon.find("input[name='sidebar-pos']").val(val2);
                this_addon.find("input[name='sidebar-icon-class']").val(val3);
                break;
            default:
                alert('You are doing somethings wrongs. Try again');
        }
        $(this).closest('.hb-settings-box').removeClass('show');
        $('.header-item.addon-active').removeClass('addon-active');
    });
    $.fn.updateClass = function(str2){
        $parent = $('.column-active');
        var classes = $parent.attr('class').split(" ");
        for (var i = 0, len = classes.length; i < len; i++)
            if(classes[i].indexOf(str2)!= -1) {
                $parent.removeClass(classes[i]);
            }
        $parent.addClass(this.getInputValue());
    }
    // logo-type logo-image-url logo-width logo-text logo-color logo-line-height logo-letter-spacing className ID
    //Set Layout Column
    $(document).on('click', '.column-layout', function (event) {
        event.preventDefault();
        layouttype = $(this).data('layout');
        if (layouttype == 'custom') {
            column = prompt('Enter your custom layout like 2,2,2,2,2,2 as total 12 grid', '2,2,2,2,2,2');
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
        row_box.attr('data-layout', layout_str);
        var old_columns = $(row_box).find('.layout-column');
        if (layout_str == '12')
            var new_columns = ['12'];
        else
            var new_columns = layout_str.split(',');
        var n_old_columns = old_columns.length;
        var n_new_columns = new_columns.length;
        row_columns.empty();
        $.each(new_columns, function (index, value) {
            var old_col_datas = old_columns.eq(index).data();
            //console.log(old_col_datas['custom_class']);
            if (index < n_old_columns) {
                var html = '<div class="layout-column col-lg-' + value;
                if (old_col_datas['md_col']) html += ' ' + old_col_datas['md_col'];
                if (old_col_datas['sm_col']) html += ' ' + old_col_datas['sm_col'];
                if (old_col_datas['xs_col']) html += ' ' + old_col_datas['xs_col'];
                html += '"';
                if (old_col_datas['background_attachment']) html += ' data-background_attachment="' + old_col_datas['background_attachment'] + '"';
                if (old_col_datas['background_position']) html += ' data-background_position="' + old_col_datas['background_position'] + '"';
                if (old_col_datas['background_repeat']) html += ' data-background_repeat="' + old_col_datas['background_repeat'] + '"';
                if (old_col_datas['background_size']) html += ' data-background_size="' + old_col_datas['background_size'] + '"';
                if (old_col_datas['background_img']) html += ' data-background_img="' + old_col_datas['background_img'] + '"';
                if (old_col_datas['xs_col']) html += ' data-xs_col="' + old_col_datas['xs_col'] + '"';
                if (old_col_datas['sm_col']) html += ' data-sm_col="' + old_col_datas['sm_col'] + '"';
                if (old_col_datas['md_col']) html += ' data-md_col="' + old_col_datas['md_col'] + '"';
                if (old_col_datas['custom_class']) html += ' data-custom_class="' + old_col_datas['custom_class'] + '"';
                html += '><div class="column">' + old_columns.eq(index).find('.column').html() + '</div><div class="col-tools"><a href="#" class="column-setting pull-right label-tooltip" data-original-title="Column Setting"><i class="fa fa-cog"></i><span>Setting</span></a><a href="#" class="add-addon pull-right label-tooltip" data-original-title="Add Addons/Modules"><i class="fa fa-plus-circle"></i><span>Addons</span></a>' + '</div></div>';
            } else
                var html = '<div class="layout-column col-lg-' + value + '"><div class="column"></div><div class="col-tools"><a href="#" class="column-setting pull-right label-tooltip" data-original-title="Column Setting"><i class="fa fa-cog"></i><span>Setting</span></a><a href="#" class="add-addon pull-right label-tooltip" data-original-title="Add Addons/Modules"><i class="fa fa-plus-circle"></i><span>Addons</span></a>' + '</div></div>';
            row_columns.append(html);
        });
        if (n_old_columns > n_new_columns)
            for (i = n_new_columns; i < n_old_columns; i++)
                row_columns.find('.column').eq(n_new_columns - 1).append(old_columns.eq(i).find('.column').html());

        UiSort();
        item_draggable();
    });
    //Add Addon
    $(document).on('click', '.add-addon', function (event) {
        event.preventDefault();
        $('#modal-addons .addon-filter ul li').removeClass('active').first().addClass('active');
        $('.layout-column').removeClass('column-active');
        $(this).parent().parent().addClass('column-active');
        var $_html = $('.hidden .pagebuilder-addons').clone(true);
        $('#modal-addons').find('.jms-modal-body').empty();
        $('#modal-addons').find('.jms-modal-body').html($_html);
        $('#modal-addons').modal();
    });

    //Remove Addon
    $(document).on('click', '.remove-addon', function (event) {
        event.preventDefault();
        if (confirm("Click Ok button to delete Block, Cancel to leave.") == true) {
            $(this).closest('.element-item').slideUp(200, function () {
                $(this).remove();
            });
        }
    });
    //Duplicate Addon
    $(document).on('click', '.duplicate-addon', function (event) {
        event.preventDefault();
        var $clone = $(this).closest('.element-item').clone();
        $(this).closest('.column').append($clone);
    });
    //Duplicate Addon
    $(document).on('click', '.duplicate-row', function (event) {
        event.preventDefault();
        $('.row').removeClass('row-active');
        $(this).closest('.row').addClass('row-active');
        var $clone = $('.row-active').clone();
        $clone.removeClass('row-active');
        $('.hb-content').append($clone);
        UiSort();
        item_draggable();
    });
    //Remove Addon
    $(document).on('click', '.remove-row', function (event) {
        event.preventDefault();
        if (confirm("Click Ok button to delete Row, Cancel to leave.") == true) {
            $(this).closest('.row').slideUp(200, function () {
                $(this).remove();
            });
        }
    });

    //Get color picker
    $(document).ready(function () {
        $('.color-field').wpColorPicker();
    });
    //Add logo Imgae button
    $(document).on('click', '#add-image', function (e) {
        var frame;
        var selector = e.currentTarget;
        e.preventDefault();
        var $input = $(selector).parent().find("input.input-file");
        if (frame) {
            frame.open();
            return;
        }
        // Create a new media frame
        frame = wp.media({
            title: 'Select Image Layer',
            button: {text: 'Use this media'},
            multiple: false
        });

        //When an image is selected in media frame...
        frame.on('select', function () {
            var attachment = frame.state().get("selection").first();
            $input.val(attachment.attributes.url).trigger("change");
            $('#logo_img').attr('src', $input.val());
            $('#row_bg').attr('src', $input.val());
            $('#col_bg').attr('src', $input.val());
        });
        frame.open();
    });
    $(document).on('click', '.remove-img', function (e) {
        var this_form = $(this).closest('.form-group');

        this_form.find("input[name='background-img']").val('');
        this_form.find("#row_bg").attr('src', "");

        this_form.find("input[name='logo-image-url']").val('');
        this_form.find("#logo_img").attr('src', "");
    });
    // ------
    function item_draggable() {
        var row_item = $(".hb-list-element .element-item"),
            row_sortable = $(".layout-column .column");
        row_item.draggable({
            connectToSortable: row_sortable,
            helper: "clone",
            revert: "invalid"
        });
        row_item.disableSelection();
    }

    function getLayout() {
        var config = [];
        var rows = $('.hb-content').find('.row');
        rows.removeClass('row-active');
        rows.each(function (index) {
            var $row = $(this),
                rowIndex = index,
                rowObj = $row.data();
            delete rowObj.sortableItem;
            var layout = 12;
            layout = $row.data('layout');
            config[rowIndex] = {
                'type': 'row',
                'name': $(this).data('name'),
                'layout': layout,
                'settings': rowObj,
                'cols': []
            };
            // Find Column Elements
            var columns = $row.find('.layout-column');
            columns.removeClass('column-active');
            columns.each(function (cindex) {
                var $column = $(this),
                    colIndex = cindex,
                    className = $column.attr('class'),
                    colObj = $column.data();
                delete colObj.sortableItem;
                config[rowIndex].cols[colIndex] = {
                    'type': 'column',
                    'className': className,
                    'settings': colObj,
                    'addons': []
                };
                // Find Addon Elements
                var addons = $column.find('.header-item');
                addons.removeClass('addon-active');
                addons.each(function (aindex) {
                    var $addon = $(this),
                        addonIndex = aindex,
                        addonObj = $addon.data();
                    delete addonObj.sortableItem;
                    config[rowIndex].cols[colIndex].addons[addonIndex] = {
                        'addon_name': $addon.data('item'),
                        'icon_class': $addon.children().attr('class'),
                        'fields': []
                    };
                    var addoninputs = $addon.find('.hb-input-group .addon-input');
                    addoninputs.each(function (aiindex) {
                        var $input = $(this),
                            addoninputIndex = aiindex;
                        var ip_name = $input.data('bind')
                        var val_result = $input.val();
                        config[rowIndex].cols[colIndex].addons[addonIndex].fields[addoninputIndex] = {
                            'name': ip_name,
                            'value': val_result
                        };
                    });
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

    $(document).on('click', '#btn-save-header', function (event) {
        var param = getLayout();
        var j = JSON.stringify(param);
        //console.log(j);
        $("textarea#data-header").text(j);
        $("#publish").trigger("click");

    });

})(jQuery);



