'use strict';
app.controller('msgNoticeCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    //服务信息
    $scope.msg1 = [];
    $http.post('/notice/notice-api/index',{
        token:$sessionStorage.token,
        start_page: 0,
        pages: 10,
        type:1
    }).success(function (data) {
        if(data.errcode == 0){
            $scope.msg1 = data.data.list;
        }
    });
    //系统公告
    $scope.msg2 = [];
    $http.post('/notice/notice-api/index',{
        token:$sessionStorage.token,
        start_page: 0,
        pages: 10,
        type:2
    }).success(function (data) {
        if(data.errcode == 0){
            $scope.msg2 = data.data.list;
        }
    });

//    去往详情页
    $scope.goToDetail = function (id) {
        $state.go('msg_detail',{
            id:id
        })
    }
}])
;