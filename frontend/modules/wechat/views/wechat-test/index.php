<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <meta charset="UTF-8"> 
        <title>js微信自定义分享标题、链接和图标</title> 
         <meta name="keywords" content="js微信分享,php微信分享" /> 
        <meta name="description" content="PHP自定义微信分享内容，包括标题、图标、链接等，分享成功和取消有js回调函数。" /> 
    </head> 
    <body> 
 
    </body> 
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
        wx.config(<?php echo $js->config(array('onMenuShareQQ', 'onMenuShareWeibo','onMenuShareTimeline'), true) ?>);

        wx.ready(function() { 
            wx.onMenuShareTimeline({ 
                title: '测试', // 分享标题 
                link: 'http://sass-admin.palcomm.com.cn/', // 分享链接 
                imgUrl: 'http://sass-admin.palcomm.com.cn/static/upload/image/20170517/1495010361.png', // 分享图标 
                success: function() { 
                    // 用户确认分享后执行的回调函数 
                }, 
                cancel: function() { 
                    // 用户取消分享后执行的回调函数 
                } 
            }); 
            wx.onMenuShareAppMessage({
                title: '测试', // 分享标题
                desc: '11111', // 分享描述
                link: 'http://sass-admin.palcomm.com.cn/', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: 'http://sass-admin.palcomm.com.cn/static/upload/image/20170517/1495010361.png', // 分享图标
               
                success: function () { 
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () { 
                    // 用户取消分享后执行的回调函数
                }
            });
        }); 
    </script>
    <p style="text-align: center;color:red;font-size:20px;margin-top: 120px">请用微信浏览器打开，并打开右上方按钮。分享到朋友圈试试。</p> 
</html>