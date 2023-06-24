layui.define(['jquery', 'layer'], function (exports) {
    "use strict";

    let MOD_NAME = 'willphp',
        $ = layui.jquery,
        layer = layui.layer;

    function willphp_jump(ret, refresh, callback, fail) {
        refresh = refresh || 0;
        callback = (refresh === 1)? function () { window.location.href = ret.url;} : (refresh === 2) ? function () { window.location.reload();} : callback;
        fail = fail || function () {};
        if (ret.status === 1) {
            layer.msg(ret.msg, { icon: 1, time: 1000 }, callback);
        } else {
            layer.msg(ret.msg, { icon: 2, time: 1500 }, fail);
        }
    }

    let willphp = new function() {
        this.ajaxGet = function (url, refresh) {
            refresh = refresh || 0;
            $.get(url, function (ret) { willphp_jump(ret, refresh); }, 'json');
        },
            this.ajaxPost = function (data, refresh, callback, fail) {
                let load = layer.load();
                refresh = refresh || 0;
                callback = callback || function () {};
                fail = fail || function () {};
                $.post(data.form.action, data.field, function (ret) {
                    layer.close(load);
                    willphp_jump(ret, refresh, callback, fail);
                }, 'json');
            },
            this.ajaxConfirm = function (url, title, refresh, callback) {
                refresh = refresh || 0;
                callback = callback || function () {};
                layer.confirm('确定要' + title + '吗?', {icon: 3, title:'提示'}, function (index) {
                    layer.close(index);
                    let load = layer.load();
                    $.get(url, function (ret) {
                        layer.close(load);
                        willphp_jump(ret, refresh, callback);
                    }, 'json');
                });
            }
    };

    exports(MOD_NAME, willphp);
});