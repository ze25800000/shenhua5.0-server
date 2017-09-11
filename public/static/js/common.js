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


$(document).ready(function(){

    // 去除虚线框（会影响效率）
    $("a").on('focus',function(){$(this).blur();});


    $('.file input[type=file]').change(function(e) {
        $(this).siblings('.text').text($(this).val());
    });

    if(!-[1,]){
        $('input[type=radio]').bind('click',function(){
            var name = $(this).attr('name');
            $('input[type=radio]["name="'+ name +']').removeClass('checked');
            if($(this).prop('checked')){
                $(this).addClass('checked');
            }
        });
    }
    if(!!!$('.opt-panel').size() &&　!!!$('.system-switch').size()){
        $(document).click(function(e) {
            $(top.window.document).find('.opt-panel').hide().end().find('.system-switch').hide();
            $(top.window.document).find('.more-info').removeClass('active').end().find('.logo-icon').removeClass('active');
        });
    }

    if(!!!$('.more-bab-list').size()){
        $(document).click(function(e) {
            $(top.window.document).find('iframe').contents().find('.more-bab-list').hide();
            $(top.window.document).find('iframe').contents().find('.tab-more').removeClass('active');
        });
    }
});


function hideElement(currentElement, targetElement, fn) {
    if (!$.isArray(targetElement)) {
        targetElement = [ targetElement ];
    }
    $(document).on("click.hideElement", function(e) {
        var len = 0, $target = $(e.target);
        for (var i = 0, length = targetElement.length; i < length; i++) {
            $.each(targetElement[i], function(j, n) {
                if ($target.is($(n)) || $.contains($(n)[0], $target[0])) {
                    len++;
                }
            });
        }
        if ($.contains(currentElement[0], $target[0])) {
            len = 1;
        }
        if (len == 0) {
            currentElement.hide();
            fn && fn(currentElement, targetElement);
        }
    });
};


/*
 *  用来给不支持HTML5 placeholder属性的浏览器增加此功能。
 *  @param element {String or Object} 需要添加placeholder提示的输入框选择器或者输入框jquery对象。
 *  @param defualtCss {String} 提示默认的样式class。
 */

function showRemind(element,defualtCss){
    if(-[1,]){
        return false;
    }

    $(element).each(function(el, i){
        var placeholder = $(this).attr('placeholder');
        if(placeholder){
            $(this).addClass(defualtCss).val(placeholder);
            $(this).focus(function(e){
                if($(this).attr('placeholder') === $(this).val()){
                    $(this).val('').removeClass(defualtCss);
                }
            });

            $(this).blur(function(e){
                if($(this).val() === ""){
                    $(this).addClass(defualtCss).val($(this).attr('placeholder'));
                }
            });
        }
    });
}

function resize(resizeHandle){
    var d = document.documentElement;
    var timer;//避免resize触发多次,影响性能
    var width = d.clientWidth, height = d.clientHeight;
    $(top.window).on('resize',function(e){
        if((width != d.clientWidth || height != d.clientHeight)){
            width = d.clientWidth, height = d.clientHeight;
            if(timer){clearTimeout(timer);}
            timer = setTimeout(function(){
                resizeHandle();
            },10);
        }
    });

}

$(document).click(function(){
    $(".select-list").hide();
})
