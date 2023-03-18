(function (jQuery) {
    "use strict";

    /**
     * Store Object of section Which has tab Controls.
     * @type {Object}
     */
    let customizerSectionTab =
    {
        breadcrumb: 'breadcrumb_section_tabs',
        header_layout: 'header_section_tabs',
    };

    jQuery.fn.extend({
        toggleOnCondition: function (condition) {
            if (condition)
                this.show();
            else
                this.hide();
        }
    });

    let control_condition = (tab_switching = false) => {
        /*-----------------------------------
       Controls Conditions
       -------------------------------------*/
        let controls = wp.customize.settings.controls;
        for (let controlKey in controls) {
            if (controls[controlKey].condition != null) {
                for (let condition in controls[controlKey].condition) {
                    wp.customize(condition).bind((controlVal => {
                        wp.customize.control(controls[controlKey].settings.default).container.toggleOnCondition(controls[controlKey].condition[condition] == controlVal)
                    }));

                    if (!tab_switching && !wp.customize.control(controls[controlKey].settings.default).container.is(":visible")) {
                        wp.customize.control(controls[controlKey].settings.default).container.toggleOnCondition(false)
                    } else if (!tab_switching) {
                        wp.customize.control(controls[controlKey].settings.default).container.toggleOnCondition(controls[controlKey].condition[condition] == wp.customize(condition)._value)
                    }
                }
            }
        }
    }

    jQuery(document).ready(function() {

        jQuery('.slider-custom-control').each(function () {
            var sliderValue = jQuery(this).find('.customize-control-slider-value');
            var newSlider = jQuery(this).find('.slider');
            var sliderMinValue = parseFloat(newSlider.attr('slider-min-value'));
            var sliderMaxValue = parseFloat(newSlider.attr('slider-max-value'));
            var sliderStepValue = parseFloat(newSlider.attr('slider-step-value'));
            let sliderReset = jQuery(this).find('.slider-reset');
            newSlider.slider({
                value: sliderValue.val(),
                min: sliderMinValue,
                max: sliderMaxValue,
                step: sliderStepValue,
                slide: function (e, ui) {
                    sliderValue.val(ui.value).trigger('change');
                },
                change: (e, ui) => {
                    sliderValue.val(ui.value).trigger('change');
                }
            });
            sliderReset.on('click', (e) => {
                sliderValue.val(sliderReset.attr('slider-reset-value')).trigger('change');
            });

        });

        /*-----------------------------------
        Select-2 Dropdown
        -------------------------------------*/
        jQuery('.customize-control-dropdown-select2').each(function () {
            jQuery('.customize-control-select2').select2({
                minimumResultsForSearch: -1
            });
        });
        jQuery(".customize-control-select2").on("change", function () {
            var select2Val = jQuery(this).val();
            jQuery(this).parent().find('.customize-control-dropdown-select2').val(select2Val).trigger('change');
        });


        /*-----------------------------------
        Section Tabs
        -------------------------------------*/
        jQuery('.customize-control-hopeui_php_section_tabs .hopeui_style-section-tabs .hopeui_style-section-tab-item').on('click', (e) => {
            jQuery(e.currentTarget).addClass('checked').siblings().removeClass('checked');

        });

        for (var key in customizerSectionTab) {

            let sectionControls = wp.customize.section(key).controls();
            let defaultTab;
            sectionControls.forEach(control => {
                if (control.params.type == "hopeui_php_section_tabs") {
                    defaultTab = control.params.default;
                    control.setting.set(defaultTab)
                    return
                }
                if (control.params.tab != defaultTab) {
                    control.container.toggleOnCondition(false);
                }
            })
            wp.customize.control(customizerSectionTab[key]).setting.bind(val => {
                sectionControls.forEach(control => {
                    if (control.templateSelector == "customize-control-hopeui_php_section_tabs-content" || control.params.tab === undefined) return;
                    control.container.toggleOnCondition(control.params.tab == val)
                    control_condition(true);
                });
            });
        }

        control_condition();
        /*-----------------------------------
        Toggle Button
        -------------------------------------*/
        jQuery('.toggle_button_button_control input[type=checkbox]').on('change', (val) => {
            jQuery(val.target).parent().toggleClass('active')
        });

        /*-----------------------------------
        Two Dimension Control
        -------------------------------------*/
        jQuery('.hopeui_style-twodimension_input .button-decrement').on('click', function () {
            let input = jQuery(this).parent().find('input');
            input.val(Number(input.val()) - 1).change();
        });
        jQuery('.hopeui_style-twodimension_input .button-increment').on('click ', function () {
            let input = jQuery(this).parent().find('input');
            input.val(Number(input.val()) + 1).change();
        });

        jQuery('.hopeui_style-twodimension_input .number-input-text-box,.hopeui_style-twodimension_input .customize-control-select2').on('change', function () {
            let hidden_input = jQuery(this).parents('.hopeui_style-twodimension_input').find('.hopeui_style-twodimension-val');
            let twodimension = jQuery(this).parents('.hopeui_style-twodimension_input');
            let val = {
                height: twodimension.find('.hopeui_style-height').val(),
                width: twodimension.find('.hopeui_style-width').val(),
                unit: twodimension.find('.hopeui_style-unit').val()
            }
            hidden_input.val(JSON.stringify(val)).change();
        });

        /*-----------------------------------
       Loader
       -------------------------------------*/
        // Section Specific Page Load
        wp.customize.section('loader', function (section) {
            section.expanded.bind(function (isExpanded) {
                wp.customize.previewer.send('show_loader', isExpanded);
            });
        });

        /*-----------------------------------
        404
        -------------------------------------*/
        wp.customize.section('fourzerofour', function (section) {
            section.expanded.bind(function (isExpanded) {
                isExpanded && wp.customize.previewer.previewUrl(wp.customize.settings.url.home + 'index.php/404');
            });
        });
        wp.customize.section('page_settings', function (section) {
            section.expanded.bind(function (isExpanded) {
                isExpanded && wp.customize.previewer.previewUrl(wp.customize.settings.url.home + 'index.php/?s=h');
            });
        });



        jQuery('.hopeui_style-typography-dropdown-button').on('click', function () {
            jQuery(this).parents('.hopeui_style-typography').next().toggleClass('active').slideToggle();
        });
        /**
     * Googe Font Select Custom Control
     *
     */

        jQuery('.google_fonts_select_control select').each(function (i, obj) {
            if (jQuery(obj).hasClass('google-fonts-list')) {
                jQuery(obj).select2();
            } else {
                jQuery(obj).select2({
                    minimumResultsForSearch: -1
                });
            }
        });

        jQuery('.google-fonts-list').on('change', function () {
            var elementRegularWeight = jQuery(this).parents('.google_fonts_select_control').find('.google-fonts-regularweight-style');
            var elementItalicWeight = jQuery(this).parents('.google_fonts_select_control').find('.google-fonts-italicweight-style');
            var elementBoldWeight = jQuery(this).parents('.google_fonts_select_control').find('.google-fonts-boldweight-style');
            var selectedFont = jQuery(this).val();
            var customizerControlName = jQuery(this).attr('control-name');
            var elementItalicWeightCount = 0;
            var elementBoldWeightCount = 0;

            // Clear Weight/Style dropdowns
            elementRegularWeight.empty();
            elementItalicWeight.empty();
            elementBoldWeight.empty();
            // Make sure Italic & Bold dropdowns are enabled
            elementItalicWeight.prop('disabled', false);
            elementBoldWeight.prop('disabled', false);

            // Get the Google Fonts control object

            var bodyfontcontrol = _wpCustomizeSettings.controls[customizerControlName];

            // Find the index of the selected font
            var indexes = jQuery.map(bodyfontcontrol.hopeui_scriptfontslist, function (obj, index) {
                if (obj.family === selectedFont) {
                    return index;
                }
            });
            var index = indexes[0];

            // For the selected Google font show the available weight/style variants
            if (bodyfontcontrol.hopeui_scriptfontslist[index].variants.includes('italic')) {
                elementRegularWeight.append(
                    jQuery('<option></option>').val('italic').html('italic')
                );
                elementRegularWeight.append(
                    jQuery('<option></option>').val('normal').html('normal')
                );
            } else {

                elementRegularWeight.append(
                    jQuery('<option></option>').val('normal').html('normal')
                );
            }
            jQuery.each(bodyfontcontrol.hopeui_scriptfontslist[index].variants, function (val, text) {

                if (text.indexOf("italic") >= 0) {
                    elementItalicWeight.append(
                        jQuery('<option></option>').val(text).html(text)
                    );
                    elementItalicWeightCount++;
                } else {
                    elementBoldWeight.append(
                        jQuery('<option></option>').val(text).html(text)
                    );
                    elementBoldWeightCount++;
                }
            });

            if (elementItalicWeightCount == 0) {
                elementItalicWeight.append(
                    jQuery('<option></option>').val('').html('Not Available for this font')
                );
                elementItalicWeight.prop('disabled', 'disabled');
            }
            if (elementBoldWeightCount == 0) {
                elementBoldWeight.append(
                    jQuery('<option></option>').val('').html('Not Available for this font')
                );
                elementBoldWeight.prop('disabled', 'disabled');
            }

            // Update the font category based on the selected font
            jQuery(this).parents('.google_fonts_select_control').find('.google-fonts-category').val(bodyfontcontrol.hopeui_scriptfontslist[index].category);

            hopeui_scriptGetAllSelects(jQuery(this).parents('.google_fonts_select_control'));
        });

        jQuery('.google_fonts_select_control select,.google_fonts_select_control input').on('input', function () {
            hopeui_scriptGetAllSelects(jQuery(this).parents('.google_fonts_select_control'));
        });



    });

}(jQuery));

function hopeui_scriptGetAllSelects(jQueryelement) {
    let textSizeElement = jQueryelement.find('.google-fonts-size'), textSize;
    textSize = textSizeElement.val().includes('px') ? textSizeElement.val() : textSizeElement.val() + textSizeElement.attr('data-unit');
    var selectedFont = {
        font: jQueryelement.find('.google-fonts-list').val(),
        regularweight: jQueryelement.find('.google-fonts-regularweight-style').val(),
        boldweight: jQueryelement.find('.google-fonts-boldweight-style').val(),
        size: textSize,
        category: jQueryelement.find('.google-fonts-category').val()
    };

    // Important! Make sure to trigger change event so Customizer knows it has to save the field
    jQueryelement.find('.customize-control-google-font-selection').val(JSON.stringify(selectedFont)).trigger('change');
}