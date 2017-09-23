<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .box {
        width: 200px;
        height: 200px;
        border: 1px solid #2a83cf;

    }

    .innerbox {
        width: 200px;
        height: 200px;
        border: 1px solid #2a83cf;
        display: none;
    }
</style>
<body>
<div class="box" data-box="box">
</div>
<h1>hello world</h1>
<div class="innerbox">123</div>
</body>
</html>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script>
    $('.box').click(function (e) {
        var box = $(this).data('box');
        $('.innerbox').show();
        $('.innerbox').unbind('click').click(function () {
            alert(box);
        });
    });
</script>