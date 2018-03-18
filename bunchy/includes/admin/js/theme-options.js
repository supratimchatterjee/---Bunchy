/* global jQuery */
/* global document */
/* global ajaxurl */
/* global confirm */

/**
 *
 * Navigation
 *
 */
(function($) {

    'use strict';

    $(document).ready(function(){
        if ($('body.appearance_page_theme-options').length > 0) {
            new $.G1ThemeOptionsNav();
        }
    });

    $.G1ThemeOptionsNav = function () {
        this._init();
    };

    $.G1ThemeOptionsNav.prototype = {
        '_init': function () {
            this._bindEvents();
            this._loadPluginPage();
            this._showSubmitButton();
            this._setCurrentTab();
        },
        '_setCurrentTab': function () {
            // GET variable has higher priority.
            if (window.location.href.match('group=.*')) {
                return;
            }

            var tabId = this._readCookie('g1_theme_options_group');

            var $tabToActivate = $('#nav-tab-' + tabId);

            if ($tabToActivate.length > 0) {
                $tabToActivate.trigger('click');
            }
        },
        '_loadPluginPage': function () {
            var $pluginSelectedOnStartup = $('a.nav-tab-active.g1-plugin');

            if ($pluginSelectedOnStartup.length > 0) {
                // emulate user selection
                $pluginSelectedOnStartup.trigger('click');
            }
        },
        '_bindEvents': function () {
            this._onMainMenuClick();
            this._onSubMenuClick();
        },
        '_onMainMenuClick': function () {
            var _this = this;

            $('.nav-tab-wrapper > a').on('click', function (e) {
                e.preventDefault();

                var $navicon = $(this);
                var isCurrent = $navicon.is('.nav-tab-active');
                var isExternalPlugin = $navicon.is('.g1-plugin');
                var isLoaded = $navicon.is('.g1-plugin-loaded');

                // skip
                if (( isCurrent && !isExternalPlugin ) || ( isCurrent && isExternalPlugin && isLoaded )) {
                    return;
                }

                // highlight current group
                $('.nav-tab-active').removeClass('nav-tab-active');
                $(this).addClass('nav-tab-active');

                _this._hideSubmenus();
                _this._showSubmitButton();

                // get group id from link anchor param
                var anchor = $(this).attr('href');
                var group = anchor.match(/&group=(.*)/);
                var groupId = '';

                // theme's internal settings
                if (group) {
                    groupId = group[1];

                    var $sectionsMenu = $('#g1ui-nav-tab-wrapper-' + groupId);

                    if ($sectionsMenu.length > 0) {
                        $sectionsMenu.show();
                        $sectionsMenu.find('> a:first').
                            removeClass('nav-tab-active').
                            trigger('click');
                    } else {
                        _this._deleteCookie('g1_theme_options_section');

                        // remove section selection
                        //$('.nav-tab-active').removeClass('nav-tab-active');

                        _this._showContentForSection(groupId);
                    }
                    // if group not defined, load plugin page via iframe
                } else {
                    var page = anchor.match(/\?page=(.*)/);

                    if (page) {
                        groupId = page[1];

                        // right now plugins have no sections
                        // so we need to clear current selection
                        _this._deleteCookie('g1_theme_options_section');

                        // load
                        if (!isLoaded) {
                            _this._hideAllSections();
                            _this._createSection(groupId, anchor);
                            $navicon.addClass('g1-plugin-loaded');
                        }

                        _this._showContentForSection(groupId);
                    }
                }

                _this._createCookie('g1_theme_options_group', groupId);
            });
        },
        '_onSubMenuClick': function () {
            var _this = this;

            $('.nav-tab-wrapper > a').on('click', function (e) {
                // skip if tab is selected
                if ($(this).is('.nav-tab-active')) {
                    e.preventDefault();
                    return;
                }

                // get section id from link anchor param
                var anchor = $(this).attr('href');
                var section = anchor.match(/&group=(.*)&section=(.*)/);

                if (section) {
                    e.preventDefault();

                    var groupId = section[1];
                    var sectionId = section[2];

                    // highlight current section
                    $('.nav-tab-active').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active');

                    _this._createCookie('g1_theme_options_section', sectionId);

                    _this._showContentForSection(groupId, sectionId);
                }
            });
        },
        '_createSection': function (groupId, anchor) {
            var $section = $('<div id="g1ui-settings-section-' + groupId + '" class="g1ui-settings-section">');
            var $info = $('<p class="g1ui-settings-section-msg">Loading...</p>');

            $('.g1ui-settings-section:last').after($section);

            $section.append($info);

            var $iframe = $('<iframe class="g1-plugin-page" src="' + anchor + '">');

            $iframe.hide();
            $section.append($iframe);

            $iframe.load(function () {
                var $iframeContent = $iframe.contents();

                $info.remove();
                $iframe.show();

                // hide elements inside iframe, besides plugin form
                //$iframeContent.find('#adminmenu, #adminmenuback, #wpadminbar, #wpfooter, .nav-tab-wrapper').remove();

                $iframeContent.find('#wpcontent').css({
                    'margin-left': 0,
                    'padding-left': 0
                });

                $iframeContent.find('.wp-toolbar').css({
                    'padding-top': 0
                });

                $iframeContent.find('.wrap').css({
                    'margin-top': 0
                });

                $iframeContent.find('input[type=submit]').hide();

                $iframeContent.find('#wpbody-content').css('padding-bottom', '20px');

                // adjust iframe height
                var $pluginContent = $iframeContent.find('#wpwrap');

                $iframe.css('height', $pluginContent.css('height'));
            });
        },
        '_showSubmitButton': function () {
            var $selectedNavItem = $('.nav-tab-wrapper > a.nav-tab-active');
            var $themeOptionsForm = $('#theme-options-form');

            if ($themeOptionsForm.length === 0) {
                return;
            }

            var $submitButton = $themeOptionsForm.find('.button-primary').not('#g1-install-demo-data');

            if ($selectedNavItem.is('.g1-form')) {
                $submitButton.show();
            } else {
                $submitButton.hide();
            }
        },
        '_hideAllSections': function () {
            $('.g1ui-settings-section').hide();
        },
        '_hideSubmenus': function () {
            //$('.nav-tab-wrapper').hide();
        },
        '_showContentForSection': function (groupId, sectionId) {
            this._hideAllSections();

            var selector = '#g1ui-settings-section-' + groupId;

            if (sectionId) {
                selector += '-' + sectionId;
            }

            $(selector).show();
        },
        '_createCookie': function (name, value, days) {
            var expires;

            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = '; expires=' + date.toUTCString();
            }
            else {
                expires = '';
            }

            document.cookie = name.concat('=', value, expires, '; path=/');
        },
        '_readCookie': function (name) {
            var nameEQ = name + '=';
            var ca = document.cookie.split(';');

            for(var i = 0; i < ca.length; i += 1) {
                var c = ca[i];
                while (c.charAt(0) === ' ') {
                    c = c.substring(1,c.length);
                }

                if (c.indexOf(nameEQ) === 0) {
                    return c.substring(nameEQ.length,c.length);
                }
            }

            return null;

        },
        '_deleteCookie': function (name) {
            this._createCookie(name, '', -1);
        }
    };
})(jQuery);


