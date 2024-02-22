/**
 * Admin Scripts.
 *
 * @package  wp-configurator-pro/assets/backend/js/
 * @version  3.2.2
 */

(function ($, window, document, undefined) {
    'use strict';

    var importFromArea = () => {
            var $importArea = $('#wpc-hidden-area'),
                $importForm = $importArea.find('#wpc-import-template-area'),
                $importBtn = $importArea.find('#wpc-import-template-trigger'),
                $importFormArea = $importArea.find('#wpc-import-template-form'),
                $importFormLoader = $importArea.find('#wpc-import-loader');

            $('#wpbody-content')
                .find('.page-title-action')
                .after($importForm)
                .after($importBtn);

            $importBtn.on('click', function (e) {
                e.preventDefault();

                $importForm.toggle();
            });

            $importFormArea.on('submit', function (e) {
                $importFormLoader.show();
            });
        },
        switchMailField = (val) => {
            if ('all-admin' == val) {
                $('#wpc_get_quote_mail_custom_user').slideUp(300);
            } else {
                $('#wpc_get_quote_mail_custom_user').slideDown(300);
            }
        };

    $(document).ready(function ($) {
        /* Code Editor */
        var $textarea = $('#css_editor');

        if ($textarea.length) {
            var editor = wp.codeEditor.initialize($textarea);

            // Improve the editor accessibility.
            $(editor.codemirror.display.lineDiv).attr({
                role: 'textbox',
                'aria-multiline': 'true',
                'aria-describedby':
                    'editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4',
            });
        }

        $('.color-picker').wpColorPicker();

        $('.fields-group .title').on('click', function () {
            let $this = $(this),
                $wrap = $this.closest('.fields-group');

            $wrap.siblings().find('.fields-group-inner').slideUp(300);
            $wrap.find('.fields-group-inner').slideToggle(300);

            $wrap.toggleClass('active');
            $wrap.siblings().removeClass('active');
        });

        let val = $('select[name="wpc_get_quote_mail_to"]').val();

        switchMailField(val);

        $('select[name="wpc_get_quote_mail_to"]').on('change', function (e) {
            e.preventDefault();

            let $self = $(this),
                val = $self.val();

            switchMailField(val);
        });

        $(
            '.post-type-amz_configurator .page-title-action, #menu-posts-amz_configurator a'
        ).on('click', function (e) {
            var $self = $(this),
                href = $self.attr('href');

            if ('undefined' !== typeof href && href.includes('post-new.php')) {
                e.preventDefault();

                if (!$('#wpc-create-configurator-popup').length) {
                    let $template = $(
                        '#tmpl-wpc-create-configurator-popup-template'
                    ).html();

                    $('body').append($template);
                }

                $('#wpc-create-configurator-popup').toggleClass('active');
            }
        });

        $('body').on(
            'click',
            '#wpc-close-create-config-popup, .wpc-overlay',
            function (e) {
                $('#wpc-create-configurator-popup').removeClass('active');
            }
        );

        $('#the-list').on('click', '.editinline', function () {
            var post_id = $(this).closest('tr').attr('id');

            post_id = post_id.replace('post-', '');

            var $inline_data = $('#inline_' + post_id);

            var product_id = $inline_data.find('._wpc_product_id').text(),
                config_id = $inline_data.find('._wpc_config_id').text(),
                config_style = $inline_data.find('._wpc_config_style').text(),
                form = $inline_data.find('._wpc_form ').text(),
                contact_form = $inline_data.find('._wpc_contact_form').text(),
                preview_slide_dot_style = $inline_data
                    .find('._wpc_preview_slide_dot_style')
                    .text(),
                preview_slide_dot_position = $inline_data
                    .find('._wpc_preview_slide_dot_position')
                    .text(),
                base_price = $inline_data.find('._wpc_base_price').text(),
                load_configurator_in = $inline_data
                    .find('._wpc_load_configurator_in')
                    .text(),
                configurator_template = $inline_data
                    .find('._wpc_configurator_template')
                    .text(),
                description = $inline_data.find('._wpc_description').text();

            $('select[name="_wpc_product_id"]', '.inline-edit-row').val(
                product_id
            );
            $('select[name="_wpc_config_id"]', '.inline-edit-row').val(
                config_id
            );
            $('select[name="_wpc_config_style"]', '.inline-edit-row').val(
                config_style
            );
            $('select[name="_wpc_form"]', '.inline-edit-row').val(form);
            $('select[name="_wpc_contact_form"]', '.inline-edit-row').val(
                contact_form
            );
            $(
                'select[name="_wpc_preview_slide_dot_style"]',
                '.inline-edit-row'
            ).val(preview_slide_dot_style);
            $(
                'select[name="_wpc_preview_slide_dot_position"]',
                '.inline-edit-row'
            ).val(preview_slide_dot_position);
            $('input[name="_wpc_base_price"]', '.inline-edit-row').val(
                base_price
            );
            $(
                'select[name="_wpc_load_configurator_in"]',
                '.inline-edit-row'
            ).val(load_configurator_in);
            $(
                'select[name="_wpc_configurator_template"]',
                '.inline-edit-row'
            ).val(configurator_template);
            $('textarea[name="_wpc_description"]', '.inline-edit-row').val(
                description
            );
        });

        $('body').on('submit', '#wpc-create-config-submit', function (e) {
            e.preventDefault();

            var $form = $(this),
                serializeData = $form.serializeArray();

            $form.find('.error').empty();

            $form.find('button').addClass('wpc-btn-loading');

            $.ajax({
                type: 'post',
                url: ajaxurl,
                data: serializeData,
            })
                .done(function (data) {
                    let parseData = JSON.parse(data),
                        error = parseData.error,
                        redirect = parseData.redirect;

                    if (!error) {
                        location.replace(redirect);
                    } else {
                        $form.find('button').removeClass('wpc-btn-loading');

                        Object.keys(parseData.notice).forEach((key) => {
                            $form
                                .find(`.${key}-error`)
                                .text(parseData.notice[key]);
                        });
                    }
                })
                .always(function () {});
        });

        importFromArea();

        $('body').on('click', '#wpc-config-mail-save-invoice', function (e) {

            e.preventDefault();

            const $self = $(this);
            
            const id = $self.data('id');

            const type = $self.data('type');

            if( 'edit' === type )  {
                $('#wpc-config-mail-invoice').attr( 'contenteditable', true );
                $self.data('type', 'save');
                $self.text(wpc_i18n.save_invoice);

            } else {
                const content = $('#wpc-config-mail-invoice').html();

                $.ajax({
                    type: 'post',
                    url: ajaxurl,
                    data: {
                        action: 'wpc_save_invoice',
                        id,
                        content,
                    },
                })
                .done(function (data) {
                    $('#wpc-config-mail-invoice').attr( 'contenteditable', false );
                    $self.data('type', 'edit');
                    $self.text(wpc_i18n.edit_invoice);
                })
                .always(function () {});
            }
            
            
        });

        $('body').on('click', '#wpc-config-apply-mail-action', function (e) {

            e.preventDefault();

            var $btn = $(this),
                id = $btn.data('id'),
                $wrap = $btn.closest('li'),
                invoice_action = $wrap.find('select[name="wpc_config_mail_action"]').val();

            $.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'wpc_apply_invoice_action',
                    id,
                    invoice_action,
                },
            })
            .done(function (data) {
                console.log(data);
            })
            .always(function () {});
        });

        
    });
})(jQuery, window, document);
