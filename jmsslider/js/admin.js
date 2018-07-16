jQuery(document).ready(function ($) {
    var datakeys = ['title', 'type', 'text', 'url', 'attachment_id', 'img_id', 'visibility', 'class', 'delay', 'time', 'x', 'y', 'layerwidthtext', 'layerheighttext', 'z_index', 'width', 'height', 'in', 'out', 'ease_in', 'ease_out', 'transform_in', 'transform_out', 'step', 'special', 'autoplay', 'loop', 'controls', 'videobg', 'videotype', 'videoid', 'fontsize', 'textcolor', 'align', 'offset', 'fontstyle', 'fontweight', 'link', 'letterspacing', 'texttransform', 'mobile-x', 'mobile-y', 'mobile-letterspacing', 'mobile-align', 'mobile-fontsize', 'mobile-offset', 'mobile-fontweight', 'mobile-texttransform', 'mobile-lineheight', 'mobile-visibility', 'tablet-x', 'tablet-y', 'tablet-letterspacing', 'tablet-align', 'tablet-fontsize', 'tablet-offset', 'tablet-fontweight', 'tablet-texttransform', 'tablet-lineheight', 'tablet-visibility'];
    jQuery('.jms-delete-item').click(function () {
        var c = confirm('Are you sure want to delete this item?');
        if (!c) {
            return false;
        }
    });
    jQuery('.color-picker').wpColorPicker({
        change: function (event, ui) {
            var element = event.target;
            var color = ui.color.toString();
            $('#frame_layer .active').eq(0).attr('data-textcolor', color);
            $('#frame_layer .active').eq(0).css('color', color);
        },
    });
    jQuery('.layer-data').tipsy();
    jQuery('.add_list_slider .ui-sortable').sortable();

    var frame;
    var displayImg = jQuery('#frame_layer_image');
    var imgIdInput = jQuery('#image_input');

    jQuery('#pick_images').click(function (event) {
        event.preventDefault();
        if (frame) {
            frame.open();
            return;
        }

        // Create a new media frame
        frame = wp.media({
            title: 'Select Image Slider',
            button: {text: 'Use this media'},
            multiple: false
        });

        //When an image is selected in media frame...
        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            var media_url = attachment['url'].replace($('#root_url').val(), "");
            jQuery('#image_url').val(media_url);
            displayImg.append('<img src="' + attachment.url + '" alt="" style="width: 100%" />');
            var ip_type = jQuery("input[name='bg_type']:checked").val();
            if( ip_type == 'image' ) {
                jQuery("#frame_layer").css( "background-color", 'none' );
                jQuery("#frame_layer").css( "background-image", 'url('+ attachment['url'] +')' );
            }
        });
        frame.open();
    });

    /**
     *
     * Set bg color
     *
     */
    var myOptions = {
        // you can declare a default color here,
        // or in the data-default-color attribute on the input
        defaultColor: false,
        // a callback to fire whenever the color changes to a valid color
        change: function (event, ui) {

        },

        clear: function () {
        },
        // hide the color picker controls on load
        hide: true,
        // show a group of common colors beneath the square
        // or, supply an array of colors to customize further
        palettes: true
    };
    $('.pick_color').wpColorPicker(myOptions);


    // Update shortcode from alias value

    var updateShortcode = function () {
        var alias = jQuery('.jmsslider #alias').val();
        var shortcode = '[jmsslider alias="' + alias + '"]';

        if (alias == '') {
            var shortcode = '-- wrong alias --';
        }
        jQuery('.jmsslider #shortcode-alias').val(shortcode);
    }

    jQuery('.jmsslider #alias').change(function () {
        updateShortcode();
    });

    jQuery('.jmsslider #alias').keyup(function () {
        updateShortcode();
    });

    /* Show List Layer click */
    jQuery('#button_show_all_layer > i.dashicons-menu').click(function (event) {
        jQuery(this).closest('.layers-list').find('#quick-layers-wrapper').toggleClass('show-list');
    });
    jQuery(document).ready(function(){
        jQuery("#layer_type").val( jQuery("#frame_layer .active").data("type") );
        jQuery("#layer_title").val( jQuery("#frame_layer .active").data("title") );
        jQuery("#layer_text").val( jQuery("#frame_layer .active").data("text") );
        if (jQuery("#layer_type").val() == 'image') {
            jQuery("#layer_attachment_id").val(jQuery("#frame_layer .active").data("attachment_id"));
        }
        if (jQuery("#layer_type").val() == 'link') {
            jQuery("#layer_url").val(jQuery("#frame_layer .active").data("link"));
        }

        if( bg_type == 'image') {
            jQuery("#bg_image").prop('checked', true);
        } else {
            jQuery("#bg_color").prop('checked', true);
        }
        jQuery("input[name='bg_type']").change(function(){
            var ip_var = jQuery("input[name='bg_type']:checked").val();
            if (ip_var == "color") {
                var ip_color = jQuery(this).closest('.row-input').find("#bg_color.wp-color-picker").val();
                jQuery("#frame_layer").css("background-image", 'none');
                if( ip_color != "" ) {
                    jQuery("#frame_layer").css( "background-color", ip_color );
                }
                jQuery('.pick_color').wpColorPicker({
                    change: function (event, ui) {
                        var element = event.target;
                        var color = ui.color.toString();
                        jQuery("#frame_layer").css( "background-color", color );
                    },
                });
            } else {
                var ip_bg = jQuery("#image_url").val();
                var root_url = jQuery("#root_url").val();
                var img_url = root_url + ip_bg;
                if( ip_bg != "" ) {
                    jQuery("#frame_layer").css( "background-image", 'url('+img_url+')' );
                    jQuery("#frame_layer").css( "background-color", 'none' );
                }
            }
        });

        jQuery("#edit-layer-btn").on('click', function (e) {
            e.preventDefault();
            jQuery('#quick-layers-wrapper').removeClass('show-list');
            var flag = jQuery("#layer_type").val();
            switch (flag) {
                case 'text':
                    var this_setting = $('.jms-wrap-model.add_text_layer');
                    this_setting.find('#submitLayerText').hide();
                    this_setting.find('#updateLayerText').show();
                    this_setting.find('#title_text_new').val("");
                    this_setting.find('#text_layer').val("");
                    this_setting.find('#title_text_new').val(jQuery('#layer_title').val());
                    this_setting.find('#text_layer').val(jQuery('#layer_text').val());
                    jQuery('.jms-wrap-model.add_text_layer').show('400');
                    jQuery("#updateLayerText").click(function () {
                        var update_title = this_setting.find('#title_text_new').val();
                        var update_txt = this_setting.find('#text_layer').val();
                        jQuery('#frame_layer .active').html(update_txt);
                        jQuery('#frame_layer .active').attr("data-title", update_title);
                        jQuery('#frame_layer .active').attr("data-text", update_txt);

                        jQuery('#layer_title').val(update_title);
                        jQuery('#layer_text').val(update_txt);

                        loadData(jQuery('#frame_layer .active'));
                        $("#the_current-editing-layer-title").val(update_txt);
                        jQuery('#quick-layers-list > li').each(function (index) {
                            if ($(this).data('text') == jQuery("#layer_text").val()) {
                                $(this).attr("data-title", update_title);
                                $(this).attr("data-text", update_txt);
                                $(this).find('span').html(update_txt);
                            }
                        });
                        $('.jms-wrap-model').hide('400');
                    });
                    break;
                case 'link':
                    var this_setting = $('.jms-wrap-model.add_link_layer');
                    this_setting.find('#submitLayerLink').hide();
                    this_setting.find('#updateLayerLink').show();
                    this_setting.find("#title_link_new").val("");
                    this_setting.find("#link_text").val("");
                    this_setting.find("#link_url").val("");
                    this_setting.find('#title_link_new').val( jQuery('#layer_title').val() );
                    this_setting.find('#link_text').val( jQuery('#layer_text').val() );
                    this_setting.find('#link_url').val( jQuery('#layer_url').val() );
                    this_setting.show('400');
                    jQuery("#updateLayerLink").click(function () {
                        var update_title = this_setting.find('#title_link_new').val();
                        var update_txt = this_setting.find('#link_text').val();
                        var update_url = this_setting.find('#link_url').val();
                        jQuery('#frame_layer .active').html(update_txt);
                        jQuery('#frame_layer .active').attr("data-title", update_title);
                        jQuery('#frame_layer .active').attr("data-text", update_txt);
                        jQuery('#frame_layer .active').attr("data-link", update_url);
                        loadData(jQuery('#frame_layer .active'));
                        jQuery("#the_current-editing-layer-title").val(update_txt);

                        jQuery('#layer_title').val(update_title);
                        jQuery('#layer_text').val(update_txt);
                        jQuery('#layer_url').val(update_url);

                        jQuery('#quick-layers-list > li').each(function (index) {
                            if ($(this).data('text') == jQuery("#layer_text").val()) {
                                $(this).attr("data-title", update_title);
                                $(this).attr("data-text", update_txt);
                                $(this).attr("data-link", update_url);
                                $(this).find('span').html(update_txt);
                            }
                        });
                        $('.jms-wrap-model').hide('400');
                    });
                    break;
                case 'image':
                    var selected_id = $('#layer_attachment_id').val();
                    // Create a new media frame
                    frame = wp.media({
                        button: {text: 'Use this media'},
                        states: [
                            new wp.media.controller.Library({
                                title: 'Select Image Layer',
                                multiple: false
                            })
                        ]
                    });
                    frame.on('open', function () {
                        var selection = frame.state().get('selection');
                        selection.add(wp.media.attachment(selected_id));
                    });
                    frame.on('select', function () {
                        var attachment = frame.state().get('selection').first().toJSON();
                        var media_url = attachment['url'].replace(jQuery('#root_url').val(), "");
                        var tpl_caption = jQuery('#frame_layer .tp-caption.active');
                        tpl_caption.attr('data-title', attachment['title']);
                        tpl_caption.attr('data-type', 'image');
                        tpl_caption.attr('data-url', media_url);
                        tpl_caption.attr('data-attachment_id', attachment['id']);
                        tpl_caption.html('<img src="' + attachment['url'] + '" />');
                        jQuery("#layer_attachment_id").val( attachment['id'] );
                        jQuery('#quick-layers-list > li').each(function () {
                            if (jQuery(this).data("attachment_id") == selected_id) {
                                jQuery(this).attr('data-attachment_id', attachment['id']);
                                jQuery(this).attr('data-img_id', 'image-'+attachment['id']);
                            }
                        });
                        tpl_caption.find('img').attr('data-src', jQuery('#root_url').val() + media_url);
                        list_event();
                    });
                    frame.open();
                    break;
                default:
                    alert('You are doing somethings wrongs. Try again');
            }
        });
        /* Show layer */
        var layer_visibility = jQuery('#layer_visibility');
        layer_visibility.val( jQuery('#frame_layer .tp-caption.active').data('visibility') );
        if( layer_visibility.val() == 0) {
            jQuery("#show-layer").find('.dashicons-visibility').hide();
        } else {
            jQuery("#show-layer").find('.dashicons-hidden').hide();
        }

        jQuery('#show-layer').click(function (e) {
            layerBtnEvent(layer_visibility);
        });

        jQuery('#show-mobile-layer').on('click', function () {
            layerBtnEvent(layer_visibility);
        });
        jQuery('#show-tablet-layer').on('click', function () {
            layerBtnEvent(layer_visibility);
        });
        
        /* ------ */
        layerListClick();
        /* Responsive Button Event */
        jQuery(".tab > .tab-mobile").hide();
        jQuery(".tab > .tab-tablet").hide();
        jQuery(".tab > .video-settings").hide();


        jQuery(".responsive-list > li").on('click', function () {
            var res = jQuery(this).attr('id');
            var this_li = jQuery(this);
            responsive_tab(res, this_li);
            resize_slider(res, this_li);
            change_style(res, this_li);
            showLayerBtn(res);
        });
        /* ------ */
    });
    /* Responsive function */
    function responsive_tab($res, $this_li) {
        if( $this_li.is(':not(.active)') ) {
            jQuery(".responsive-list > li").removeClass('active');
            $this_li.addClass('active');
            jQuery(".tab > .tab-responsive").hide();
            jQuery(".tab > .tab-" + $res).show();
            jQuery(".tab > .tablinks").each(function () {
                jQuery(this).removeClass('active');
                if( jQuery(this).hasClass('tab-' + $res) ) {
                    jQuery(this).addClass('active');
                    jQuery('.inner > .tabcontent').css('display', 'none');
                    jQuery('#tab_style_' + $res).css('display', 'block');
                }
            });
        }
    }
    function resize_slider ($res, $this_li) {
        var sw = $(".slider-background").data("width");
        var sh = $(".slider-background").data("height");
        var th = $(".slider-background").data("tablet_height");
        var mh = $(".slider-background").data("mobile_height");
        if ( $res == 'mobile' ) {
            jQuery(".slider-background").css("width", 480);
            jQuery(".slider-background").css("height", mh);
        } else if( $res == 'tablet' ) {
            $(".slider-background").css("width", 991);
            $(".slider-background").css("height", th);
        } else {
            $(".slider-background").css("width", sw);
            $(".slider-background").css("height", sh);
        }
    }
    function change_style($res, $this_li) {
        var data = "";
        if( $res == 'mobile' || $res == 'tablet') {
            data = $res+'-';
        }
        var $_layers = jQuery('#frame_layer').find('.tp-caption');
        $_layers.each(function (index) {
            jQuery(this).css( "top", jQuery(this).data(data + "y") );
            jQuery(this).css( "left", jQuery(this).data(data + "x") );
            jQuery(this).css( "font-size", jQuery(this).data(data + "fontsize") );
            jQuery(this).css( "letter-spacing", jQuery(this).data(data + "letterspacing") );
            jQuery(this).css( "font-weight", jQuery(this).data(data + "fontweight") );
            jQuery(this).css( "text-transform", jQuery(this).data(data + "texttransform") );
            jQuery(this).css( "line-height", jQuery(this).data(data + "lineheight") + "px" );
        });
        $_layers.each(function (index) {
            jQuery(this).draggable({
                stop: function (event, ui) {
                    // Show dropped position.
                    var Stoppos = jQuery(this).position();
                    jQuery('#layer_'+data+'x').val(Math.round(Stoppos.left));
                    jQuery('#layer_'+data+'y').val(Math.round(Stoppos.top));
                    jQuery(this).attr('data-'+data+'x', Math.round(Stoppos.left));
                    jQuery(this).attr('data-'+data+'y', Math.round(Stoppos.top));	//truyen bien len input
                    jQuery(this).data(data+'x', Math.round(Stoppos.left));
                    jQuery(this).data(data+'y', Math.round(Stoppos.top));
                    var mx = Math.round(Stoppos.left);
                    var my = Math.round(Stoppos.top);
                    dl = jQuery('#frame_layer'),
                        l = parseInt(dl.offset().left, 0) - parseInt(jQuery('#wrap-slider').offset().left, 0);
                    jQuery('#verlinie').css({left: mx + l + "px"});
                    jQuery('#horlinie').css({top: my + 38 + "px"});
                    jQuery('#verlinetext').html(mx);
                    jQuery('#horlinetext').html(my);
                }
            });
            jQuery(this).css('opacity', 1 );
            if( jQuery(this).data(data+"visibility") == 0 ) {
                jQuery(this).css('opacity', 0.3 );
            }
        });
        var input_type = "";
        if( $res == 'mobile' || $res == 'tablet') {
            input_type = '-' + $res;
        }
        jQuery('.layer-data'+input_type).change(function (e) {
            var name = jQuery(this).attr("name");
            var value = jQuery(this).val();
            jQuery('#frame_layer .active').eq(0).attr('data-' + name, value);
            if (name == data+'x') {
                jQuery('#frame_layer .active').css('left', value + 'px');
            }
            if (name == data+'y')
                jQuery('#frame_layer .active').css('top', value + 'px');
            if (name == data+'fontsize')
                jQuery('#frame_layer .active').css('font-size', value + 'px');
            if (name == data+'letterspacing')
                jQuery('#frame_layer .active').css('letter-spacing', value + 'px');
            if (name == data+'fontweight')
                jQuery('#frame_layer .active').css('font-weight', value);
            if (name == data+'texttransform')
                jQuery('#frame_layer .active').css('text-transform', value);
            if (name == data+'lineheight')
                jQuery('#frame_layer .active').css('line-height', value + 'px');
            if (name == data+'visibility') {
                if ( jQuery(this).val() == 0 ) {
                    jQuery('#frame_layer .active').css('opacity', 0.3 );
                } else {
                    jQuery('#frame_layer .active').css('opacity', 1 );
                }
            }
        });
    }
    function showLayerBtn($res) {
        jQuery('.show-layer-btn').hide();
        if ($res == 'tablet' || $res == 'mobile') {
            var data = $res + '-';
        }
        if( $res == 'desktop' ) {
            var data = '';
        }
        jQuery('#frame_layer .tp-caption').each(function (e) {
            if( jQuery(this).data(data+ 'visibility') == 1 ) {
                jQuery(this).css('opacity', 1);
                jQuery('#show-'+data+'layer').find('.dashicons-hidden').hide();
                jQuery('#show-'+data+'layer').find('.dashicons-visibility').show();
            } else {
                jQuery(this).css('opacity', 0.3);
                jQuery('#show-'+data+'layer').find('.dashicons-hidden').show();
                jQuery('#show-'+data+'layer').find('.dashicons-visibility').hide();
            }
        });
        jQuery('#show-'+data+'layer').show();
        var layer_visibility = jQuery('#layer_visibility');
        layer_visibility.val("");
        layer_visibility.val( jQuery('#frame_layer .tp-caption.active').data(data+'visibility') );
        if( layer_visibility.val() == 0) {
            jQuery('#show-'+data+'layer').find('.dashicons-visibility').hide();
            jQuery('#show-'+data+'layer').find('.dashicons-hidden').show();
        } else {
            jQuery('#show-'+data+'layer').find('.dashicons-hidden').hide();
            jQuery('#show-'+data+'layer').find('.dashicons-visibility').show();
        }
    }
    function layerBtnEvent (layer_visibility) {
        var $res = jQuery(".responsive-list > li.active").attr('id');
        var data = "";
        if( $res == 'mobile' || $res == 'tablet') {
            data = $res+'-';
            layer_visibility.val( jQuery('#frame_layer .tp-caption.active').data(data+'visibility') );
        }
        if( layer_visibility.val() == 0 ) {
            jQuery('#show-'+data+'layer').find('.dashicons-hidden').hide();
            jQuery('#show-'+data+'layer').find('.dashicons-visibility').show();
            layer_visibility.val(1);
            jQuery('#frame_layer .tp-caption.active').css('opacity', 1);
        } else {
            jQuery('#show-'+data+'layer').find('.dashicons-visibility').hide();
            jQuery('#show-'+data+'layer').find('.dashicons-hidden').show();
            layer_visibility.val(0);
            jQuery('#frame_layer .tp-caption.active').css('opacity', 0.3);
        }
        jQuery('#frame_layer .tp-caption.active').attr('data-'+data+'visibility',layer_visibility.val());
        jQuery('#frame_layer .tp-caption.active').data(data+'visibility',layer_visibility.val());
    }
    function changeLayerVis() {
        var layer_visibility = jQuery('#layer_visibility');
        layer_visibility.val( jQuery('#frame_layer .tp-caption.active').data('visibility') );
        var $res = jQuery(".responsive-list > li.active").attr('id');
        var data = "";
        if( $res == 'mobile' || $res == 'tablet') {
            data = $res+'-';
            layer_visibility.val( jQuery('#frame_layer .tp-caption.active').data(data+'visibility') );
        }
        if( layer_visibility.val() == 0) {
            jQuery('#show-'+data+'layer').find('.dashicons-visibility').hide();
            jQuery('#show-'+data+'layer').find('.dashicons-hidden').show();
        } else {
            jQuery('#show-'+data+'layer').find('.dashicons-hidden').hide();
            jQuery('#show-'+data+'layer').find('.dashicons-visibility').show();
        }
    }
    /* ----- */

    /* */
    function layerListClick() {
        jQuery('#quick-layers-list > li').each(function () {
            jQuery(this).click(function (event) {
                jQuery('#quick-layers-list > li').removeClass('active');
                var li_text = jQuery(this).data("text");
                var li_url = jQuery(this).data("url");
                var li_attachment_id = jQuery(this).data("attachment_id");
                var li_img_id = jQuery(this).data("img_id");
                var li_title = jQuery(this).data("title");
                var li_link = jQuery(this).data("link");
                jQuery(this).closest('.layers-list').find('#button_show_all_layer > #the_current-editing-layer-title').val(li_text);
                jQuery('#frame_layer .tp-caption.active').removeClass('active');
                jQuery('#frame_layer .tp-caption').each(function (index) {
                    if (jQuery(this).data("text") == li_text || (jQuery(this).data("img_id") == li_img_id && li_url !== undefined)) {
                        jQuery(this).addClass('active');
                    }
                });
                changeLayerVis();
                if (jQuery(this).data("type") == 'link') {
                    $('.linkurl').show();
                    jQuery("#layer_url").val( jQuery(this).data("link") );
                } else {
                    $('.linkurl').hide();
                }
                if (jQuery(this).data("type") == 'image' && li_attachment_id !== undefined) {
                    jQuery("#layer_url").val( li_url );
                    jQuery("#layer_attachment_id").val( li_attachment_id );
                    jQuery("#the_current-editing-layer-title").val("Image Layer");
                }
                jQuery("#layer_type").val(jQuery(this).data("type"));
                jQuery("#layer_text").val('text', li_text);
                jQuery("#layer_title").val('title', li_title);
                loadData(jQuery(this));
                jQuery("#edit-layer-btn").click(function () {
                    jQuery('#quick-layers-wrapper').removeClass('show-list');
                    var flag = jQuery("#layer_type").val();
                    switch (flag) {
                        case 'text':
                            var this_setting = $('.jms-wrap-model.add_text_layer');
                            this_setting.find('#title_text_new').val("");
                            this_setting.find('#text_layer').val("");
                            this_setting.find('#title_text_new').val(li_title);
                            this_setting.find('#text_layer').val(li_text);
                            this_setting.show('400');
                            break;
                        case 'link':
                            var this_setting = $('.jms-wrap-model.add_link_layer');
                            this_setting.find('#title_link_new').val("");
                            this_setting.find('#link_text').val("");
                            this_setting.find('#link_url').val("");
                            this_setting.find('#title_link_new').val(li_title);
                            this_setting.find('#link_text').val(li_text);
                            this_setting.find('#link_url').val(li_link);
                            this_setting.show('400');
                            break;
                    }
                });
                jQuery("#quick-layers-wrapper").removeClass('show-list');
                jQuery(this).addClass('active');
            });
        });
    }

    /* ------ */
    jQuery('#the_current-editing-layer-title').change(function (e) {
        if (jQuery('#frame_layer .active').data('type') == 'text' || jQuery('#frame_layer .active').data('type') == 'link') {
            var value = jQuery(this).val();
            jQuery('#frame_layer .active').html(value);
            jQuery('#frame_layer .active').attr("data-text", value);
            jQuery('#quick-layers-list > li').each(function () {
                if ( jQuery(this).data('text') == jQuery('#layer_text').val() ) {
                    jQuery(this).attr('data-text', value);
                    jQuery('#layer_text').val(value);
                    jQuery(this).find('span').html(value);
                }
            });
        }
    });
    /* ------ */
    updateShortcode();

    function resetFormData() {
        $.each(datakeys, function (key, value) {
            $('#layer_' + value).val('');
        });
    }

    function loadData(el) {
        $.each(datakeys, function (key, value) {
            $('#layer_' + value).val(el.attr('data-' + value));
            if (value == 'textcolor') {
                $('.color-picker').wpColorPicker('color', el.attr('data-' + value));
            }

        });
    }

    function getLayersJson() {
        var config = [];
        var $_layers = jQuery('#frame_layer').find('.tp-caption');
        $_layers.each(function (index) {
            var $_layer = jQuery(this),
                layerIndex = index;
            config[layerIndex] = {};
            $.each(datakeys, function (key, value) {
                var data_key = 'data-' + value;
                var data_val = $_layer.attr(data_key);
                if (data_val != null) {
                    config[layerIndex][value] = data_val;
                }
            });
        });
        //console.log(config);
        return config;
    }

    function getSlideJson() {
        var config = {};
        var $_setting = jQuery('.edit-form .option-block').find('.row-input');
        var arr = [];
        $_setting.each(function () {
            var $_input = jQuery(this).find('input');
            $_input.each(function(key, value){
                key = jQuery(this).attr("name");
                value = jQuery(this).val();
                if (key == 'bg_type') {
                    value = jQuery(this).val();
                    if ( jQuery(this).is(":checked") ) {
                        value = jQuery(this).val();
                    } else {
                        value = "";
                    }
                }
                if ( key !== undefined && value != "") {
                    config[key] = value;
                }
            });
        });
        return config;
    }

    function loadTimeLines() {
        //load layer timebars
        var li_fulltime = $('#time-line #fulltime').clone();
        $('#time-line ul').html('');
        $('#time-line ul').append(li_fulltime);
        var li_fulltimetitle = $('#fulltime-title').clone();
        $('#timeline-title').html('');
        $('#timeline-title').append(li_fulltimetitle);
        var $_layers = jQuery('#frame_layer').find('.tp-caption');
        $_layers.each(function (index) {
            var li_bar = $('<li />', {
                'class': 'mastertimer-layer'
            });
            li_bar.attr('data-index', index);
            var layer_time = $('<div />', {
                'class': 'layer-time'
            });
            var delay_time = $('<div />', {
                'class': 'delay-time'
            });
            delay_time.css('width', $(this).attr('data-delay') / 10 + 'px');
            layer_time.append(delay_time);
            if ($(this).attr('data-time'))
                layer_time.css('width', $(this).attr('data-time') / 10 + 'px');
            else
                layer_time.css('width', $('#slide-duration').val() / 10 + 'px');
            li_bar.append(layer_time);
            $('#time-line ul').append(li_bar);
            $('#timeline-title').append('<li>' + $(this).attr('data-title') + '</li>');
        });
        list_event();
    }

    function drawRuler() {
        var horl = jQuery('#hor-css-linear .linear-texts'),
            verl = jQuery('#ver-css-linear .linear-texts'),
            maintimer = jQuery('#mastertimer-linear .linear-texts');
        mw = jQuery('#mw').val();
        for (var i = -600; i < mw; i = i + 100) {
            if (mw - i < 100)
                horl.append('<li style="width:' + (mw - i) + 'px"><span>' + i + '</span></li>');
            else
                horl.append('<li><span>' + i + '</span></li>');
        }
        for (var i = 0; i < 2000; i = i + 100) {
            verl.append('<li><span>' + i + '</span></li>');
        }
        for (var i = 0; i < 160; i = i + 1) {
            var txt = i + "s";
            maintimer.append('<li><span>' + txt + '</span></li>');
        }

        //list_event();
    }

    function horRuler() {
        var dll = jQuery('#frame_layer');
        if (dll.length > 0) {
            var l = parseInt(dll.offset().left, 0) - parseInt(jQuery('#wrap-slider').offset().left, 0);
            jQuery('#hor-css-linear').css({backgroundPosition: (l) + "px 50%"});
            jQuery('#hor-css-linear .linear-texts').css({left: (l - 595) + "px"});
        }
    }

    function list_event() {
        jQuery('.tp-caption').click(function (e) {
            $('.tp-caption').removeClass('active');
            if (!$(this).hasClass('active')) {
                $(this).addClass('active');
                resetFormData();
                loadData($(this));
                if ($(this).attr('data-type') == 'video') {
                    jQuery('.video-settings').show();
                } else {
                    jQuery('.video-settings').hide();
                }
                if (jQuery(this).attr('data-type') == 'text') {
                    jQuery('.text-area').show();
                    jQuery('.linkurl').hide();
                } else if ($(this).attr('data-type') == 'link') {
                    jQuery('.text-area').show();
                    jQuery('.linkurl').show();
                }
                else {
                    jQuery('.text-area').hide();
                }

                var _index = $(".tp-caption").index($(this));
                $('#time-line li').removeClass('active');
                $('#time-line li').eq(_index + 1).addClass('active');
            }
            changeLayerVis();
            var active_obj = jQuery('.tp-caption.active');
            jQuery('#quick-layers-list > li').each(function () {
                jQuery(this).removeClass('active');

                if( active_obj.data('type') == 'text' && jQuery(this).data('text') == active_obj.data('text')  ) {
                    jQuery(this).addClass('active');
                }
                if( active_obj.data('type') == 'link' && jQuery(this).data('text') == active_obj.data('text')  ) {
                    jQuery(this).addClass('active');
                }
                if( active_obj.data('type') == 'image' && jQuery(this).data('img_id') == active_obj.data('img_id')  ) {
                    jQuery(this).addClass('active');
                }
            });

            jQuery( "#layer_type").val( jQuery('.tp-caption.active').data('type') );

            if ( jQuery( "#layer_type").val() == 'image') {
                jQuery("#the_current-editing-layer-title").val('Image Layer');
                jQuery("#layer_url").val(jQuery('.tp-caption.active').data('url'));
                if ($('.tp-caption.active').data('attachment_id') !== undefined) {
                    jQuery("#layer_attachment_id").val(jQuery('.tp-caption.active').data('attachment_id'));
                }
            } else if ( jQuery( "#layer_type").val() == 'text' ) {
                var txt = $('.tp-caption.active').data('text');
                jQuery("#the_current-editing-layer-title").val( jQuery(this).data('text') );
                jQuery('#layer_title').val( jQuery(this).data('title') );
                jQuery('#layer_text').val( jQuery(this).data('text') );
            } else if ( jQuery( "#layer_type").val() == 'link' ) {
                var txt = $('.tp-caption.active').data('text');
                jQuery("#the_current-editing-layer-title").val(txt);
                jQuery('#layer_title').val( jQuery('.tp-caption.active').data('title') );
                jQuery('#layer_text').val( jQuery('.tp-caption.active').data('text') );
                jQuery('#layer_url').val( jQuery('.tp-caption.active').data('link') );
            }
            else {
                jQuery("#the_current-editing-layer-title").val('Video Layer');
            }
            jQuery("#edit-layer-btn").click(function () {
                jQuery('#quick-layers-wrapper').removeClass('show-list');
                var flag = jQuery("#layer_type").val();
                switch (flag) {
                    case 'text':
                        var this_setting = jQuery('.jms-wrap-model.add_text_layer');
                        this_setting.find('#title_text_new').val("");
                        this_setting.find('#text_layer').val("");
                        this_setting.find('#title_text_new').val( jQuery('#layer_title').val() );
                        this_setting.find('#text_layer').val( jQuery('#layer_text').val() );
                        jQuery('.jms-wrap-model.add_text_layer').show('400');
                        break;
                }
            });
        });
        jQuery('.layer-data').change(function (e) {
            var name = jQuery(this).attr("name");
            var value = jQuery(this).val();
            jQuery('#frame_layer .active').eq(0).attr('data-' + name, value);
            if (name == 'x') {
                jQuery('#frame_layer .active').css('left', value + 'px');
            }
            if (name == 'y')
                jQuery('#frame_layer .active').css('top', value + 'px');
            if (name == 'videobg')
                if (value == 1) {
                    jQuery('#frame_layer .active iframe').attr('width', '100%');
                    jQuery('#frame_layer .active iframe').attr('height', '100%');
                    jQuery('#frame_layer .active').css('left', '0px');
                    jQuery('#frame_layer .active').css('top', '0px');
                    jQuery('#frame_layer .active').css('width', '100%');
                    jQuery('#frame_layer .active').css('height', '100%');
                } else {
                    jQuery('#frame_layer .active iframe').attr('width', jQuery('#layer_width').val() + 'px');
                    jQuery('#frame_layer .active iframe').attr('height', jQuery('#layer_height').val() + 'px');
                    jQuery('#frame_layer .active').css('left', jQuery('#layer_x').val() + 'px');
                    jQuery('#frame_layer .active').css('top', jQuery('#layer_y').val() + 'px');
                }
            if (name == 'width' && jQuery('#layer_videobg').val() != 1) {
                jQuery('#frame_layer .active iframe').attr('width', value + 'px');
                jQuery('#frame_layer .active').css('width', 'auto');
            }
            if (name == 'height' && jQuery('#layer_videobg').val() != 1) {
                jQuery('#frame_layer .active iframe').attr('height', value + 'px');
                jQuery('#frame_layer .active').css('height', 'auto');
            }
            if (name == 'z_index')
                jQuery('#frame_layer .active').css('z-index', value);
            if (name == 'text') {
                if (jQuery('#frame_layer .active').attr('data-type') == 'text')
                    jQuery('#frame_layer .active').html(value);
                else if (jQuery('#frame_layer .active').attr('data-type') == 'link')
                    jQuery('#frame_layer .active a').text(value);
            }
            if (name == 'link')
                jQuery('#frame_layer .active').attr('href', value);
            if (name == 'fontsize')
                jQuery('#frame_layer .active').css('font-size', value + 'px');
            if (name == 'fontstyle')
                jQuery('#frame_layer .active').css('font-style', value);
            if (name == 'fontweight')
                jQuery('#frame_layer .active').css('font-weight', value);
            if (name == 'texttransform')
                jQuery('#frame_layer .active').css('text-transform', value);
            if (name == 'letterspacing')
                jQuery('#frame_layer .active').css('letter-spacing', value + 'px');
            if (name == 'lineheight')
                jQuery('#frame_layer .active').css('line-height', value + 'px');
            if (name == 'align') {
                if (jQuery('#layer_offset').val() == '')
                    var layer_offset = 0;
                else
                    var layer_offset = parseInt(jQuery('#layer_offset').val());
                if (value == 'left') {
                    jQuery('#frame_layer .active').css('left', '0px');
                    jQuery('#frame_layer .active').attr('data-x', 0);
                    jQuery('#layer_x').val(0);
                } else if (value == 'right') {
                    var obj_width = jQuery('#frame_layer .active').outerWidth();
                    jQuery('#frame_layer .active').css('left', jQuery('#mw').val() - obj_width - layer_offset);
                    jQuery('#frame_layer .active').attr('data-x', jQuery('#mw').val() - obj_width - layer_offset);
                    jQuery('#layer_x').val(jQuery('#mw').val() - obj_width - layer_offset);
                } else if (value == 'center') {
                    var obj_width = jQuery('#frame_layer .active').outerWidth();
                    jQuery('#frame_layer .active').css('left', (jQuery('#mw').val() - obj_width) / 2 + layer_offset);
                    jQuery('#frame_layer .active').attr('data-x', (jQuery('#mw').val() - obj_width) / 2 + layer_offset);
                    jQuery('#layer_x').val((jQuery('#mw').val() - obj_width) / 2 + layer_offset);
                }
            }
            if (name == 'layerwidthtext') {
                if (value != '') {
                    jQuery('#frame_layer .active').css('width', value + 'px');
                }
                else {
                    jQuery('#frame_layer .active').css('width', 'auto');
                }
            }
            if (name == 'layerheighttext') {
                if (value != '') {
                    jQuery('#frame_layer .active').css('height', value + 'px');
                }
                else {
                    jQuery('#frame_layer .active').css('height', 'auto');
                }
            }
            if (name == 'offset') {
                if (value == '')
                    var layer_offset = 0;
                else
                    var layer_offset = parseInt(value);
                var layer_align = jQuery('#layer_align').val();
                if (layer_align == 'left') {
                    jQuery('#frame_layer .active').css('left', layer_offset);
                    jQuery('#frame_layer .active').attr('data-x', layer_offset);
                    jQuery('#layer_x').val(value);
                } else if (layer_align == 'right') {
                    var obj_width = jQuery('#frame_layer .active').outerWidth();
                    jQuery('#frame_layer .active').css('left', jQuery('#mw').val() - obj_width - layer_offset);
                    jQuery('#frame_layer .active').attr('data-x', jQuery('#mw').val() - obj_width - layer_offset);
                    jQuery('#layer_x').val(jQuery('#mw').val() - obj_width - layer_offset);
                } else if (layer_align == 'center') {
                    var obj_width = jQuery('#frame_layer .active').outerWidth();
                    jQuery('#frame_layer .active').css('left', (jQuery('#mw').val() - obj_width) / 2 + layer_offset);
                    jQuery('#frame_layer .active').attr('data-x', (jQuery('#mw').val() - obj_width) / 2 + layer_offset);
                    jQuery('#layer_x').val((jQuery('#mw').val() - obj_width) / 2 + layer_offset);
                }
            }
            if (name == 'transform_in' || name == 'transform_out') {
                jQuery('#frame_layer .active').addClass(value + ' animated');
                setTimeout(function () {
                    jQuery('#frame_layer .active').removeClass(value + ' animated');
                }, 2000);
            }
        });
        jQuery('.tp-caption').css('cursor', 'move');

        jQuery('.tp-caption').draggable({
            stop: function (event, ui) {
                // Show dropped position.
                var Stoppos = jQuery(this).position();
                jQuery('#layer_x').val(Math.round(Stoppos.left));
                jQuery('#layer_y').val(Math.round(Stoppos.top));
                jQuery(this).attr('data-x', Math.round(Stoppos.left));
                jQuery(this).attr('data-y', Math.round(Stoppos.top));	//truyen bien len input
                var mx = Math.round(Stoppos.left);
                var my = Math.round(Stoppos.top);
                dl = jQuery('#frame_layer'),
                    l = parseInt(dl.offset().left, 0) - parseInt(jQuery('#wrap-slider').offset().left, 0);
                jQuery('#verlinie').css({left: mx + l + "px"});
                jQuery('#horlinie').css({top: my + 38 + "px"});
                jQuery('#verlinetext').html(mx);
                jQuery('#horlinetext').html(my);
            }
        });
        jQuery('.delay-time').resizable({
            handles: 'e',
            stop: function (event, ui) {
                var _index = parseInt(jQuery(this).closest('li').attr('data-index'));
                jQuery('.tp-caption').eq(_index).attr('data-delay', jQuery(this).width() * 10);
                if (jQuery('.tp-caption').eq(_index).hasClass('active')) {
                    jQuery('#layer_delay').val(jQuery(this).width() * 10);
                } else {
                    jQuery('.tp-caption').eq(_index).trigger("click");
                }
            },
            resize: function (event, ui) {
                jQuery('#mastertimer-curtimeinner').html(jQuery(this).width() * 10 + 'ms');
                jQuery('#mastertimer-curtime').css('left', jQuery(this).width() + 'px');
            }
        });
        jQuery('.layer-time').resizable({
            handles: 'e',
            stop: function (event, ui) {
                var _index = jQuery(this).closest('li').attr('data-index');
                jQuery('.tp-caption').eq(_index).attr('data-time', jQuery(this).width() * 10);
                if (jQuery('.tp-caption').eq(_index).hasClass('active')) {
                    jQuery('#layer_time').val(jQuery(this).width() * 10);
                } else {
                    jQuery('.tp-caption').eq(_index).trigger("click");
                }
            },
            resize: function (event, ui) {
                jQuery('#mastertimer-curtimeinner').html(jQuery(this).width() * 10 + 'ms');
                jQuery('#mastertimer-curtime').css('left', jQuery(this).width() + 'px');
            }
        });
        jQuery('.mastertimer-layer').click(function (e) {
            e.preventDefault();
            var _index = jQuery(this).attr('data-index');
            jQuery('.tp-caption').eq(_index).trigger("click");
        });
    }

    jQuery('#duplicate-layer').click(function (e) {
        if (jQuery("#frame_layer .active").length == 0) {
            alert('Please click to Layer box to choose one Layer to copy!');
            return false;
        }
        var e_type = jQuery("#frame_layer .active").data("type");
        var obj_active = jQuery("#frame_layer .active");
        if( e_type == 'text' ) {
            obj_active.clone().html(obj_active.data('text') + ' coppy').attr('data-text', obj_active.data('text') + ' coppy').removeClass('active').appendTo("#frame_layer");
        } if(e_type == 'image') {
            obj_active.clone().attr('data-img_id', obj_active.data('img_id') + '-coppy').removeClass('active').appendTo("#frame_layer");
        }
        else {
            obj_active.clone().removeClass('active').appendTo("#frame_layer");
        }
        jQuery('#quick-layers-list li').each(function(){
            switch (e_type) {
                case 'text':
                    if( jQuery(this).data("text") == obj_active.data("text") ) {
                        jQuery(this).clone().html('<i class="dashicons dashicons-format-aside"></i><span>'+obj_active.data('text') + ' coppy'+'</span>').attr('data-text', obj_active.data('text') + ' coppy').removeClass('active').appendTo("#quick-layers-list");
                    }
                    break;
                case 'image':
                    if( jQuery(this).data("img_id") == jQuery("#frame_layer .active").data("img_id") ) {
                        jQuery(this).clone().attr('data-img_id', obj_active.data('img_id') + '-coppy').removeClass('active').appendTo("#quick-layers-list");
                    }
                    break;
            }
        });
        list_event();
    });
    jQuery('#del-layer').click(function () {
        if (jQuery("#frame_layer .active").length == 0) {
            alert('Please click to Layer box to choose one Layer to delete!');
            return false;
        }
        var c = confirm('Are you sure want to delete this layer?');
        if (!c) {
            return false;
        } else {
            var li_text = jQuery("#frame_layer .active").data("text");
            var li_url = jQuery("#frame_layer .active").data("url");
            var li_img_id = jQuery("#frame_layer .active").data("img_id");
            jQuery("#quick-layers-list li").each(function (index) {
                if (jQuery(this).data("text") == li_text || (jQuery(this).data("url") !== undefined && jQuery(this).data("url") == li_url) || (jQuery(this).data("img_id") !== undefined && jQuery(this).data("url") == li_img_id) ) {
                    jQuery(this).remove();
                }
            });
            var _index = jQuery(".tp-caption").index(jQuery("#frame_layer .active").eq(0));
            jQuery("#frame_layer .active").remove();
            //delete timeline

            jQuery('#time-line li.mastertimer-layer').each(function (index) {
                if (jQuery(this).attr('data-index') == _index) {
                    jQuery(this).remove();
                    jQuery('#timeline-title li').eq(_index).remove();
                }
            });
            //reorder index
            jQuery('#time-line li.mastertimer-layer').each(function (index) {
                jQuery(this).attr('data-index', index);
            });
        }
    });
    jQuery('#save-layers').click(function (e) {
        var layer_params = JSON.stringify(getLayersJson());
        var slide_params = JSON.stringify(getSlideJson());
        var slide_title = jQuery( "input[name='title']" ).val();
        console.log(layer_params);
        jQuery('#layersjson').val(layer_params);
        jQuery('#slidejson').val(slide_params);
        jQuery('#slidetitle').val(slide_title);
        var layersForm = document.layersForm;
        layersForm.submit();
        return false;
    });
    jQuery('#import_submit').click(function (e) {
        e.preventDefault();
        var importtForm = document.importtForm;
        importtForm.submit();
    });
    /* Import - Export */
    jQuery('.import-wrapper > a').on('click', function (e) {
        e.preventDefault();
        jQuery('.import-wrapper > #importtForm').toggleClass('active');
    });

    /**
     *
     * Add Layer Event
     *
     */
    jQuery('#jms-dialog .close').click(function (event) {
        event.preventDefault();
        jQuery('.jms-wrap-model').hide('400');
    });
    jQuery('#add-layer-wrap').mouseover(function (e) {
        jQuery('.add-layer-list').show();
    });
    jQuery('#add-layer-wrap').mouseleave(function (e) {
        jQuery('.add-layer-list').hide();
    });
    jQuery('#add-text').click(function (e) {
        jQuery(".jms-wrap-model.add_text_layer").find('#updateLayerText').hide();
        jQuery(".jms-wrap-model.add_text_layer").find('#submitLayerText').show();
        jQuery(".jms-wrap-model.add_text_layer").find("#title_text_new").val("");
        jQuery(".jms-wrap-model.add_text_layer").find("#text_layer").val("");
        jQuery('.jms-wrap-model.add_text_layer').show('400');
    });

    // Submit text
    jQuery('#submitLayerText').click(function () {
        id_slider = jQuery('#id_slider').val();
        title = jQuery('#title_text_new').val();

        if (jQuery("#wp-text_layer-wrap").hasClass("tmce-active")) {
            text_layer = tinyMCE.activeEditor.getContent();
        } else {
            text_layer = jQuery('#text_layer').val();
        }
        var tpl_caption = jQuery('<div />', {
            'class': 'tp-caption ui-draggable ui-draggable-handle'
        });
        tpl_caption.html(text_layer);
        tpl_caption.attr('data-title', title);
        tpl_caption.attr('data-type', 'text');
        tpl_caption.attr('data-text', text_layer);
        tpl_caption.attr('data-visibility', 1);
        tpl_caption.attr('data-tablet-visibility', 1);
        tpl_caption.attr('data-mobile-visibility', 1);
        jQuery('#frame_layer').append(tpl_caption);

        var layers_list = jQuery('<li data-type="text" data-text="' + text_layer + '"> <i class="dashicons dashicons-format-aside"></i> <span>' + text_layer + '</span> </li>');
        jQuery('#quick-layers-list').append(layers_list);
        layerListClick();
        jQuery('.jms-wrap-model').hide('400');
        var _index = jQuery('.tp-caption').index(tpl_caption);
        loadTimeLines();
        list_event();
        return false;
    });
    jQuery('#add-link').click(function (e) {
        jQuery(".jms-wrap-model.add_link_layer").find('#submitLayerLink').show();
        jQuery(".jms-wrap-model.add_link_layer").find('#updateLayerLink').hide();
        jQuery(".jms-wrap-model.add_link_layer").find("#title_link_new").val("");
        jQuery(".jms-wrap-model.add_link_layer").find("#link_text").val("");
        jQuery(".jms-wrap-model.add_link_layer").find("#link_url").val("");
        jQuery('.jms-wrap-model.add_link_layer').show('400');
    });
    // Submit link
    jQuery('#submitLayerLink').click(function () {
        id_slider = jQuery('#id_slider').val();
        title = jQuery('#title_link_new').val();
        text_layer = jQuery('#link_text').val();
        var tpl_caption = jQuery('<div />', {
            'class': 'tp-caption ui-draggable ui-draggable-handle'
        });
        var captionlink = jQuery("<a></a>").text(text_layer);
        tpl_caption.append(captionlink);
        captionlink.attr('href', jQuery('#link_url').val());
        tpl_caption.attr('data-title', title);
        tpl_caption.attr('data-type', 'link');
        tpl_caption.attr('data-text', text_layer);
        tpl_caption.attr('data-link', jQuery('#link_url').val());
        tpl_caption.attr('data-visibility', 1);
        jQuery('#frame_layer').append(tpl_caption);
        jQuery('.jms-wrap-model').hide('400');
        var _index = jQuery('.tp-caption').index(tpl_caption);
        loadTimeLines();
        list_event();
        return false;
    });

    function parseVideo(url) {
        url.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);

        if (RegExp.$3.indexOf('youtu') > -1) {
            var type = 'youtube';
        } else if (RegExp.$3.indexOf('vimeo') > -1) {
            var type = 'vimeo';
        }

        return {
            type: type,
            id: RegExp.$6
        };
    }

    //popup video layer
    jQuery('#add-video').click(function (e) {
        jQuery('.jms-wrap-model.add_video_layer').show('400');
    });

    //submit add video layer
    jQuery('#submitLayerVideo').click(function (e) {
        var video_url = jQuery('#data_video_new').val();
        var video = parseVideo(video_url);
        var tpl_caption = jQuery('<div />', {
            'class': 'tp-caption ui-draggable ui-draggable-handle'
        });
        tpl_caption.attr('data-title', jQuery('#title_video_new').val());
        tpl_caption.attr('data-type', 'video');
        tpl_caption.attr('data-videotype', video['type']);
        tpl_caption.attr('data-videoid', video['id']);
        tpl_caption.attr('data-width', 500);
        tpl_caption.attr('data-height', 300);
        tpl_caption.attr('data-autoplay', 1);
        tpl_caption.attr('data-loop', 0);
        tpl_caption.attr('data-controls', 0);
        tpl_caption.attr('data-videobg', 0);
        tpl_caption.attr('data-visibility', 1);
        if (video['type'] == 'youtube') {
            tpl_caption.html('<i class="dashicons dashicons-move" title="Keep mouse to move" ></i><iframe src="http://www.youtube.com/embed/' + video['id'] + '?autoplay=1&loop=1" allowfullscreen frameborder="0" />');
        } else if (video['type'] == 'vimeo') {
            tpl_caption.html('<i class="dashicons dashicons-move" title="Keep mouse to move" ></i><iframe src="https://player.vimeo.com/video/' + video['id'] + '?autoplay=1&loop=1" allowfullscreen frameborder="0" />');
        } else {
            alert('Video Type must be Youtube or Vimeo');
            return false;
        }
        jQuery('#frame_layer').append(tpl_caption);
        jQuery('.jms-wrap-model.add_video_layer').hide('400');
        list_event();
    });

    jQuery('#add-image').click(function (e) {
        e.preventDefault();
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
            var attachment = frame.state().get('selection').first().toJSON();
            var media_url = attachment['url'].replace(jQuery('#root_url').val(), "");
            var tpl_caption = jQuery('<div />', {
                'class': 'tp-caption ui-draggable ui-draggable-handle'
            });
            tpl_caption.html('<img src="' + attachment['url'] + '" />');
            tpl_caption.attr('data-title', attachment['title']);
            tpl_caption.attr('data-type', 'image');
            tpl_caption.attr('data-url', media_url);
            tpl_caption.attr('data-attachment_id', attachment['id']);
            tpl_caption.attr('data-img_id', 'image-'+attachment['id']);
            tpl_caption.attr('data-visibility', 1);
            jQuery('#frame_layer').append(tpl_caption);

            var clone_html = '<li data-attachment_id="'+attachment['id']+'" data-img_id="image-'+attachment['id']+'" data-type="image">' +
                '<i class="dashicons dashicons-format-image"></i>' +
                '                <span>Image layers</span> </li>';
            jQuery('#quick-layers-list').append(clone_html);
            list_event();
        });
        frame.open();
    });
    list_event();
    horRuler();
    drawRuler();
    loadTimeLines();
    jQuery('.tp-caption').eq(0).trigger("click");
});