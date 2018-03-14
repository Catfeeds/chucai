'use strict';
app.controller('mineAboutCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.aboutUsTel = $sessionStorage.aboutUsTel; // 客服电话
    $scope.aboutUsEmail = $sessionStorage.aboutUsEmail; // 联系邮箱
    $scope.aboutUsContent = $sessionStorage.aboutUsContent; // APP介绍
    $http.post('/aboutus/about-us-api/view',{
    }).success(function (data) {
        if(data.errcode == 0){
            $scope.aboutUsTel = $sessionStorage.aboutUsTel = data.data.list[0].tel;
            $scope.aboutUsEmail = $sessionStorage.aboutUsEmail = data.data.list[0].email;
            $scope.aboutUsContent = $sessionStorage.aboutUsContent = data.data.list[0].content;
        }
    });
}]);
