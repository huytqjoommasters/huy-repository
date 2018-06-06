jQuery(document).ready(function ($) {
    var datakeys = ['title', 'type', 'text', 'url', 'class', 'delay', 'time', 'x', 'y', 'layerwidthtext', 'layerheighttext', 'z_index', 'width', 'height', 'in', 'out', 'ease_in', 'ease_out', 'transform_in', 'transform_out', 'step', 'special', 'autoplay', 'loop', 'controls', 'videobg', 'videotype', 'videoid', 'fontsize', 'textcolor', 'align', 'offset', 'fontstyle', 'fontweight', 'link', 'letterspacing', 'texttransform', 'mx', 'my', 'mletterspacing', 'malign', 'mfontsize', 'moffset', 'mfontweight', 'mtexttransform', 'mlineheight',];
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
            var media_url = attachment['url'].replace($('#site_url').val(), "");
            jQuery('#image_url').val(media_url);
            displayImg.append('<img src="' + attachment.url + '" alt="" style="width: 100%" />');
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
    jQuery(document).ready(function () {
        layerListClick();

        jQuery("#edit-layer-btn").data('flag', $("#frame_layer .active").data("type") );
        jQuery("#edit-layer-btn").click(function () {
            var flag = $(this).data('flag');
            switch (flag){
                case 'text':
                    $('.jms-wrap-model.add_text_layer').show('400');
                    break;
                case 'link':
                    break;
                case 'image':
                    break;
                case 'video':
                    break;
                default:
                    alert('You are doing somethings wrongs. Try again');
            }
        });
    });

    /* */
    function layerListClick() {
        jQuery('#quick-layers-list > li').each(function (){
            jQuery(this).click(function (event) {
                var li_text = jQuery(this).data("text");
                var li_url = jQuery(this).data("url");
                jQuery(this).closest('.layers-list').find('#button_show_all_layer > #the_current-editing-layer-title').val(li_text);
                jQuery('#frame_layer .tp-caption.active').removeClass('active');
                jQuery('#frame_layer .tp-caption').each(function (index) {
                    if (jQuery(this).data("text") == li_text || (jQuery(this).data("url") == li_url && li_url !== undefined)) {
                        jQuery(this).addClass('active');
                    }
                });
                if (jQuery(this).data("type") == 'link') {
                    $('.linkurl').show();
                } else {
                    $('.linkurl').hide();
                }
                jQuery("#edit-layer-btn").data('flag', jQuery(this).data("type"));
                loadData(jQuery(this));
            });
        });
    }

    jQuery('#the_current-editing-layer-title').change(function (e) {
        var value = jQuery(this).val();
        jQuery('#frame_layer .active').html(value);
        jQuery('#frame_layer .active').attr("data-text", value);
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
        console.log(config);
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

        list_event();
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
                    $('.video-settings').show();
                } else {
                    $('.video-settings').hide();
                }
                if ($(this).attr('data-type') == 'text') {
                    $('.text-area').show();
                    $('.linkurl').hide();
                } else if ($(this).attr('data-type') == 'link') {
                    $('.text-area').show();
                    $('.linkurl').show();
                } else {
                    $('.text-area').hide();
                }

                var _index = $(".tp-caption").index($(this));
                $('#time-line li').removeClass('active');
                $('#time-line li').eq(_index + 1).addClass('active');
            }
            var txt = $('.tp-caption.active').data('text');
            jQuery("#the_current-editing-layer-title").val(txt);
        });
        jQuery('.layer-data').change(function (e) {
            var name = $(this).attr("name");
            var value = $(this).val();
            $('#frame_layer .active').eq(0).attr('data-' + name, value);
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
                    jQuery('#frame_layer .active iframe').attr('width', $('#layer_width').val() + 'px');
                    jQuery('#frame_layer .active iframe').attr('height', $('#layer_height').val() + 'px');
                    jQuery('#frame_layer .active').css('left', $('#layer_x').val() + 'px');
                    jQuery('#frame_layer .active').css('top', $('#layer_y').val() + 'px');
                }
            if (name == 'width' && $('#layer_videobg').val() != 1) {
                jQuery('#frame_layer .active iframe').attr('width', value + 'px');
                jQuery('#frame_layer .active').css('width', 'auto');
            }
            if (name == 'height' && $('#layer_videobg').val() != 1) {
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
                jQuery('#frame_layer .active').css('line-height', value);
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
                var layer_align = $('#layer_align').val();
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
                var Stoppos = $(this).position();
                $('#layer_x').val(Math.round(Stoppos.left));
                $('#layer_y').val(Math.round(Stoppos.top));
                $(this).attr('data-x', Math.round(Stoppos.left));
                $(this).attr('data-y', Math.round(Stoppos.top));	//truyen bien len input
                var mx = Math.round(Stoppos.left);
                var my = Math.round(Stoppos.top);
                dl = jQuery('#frame_layer'),
                    l = parseInt(dl.offset().left, 0) - parseInt(jQuery('#wrap-slider').offset().left, 0);
                $('#verlinie').css({left: mx + l + "px"});
                $('#horlinie').css({top: my + 38 + "px"});
                $('#verlinetext').html(mx);
                $('#horlinetext').html(my);
            }
        });
        jQuery('.delay-time').resizable({
            handles: 'e',
            stop: function (event, ui) {
                var _index = parseInt($(this).closest('li').attr('data-index'));
                $('.tp-caption').eq(_index).attr('data-delay', $(this).width() * 10);
                if ($('.tp-caption').eq(_index).hasClass('active')) {
                    $('#layer_delay').val($(this).width() * 10);
                } else {
                    $('.tp-caption').eq(_index).trigger("click");
                }
            },
            resize: function (event, ui) {
                $('#mastertimer-curtimeinner').html($(this).width() * 10 + 'ms');
                $('#mastertimer-curtime').css('left', $(this).width() + 'px');
            }

        });
        jQuery('.layer-time').resizable({
            handles: 'e',
            stop: function (event, ui) {
                var _index = $(this).closest('li').attr('data-index');
                $('.tp-caption').eq(_index).attr('data-time', $(this).width() * 10);
                if ($('.tp-caption').eq(_index).hasClass('active')) {
                    $('#layer_time').val($(this).width() * 10);
                } else {
                    $('.tp-caption').eq(_index).trigger("click");
                }
            },
            resize: function (event, ui) {
                $('#mastertimer-curtimeinner').html($(this).width() * 10 + 'ms');
                $('#mastertimer-curtime').css('left', $(this).width() + 'px');
            }
        });
        jQuery('.mastertimer-layer').click(function (e) {
            var _index = $(this).attr('data-index');
            $('.tp-caption').eq(_index).trigger("click");
        });
    }

    jQuery('#duplicate-layer').click(function (e) {
        if ($("#frame_layer .active").length == 0) {
            alert('Please click to Layer box to choose one Layer to copy!');
            return false;
        }
        $("#frame_layer .active").clone().removeClass('active').appendTo("#frame_layer");
        list_event();
    });
    jQuery('#del-layer').click(function () {
        if ($("#frame_layer .active").length == 0) {
            alert('Please click to Layer box to choose one Layer to delete!');
            return false;
        }
        var c = confirm('Are you sure want to delete this layer?');
        if (!c) {
            return false;
        } else {
            var li_text = $("#frame_layer .active").data("text");
            var li_url = $("#frame_layer .active").data("url");
            $("#quick-layers-list li").each(function (index) {
                if ($(this).data("text") == li_text || ($(this).data("url") !== undefined && $(this).data("url") == li_url)) {
                    $(this).remove();
                }
            });
            var _index = $(".tp-caption").index($("#frame_layer .active").eq(0));
            $("#frame_layer .active").remove();
            //delete timeline

            $('#time-line li.mastertimer-layer').each(function (index) {
                if ($(this).attr('data-index') == _index) {
                    $(this).remove();
                    $('#timeline-title li').eq(_index).remove();
                }
            });
            //reorder index
            $('#time-line li.mastertimer-layer').each(function (index) {
                $(this).attr('data-index', index);
            });
        }
    });
    jQuery('#save-layers').click(function (e) {
        var params = JSON.stringify(getLayersJson());
        $('#layersjson').val(params);
        var layersForm = document.layersForm;
        layersForm.submit();
        return false;
    });


    /**
     *
     * Add Layer Event
     *
     */
    jQuery('#jms-dialog .close').click(function (event) {
        event.preventDefault();
        $('.jms-wrap-model').hide('400');
    });
    jQuery('#add-layer-wrap').mouseover(function (e) {
        $('.add-layer-list').show();
    });
    jQuery('#add-layer-wrap').mouseleave(function (e) {
        $('.add-layer-list').hide();
    });
    jQuery('#add-text').click(function (e) {
        $('.jms-wrap-model.add_text_layer').show('400');
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
        var tpl_caption = $('<div />', {
            'class': 'tp-caption ui-draggable ui-draggable-handle'
        });
        tpl_caption.html(text_layer);
        tpl_caption.attr('data-title', title);
        tpl_caption.attr('data-type', 'text');
        tpl_caption.attr('data-text', text_layer);
        jQuery('#frame_layer').append(tpl_caption);

        var layers_list = $('<li />');
        layers_list.html(text_layer);
        layers_list.attr('data-type', 'text');
        layers_list.attr('data-text', text_layer);
        jQuery('#quick-layers-list').append(layers_list);
        layerListClick();
        $('.jms-wrap-model').hide('400');
        var _index = $('.tp-caption').index(tpl_caption);
        loadTimeLines();
        list_event();
        return false;
    });
    jQuery('#add-link').click(function (e) {
        $('.jms-wrap-model.add_link_layer').show('400');
    });
    // Submit link
    jQuery('#submitLayerLink').click(function () {
        id_slider = jQuery('#id_slider').val();
        title = jQuery('#title_link_new').val();
        text_layer = jQuery('#link_text').val();
        var tpl_caption = $('<div />', {
            'class': 'tp-caption ui-draggable ui-draggable-handle'
        });
        var captionlink = $("<a></a>").text(text_layer);
        tpl_caption.append(captionlink);
        captionlink.attr('href', jQuery('#link_url').val());
        tpl_caption.attr('data-title', title);
        tpl_caption.attr('data-type', 'link');
        tpl_caption.attr('data-text', text_layer);
        tpl_caption.attr('data-link', jQuery('#link_url').val());
        jQuery('#frame_layer').append(tpl_caption);
        $('.jms-wrap-model').hide('400');
        var _index = $('.tp-caption').index(tpl_caption);
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
        $('.jms-wrap-model.add_video_layer').show('400');
    });

    //submit add video layer
    jQuery('#submitLayerVideo').click(function (e) {
        var video_url = $('#data_video_new').val();
        var video = parseVideo(video_url);
        var tpl_caption = $('<div />', {
            'class': 'tp-caption ui-draggable ui-draggable-handle'
        });
        tpl_caption.attr('data-title', $('#title_video_new').val());
        tpl_caption.attr('data-type', 'video');
        tpl_caption.attr('data-videotype', video['type']);
        tpl_caption.attr('data-videoid', video['id']);
        tpl_caption.attr('data-width', 500);
        tpl_caption.attr('data-height', 300);
        tpl_caption.attr('data-autoplay', 1);
        tpl_caption.attr('data-loop', 0);
        tpl_caption.attr('data-controls', 0);
        tpl_caption.attr('data-videobg', 0);
        if (video['type'] == 'youtube') {
            tpl_caption.html('<i class="dashicons dashicons-move" title="Keep mouse to move" ></i><iframe src="http://www.youtube.com/embed/' + video['id'] + '?autoplay=1&loop=1" allowfullscreen frameborder="0" />');
        } else if (video['type'] == 'vimeo') {
            tpl_caption.html('<i class="dashicons dashicons-move" title="Keep mouse to move" ></i><iframe src="https://player.vimeo.com/video/' + video['id'] + '?autoplay=1&loop=1" allowfullscreen frameborder="0" />');
        } else {
            alert('Video Type must be Youtube or Vimeo');
            return false;
        }
        jQuery('#frame_layer').append(tpl_caption);
        $('.jms-wrap-model.add_video_layer').hide('400');
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
            var media_url = attachment['url'].replace($('#root_url').val(), "");
            var tpl_caption = $('<div />', {
                'class': 'tp-caption ui-draggable ui-draggable-handle'
            });
            tpl_caption.html('<img src="' + attachment['url'] + '" />');
            tpl_caption.attr('data-title', attachment['title']);
            tpl_caption.attr('data-type', 'image');
            tpl_caption.attr('data-url', media_url);
            jQuery('#frame_layer').append(tpl_caption);
            list_event();
        });
        frame.open();
    });
    list_event();
    horRuler();
    drawRuler();
    loadTimeLines();
    $('.tp-caption').eq(0).trigger("click");
});