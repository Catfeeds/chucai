'use strict';
app.controller('healthyDetailCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $rootScope.changeNavH();

    $scope.isWeiXin = function (){
        var ua = window.navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i) == 'micromessenger'){
            $('.y-back').hide();
            $('.y-share').hide();
        }else{
            return false;
        }
    };
    $scope.isWeiXin();
    $scope.healthyDetail = [];
    $http.post('/news/news-api/view',{
        id:$stateParams.id
    }).success(function (data) {
        // console.log(data.data);
        $scope.healthyDetail = data.data;
    });

    $scope.isShowShare = false;
    // 分享所需内容
    $scope.shareData = {};
    $scope.showShare = function () {
        $scope.isShowShare = true;
        $scope.shareData = {
            url:window.location.href,
            urlImg:$stateParams.img,
            title:$scope.healthyDetail.title,
            con:$('.y-detail-text').text().substring(0,100)
        };

    };
    $scope.cancle = function () {
        $scope.isShowShare = false;
    };
// 文章分享
    $scope.shareDetail = function (type) {
        var u = navigator.userAgent;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        var url = $scope.shareData.url,urlImg = $scope.shareData.urlImg,title = $scope.shareData.title,con = $scope.shareData.con;
        //getSureToken是函数名
        var shareMsg = {
            body:{
                type:type,
                url:url,
                urlImg:urlImg,
                title:title,
                con:con
            }
        };
        if(isiOS){
            if(window.webkit){
                window.webkit.messageHandlers.shareArticle.postMessage(shareMsg);
            }
        }else{
            if(window.App){
                window.App.getSureToken(type,url,urlImg,title,con);
            }
        }
    };
//    返回新闻列表
    $scope.goToBack = function () {
        $sessionStorage.newsScrollTop = $stateParams.scrollTop;
        history.go(-1);
    }
}])
;