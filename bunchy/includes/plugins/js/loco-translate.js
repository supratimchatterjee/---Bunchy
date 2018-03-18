/* global document */
/* global jQuery */
/* global bunchy_loco_translate_config */

(function($) {
    'use strict';

    var config;
    var $locoWrapper;
    var $commonLocale;
    var $customLocale;
    var $warning;
    var $submitButton;

    $(document).ready(function() {

        $('.loco-admin.loco-init').each(function() {
            config = $.parseJSON(bunchy_loco_translate_config);

            if (typeof config === 'undefined') {
                return;
            }

            $locoWrapper = $(this);
            $commonLocale = $locoWrapper.find('select[name=common-locale]');
            $customLocale = $locoWrapper.find('input[name=custom-locale]');
            $submitButton = $locoWrapper.find('input[type=submit]');

            $warning = $('<span class="bunchy-warning">'+ config.locale_warning +'</span>');
            $customLocale.parents('p').append($warning);
            $warning.hide();

            selectGlobalDirAndHideRadios();
            setDefaultLocale();
            listenOnLocaleChange();
            blockIfTranslationNotAllowed();
        });

    });

    function selectGlobalDirAndHideRadios() {
        $locoWrapper.find('input[name=gforce]').each(function() {
            var $radio = $(this);
            var $radioWrapper = $radio.parents('p');

            if ($radio.is('[value=1]')) {
                $radio.attr('checked', 'checked');
            }

            $radioWrapper.hide();
        });
    }

    function setDefaultLocale() {
        $commonLocale.find('option[value='+ config.locale +']').attr('selected', 'selected');
        $commonLocale.trigger('change');
    }

    function  listenOnLocaleChange() {
        $commonLocale.on('change', function() {
            var selectedCode = $commonLocale.find('option:selected').val();

            checkCurrentLangCode(selectedCode);
        });

        $customLocale.on('keyup', function() {
            checkCurrentLangCode($(this).val());
        });
    }

    function checkCurrentLangCode(code) {
        if (code !== config.locale) {
            $warning.show();
        } else {
            $warning.hide();
        }
    }

    function blockIfTranslationNotAllowed() {
        if ($('.bunchy-translation-not-allowed').length > 0) {
            $submitButton.hide();
        }
    }

})(jQuery);