/**
 *
 * Import Theme Options
 *
 */
(function($) {

    'use strict';

    $(document).ready(function(){
        if ($('body.appearance_page_theme-options').length > 0) {
            $('#g1-import-theme-options').on('click', function (e) {
                if ( !confirm('Import will override your current theme options. Proceed? ') ) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                }
            });
        }
    });

})(jQuery);


/**
 *
 * Dashboard
 *
 */
(function($) {

    'use strict';

    $(document).ready(function(){
        if ($('body.appearance_page_theme-options').length === 0) {
            return;
        }

        $('#g1ui-settings-section-dashboard').each(function () {
            var $this = $(this);
            var $installAction = $this.find('#g1-install-demo-data');
            var $skipAction = $this.find('#g1-skip-demo-data');

            // Dashboard: normal mode
            // ----------------------
            $this.find('.g1-demo-imported-congrats').each(function () {
                setTimeout(function () {
                    $('html, body').animate({
                        scrollTop: 0
                    }, 1000);
                }, 1000);
            });

            // Dashboard: welcome mode
            // -----------------------

            // select plugin to install
            $this.find('.g1ui-plugicon').on('click', function (e) {
                if ($(this).parents('.g1ui-plugicons').length === 0) {
                    return;
                }

                var checkboxClicked = $(e.target).is('input[type=checkbox]');
                var $wrapper = $(this);
                var $checkbox = $wrapper.find('input[type=checkbox]');

                // if user clicked in container, we need to manually set checkbox state
                if (!checkboxClicked) {
                    if ($checkbox.is(':checked')) {
                        $checkbox.removeAttr('checked');
                    } else {
                        $checkbox.attr('checked', 'checked');
                    }
                }

                $wrapper.toggleClass('g1ui-plugicon-checked g1ui-plugicon-unchecked');
            });

            // select demo to install
            $this.find('.g1ui-plugicon').on('click', function (e) {
                if ($(this).parents('.g1ui-demicons').length === 0) {
                    return;
                }

                // uncheck all demos
                $(this).siblings('.g1ui-plugicon').each(function () {
                    var $wrapper = $(this);

                    $wrapper.find('input').removeAttr('checked');

                    $wrapper.
                        removeClass('g1ui-plugicon-checked').
                        addClass('g1ui-plugicon-unchecked');
                });

                var checkboxClicked = $(e.target).is('input[type=checkbox]');
                var $wrapper = $(this);
                var $checkbox = $wrapper.find('input[type=checkbox]');

                // if user clicked in container, we need to manually set checkbox state
                if (!checkboxClicked) {
                    if ($checkbox.is(':checked')) {
                        $checkbox.removeAttr('checked');
                    } else {
                        $checkbox.attr('checked', 'checked');
                    }

                    $checkbox.trigger('change');
                }

                $wrapper.toggleClass('g1ui-plugicon-checked g1ui-plugicon-unchecked');

                // if user decided to install demo content, the Wordpress Importer plugin is required
                var $importerPlugin = $('.g1-plugin-to-install[name=wordpress-importer]');

                // ready to install?
                if ($importerPlugin.length > 0) {
                    // install WP Importer only if user wants to install demo content
                    $checkbox.on('change', function () {
                        if ($(this).is(':checked')) {
                            $importerPlugin.attr('checked', 'checked');
                        } else {
                            $importerPlugin.removeAttr('checked');
                        }
                    });
                }
            });

            $installAction.on('click', function (e) {
                e.preventDefault();

                // plugins
                var plugins = [];

                $this.find('.g1ui-plugicons .g1ui-plugicon').each(function () {
                    var $container = $(this);

                    if ($container.is('.g1ui-plugicon-checked')) {
                        $container.removeClass('g1ui-plugicon-checked');
                        $container.addClass('g1ui-plugicon-pending');
                        plugins.push($container);
                    } else {
                        $container.removeClass('g1ui-plugicon-unchecked');
                        $container.addClass('g1ui-plugicon-omitted');
                    }
                });

                // demos
                var demos = [];

                $this.find('.g1ui-demicons .g1ui-plugicon').each(function () {
                    var $container = $(this);

                    if ($container.is('.g1ui-plugicon-checked')) {
                        $container.removeClass('g1ui-plugicon-checked');
                        $container.addClass('g1ui-plugicon-pending');
                        demos.push($container);
                    } else {
                        $container.removeClass('g1ui-plugicon-unchecked');
                        $container.addClass('g1ui-plugicon-omitted');
                    }
                });

                demoInstallationStarted();

                installPlugins(plugins, function () {
                    // plugins installed so we can move to next step
                    // and install demo content + theme options
                    installContentAndOptions(demos, function () {
                        // demo data installed
                        disableWelcomeMode(true, function () {
                            // all done
                            setTimeout(function () {
                                // reload page to change dashboard view
                                window.location.reload();
                            }, 2000);
                        });
                    });
                });
            });

            $skipAction.on('click', function (e) {
                e.preventDefault();

                disableWelcomeMode(false, function () {
                    // reload page to change dashboard view
                    window.location.reload();
                });
            });
        });
    });

    function installPlugins (plugins, finishCallback) {
        if (plugins.length === 0) {
            finishCallback();
            return;
        }

        // get first plugin from list
        var $container = plugins.shift();
        var $plugin = $container.find('input.g1-plugin-to-install');
        var url = $plugin.attr('data-g1-install-url');

        $container.removeClass('g1ui-plugicon-pending');
        $container.addClass('g1ui-plugicon-loading');

        // install plugin
        $.get( url, function( data ) {
            var status = 'success';
            var $res = $(data);

            var successInfo = $('*:contains("Successfully")', $res).length > 0 || $('*:contains("successfully")', $res).length > 0;

            if (!successInfo) {
                var $errorMessage = $res.find('#message.error');

                status = $errorMessage.length === 0 ? 'success': 'failure';
            }

            $container.removeClass('g1ui-plugicon-loading');

            if (status === 'success') {
                $container.addClass('g1ui-plugicon-succeed');
            } else {
                $container.addClass('g1ui-plugicon-failed');
            }

            // process the rest of plugins
            // it's done this way to use async ajax calls and in the same time install plugins one after another, not asynchronously
            // TGM has problem with installing more than one plugin via "Install" link. Batch action is for this.
            installPlugins(plugins, finishCallback);
        });
    }

    function installContentAndOptions (demos, finishCallback) {
        // without demo content?
        if (demos.length === 0) {
            finishCallback();
            return;
        }

        var $container = demos.shift();

        $container.removeClass('g1ui-plugicon-pending');
        $container.addClass('g1ui-plugicon-loading');

        var installUrl = $container.find('input.g1-demo-to-install').attr('data-g1-install-url');

        disableWelcomeMode(true, function () {
            // redirect to install demo content action
            window.location.href = installUrl;
        });
    }

    function disableWelcomeMode (demoDataInstalled, finishCallback) {
        var xhr = $.ajax({
            'type': 'POST',
            'url' : ajaxurl,
            'data': {
                'action'   :    'bunchy_change_mode_to_normal',
                'security':     $('input#g1-change-mode-ajax-nonce').val(),
                'demo_state': demoDataInstalled ? 'installed' : 'not_installed'
            }
        });

        xhr.done(function () {
            finishCallback();
        });
    }

    function demoInstallationStarted () {
        $.ajax({
            'type': 'POST',
            'url' : ajaxurl,
            'data': {
                'action'   :    'bunchy_change_mode_to_in_progress',
                'security':     $('input#g1-change-mode-ajax-nonce').val()
            }
        });
    }

})(jQuery);