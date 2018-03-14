'use strict';
app.controller('mineGrzlCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.perData = [];//个人资料
    $scope.marriage = ''; //是否已婚
    $http.post('/health/health-api/index',{
        mobile:15168230440
    }).success(function (data) {
        $scope.perData = data.data[0].data;
        if($scope.perData[0].marriage == 1){
            $scope.marriage = '已婚'
        }else if($scope.perData[0].marriage == 2){
            $scope.marriage = '未婚'
        }
    });
}]);
