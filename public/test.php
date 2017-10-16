<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .shenhua-hover-box {
            width: 320px;
            position: relative;
        }
        .shenhua-title {
            position: absolute;
            width: 100%;
            height: 50px;
            line-height: 50px;
            background-color: #ee6b0c;
        }
        .oil-warning {
            top: 100px;
        }
        .shenhua-hover-box:hover .shenhua-list{
            display: block;
        }
        .shenhua-list {
            position: absolute;
            left: 0;
            top: 35px;
            width: 100%;
            border: 1px solid #0d6ba1;
            display: none;
            max-height: 500px;
            background-color: #bcffee;
            z-index:100;
            padding: 0;
        }
        li {
            list-style:none;
        }
    </style>
</head>
<body>
    <div class="shenhua-hover-box">
        <div class="shenhua-title">5台设备需要润滑</div>
        <ul class="shenhua-list">
            <li>1</li>
            <li>1</li>
            <li>1</li>
            <li>1</li>
            <li>1</li>
        </ul>
    </div>
    <div class="shenhua-hover-box oil-warning">
        <div class="shenhua-title">5台设备需要润滑</div>
        <ul class="shenhua-list">
            <li>1</li>
            <li>2</li>
            <li>3</li>
            <li>4</li>
            <li>5</li>
        </ul>
    </div>
</body>
</html>