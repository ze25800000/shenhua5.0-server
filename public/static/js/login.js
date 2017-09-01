$(function () {
    $(document).on('click', '#login', function () {
        var $userName = $('#username'),
            $pwd = $('#pwd');
        if (!$userName.val()) {
            $userName.next().show().text('请输入用户名');
            return;
        }
        if (!$pwd.val()) {
            $pwd.next().show().text('请输入密码');
            return;
        }
        var params = {
            url: 'login',
            type: 'post',
            data: {userName: $userName.val(), pwd: $pwd.val()},
            sCallback: function (data) {
                console.log(data);
                if (data.errcode === 0) {
                    location.href = "/";
                } else if (data.errcode === 1) {
                    $userName.next().show().text(data.msg);
                } else if (data.errcode === 2) {
                    $pwd.next().show().text(data.msg);
                }
            },
            eCallback: function (data) {
                console.log(data);
            }
        };
        window.base.getData(params);
    });
    $(document).on('focus', 'input', function () {
        $('.error-tips').hide();
    });
    $(document).on('keydown', 'input', function (e) {
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if (e && e.keyCode == 13) {
            $('#login').trigger('click');
        }
    });
});