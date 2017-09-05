window.base = {
    g_restUrl: 'http://shenhua.cn/',
    getData: function (params) {
        if (!params.type) {
            params.type = 'GET';
        }
        var that = this;
        $.ajax({
            url: that.g_restUrl + params.url,
            type: params.type,
            data: params.data,
            success: function (data) {
                params.sCallback && params.sCallback(data);
            },
            error: function (err) {
                params.eCallback && params.eCallback(err.responseJSON);
            }
        })
    },
    uploadFile: function (params) {
        if (!params.type) {
            params.type = 'post'
        }
        var that = this;
        $.ajax({
            url: that.g_restUrl + params.url,
            type: params.type,
            data: params.data,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                params.sCallback && params.sCallback(data);
            },
            error: function (err) {
                params.eCallback && params.eCallback(err.responseJSON);
            }
        })
    },
    getEquipmentList: function (Callback) {
        var params = {
            url: 'document/equipment/getlist',
            sCallback: function (data) {
                Callback && Callback(data.data);
            },
            eCallback: function (err) {
                alert(err.msg);
            }
        };
        this.getData(params);
    },
    getOilStandardList: function (callback) {
        var params = {
            url: 'document/oilstandard/getlist',
            sCallback: function (data) {
                callback && callback(data.data);
            },
            eCallback: function (err) {
                alert(err.msg);
            }
        };
        this.getData(params);
    },
    getAnalysisList: function (callback) {
        var params = {
            url: 'document/oilanalysis/getlist',
            sCallback: function (data) {
                callback && callback(data.data);
            },
            eCallback: function (err) {
                alert(err.msg);
            }
        };
        this.getData(params);
    },
    getOilDetailList: function (callback) {
        var params = {
            url: 'document/oildetail/getlist',
            sCallback: function (data) {
                callback && callback(data.data);
            },
            eCallback: function (err) {
                alert(err.msg);
            }
        };
        this.getData(params);
    },
    editItemByDblClick: function (_this, input, oldVal, url) {
        $(window).keydown(function (e) {
            if (e.keyCode == 27) {
                _this.html(oldVal);
            }
        });
        input.blur(function () {
            editItem();
        });
        input.keydown(function (e) {
            if (e.keyCode == 13) {
                editItem();
            }
        });

        function editItem() {
            var newVal = input.val(),
                id = input.parent().data('id'),
                key = input.parent().data('key');
            _this.html(newVal);
            var params = {
                url: url + id+'?XDEBUG_SESSION_START=13415',
                type: 'post',
                data: {[key]: newVal},
                sCallback: function (data) {
                    alert(data.msg)
                },
                eCallback: function (err) {
                    alert('修改失败');
                    _this.html(oldVal);
                }
            };
            if (newVal != oldVal) {
                window.base.getData(params);
            }
        }
    }
};