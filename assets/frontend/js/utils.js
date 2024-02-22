/**
 * Helper Scripts.
 *
 * @package  wp-configurator-pro/assets/frontend/js/
 * @since  2.0
 * @version  3.5.3
 */

(function ($, window, document) {
    'use strict';

    // global wpc => configurator for WordPress in reverse order
    window.wpc = window.wpc || {};

    window.wpc_reset_keys = {};

    // Store all wpc.hooks here
    /**
     * Hooks object
     *
     * This object needs to be declared early so that it can be used in code.
     * Preferably at a global scope.
     */
    wpc.hooks = wpc.hooks || {}; // Extend wpc.hooks if exists or create new wpc.hooks object.

    wpc.hooks.actions = wpc.hooks.actions || {}; // Registered actions
    wpc.hooks.filters = wpc.hooks.filters || {}; // Registered filters

    /**
     * Add a new Action callback to wpc.hooks.actions
     *
     * @param tag The tag specified by do_action()
     * @param callback The callback function to call when do_action() is called
     * @param priority The order in which to call the callbacks. Default: 10 (like WordPress)
     */
    wpc.add_action = function (tag, callback, priority) {
        if (typeof priority === 'undefined') {
            priority = 10;
        }

        // If the tag doesn't exist, create it.
        wpc.hooks.actions[tag] = wpc.hooks.actions[tag] || [];
        wpc.hooks.actions[tag].push({ priority: priority, callback: callback });
    };

    /**
     * Add a new Filter callback to wpc.hooks.filters
     *
     * @param tag The tag specified by apply_filters()
     * @param callback The callback function to call when apply_filters() is called
     * @param priority Priority of filter to apply. Default: 10 (like WordPress)
     */
    wpc.add_filter = function (tag, callback, priority) {
        if (typeof priority === 'undefined') {
            priority = 10;
        }

        // If the tag doesn't exist, create it.
        wpc.hooks.filters[tag] = wpc.hooks.filters[tag] || [];
        wpc.hooks.filters[tag].push({ priority: priority, callback: callback });
    };

    /**
     * Remove an Anction callback from wpc.hooks.actions
     *
     * Must be the exact same callback signature.
     * Warning: Anonymous functions can not be removed.
     * @param tag The tag specified by do_action()
     * @param callback The callback function to remove
     */
    wpc.remove_action = function (tag, callback) {
        wpc.hooks.actions[tag] = wpc.hooks.actions[tag] || [];

        wpc.hooks.actions[tag].forEach(function (filter, i) {
            if (filter.callback === callback) {
                wpc.hooks.actions[tag].splice(i, 1);
            }
        });
    };

    /**
     * Remove a Filter callback from wpc.hooks.filters
     *
     * Must be the exact same callback signature.
     * Warning: Anonymous functions can not be removed.
     * @param tag The tag specified by apply_filters()
     * @param callback The callback function to remove
     */
    wpc.remove_filter = function (tag, callback) {
        wpc.hooks.filters[tag] = wpc.hooks.filters[tag] || [];

        wpc.hooks.filters[tag].forEach(function (filter, i) {
            if (filter.callback === callback) {
                wpc.hooks.filters[tag].splice(i, 1);
            }
        });
    };

    /**
     * Calls actions that are stored in wpc.hooks.actions for a specific tag or nothing
     * if there are no actions to call.
     *
     * @param tag A registered tag in Hook.actions
     * @options Optional JavaScript object to pass to the callbacks
     */
    wpc.do_action = function (tag, options) {
        var actions = [];

        if (
            typeof wpc.hooks.actions[tag] !== 'undefined' &&
            wpc.hooks.actions[tag].length > 0
        ) {
            wpc.hooks.actions[tag].forEach(function (hook) {
                actions[hook.priority] = actions[hook.priority] || [];
                actions[hook.priority].push(hook.callback);
            });

            actions.forEach(function (hooks) {
                hooks.forEach(function (callback) {
                    callback(options);
                });
            });
        }
    };

    /**
     * Calls filters that are stored in wpc.hooks.filters for a specific tag or return
     * original value if no filters exist.
     *
     * @param tag A registered tag in Hook.filters
     * @options Optional JavaScript object to pass to the callbacks
     */
    wpc.apply_filters = function (tag, value, options) {
        var filters = [];

        if (
            typeof wpc.hooks.filters[tag] !== 'undefined' &&
            wpc.hooks.filters[tag].length > 0
        ) {
            wpc.hooks.filters[tag].forEach(function (hook) {
                filters[hook.priority] = filters[hook.priority] || [];
                filters[hook.priority].push(hook.callback);
            });

            filters.forEach(function (hooks) {
                hooks.forEach(function (callback) {
                    value = callback(value, options);
                });
            });
        }

        return value;
    };

    /***
     * EXAMPLES
     *
     * Note: Using the Hooks object assumes that it is available at the scope your
     * code is executing.
     *
     * Simplest way to test, if you have `node` installed run `node Hooks.js`
     */

    // Filters ---------------------------------------------

    // Note: Add filters before you apply filters. Its up to you to decide how to implement app wide.

    // Anonymous example
    // Hooks.add_filter( 'my_filter', function( value, options ) {
    //     return value + ' [Option:' +  options.option1 + ']'
    // } ) // Default priority 10

    // // Non-anonymous example
    // function non_anon_filter( value, options ) {
    //     return 'Awesome: ' + value;
    // }
    // Hooks.add_filter( 'my_filter', non_anon_filter, 1 ); // Priority 1

    // var my_value = 'Will be awesome'
    // var my_filtered_value = Hooks.apply_filters( 'my_filter', my_value, { option1: 'Optional option' } );
    // console.log( my_filtered_value );

    // // Remove filter
    // Hooks.remove_filter( 'my_filter', non_anon_filter );

    // var my_value_2 = 'Will not be awesome';
    // var my_filtered_value_2 = Hooks.apply_filters( 'my_filter', my_value_2, { option1: 'Another option' } );
    // console.log( my_filtered_value_2 );

    // // Actions ---------------------------------------------

    // // Note: Add actions before you call do_action()

    // // Anonymous example
    // Hooks.add_action( 'my_action', function( options ) {

    //     console.log( 'Now you can perform custom actions at this exact moment of code execution.' );

    // } ) // Default priority 10

    // // Non-anonymous example
    // function non_anon_action( value, options ) {

    //     console.log( 'This line should execute before the previously defined action. Priority 1!' );

    // }
    // Hooks.add_action( 'my_action', non_anon_action, 1 ); // Priority 1

    // Hooks.do_action( 'my_action' ); // Not using options in this example

    /*
     * General Functions
     */

    // Encode the string
    wpc.encodeStr = function (str) {
        return $.base64.encode(str);
    };

    // Decode the string
    wpc.decodeStr = function (encodedString) {
        return $.base64.decode(encodedString);
    };

    // Remove the duplicate value in array
    wpc.arrUnique = function (list) {
        var result = [];
        $.each(list, function (i, e) {
            if ($.inArray(e, result) == -1) result.push(e);
        });
        return result;
    };

    // Generate random string
    wpc.random = function (length) {
        let result = '',
            characters =
                'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',
            charactersLength = characters.length;

        for (let i = 0; i < length; i++) {
            result += characters.charAt(
                Math.floor(Math.random() * charactersLength)
            );
        }
        return result;
    };

    wpc.addStyleSheet = function (url) {
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = url;
        document.getElementsByTagName('head')[0].appendChild(link);
    };

    wpc.generateFilename = function () {
        let today = new Date(),
            date =
                today.getFullYear() +
                '-' +
                (today.getMonth() + 1) +
                '-' +
                today.getDate(),
            time =
                today.getHours() +
                ':' +
                today.getMinutes() +
                ':' +
                today.getSeconds(),
            dateTime = date + ' ' + time;

        return (document.title + ' ' + dateTime).trim().toLowerCase();
    };

    wpc.stringToBoolean = function (value) {
        if ('boolean' === typeof value) {
            return value;
        } else if ('string' === typeof value) {
            switch (value.toLowerCase().trim()) {
                case 'true':
                case 'yes':
                case '1':
                case 'show':
                case 'enable':
                case 'activate':
                    return true;
                case 'false':
                case 'no':
                case '0':
                case 'hide':
                case 'disable':
                case 'deactivate':
                    return false;
                default:
                    return Boolean(value);
            }
        } else {
            return false;
        }
    };

    wpc.changeCase = function (string, type = 'kebab') {
        if ('kebab' === type) {
            return string
                .replace(/([a-z])([A-Z])/g, '$1-$2')
                .replace(/[\s_]+/g, '-')
                .toLowerCase();
        }
    };

    wpc.debounce = function (func, timeout = 300) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                func.apply(this, args);
            }, timeout);
        };
    };

    // Simpify String
    wpc.simplify_string = function (string) {
        let result = string.toLowerCase();

        result = result.replace(/[^a-z0-9]/gim, '').replace(/\s+/g, '');

        return result;
    };

    // Query string to build url
    wpc.updateQueryStringParameter = function (uri, key, value) {
        if (!uri) {
            return;
        }

        var re = new RegExp('([?&])' + key + '=.*?(&|#|$)', 'i');

        if (value === undefined) {
            if (uri.match(re)) {
                return uri.replace(re, '$1$2');
            } else {
                return uri;
            }
        } else {
            if (uri && uri.match(re)) {
                return uri.replace(re, '$1' + key + '=' + value + '$2');
            } else {
                var separator = uri && uri.indexOf('?') !== -1 ? '&' : '?';
                return uri + separator + key + '=' + value;
            }
        }
    };

    wpc.isUndefined = function (obj) {
        return obj === void 0;
    };

    wpc.isEmpty = function (value) {
        return '' == value || 0 === value || '0' === value || isNaN(value);
    };

    // Convert object to string split with commas
    wpc.obj2String = function (obj) {
        let string = '';

        for (var i in obj) {
            string += '' == string ? obj[i] : ',' + obj[i];
        }

        return string;
    };

    // String with commas generate it to array
    wpc.string2Array = function (string) {
        let array = string.split(',');

        array = array.filter(Boolean);
        array = wpc.arrUnique(array);

        return array;
    };

    wpc.getStore = function (configID) {
        return Alpine ? Alpine.store(`config_${configID}`) : false;
    };

    wpc.getProportion = function (img, cropSize) {
        let maxWidth = parseInt(cropSize),
            maxHeight = parseInt(cropSize),
            width = parseInt(img.width),
            height = parseInt(img.height),
            thumbwidth,
            thumbheight;

        if (maxWidth < width && width >= height) {
            thumbwidth = maxWidth;
            thumbheight = (thumbwidth / width) * height;
        } else if (maxHeight < height && height >= width) {
            thumbheight = maxHeight;
            thumbwidth = (thumbheight / height) * width;
        } else {
            thumbwidth = width;
            thumbheight = height;
        }

        return {
            width: parseInt(thumbwidth),
            height: parseInt(thumbheight),
        };
    };

    wpc.getFileExtension = function (fname) {
        return fname.slice(((fname.lastIndexOf('.') - 1) >>> 0) + 2);
    };

    wpc.milliSecondsToMinutes = (milliseconds) => {
        var minutes = Math.floor(milliseconds / 60000);
        var seconds = ((milliseconds % 60000) / 1000).toFixed(0);
        return seconds == 60
            ? minutes + 1 + ':00'
            : minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
    };

    wpc.createBlob = function (file, callback) {
        var reader = new FileReader();
        reader.onload = function () {
            callback(reader.result);
        };
        reader.readAsDataURL(file);
    };

    wpc.buildActivePreviewImage = function ($store, save, event) {
        let configID = $store.configID,
            maxWidth = $store.maxImageWidth,
            maxHeight = $store.maxImageHeight,
            $elemCon = $(
                '[data-configurator][data-config-id="' +
                    configID +
                    '"] .active [data-preview-inner]'
            ).clone(),
            type = $elemCon.data('type'),
            $el = $('<div />', {
                id: 'screenshot-con',
                'data-config-id': configID,
                'data-type': type,
            }).html($elemCon.html());

        $el.width(maxWidth + 80).height(maxHeight + 80);
        $el.find('template').remove();
        $el.find('[data-hotspot]').remove();

        wpc.do_action('wpc_before_canvas_element_generated', {
            event,
            $el,
            $store,
        });

        $el.appendTo('body');

        wpc.rePositionSubset($store, $el);

        wpc.do_action('wpc_before_canvas_created', {
            event,
            $el,
            $store,
        });

        if (save) {
            wpc.do_action('wpc_before_save_photo', { $el, configID });
        }

        wpcHtml2Canvas($el[0])
            .then((canvas) => {
                if (save) {
                    let filename = wpc.generateFilename() + '.png';

                    canvas.toBlob(function (blob) {
                        saveAs(blob, filename);
                    });
                }

                let dataUrl = canvas.toDataURL(),
                    img = new Image();

                img.src = dataUrl;

                $store['full_image_data'] = dataUrl;

                wpc.do_action('wpc_after_canvas_created', {
                    $store,
                    canvas,
                    event,
                });

                return img;
            })
            .then((img) => {
                let $thumbnail = $('<div />', {
                        id: 'thumbnail',
                    }).html(img),
                    newCanvas = document.createElement('canvas'),
                    ctx = newCanvas.getContext('2d'),
                    thumb;

                $thumbnail.appendTo('body');

                $($thumbnail).imagesLoaded(function () {
                    thumb = $thumbnail.find('img');

                    let thumbSize = wpc.getProportion(thumb[0], 300);

                    newCanvas.width = parseInt(thumbSize['width']);
                    newCanvas.height = parseInt(thumbSize['height']);

                    ctx.drawImage(
                        img,
                        0,
                        0,
                        parseInt(thumbSize['width']),
                        parseInt(thumbSize['height'])
                    );

                    var smallImageDataUrl = newCanvas.toDataURL();

                    if (
                        wpc.stringToBoolean(wpc_plugin.image_partially_encoded)
                    ) {
                        smallImageDataUrl = smallImageDataUrl.replace(
                            'data:image/png;base64,',
                            ''
                        );
                    }

                    $store.activeData['image'] = smallImageDataUrl;

                    $thumbnail.remove();
                    $el.remove();

                    wpc.do_action('wpc_after_placeholder_removed', {
                        $el,
                        $store,
                        configID,
                        event,
                    });

                    return true;
                });
            });
    };

    wpc.getConfigID = function ($self) {
        return $self.closest('[data-config-id]').data('config-id');
    };

    wpc.getViewKeys = function (configID) {
        return Object.keys(window['wpc_' + configID + '_views']);
    };

    wpc.getLayers = function (configID) {
        return window['wpc_' + configID + '_layers'];
    };

    wpc.getLayer = function (uid, layerObj) {
        return layerObj[uid];
    };

    wpc.getLayerSetting = function (uid, layerObj) {
        return !wpc.isUndefined(layerObj[uid]) &&
            !wpc.isUndefined(layerObj[uid]['settings'])
            ? layerObj[uid]['settings']
            : false;
    };

    wpc.setLayerSetting = function (key, value, uid, layerObj) {
        let settings =
            !wpc.isUndefined(layerObj[uid]) &&
            !wpc.isUndefined(layerObj[uid]['settings'])
                ? layerObj[uid]['settings']
                : false;

        settings[key] = value;
    };

    wpc.getParentSetting = function (uid, layerObj) {
        let parentUid = layerObj[uid]['parent'];
        return !wpc.isUndefined(layerObj[parentUid]['settings'])
            ? layerObj[parentUid]['settings']
            : false;
    };

    wpc.getSiblings = function (parentUid, layerObj) {
        return !wpc.isUndefined(layerObj[parentUid]) &&
            !wpc.isUndefined(layerObj[parentUid]['children'])
            ? layerObj[parentUid]['children']
            : false;
    };

    wpc.getDeselectSiblings = function (uid, layerObj) {
        return !wpc.isUndefined(layerObj[uid]) &&
            !wpc.isUndefined(layerObj[uid]['deselect_siblings'])
            ? layerObj[uid]['deselect_siblings']
            : false;
    };

    wpc.getParentUid = function (layer) {
        return layer.parent;
    };

    wpc.getLayerTree = function (layer) {
        return layer.tree;
    };

    wpc.getDescription = function (layerSetting) {
        return layerSetting && !wpc.isUndefined(layerSetting.description)
            ? layerSetting.description
            : '';
    };

    wpc.getRegularPrice = function (layerSetting) {
        return layerSetting && !wpc.isUndefined(layerSetting.price)
            ? parseFloat(layerSetting.price)
            : 0;
    };

    wpc.getPrice = function (layerSetting) {
        let regularPrice =
            layerSetting && !wpc.isUndefined(layerSetting.price)
                ? parseFloat(layerSetting.price)
                : 0;
        let salePrice =
            layerSetting && !wpc.isUndefined(layerSetting.sale_price)
                ? parseFloat(layerSetting.sale_price)
                : 0;
        return salePrice ? salePrice : regularPrice;
    };

    wpc.isActive = function (layerSetting) {
        return layerSetting && !wpc.isUndefined(layerSetting.active)
            ? layerSetting.active
            : false;
    };

    wpc.isMultiple = function (parentSetting) {
        return parentSetting && !wpc.isUndefined(parentSetting.multiple)
            ? wpc.stringToBoolean(parentSetting.multiple)
            : false;
    };

    wpc.isRequired = function (parentSetting) {
        return parentSetting && !wpc.isUndefined(parentSetting.required)
            ? wpc.stringToBoolean(parentSetting.required)
            : false;
    };

    wpc.isDeselectChild = function (parentSetting) {
        return !wpc.isUndefined(parentSetting.deselect_child)
            ? wpc.stringToBoolean(parentSetting.deselect_child)
            : false;
    };

    wpc.deselectType = function (parentSetting) {
        return !wpc.isUndefined(parentSetting.deselect_type)
            ? parentSetting.deselect_type
            : false;
    };

    wpc.isSwitchView = function (parentSetting) {
        return parentSetting && !wpc.isUndefined(parentSetting.switch_view)
            ? parentSetting.switch_view
            : false;
    };

    wpc.getViewSettings = function (view, layer) {
        return !wpc.isUndefined(layer['settings']) &&
            !wpc.isUndefined(layer['settings']['views']) &&
            !wpc.isUndefined(layer['settings']['views'][view])
            ? layer['settings']['views'][view]
            : false;
    };

    wpc.getAlignH = function (viewObj) {
        return !wpc.isUndefined(viewObj.align_h) ? viewObj.align_h : 'center';
    };

    wpc.getAlignV = function (viewObj) {
        return !wpc.isUndefined(viewObj.align_v) ? viewObj.align_v : 'middle';
    };

    wpc.getZIndex = function (viewObj) {
        return !wpc.isUndefined(viewObj.z_index)
            ? parseInt(viewObj.z_index)
            : 0;
    };

    wpc.getOffsetX = function (viewObj) {
        return !wpc.isUndefined(viewObj.offset_x)
            ? parseFloat(viewObj.offset_x, 10)
            : 0;
    };

    wpc.getOffsetY = function (viewObj) {
        return !wpc.isUndefined(viewObj.offset_y)
            ? parseFloat(viewObj.offset_y, 10)
            : 0;
    };

    wpc.getImageWidth = function (configID, viewObj) {
        return !wpc.isUndefined(viewObj.width)
            ? parseFloat(viewObj.width, 10)
            : !wpc.isUndefined(
                  window['wpc_' + configID + '_editor_images'][viewObj.image]
              ) &&
              window['wpc_' + configID + '_editor_images'][viewObj.image][
                  'width'
              ]
            ? window['wpc_' + configID + '_editor_images'][viewObj.image][
                  'width'
              ]
            : 0;
    };

    wpc.getImageHeight = function (configID, viewObj) {
        return !wpc.isUndefined(viewObj.height)
            ? parseFloat(viewObj.height, 10)
            : !wpc.isUndefined(
                  window['wpc_' + configID + '_editor_images'][viewObj.image]
              ) &&
              window['wpc_' + configID + '_editor_images'][viewObj.image][
                  'height'
              ]
            ? window['wpc_' + configID + '_editor_images'][viewObj.image][
                  'height'
              ]
            : 0;
    };

    wpc.hasHotSpot = function (viewObj) {
        return !wpc.isUndefined(viewObj.hs_enable)
            ? wpc.stringToBoolean(viewObj.hs_enable)
            : false;
    };

    wpc.getImageUrl = function (imageID, configID) {
        return !wpc.isUndefined(
            window['wpc_' + configID + '_editor_images'][imageID]
        )
            ? window['wpc_' + configID + '_editor_images'][imageID]['src']
            : false;
    };

    wpc.buildTreeSet = function ($self) {
        var configID = wpc.getConfigID($self),
            layerObj = wpc.getLayers(configID),
            uid = $self.data('uid'),
            layer = wpc.getLayer(uid, layerObj),
            tree = wpc.getLayerTree(layer),
            parentUid = wpc.getParentUid(layer),
            parentSetting = wpc.getLayerSetting(parentUid, layerObj),
            multiple = wpc.isMultiple(parentSetting),
            treeUid = true == multiple ? uid : parentUid;

        window['wpc_' + configID + '_tree_set'][treeUid] = tree;
    };

    wpc.getActiveTreeSet = function (configID) {
        window['wpc_' + configID + '_tree_set'] = Array.isArray(
            window['wpc_' + configID + '_tree_set']
        )
            ? {}
            : window['wpc_' + configID + '_tree_set'];
        return window['wpc_' + configID + '_tree_set'];
    };

    wpc.formatMoney = function (price) {
        return accounting.formatMoney(
            price,
            wpc_lib.symbol,
            wpc_lib.precision,
            wpc_lib.thousand,
            wpc_lib.decimal,
            wpc_lib.format
        );
    };

    wpc.isImage = function (url) {
        return /\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(url);
    };

    wpc.isDataImage = function (data) {
        return data.match('/jpg|jpeg|png|webp|avif|gif|svg/');
    };

    wpc.getPreviewElementStyle = ({
        layer,
        view,
        $store,
        previewWidth,
        previewHeight,
    }) => {
        let style = {};

        const configID = $store.configID;

        previewWidth = previewWidth || $store.previewWidth;

        previewHeight = previewHeight || $store.previewHeight;

        let valX;
        let valY;

        const viewObj = wpc.getViewSettings(view, layer);

        let x = wpc.getAlignH(viewObj);
        let y = wpc.getAlignV(viewObj);
        let z = wpc.getZIndex(viewObj);
        let offsetX = wpc.getOffsetX(viewObj);
        let offsetY = wpc.getOffsetY(viewObj);
        let width = wpc.getImageWidth(configID, viewObj);
        let height = wpc.getImageHeight(configID, viewObj);

        if ('left' == x) {
            valX = 0;
        } else if ('right' == x) {
            valX = previewWidth - width;
        } else if ('center' == x) {
            valX = (previewWidth - width) / 2;
        }

        if ('middle' == y) {
            valY = (previewHeight - height) / 2;
        } else if ('top' == y) {
            valY = 0;
        } else if ('bottom' == y) {
            valY = previewHeight - height;
        }

        if (valX) {
            style.left = `${valX + offsetX}px`;
            style.right = 'auto';
        }

        if (valY) {
            style.top = `${valY + offsetY}px`;
            style.bottom = 'auto';
        }

        if (z) {
            style['z-index'] = z;
        }

        return style;
    };

    wpc.rePositionSubset = function ($store, $preview) {
        var configID = $store.configID,
            layerObj = wpc.getLayers(configID);

        if (wpc.isUndefined(configID)) {
            return;
        }

        let previewWidth = $preview.width();
        let previewHeight = $preview.height();

        $preview.removeClass('wpc-loading');

        var $previewImagesCon = $preview.find('.subset');

        $previewImagesCon.each(function (index, el) {
            let $self = $(this);

            let uid = $self.data('uid');

            let layer = layerObj[uid];

            let view = $self.closest('[data-type]').data('type');

            $self.removeAttr('x-init');
            $self.removeAttr('x-bind:style');
            $self.removeAttr('x-bind:class');

            let style = wpc.getPreviewElementStyle({
                layer,
                view,
                $store,
                previewWidth,
                previewHeight,
            });

            $self.css(style);
        });
    };

    /*
     * Configurator Helper Functions
     */
    wpc.switchView = function (parentUid, $store) {
        let parentSetting = wpc.getLayerSetting(parentUid, $store.layers);

        let switchView = wpc.isSwitchView(parentSetting);

        if (!switchView) {
            return;
        }

        let configID = $store.configID;

        let viewKeys = wpc.getViewKeys(configID);

        let switchViewIndex = viewKeys.indexOf(switchView);

        $store.activeView = switchView;

        if (switchViewIndex != -1) {
            let $config = $(
                `[data-configurator][data-config-id="${configID}"] [data-configurator-view]`
            );

            $config.trigger('to.wpccarousel.carousel', switchViewIndex);
        }
    };

    wpc.setupCustomFields = function (configID) {
        var $customFieldForm = configID
                ? $(
                      '[data-custom-field-form][data-config-id="' +
                          configID +
                          '"]'
                  )
                : $('[data-custom-field-form]'),
            $form,
            configID;

        $customFieldForm.each(function (index, el) {
            configID = $(el).data('config-id');

            $form = $('[data-config-id="' + configID + '"] [data-form]');

            if ('undefined' != typeof wpc_config_custom_fields) {
                Object.keys(wpc_config_custom_fields).forEach((index) => {
                    let type = wpc_config_custom_fields[index]['type'],
                        value;

                    if (
                        'text' === type ||
                        'textarea' === type ||
                        'select' === type
                    ) {
                        value = $(el)
                            .find(
                                '[name="' +
                                    wpc_config_custom_fields[index]['id'] +
                                    '"]'
                            )
                            .val();
                    } else if ('radio' === type) {
                        value = $(el)
                            .find(
                                '[name="' +
                                    wpc_config_custom_fields[index]['id'] +
                                    '"]:checked'
                            )
                            .val();
                    }

                    if (value) {
                        $form
                            .find(
                                '[name="' +
                                    wpc_config_custom_fields[index]['id'] +
                                    '"]'
                            )
                            .val(value);
                    }
                });
            }
        });
    };

    wpc.createInspiration = function (el, $store) {
        $store.notices = {};

        const $form = $(el);
        const serializeData = $form.serializeArray();

        const ajaxurl = wpc_plugin.ajaxurl;

        serializeData.push(
            { name: 'image', value: $store.activeData['image'] },
            { name: 'key', value: $store.activeData['encoded'] },
            { name: 'price', value: $store.activeData['total'] }
        );

        wpc.do_action('wpc_inspiration_before_created', { $store });

        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: serializeData,
            beforeSend: function () {},
            complete: function () {},
        })
            .done(function (data) {
                wpc.do_action('wpc_inspiration_created', { data, $store });
            })
            .always(function () {});
    };

    wpc.updateInspiration = function (el, $store) {
        $store.notices = {};

        const $form = $(el);
        const serializeData = $form.serializeArray();

        const ajaxurl = wpc_plugin.ajaxurl;

        wpc.do_action('wpc_inspiration_before_updated', { $store });

        serializeData.push({ name: 'id', value: $store.editInspirationPost });

        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: serializeData,
            beforeSend: function () {},
            complete: function () {},
        })
            .done(function (data) {
                wpc.do_action('wpc_inspiration_updated', {
                    data,
                    old_term_id: $store.editInspirationTerm,
                    $store,
                });
            })
            .always(function () {});
    };

    wpc.resetInspiration = function (id, index, $store) {
        const ajaxurl = wpc_plugin.ajaxurl;

        let values = {
            config_id: $store.configID,
            id,
            key: $store.activeData.encoded,
            image: $store.activeData.image,
            price: $store.activeData.total,
        };

        wpc.do_action('wpc_inspiration_before_resetted', { $store });

        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'wpc_reset_inspiration',
                values,
            },
            beforeSend: function () {},
            complete: function () {},
        })
            .done(function (data) {
                wpc.do_action('wpc_inspiration_resetted', {
                    data,
                    id,
                    index,
                    $store,
                });
            })
            .always(function () {});
    };

    wpc.deleteInspiration = function (id, index, $store) {
        const ajaxurl = wpc_plugin.ajaxurl;

        wpc.do_action('wpc_inspiration_before_deleted', { $store });

        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'wpc_delete_inspiration',
                id,
            },
            beforeSend: function () {},
            complete: function () {},
        })
            .done(function (data) {
                wpc.do_action('wpc_inspiration_deleted', {
                    data,
                    id,
                    index,
                    $store,
                });
            })
            .always(function () {});
    };

    wpc.deleteInspirationGroup = function (term_id, $store) {
        const configID = $store.configID;

        const ajaxurl = wpc_plugin.ajaxurl;

        wpc.do_action('wpc_inspiration_before_group_deleted', { $store });

        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'wpc_delete_inspiration_group',
                id: configID,
                term_id,
            },
            beforeSend: function () {},
            complete: function () {},
        })
            .done(function (data) {
                wpc.do_action('wpc_inspiration_group_deleted', {
                    data,
                    term_id,
                    $store,
                });
            })
            .always(function () {});
    };

    /*
     * Submit Form Helpers
     */

    wpc.beforeSubmitForm = function (type, $form) {
        const configID = wpc.getConfigID($form);

        const $store = wpc.getStore(configID);

        const ajaxurl = wpc_plugin.ajaxurl;

        let custom_data = wpc.apply_filters(
            'wpc_submit_form_custom_data',
            {},
            { $store }
        );

        if (Object.keys(custom_data).length) {
            $.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'wpc_before_submit_form',
                    custom_data,
                },
                beforeSend: function () {
                    wpc.do_action('wpc_before_submit_form', { $store });
                },
                complete: function () {},
            })
                .done(function (data) {
                    wpc.do_action('wpc_after_submit_form', { data, $store });

                    wpc.submitForm(type, $form, $store);
                })
                .always(function () {});
        } else {
            wpc.do_action('wpc_after_submit_form', { $store });

            wpc.submitForm(type, $form, $store);
        }
    };

    // Cart Form, Get a Quote and Contact Form 7 Form Submission
    wpc.submitForm = function (type, $form, $store) {
        if (!$form.hasClass('wpc-submitting-form')) {
            $store.notices = {};
            $form.addClass('wpc-submitting-form');

            var configID = $store.configID,
                maxWidth = $store.maxImageWidth,
                maxHeight = $store.maxImageHeight,
                $carousel = $(
                    '[data-configurator][data-config-id="' +
                        configID +
                        '"] [data-configurator-view]'
                ),
                $elemCon,
                $scaledElement,
                $imageField = $form.find('input[name="wpc-config-image"]'),
                cart_thumbnail_view =
                    window[`wpc_${configID}_cart_thumbnail_view`][0];

            let cart_thumbnail_view_index = wpc
                .getViewKeys(configID)
                .findIndex((view) => {
                    return view === cart_thumbnail_view;
                });

            $carousel.trigger('to.wpccarousel.carousel', [
                cart_thumbnail_view_index,
                0,
                true,
            ]);

            $elemCon = $(
                '[data-configurator][data-config-id="' +
                    configID +
                    '"] [data-configurator-view] .active [data-preview-inner]'
            ).clone();

            $scaledElement = $('<div />', {
                id: 'screenshot-con',
                'data-config-id': configID,
                'data-type': cart_thumbnail_view,
            }).html($elemCon.html());

            $scaledElement.width(maxWidth + 80).height(maxHeight + 80);

            $scaledElement.find('template').remove();
            $scaledElement.find('[data-hotspot]').remove();

            wpc.do_action('wpc_before_canvas_element_generated', {
                event: false,
                $el: $scaledElement,
                $store,
            });

            $scaledElement.appendTo('body');

            wpc.rePositionSubset($store, $scaledElement);

            wpcHtml2Canvas($scaledElement[0])
                .then((canvas) => {
                    let dataUrl = canvas.toDataURL();

                    if (wpc.isDataImage(dataUrl)) {
                        let img = new Image();

                        img.src = dataUrl;

                        return img;
                    }

                    return '';
                })
                .then((img) => {
                    let $thumbnail = $('<div />', {
                            id: 'thumbnail',
                        }).html(img),
                        newCanvas = document.createElement('canvas'),
                        ctx = newCanvas.getContext('2d'),
                        thumb;

                    $thumbnail.appendTo('body');

                    $($thumbnail).imagesLoaded(function () {
                        if (img) {
                            thumb = $thumbnail.find('img');

                            let thumbSize = wpc.getProportion(
                                thumb[0],
                                parseInt(wpc_plugin.thumb_size)
                            );

                            newCanvas.width = parseInt(thumbSize['width']);
                            newCanvas.height = parseInt(thumbSize['height']);

                            ctx.drawImage(
                                img,
                                0,
                                0,
                                parseInt(thumbSize['width']),
                                parseInt(thumbSize['height'])
                            );

                            var smallImageDataUrl = newCanvas.toDataURL();

                            if (
                                wpc.stringToBoolean(
                                    wpc_plugin.image_partially_encoded
                                )
                            ) {
                                smallImageDataUrl = smallImageDataUrl.replace(
                                    'data:image/png;base64,',
                                    ''
                                );
                            }

                            $imageField.val(smallImageDataUrl);
                        }

                        if ('quote-form' == type) {
                            var ajaxurl = wpc_plugin.ajaxurl,
                                $data = $form.serialize();
                            $.ajax({
                                type: 'post',
                                url: ajaxurl,
                                data: $data,
                                beforeSend: function () {},
                                complete: function () {},
                            })
                                .done(function (data) {
                                    let parseData = JSON.parse(data),
                                        hasErrors = parseData.error,
                                        notice = parseData.notice,
                                        errorData;

                                    $form.removeClass('wpc-submitting-form');

                                    $form.find('.error').empty();

                                    // Has any errors.
                                    if (hasErrors) {
                                        errorData = notice.errors;

                                        Object.keys(errorData).forEach((i) => {
                                            $store.notices[i] = errorData[i][0];
                                        });

                                        wpc.do_action(
                                            'wpc_quote_form_field_error_notice',
                                            { $form, errorData }
                                        );
                                    } else {
                                        // If it passes the validation, returns success notice.
                                        $store.notices['success'] = notice;

                                        wpc.do_action(
                                            'wpc_quote_form_successfully_mail_sent',
                                            { $form, parseData }
                                        );

                                        if (parseData.redirect) {
                                            window.location.href =
                                                parseData.redirect;
                                        }
                                    }
                                })
                                .always(function () {});
                        } else if ('contact-form' == type) {
                            wpcf7.submit($form[0]);
                            $form.removeClass('wpc-submitting-form');
                        } else if ('cart-form' == type) {
                            $form.submit();
                        }

                        wpc.do_action('wpc_form_submitted', {
                            $store,
                        });

                        $thumbnail.remove();
                        $scaledElement.remove();

                        return true;
                    });
                });
        }
    };
})(jQuery, window, document);
