<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="static/js/Chart.js"></script>
</head>
<body>
<canvas id="myChart" width="1058" height="200"></canvas>
<button class="button1">切换</button>
<button class="button2">切换</button>
</body>
</html>
<script>
    var btn1 = document.querySelector('.button1');
    var btn2 = document.querySelector('.button2');
    btn1.onclick = function () {
        var data = {
            labels: ["2017年12月1日", "2017年12月1日", "2017年12月1日", "2017年12月1日", "2017年12月1日",],
            datasets: [
                {
                    fillColor: "rgba(220,220,220,0)",
                    strokeColor: "red",
//                pointColor: 'red',
//                pointStrokeColor: "red",
                    data: [3.5, 3.5, 3.5]
                },
                {
                    fillColor: "rgba(220,220,220,0)",
                    strokeColor: "rgba(220,220,220,1)",
                    pointColor: "rgba(220,220,220,1)",
                    pointStrokeColor: "#fff",
                    data: [2.5, 4.8, 4.5]
                }

            ]
        };
        change(data);
    };
    btn2.onclick = function () {
        var data = {
            labels: ["2017年12月1日", "2017年12月1日", "2017年12月1日", "2017年12月1日", "2017年12月1日",],
            datasets: [
                {
                    fillColor: "rgba(220,220,220,0)",
                    strokeColor: "red",
//                pointColor: 'red',
//                pointStrokeColor: "red",
                    data: [5.5, 5.5, 5.5]
                },
                {
                    fillColor: "rgba(220,220,220,0)",
                    strokeColor: "rgba(220,220,220,1)",
                    pointColor: "rgba(220,220,220,1)",
                    pointStrokeColor: "#fff",
                    data: [3.5, 5.8, 7.5]
                }

            ]
        };
        change(data);
    };

    function change(data) {
        var ctx = document.getElementById("myChart").getContext("2d");

        var options = {
            pointDot: false,
            animation: false
        };
        new Chart(ctx).Line(data, options);
    }


</script>