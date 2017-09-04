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
    }
};