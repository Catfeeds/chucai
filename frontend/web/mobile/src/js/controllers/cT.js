/**
 * Created by Bingo on 2017/4/20.
 */
'use strict';
/* Controllers */
app.controller('控制器名字', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
    //弹窗
    $scope.mPop={
        content:{
            type: 'success',
            title: '通知',
            text: 'Message',
            dataout:2000
        },
        launch:function () {
            toaster.pop($scope.mPop.content.type, $scope.mPop.content.title, $scope.mPop.content.text,$scope.mPop.content.dataout);
        },
        info:function (text) {
            $scope.mPop.content.type='success';
            $scope.mPop.content.text=text;
            $scope.mPop.launch();
        },
        err:function (text) {
            $scope.mPop.content.type='error';
            $scope.mPop.content.text=text;
            $scope.mPop.launch();
        }

    };
    //播报列表
    $scope.notices=['1111111','2222222222','333333333'];
    //播报信息滚动
    var _wrap=$('ul.gonggao-ul');//定义滚动区域
    var _interval=4000;//定义滚动间隙时间
    var _moving;//需要清除的动画
    _wrap.hover(function(){
        clearInterval(_moving);//当鼠标在滚动区域中时,停止滚动
    },function(){
        _moving=setInterval(function(){
            var _field=_wrap.find('li:first');//此变量不可放置于函数起始处,li:first取值是变化的
            var _h=_field.height();//取得每次滚动高度
            _field.animate({marginTop:-_h+'px'},1000,function(){//通过取负margin值,隐藏第一行
                _field.css('marginTop',0).appendTo(_wrap);//隐藏后,将该行的margin值置零,并插入到最后,实现无缝滚动
            })
        },_interval)//滚动间隔时间取决于_interval
    }).trigger('mouseleave');//函数载入时,模拟执行mouseleave,即自动滚动
}])
;