(function (jQuery) {
    "use strict";

    jQuery.fn.extend({
        toggleOnCondition: function (condition) {
            if (condition)
                this.show();
            else
                this.hide();
        }
    });

   
    const colors = [
        ["primary_color", "--color-theme-primary"],
        ["secondary_color", "--color-theme-secondary"],
        ["title_color", "--global-font-title"],
        ["text_color", "--global-font-color"],
    ];
    const breadcrumb_contols = [
        ["breadcrumb_title_color", ".hopeui_style-breadcrumb .title", 'color', false],
        ["breadcrumb_bg_color", ".hopeui_style-breadcrumb", 'background-color', false],
        ["breadcrumb_bg_image", ".hopeui_style-breadcrumb", 'background-image', true, 'url'],

    ]
    jQuery(document).ready(function () {
        let wpPreviewRefresh = function () {
            wp.customize.preview.send('refresh');
        }
        // General Panel Binds


        wp.customize("container_width", function (control) {
            control.bind(function (controlValue) {
                jQuery("body").css("--content-width-sm", controlValue + "px");
            });
        });

        // Color Panel Binds

        colors.forEach(e => {
            wp.customize(e[0], function (control) {
                control.bind(function (controlValue) {
                    jQuery("body").css(e[1], controlValue);
                });
            });
        });


        // BreadCrumb Panel Binds

        breadcrumb_contols.forEach(colorControl => {
            wp.customize(colorControl[0], control => {
                control.bind(controlValue => {
                    jQuery(colorControl[1]).css(colorControl[2], !colorControl[3] ? controlValue : colorControl[4] + '(' + controlValue + ')');
                })
            });
        });

        // Header Panel Binds
        wp.customize('header_container').bind(() => {
            jQuery('header > div').toggleClass('container container-fluid');
        })
        wp.customize('header_postion').bind(() => {
            jQuery('body').toggleClass('hopeui_style-header-static hopeui_style-header-over');
        })
        wp.customize('display_search').bind((controlValue) => {
            let search = jQuery('header .search_count')
            search.length == 0 && wpPreviewRefresh();
            search.toggleOnCondition(controlValue);
        });

        wp.customize('header_background_color').bind((controlVal) => {
            jQuery('header').css('background-color', controlVal);
        })
        wp.customize('header_background_img').bind((controlVal) => {
            jQuery('header#default-header').css('background-image', 'url(' + controlVal + ')');
        });

        // Loader Value Bind
        wp.customize('hopeui_php_show_loader').bind((controlValue) => {
            let loader = jQuery('#loading')
            loader.length == 0 && wpPreviewRefresh();
            loader.toggleOnCondition(controlValue);
        });
        wp.customize('hopeui_php_loader_bg_color').bind((controlVal) => {
            jQuery('#loading').css('background-color',  controlVal );
        });
    });


    wp.customize.bind( 'preview-ready', function() {
        wp.customize.preview.bind('show_loader', function (message) {
            wp.customize('hopeui_php_show_loader')._value && jQuery('#loading').toggleOnCondition(message)
        });
    });
}(jQuery));