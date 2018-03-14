'use strict';
app.controller('msgDetailCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.con = []; //详情内容
    $http.post('/notice/notice-api/view',{
        token:$sessionStorage.token,
        id:$stateParams.id
    }).success(function (data) {
        if(data.errcode == 0){
            console.log(data);
            $scope.con = data.data.notice;
        }
    });

    //清空消息
    $scope.showMsgChoose = function () {
        $scope.showMask = true;
    };
//    取消遮罩
    $scope.cancel = function () {
        $scope.showMask = false;
    };
//    返回
    $scope.goToBack = function () {
        // 表示已读
        $http.post('/notice/notice-api/index',{
            token:$sessionStorage.token,
            start_page: 0,
            pages: 50,
            type:1
        }).success(function (data) {
            if(data.errcode == 0){
                $sessionStorage.msg1 = data.data.list;
                $http.post('/notice/notice-api/index',{
                    token:$sessionStorage.token,
                    start_page: 0,
                    pages: 50,
                    type:2
                }).success(function (data) {
                    if(data.errcode == 0){
                        $sessionStorage.msg2 = data.data.list;
                        history.go(-1);
                    }
                });
            }
        });
    };
}])
;
