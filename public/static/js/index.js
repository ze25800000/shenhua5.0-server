$(window).resize(function (e) {
    $("#bd").height($(window).height() - $("#hd").height() - $("#ft").height() - 6);
    $(".wrap").height($("#bd").height() - 6);
    $(".nav").css("minHeight", $(".sidebar").height() - $(".sidebar-header").height() - 1);
    $("#iframe").height($(window).height() - $("#hd").height() - $("#ft").height() - 12);
}).resize();

// $(".nav>li").css({"borderColor":"#dbe9f1"});
// $(".nav>.current").prev().css({"borderColor":"#7ac47f"});
// $(".nav").on("click","li",function(e){
// 	var aurl = $(this).find("a").attr("date-src");
// 	$("#iframe").attr("src",aurl);
// 	$(".nav>li").css({"borderColor":"#dbe9f1"});
// 	$(".nav>.current").prev().css({"borderColor":"#7ac47f"});
// 	return false;
// });

$('.exitDialog').Dialog({
    title: '提示信息',
    autoOpen: false,
    width: 400,
    height: 200

});

$('.exit').click(function () {
    $('.exitDialog').Dialog('open');
});


$('.exitDialog input[type=button]').click(function (e) {
    $('.exitDialog').Dialog('close');

    if ($(this).hasClass('ok')) {
        window.location.href = "/logout";
    }
});

$(".btn1").click(function (event) {
    event.stopPropagation();
    $(".hint").css({"display": "block"});
    $(".box").css({"display": "block"});
});

$(".hint-in3").click(function (event) {
    $(".hint").css({"display": "none"});
    $(".box").css({"display": "none"});
});

$(".btn2").click(function (event) {
    // $(".hintl").css({"display": "block"});
    // $(".box").css({"display": "block"});
    $(".hintl").show();
    $(".box").hide();
    event.stopPropagation();
});

$(".hint3").click(function (event) {
    $(this).parent().parent().css({"display": "none"});
    $(".box").css({"display": "none"});
});

$(".hintl-in3").click(function (event) {
    $(".hintl").css({"display": "none"});
    $(".box").css({"display": "none"});
});

$(".hintl-in4").click(function () {
    $(".hintl").css({"display": "none"});
    $(".box").css({"display": "none"});
});
$(".a-upload").on("change", "input[type='file']", function () {
    var filePath = $(this).val();
    if (filePath.indexOf("xls") != -1 || filePath.indexOf("xlsx") != -1) {
        $(".fileerrorTip").html("").hide();
        var arr = filePath.split('\\');
        var fileName = arr[arr.length - 1];
        $(".showFileName").html(fileName);
    } else {
        $(".showFileName").html("");
        $(".fileerrorTip").html("您未上传文件，或者您上传文件类型有误！").show();
        return false
    }
});


