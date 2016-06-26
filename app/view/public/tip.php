<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>信息提示</title>
    <style>
    body{font: 500 0.875em/20px Microsoft Yahei, Hiragino Sans GB,Arial,WenQuanYi Micro Hei, sans-serif; padding: 55px 10px;font-size: 100%; color: #666;}
    p {margin: 0; }
    .container {max-width: 380px;_width: 380px;margin: 0 auto;}
    .panel {margin-bottom: 20px; background-color: #ffffff; border: 1px solid transparent; border-radius: 4px; -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05); box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05); }
    .panel-body {padding: 15px; text-align: center; }
    .panel-body:before, .panel-body:after {display: table; content: " "; }
    .panel-body:after {clear: both; }
    .panel-body:before, .panel-body:after {display: table; content: " "; }
    .panel-body:after {clear: both; }
    .panel-heading {padding: 10px 15px; border-bottom: 1px solid transparent; border-top-right-radius: 3px; border-top-left-radius: 3px; }
    .panel-title {margin-top: 0; margin-bottom: 0; font-size: 16px; }
    .panel-title > a {color: inherit; }
    .panel-footer {text-align: center; padding: 10px 15px; background-color: #f5f5f5; border-top: 1px solid #dddddd; border-bottom-right-radius: 3px; border-bottom-left-radius: 3px; }
    .panel-footer a{font-size: 14px; color: #666;text-decoration: none;}
    .panel-primary {border-color: #428bca; }
    .panel-primary > .panel-heading {color: #ffffff; background-color: #428bca; border-color: #428bca; }
    .panel-primary > .panel-heading + .panel-collapse .panel-body {border-top-color: #428bca; }
    .panel-primary > .panel-footer + .panel-collapse .panel-body {border-bottom-color: #428bca; }
    </style>
</head>
<body>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">信息提示</div>
            </div>
            <div class="panel-body">
                <p><?php echo $msg ?></p>
            </div>
            <div class="panel-footer">
                <a id="href" href="<?php echo $jump ?>">页面自动跳转 等待时间： <b id="wait"><?php echo $second ?></b></a>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    (function(){
    var wait = document.getElementById('wait'),href = document.getElementById('href').href;
    var interval = setInterval(function(){
        var time = --wait.innerHTML;
        if(time <= 0) {
            location.href = href;
            clearInterval(interval);
        };
    }, 1000);
    })();
    </script>
</body>
</html>