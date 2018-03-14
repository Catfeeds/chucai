'use strict';
app.controller('msgZxCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $rootScope.baseOption.msgShow=1;
    $scope.msgList = [];
    $http.post('/consult/consult-api/index-list',{
        token:$sessionStorage.token,
        start_page: 0,
        pages: 50
    }).success(function (data) {
        if(data.errcode==0){
            $scope.msgList = data.data.list;
            // console.log(data.data.list);
        }

    });
}])
;