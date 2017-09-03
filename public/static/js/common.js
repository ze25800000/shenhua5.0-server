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
            data: new FormData($("#uploadForm")[0]),
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                params.sCallback && params.sCallback(data);
            },
            error: function (err) {
                params.eCallback && params.eCallback(err);
            }
        })
    }
};